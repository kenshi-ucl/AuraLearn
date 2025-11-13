<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminDebugController extends Controller
{
    public function debugSession(Request $request)
    {
        try {
            Log::info('Debug admin session', [
                'session_id' => Session::getId(),
                'session_driver' => config('session.driver'),
                'has_admin_guard' => Auth::guard('admin')->check(),
                'admin_user' => Auth::guard('admin')->user() ? Auth::guard('admin')->user()->toArray() : null,
                'request_headers' => $request->headers->all(),
                'cookies' => $request->cookies->all(),
                'session_data' => Session::all()
            ]);
            
            return response()->json([
                'session_id' => Session::getId(),
                'session_driver' => config('session.driver'),
                'has_admin_guard' => Auth::guard('admin')->check(),
                'admin_user' => Auth::guard('admin')->user() ? Auth::guard('admin')->user()->only(['id', 'name', 'email']) : null,
                'cookies' => array_keys($request->cookies->all()),
                'session_exists' => Session::exists('admin_guard'),
                'session_all' => Session::all()
            ]);
        } catch (\Exception $e) {
            Log::error('Debug session error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
}
