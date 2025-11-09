<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\AuditLog;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function overview(Request $request)
    {
        $usersCount = User::count();
        $adminsCount = Admin::count();
        $jobsCount = \DB::table('jobs')->count();

        $supabaseOk = true;
        $supabaseError = null;
        try {
            // Simple connectivity test - just check if the database connection works
            // Using a simple query that doesn't depend on specific tables existing
            \DB::connection('pgsql')->select('SELECT 1 as test');
        } catch (\Throwable $e) {
            $supabaseOk = false;
            $supabaseError = $e->getMessage();
        }

        return response()->json([
            'stats' => [
                'users' => $usersCount,
                'admins' => $adminsCount,
                'queuedJobs' => $jobsCount,
                'supabase' => [
                    'ok' => $supabaseOk,
                    'error' => $supabaseError,
                ],
            ],
        ]);
    }

    public function users(Request $request)
    {
        $limit = (int) min((int) $request->query('limit', 20), 100);
        $users = User::orderByDesc('id')->limit($limit)->get(['id','name','email','created_at']);
        return response()->json([
            'users' => $users,
        ]);
    }

    public function logs(Request $request)
    {
        $limit = (int) min((int) $request->query('limit', 100), 500);
        $type = $request->query('type', 'audit'); // 'audit' or 'application'
        
        if ($type === 'audit') {
            // Return audit logs from database
            $logs = AuditLog::orderByDesc('created_at')
                ->limit($limit)
                ->get()
                ->map(function($log) {
                    return [
                        'id' => $log->id,
                        'user_type' => $log->user_type,
                        'user_id' => $log->user_id,
                        'event_type' => $log->event_type,
                        'description' => $log->description,
                        'event_data' => $log->event_data,
                        'ip_address' => $log->ip_address,
                        'device_type' => $log->device_type,
                        'browser' => $log->browser,
                        'platform' => $log->platform,
                        'location' => $log->location,
                        'created_at' => $log->created_at->toISOString()
                    ];
                });
            
            return response()->json(['logs' => $logs, 'type' => 'audit']);
        }
        
        // Return application log file
        $path = storage_path('logs/laravel.log');
        if (!file_exists($path)) {
            return response()->json(['lines' => [], 'type' => 'application']);
        }
        $lines = [];
        $fp = fopen($path, 'r');
        if ($fp) {
            // Efficient tail-like read
            $buffer = '';
            while (!feof($fp)) {
                $buffer .= fread($fp, 8192);
            }
            fclose($fp);
            $all = preg_split("/\r?\n/", $buffer);
            $all = array_values(array_filter($all, fn($l) => $l !== ''));
            $lines = array_slice($all, -$limit);
        }
        return response()->json(['lines' => $lines, 'type' => 'application']);
    }

    public function settings(Request $request)
    {
        $settings = SystemSetting::getAllGrouped();
        return response()->json(['settings' => $settings]);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.id' => 'required|integer|exists:system_settings,id',
            'settings.*.value' => 'nullable|string'
        ]);

        $admin = Auth::guard('admin')->user();
        $changes = [];

        foreach ($validated['settings'] as $settingData) {
            $setting = SystemSetting::find($settingData['id']);
            
            if (!$setting || !$setting->is_editable) {
                continue;
            }

            $oldValue = $setting->value;
            $newValue = $settingData['value'] ?? '';

            if ($oldValue !== $newValue) {
                $setting->value = $newValue;
                $setting->save();

                $changes[] = [
                    'key' => $setting->key,
                    'old_value' => $setting->is_sensitive ? '***' : $oldValue,
                    'new_value' => $setting->is_sensitive ? '***' : $newValue
                ];

                // Clear cache for this setting
                \Cache::forget("system_setting_{$setting->key}");
            }
        }

        // Log the settings change
        if (!empty($changes) && $admin) {
            AuditLog::logSettingsChange('admin', $admin->id, $changes);
        }

        return response()->json([
            'message' => 'Settings updated successfully',
            'changes' => count($changes)
        ]);
    }
} 