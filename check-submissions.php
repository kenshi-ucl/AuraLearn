<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ActivitySubmission;
use App\Models\UserProgress;

echo "=== CHECKING USER 6 DATA ===\n\n";

// Check activity submissions
$submissions = ActivitySubmission::where('user_id', 6)->get();
echo "Activity Submissions: " . $submissions->count() . "\n";

if ($submissions->count() > 0) {
    foreach ($submissions as $sub) {
        echo "  - Activity #{$sub->activity_id}: Score={$sub->score}, Completed={$sub->is_completed}, Time={$sub->time_spent_minutes}min\n";
    }
    
    $totalTime = $submissions->sum('time_spent_minutes');
    $completedCount = $submissions->where('is_completed', 1)->count();
    
    echo "\nTotal time spent: {$totalTime} minutes\n";
    echo "Completed activities: {$completedCount}\n";
} else {
    echo "  (No submissions found)\n";
}

echo "\n--- User Progress Records ---\n";
$progress = UserProgress::where('user_id', 6)->get();
echo "Progress Records: " . $progress->count() . "\n";

if ($progress->count() > 0) {
    foreach ($progress as $p) {
        echo "  - Lesson #{$p->lesson_id}: {$p->completion_percentage}% complete\n";
    }
} else {
    echo "  (No progress records found)\n";
}

echo "\n=== DONE ===\n";

