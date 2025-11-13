<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AdminDebugController extends Controller
{
    public function debugSession(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $sessionId = Session::getId();
        $sessionData = Session::all();
        
        // Check if session exists in database
        $dbSession = DB::table('sessions')->where('id', $sessionId)->first();
        
        return response()->json([
            'session_id' => $sessionId,
            'session_driver' => config('session.driver'),
            'session_lifetime' => config('session.lifetime'),
            'session_same_site' => config('session.same_site'),
            'session_secure' => config('session.secure'),
            'has_admin_guard' => Auth::guard('admin')->check(),
            'admin_user' => $admin ? ['id' => $admin->id, 'name' => $admin->name] : null,
            'session_data_keys' => array_keys($sessionData),
            'db_session_exists' => $dbSession ? true : false,
            'db_session_payload_length' => $dbSession ? strlen($dbSession->payload) : 0,
            'request_cookies' => $request->cookies->all(),
        ]);
    }
}
