<?php

namespace App\Http\Controllers;

use App\Models\UserProgress;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserProgressController extends Controller
{
    /**
     * Track when user starts a lesson
     */
    public function trackLessonStart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'course_id' => 'required|integer',
            'lesson_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $progress = UserProgress::firstOrCreate(
                [
                    'user_id' => $request->user_id,
                    'course_id' => $request->course_id,
                    'lesson_id' => $request->lesson_id,
                ],
                [
                    'started_at' => now(),
                    'completion_percentage' => 0,
                    'is_completed' => 0,
                ]
            );

            // If lesson was already started, just update the timestamp
            if (!$progress->wasRecentlyCreated) {
                $progress->touch();
            }

            return response()->json([
                'message' => 'Lesson start tracked successfully',
                'progress' => $progress
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to track lesson start: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to track lesson start',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update lesson progress percentage
     */
    public function updateLessonProgress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'course_id' => 'required|integer',
            'lesson_id' => 'required|integer',
            'completion_percentage' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $progress = UserProgress::firstOrCreate(
                [
                    'user_id' => $request->user_id,
                    'course_id' => $request->course_id,
                    'lesson_id' => $request->lesson_id,
                ],
                [
                    'started_at' => now(),
                ]
            );

            $progress->completion_percentage = $request->completion_percentage;
            
            // Auto-mark as completed if 100%
            if ($request->completion_percentage >= 100) {
                $progress->is_completed = 1;
                $progress->completed_at = $progress->completed_at ?? now();
            }
            
            $progress->save();

            return response()->json([
                'message' => 'Progress updated successfully',
                'progress' => $progress
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to update progress: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update progress',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Track time spent on a lesson
     */
    public function trackTimeSpent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'course_id' => 'required|integer',
            'lesson_id' => 'required|integer',
            'time_spent_minutes' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $progress = UserProgress::firstOrCreate(
                [
                    'user_id' => $request->user_id,
                    'course_id' => $request->course_id,
                    'lesson_id' => $request->lesson_id,
                ],
                [
                    'started_at' => now(),
                ]
            );

            // Note: The activity_submissions table tracks time_spent_minutes
            // This could be extended to track lesson viewing time separately
            $progress->touch(); // Update timestamp

            return response()->json([
                'message' => 'Time tracked successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to track time: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to track time',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Track topic completion within a lesson
     */
    public function trackTopicComplete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'course_id' => 'required|integer',
            'lesson_id' => 'required|integer',
            'topic_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $progress = UserProgress::firstOrCreate(
                [
                    'user_id' => $request->user_id,
                    'course_id' => $request->course_id,
                    'lesson_id' => $request->lesson_id,
                ],
                [
                    'started_at' => now(),
                ]
            );

            // Add topic to completed topics array
            $completedTopics = $progress->completed_topics ?? [];
            $topicId = (int)$request->topic_id;
            
            if (!in_array($topicId, $completedTopics)) {
                $completedTopics[] = $topicId;
                $progress->completed_topics = $completedTopics;
                $progress->save();
            }

            return response()->json([
                'message' => 'Topic completion tracked successfully',
                'completed_topics' => $completedTopics
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to track topic completion: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to track topic completion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user progress for a specific lesson
     */
    public function getLessonProgress(Request $request)
    {
        $userId = $request->query('user_id');
        $courseId = $request->query('course_id');
        $lessonId = $request->query('lesson_id');

        if (!$userId || !$courseId || !$lessonId) {
            return response()->json([
                'message' => 'Missing required parameters'
            ], 400);
        }

        try {
            $progress = UserProgress::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->where('lesson_id', $lessonId)
                ->first();

            if (!$progress) {
                return response()->json([
                    'completion_percentage' => 0,
                    'is_completed' => false,
                    'time_spent_minutes' => 0
                ]);
            }

            return response()->json([
                'completion_percentage' => $progress->completion_percentage,
                'is_completed' => (bool)$progress->is_completed,
                'time_spent_minutes' => 0, // Can be calculated from activity submissions
                'started_at' => $progress->started_at,
                'completed_at' => $progress->completed_at,
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to get lesson progress: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to get progress',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

