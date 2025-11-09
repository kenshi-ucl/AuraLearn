<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_type',
        'user_id',
        'event_type',
        'description',
        'event_data',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'location',
        'created_at'
    ];

    protected $casts = [
        'event_data' => 'array',
        'created_at' => 'datetime'
    ];

    public $timestamps = false; // Only using created_at

    /**
     * Create a new audit log entry
     */
    public static function logEvent(
        string $userType,
        ?int $userId,
        string $eventType,
        ?string $description = null,
        array $eventData = []
    ): self {
        $agent = new Agent();
        $agent->setUserAgent(Request::userAgent());

        // Determine device type
        $deviceType = 'desktop';
        if ($agent->isMobile()) {
            $deviceType = 'mobile';
        } elseif ($agent->isTablet()) {
            $deviceType = 'tablet';
        }

        return self::create([
            'user_type' => $userType,
            'user_id' => $userId,
            'event_type' => $eventType,
            'description' => $description,
            'event_data' => $eventData,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'device_type' => $deviceType,
            'browser' => $agent->browser() . ' ' . $agent->version($agent->browser()),
            'platform' => $agent->platform() . ' ' . $agent->version($agent->platform()),
            'location' => null, // Can be populated with IP geolocation service
            'created_at' => now()
        ]);
    }

    /**
     * Log user login
     */
    public static function logLogin(string $userType, int $userId, string $email): self
    {
        return self::logEvent(
            $userType,
            $userId,
            'login',
            "$userType logged in successfully",
            ['email' => $email]
        );
    }

    /**
     * Log failed login attempt
     */
    public static function logFailedLogin(string $userType, string $email): self
    {
        return self::logEvent(
            $userType,
            null,
            'failed_login',
            "Failed login attempt for $userType",
            ['email' => $email]
        );
    }

    /**
     * Log logout
     */
    public static function logLogout(string $userType, int $userId): self
    {
        return self::logEvent(
            $userType,
            $userId,
            'logout',
            "$userType logged out"
        );
    }

    /**
     * Log settings change
     */
    public static function logSettingsChange(string $userType, int $userId, array $changes): self
    {
        return self::logEvent(
            $userType,
            $userId,
            'settings_changed',
            "System settings updated",
            $changes
        );
    }
}

