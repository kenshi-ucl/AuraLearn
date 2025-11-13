<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminDebugController extends Controller
{
    public function debugSession(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $sessionId = Session::getId();
        $sessionData = Session::all();
        
        // Check if session exists in database when using database driver
        $dbSessionExists = false;
        $dbSessionPayloadLength = 0;
        if (config('session.driver') === 'database') {
            $dbSession = DB::table('sessions')->where('id', $sessionId)->first();
            if ($dbSession) {
                $dbSessionExists = true;
                $dbSessionPayloadLength = strlen($dbSession->payload);
            }
        }
        
        return response()->json([
            'session_id' => $sessionId,
            'session_driver' => config('session.driver'),
            'session_lifetime' => config('session.lifetime'),
            'session_same_site' => config('session.same_site'),
            'session_secure' => config('session.secure'),
            'has_admin_guard' => Auth::guard('admin')->check(),
            'admin_user' => $admin ? ['id' => $admin->id, 'name' => $admin->name, 'email' => $admin->email] : null,
            'request_cookies' => $request->cookies->all(),
            'session_data_keys' => array_keys($sessionData),
            'db_session_exists' => $dbSessionExists,
            'db_session_payload_length' => $dbSessionPayloadLength,
        ]);
    }
}
