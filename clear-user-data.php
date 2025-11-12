<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ActivitySubmission;
use App\Services\TemporaryDatabaseService;

$userId = 6;

echo "🗑️ Clearing all data for user {$userId}...\n\n";

// Clear from database
$dbCount = ActivitySubmission::where('user_id', $userId)->delete();
echo "✅ Deleted {$dbCount} submissions from database\n";

// Clear from temporary storage
$tempDB = new TemporaryDatabaseService();
$tempDB->clearUserActivityData($userId, 1); // Activity 1
$tempDB->clearUserActivityData($userId, 2); // Activity 2
$tempDB->clearUserActivityData($userId, 3); // Activity 3
echo "✅ Cleared temporary storage\n";

echo "\n🎉 User data cleared! You can now resubmit activities.\n";

