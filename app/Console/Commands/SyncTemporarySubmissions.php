<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\ActivitySubmission;

class SyncTemporarySubmissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'submissions:sync-temp
                            {--clear : Clear temporary files after sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync temporary JSON submissions to the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting sync of temporary submissions to database...');
        
        $filename = 'temp_db/submissions.json';
        
        if (!Storage::disk('local')->exists($filename)) {
            $this->warn('⚠️ No temporary submissions file found.');
            return Command::SUCCESS;
        }
        
        $content = Storage::disk('local')->get($filename);
        $submissions = json_decode($content, true) ?: [];
        
        if (empty($submissions)) {
            $this->info('ℹ️ No submissions to sync.');
            return Command::SUCCESS;
        }
        
        $this->info(sprintf('📊 Found %d submissions in temporary storage', count($submissions)));
        
        $synced = 0;
        $skipped = 0;
        $errors = 0;
        
        $bar = $this->output->createProgressBar(count($submissions));
        $bar->start();
        
        foreach ($submissions as $submission) {
            try {
                // Check if already exists in database
                $exists = ActivitySubmission::where('user_id', $submission['user_id'])
                    ->where('activity_id', $submission['activity_id'])
                    ->where('attempt_number', $submission['attempt_number'])
                    ->exists();
                
                if ($exists) {
                    $skipped++;
                    $bar->advance();
                    continue;
                }
                
                // Create in database
                ActivitySubmission::create([
                    'user_id' => $submission['user_id'],
                    'activity_id' => $submission['activity_id'],
                    'submitted_code' => $submission['submitted_code'],
                    'score' => $submission['score'],
                    'is_completed' => $submission['is_completed'],
                    'completion_status' => $submission['completion_status'],
                    'time_spent_minutes' => $submission['time_spent_minutes'] ?? 0,
                    'feedback' => $submission['feedback'],
                    'attempt_number' => $submission['attempt_number'],
                    'validation_results' => is_string($submission['validation_results']) 
                        ? $submission['validation_results'] 
                        : json_encode($submission['validation_results']),
                    'submitted_at' => $submission['created_at'] ?? now(),
                    'completed_at' => $submission['is_completed'] ? ($submission['created_at'] ?? now()) : null
                ]);
                
                $synced++;
                
            } catch (\Exception $e) {
                $errors++;
                Log::error('Failed to sync submission', [
                    'submission' => $submission,
                    'error' => $e->getMessage()
                ]);
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        
        // Display results
        $this->info(sprintf('✅ Synced: %d', $synced));
        $this->info(sprintf('⏭️ Skipped (already in DB): %d', $skipped));
        
        if ($errors > 0) {
            $this->error(sprintf('❌ Errors: %d', $errors));
        }
        
        // Clear temporary files if requested
        if ($this->option('clear') && $synced > 0) {
            if ($this->confirm('Clear temporary submission files?', true)) {
                Storage::disk('local')->delete($filename);
                $this->info('🗑️ Temporary files cleared');
            }
        }
        
        $this->newLine();
        $this->info('🎉 Sync completed successfully!');
        
        return Command::SUCCESS;
    }
}

