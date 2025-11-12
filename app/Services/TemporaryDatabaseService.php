<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\ActivitySubmission;

/**
 * Temporary file-based database service to handle missing PostgreSQL driver
 * This is a temporary workaround until PostgreSQL PHP extension is installed
 * NOW ALSO PERSISTS TO DATABASE for dashboard compatibility
 */
class TemporaryDatabaseService
{
    private $storageDir = 'temp_db';

    public function __construct()
    {
        if (!Storage::disk('local')->exists($this->storageDir)) {
            Storage::disk('local')->makeDirectory($this->storageDir);
        }
    }

    public function storeSubmission($data)
    {
        // Store in JSON file for backward compatibility
        $filename = $this->storageDir . '/submissions.json';
        $submissions = $this->getStoredData($filename);
        
        $data['id'] = count($submissions) + 1;
        $data['created_at'] = now()->toISOString();
        $data['updated_at'] = now()->toISOString();
        
        $submissions[] = $data;
        
        Storage::disk('local')->put($filename, json_encode($submissions, JSON_PRETTY_PRINT));
        
        Log::info('Stored submission temporarily', ['id' => $data['id']]);
        
        // ALSO persist to actual database for dashboard tracking
        try {
            $dbSubmission = ActivitySubmission::create([
                'user_id' => $data['user_id'],
                'activity_id' => $data['activity_id'],
                'submitted_code' => $data['submitted_code'],
                'score' => $data['score'],
                'is_completed' => $data['is_completed'],
                'completion_status' => $data['completion_status'],
                'time_spent_minutes' => $data['time_spent_minutes'] ?? 0,
                'feedback' => $data['feedback'],
                'attempt_number' => $data['attempt_number'],
                'validation_results' => is_string($data['validation_results']) ? $data['validation_results'] : json_encode($data['validation_results']),
                'submitted_at' => now(),
                'completed_at' => $data['is_completed'] ? now() : null
            ]);
            
            Log::info('✅ Submission persisted to database', [
                'db_id' => $dbSubmission->id,
                'user_id' => $data['user_id'],
                'activity_id' => $data['activity_id'],
                'is_completed' => $data['is_completed'],
                'score' => $data['score']
            ]);
            
            // Update the data with the real database ID
            $data['db_id'] = $dbSubmission->id;
            
        } catch (\Exception $e) {
            Log::warning('⚠️ Could not persist submission to database (continuing with temp storage)', [
                'error' => $e->getMessage(),
                'user_id' => $data['user_id'],
                'activity_id' => $data['activity_id']
            ]);
        }
        
        return $data;
    }

    public function getSubmissionStatus($userId, $activityId)
    {
        // Try to read from database first for accuracy
        try {
            $dbSubmissions = ActivitySubmission::where('user_id', $userId)
                ->where('activity_id', $activityId)
                ->orderBy('created_at', 'desc')
                ->get();
            
            if ($dbSubmissions->isNotEmpty()) {
                $latestSubmission = $dbSubmissions->first();
                $bestScore = $dbSubmissions->max('score');
                
                Log::info('📊 Reading submission status from database', [
                    'user_id' => $userId,
                    'activity_id' => $activityId,
                    'total_attempts' => $dbSubmissions->count(),
                    'is_completed' => $latestSubmission->is_completed
                ]);
                
                return [
                    'total_attempts' => $dbSubmissions->count(),
                    'remaining_attempts' => null,
                    'best_score' => $bestScore,
                    'is_completed' => $latestSubmission->is_completed,
                    'latest_submission' => [
                        'id' => $latestSubmission->id,
                        'score' => $latestSubmission->score,
                        'is_completed' => $latestSubmission->is_completed,
                        'completion_status' => $latestSubmission->completion_status,
                        'feedback' => $latestSubmission->feedback,
                        'attempt_number' => $latestSubmission->attempt_number,
                        'created_at' => $latestSubmission->created_at->toISOString()
                    ]
                ];
            }
        } catch (\Exception $e) {
            Log::warning('⚠️ Could not read from database, falling back to temp storage', [
                'error' => $e->getMessage()
            ]);
        }
        
        // Fallback to JSON file storage
        $filename = $this->storageDir . '/submissions.json';
        $submissions = $this->getStoredData($filename);
        
        $userSubmissions = array_filter($submissions, function($sub) use ($userId, $activityId) {
            return $sub['user_id'] == $userId && $sub['activity_id'] == $activityId;
        });
        
        if (empty($userSubmissions)) {
            return [
                'total_attempts' => 0,
                'remaining_attempts' => null, // Unlimited attempts
                'best_score' => 0,
                'is_completed' => false,
                'latest_submission' => null
            ];
        }
        
        $latestSubmission = end($userSubmissions);
        $bestScore = max(array_column($userSubmissions, 'score'));
        
        return [
            'total_attempts' => count($userSubmissions),
            'remaining_attempts' => null, // Unlimited attempts - tracking only for AuraBot display
            'best_score' => $bestScore,
            'is_completed' => $latestSubmission['is_completed'] ?? false,
            'latest_submission' => $latestSubmission
        ];
    }

    public function logActivity($data)
    {
        $filename = $this->storageDir . '/activity_logs.json';
        $logs = $this->getStoredData($filename);
        
        $data['id'] = count($logs) + 1;
        $data['created_at'] = now()->toISOString();
        
        $logs[] = $data;
        
        Storage::disk('local')->put($filename, json_encode($logs, JSON_PRETTY_PRINT));
    }

    private function getStoredData($filename)
    {
        if (!Storage::disk('local')->exists($filename)) {
            return [];
        }
        
        $content = Storage::disk('local')->get($filename);
        return json_decode($content, true) ?: [];
    }

    /**
     * Clear all temporary data for a specific user and activity
     */
    public function clearUserActivityData($userId, $activityId)
    {
        // Clear from JSON file
        $filename = $this->storageDir . '/submissions.json';
        $submissions = $this->getStoredData($filename);
        
        // Remove all submissions for this user/activity combination
        $filteredSubmissions = array_filter($submissions, function($sub) use ($userId, $activityId) {
            return !($sub['user_id'] == $userId && $sub['activity_id'] == $activityId);
        });
        
        Storage::disk('local')->put($filename, json_encode(array_values($filteredSubmissions), JSON_PRETTY_PRINT));
        
        $removedCount = count($submissions) - count($filteredSubmissions);
        
        // Also clear from database
        try {
            $dbRemovedCount = ActivitySubmission::where('user_id', $userId)
                ->where('activity_id', $activityId)
                ->delete();
            
            Log::info('✅ Cleared data from database and temp storage', [
                'user_id' => $userId, 
                'activity_id' => $activityId,
                'temp_removed' => $removedCount,
                'db_removed' => $dbRemovedCount
            ]);
        } catch (\Exception $e) {
            Log::warning('⚠️ Could not clear database (temp storage cleared)', [
                'error' => $e->getMessage(),
                'temp_removed' => $removedCount
            ]);
        }
    }

    /**
     * Clear all temporary data (for testing purposes)
     */
    public function clearAllData()
    {
        $files = ['submissions.json', 'activity_logs.json'];
        foreach ($files as $file) {
            $fullPath = $this->storageDir . '/' . $file;
            if (Storage::disk('local')->exists($fullPath)) {
                Storage::disk('local')->delete($fullPath);
                Log::info('Cleared temporary file: ' . $file);
            }
        }
    }
}