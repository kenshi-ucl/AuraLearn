<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AiValidationService
{
    private NebiusClient $nebiusClient;
    private int $maxExecutionTime;
    private int $maxTokens;

    public function __construct(NebiusClient $nebiusClient)
    {
        $this->nebiusClient = $nebiusClient;
        $this->maxExecutionTime = (int) env('AI_VALIDATION_TIMEOUT_SECONDS', 12);
        $this->maxTokens = max(400, min((int) env('AI_VALIDATION_MAX_TOKENS', 900), 2000));
    }

    /**
     * AI-powered validation of user code against activity instructions
     */
    public function validateCodeWithAi($userCode, $instructions, $activityTitle, $activityDescription = null)
    {
        Log::info('Starting AI validation', [
            'activity_title' => $activityTitle,
            'code_length' => strlen($userCode),
            'instructions_count' => count($instructions)
        ]);

        // Track execution time for observability
        $startTime = microtime(true);

        // Prepare the AI prompt for validation
        $prompt = $this->buildValidationPrompt($userCode, $instructions, $activityTitle, $activityDescription);
        
        // Format prompt as messages array for NebiusClient
        $messages = [
            [
                'role' => 'system',
                'content' => 'You are an expert HTML instructor evaluating student code submissions. Provide concise, structured validation in JSON format. Be strict and accurate.'
            ],
            [
                'role' => 'user',
                'content' => $prompt
            ]
        ];
        
        // Get AI analysis
        $aiResponse = $this->nebiusClient->createChatCompletion($messages, [
            'max_tokens' => $this->maxTokens
        ]);
        
        // Check if we exceeded time limit
        $executionTime = microtime(true) - $startTime;
        if ($executionTime > $this->maxExecutionTime) {
            Log::warning('AI validation took longer than expected', [
                'execution_time' => $executionTime,
                'configured_max' => $this->maxExecutionTime
            ]);
        }
        
        // Parse the AI response into structured validation data
        $validationResult = $this->parseAiValidationResponse($aiResponse);
        
        Log::info('AI validation completed', [
            'overall_score' => $validationResult['overall_score'],
            'completion_status' => $validationResult['completion_status'],
            'execution_time' => $executionTime
        ]);

        return $validationResult;
    }

    /**
     * Build comprehensive validation prompt for AI
     */
    private function buildValidationPrompt($userCode, $instructions, $activityTitle, $activityDescription)
    {
        $instructionsText = is_array($instructions) ? implode("\n", $instructions) : $instructions;
        
        return "Evaluate this HTML code for '{$activityTitle}'.

REQUIREMENTS:
{$instructionsText}

CODE:
```html
{$userCode}
```

Return JSON with:
- overall_score: 0-100
- completion_status: 'passed'/'partial'/'failed' 
- requirements_analysis: [{requirement, met: bool, score, explanation}]
- technical_validation: {html_structure: bool, syntax_valid: bool, semantic_quality: 0-100, accessibility: 0-100}
- detailed_feedback: max 100 chars on what to fix
- suggestions: max 3 brief fixes
- areas_for_improvement: max 3 issues
- positive_aspects: max 2 positives

Be VERY concise. Focus on errors. JSON only.";
    }

    /**
     * Parse AI response into structured validation result
     */
    private function parseAiValidationResponse($aiResponse)
    {
        try {
            // Extract content from AI response (it's nested in the response structure)
            if (is_array($aiResponse) && isset($aiResponse['choices'][0]['message']['content'])) {
                $responseContent = $aiResponse['choices'][0]['message']['content'];
            } elseif (is_array($aiResponse) && isset($aiResponse['content'])) {
                $responseContent = $aiResponse['content'];
            } else {
                $responseContent = is_string($aiResponse) ? $aiResponse : json_encode($aiResponse);
            }
            
            // Clean the response (remove any markdown code blocks or extra text)
            $cleanResponse = $this->cleanJsonResponse($responseContent);
            
            // Parse JSON response from AI
            $aiResult = json_decode($cleanResponse, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response from AI: ' . json_last_error_msg());
            }

            // Validate and structure the response
            return [
                'ai_powered' => true,
                'overall_score' => $this->validateScore($aiResult['overall_score'] ?? 0),
                'completion_status' => $this->validateCompletionStatus($aiResult['completion_status'] ?? 'failed'),
                'is_completed' => ($aiResult['overall_score'] ?? 0) >= 80,
                'requirements_analysis' => $aiResult['requirements_analysis'] ?? [],
                'technical_validation' => $this->validateTechnicalResults($aiResult['technical_validation'] ?? []),
                'detailed_feedback' => $aiResult['detailed_feedback'] ?? 'No detailed feedback available.',
                'suggestions' => $aiResult['suggestions'] ?? [],
                'positive_aspects' => $aiResult['positive_aspects'] ?? [],
                'areas_for_improvement' => $aiResult['areas_for_improvement'] ?? [],
                'validation_summary' => $this->createValidationSummary($aiResult),
                'instruction_progress' => $this->createInstructionProgress($aiResult['requirements_analysis'] ?? [])
            ];

        } catch (\Exception $e) {
            Log::error('Failed to parse AI validation response', [
                'error' => $e->getMessage(),
                'response_preview' => is_string($aiResponse) ? substr($aiResponse, 0, 200) : substr(json_encode($aiResponse), 0, 200)
            ]);

            throw $e;
        }
    }

    /**
     * Clean JSON response from potential markdown or extra text
     */
    private function cleanJsonResponse($response)
    {
        // Remove markdown code blocks
        $response = preg_replace('/```json\s*/', '', $response);
        $response = preg_replace('/```\s*$/', '', $response);
        
        // Find JSON object boundaries
        $start = strpos($response, '{');
        $end = strrpos($response, '}');
        
        if ($start !== false && $end !== false && $end > $start) {
            return substr($response, $start, $end - $start + 1);
        }
        
        return trim($response);
    }

    /**
     * Validate and normalize score
     */
    private function validateScore($score)
    {
        $score = floatval($score);
        return max(0, min(100, $score));
    }

    /**
     * Validate completion status and map to database-compatible values
     */
    private function validateCompletionStatus($status)
    {
        // Map AI statuses to database-compatible values
        $statusMapping = [
            'passed' => 'passed',
            'partial' => 'needs_review', // Map 'partial' to 'needs_review' for database
            'failed' => 'failed'
        ];
        
        $normalizedStatus = strtolower(trim($status));
        return $statusMapping[$normalizedStatus] ?? 'failed';
    }

    /**
     * Validate technical validation results
     */
    private function validateTechnicalResults($technical)
    {
        return [
            'html_structure' => $technical['html_structure'] ?? false,
            'syntax_valid' => $technical['syntax_valid'] ?? false,
            'semantic_quality' => $this->validateScore($technical['semantic_quality'] ?? 0),
            'accessibility' => $this->validateScore($technical['accessibility'] ?? 0)
        ];
    }

    /**
     * Create validation summary from AI results
     */
    private function createValidationSummary($aiResult)
    {
        $technical = $aiResult['technical_validation'] ?? [];
        $requirements = $aiResult['requirements_analysis'] ?? [];
        
        $passedChecks = 0;
        $totalChecks = 0;

        // Count technical checks
        foreach (['html_structure', 'syntax_valid'] as $check) {
            $totalChecks++;
            if ($technical[$check] ?? false) {
                $passedChecks++;
            }
        }

        // Count requirement checks
        foreach ($requirements as $req) {
            $totalChecks++;
            if ($req['met'] ?? false) {
                $passedChecks++;
            }
        }

        return [
            'overall' => [
                'passed' => $passedChecks,
                'total' => $totalChecks,
                'percentage' => $totalChecks > 0 ? round(($passedChecks / $totalChecks) * 100) : 0
            ],
            'details' => [
                'html_structure_check' => [
                    'passed' => $technical['html_structure'] ?? false,
                    'message' => ($technical['html_structure'] ?? false) ? 
                        'HTML structure is valid' : 'HTML structure needs improvement'
                ],
                'syntax_validation' => [
                    'passed' => $technical['syntax_valid'] ?? false,
                    'message' => ($technical['syntax_valid'] ?? false) ? 
                        'Syntax is valid' : 'Syntax errors detected'
                ],
                'semantic_quality' => [
                    'passed' => ($technical['semantic_quality'] ?? 0) >= 70,
                    'message' => ($technical['semantic_quality'] ?? 0) >= 70 ? 
                        'Good semantic HTML usage' : 'Semantic HTML usage could be improved'
                ],
                'accessibility_check' => [
                    'passed' => ($technical['accessibility'] ?? 0) >= 70,
                    'message' => ($technical['accessibility'] ?? 0) >= 70 ? 
                        'Good accessibility practices' : 'Accessibility could be improved'
                ]
            ]
        ];
    }

    /**
     * Create instruction progress from requirements analysis
     */
    private function createInstructionProgress($requirements)
    {
        if (empty($requirements)) {
            return [
                'completed' => 0,
                'total' => 0,
                'percentage' => 0,
                'details' => []
            ];
        }

        $completed = 0;
        $details = [];

        foreach ($requirements as $index => $req) {
            $key = "requirement_" . ($index + 1);
            $met = $req['met'] ?? false;
            
            if ($met) {
                $completed++;
            }
            
            $details[$key] = $met;
        }

        return [
            'completed' => $completed,
            'total' => count($requirements),
            'percentage' => count($requirements) > 0 ? round(($completed / count($requirements)) * 100) : 0,
            'details' => $details
        ];
    }

    /**
     * Generate concise educational feedback
     */
    public function generateEducationalFeedback($validationResult)
    {
        $feedback = [];
        
        if ($validationResult['is_completed']) {
            return "🎉 **Perfect!** All requirements completed successfully.";
        }

        // Only show what needs to be fixed
        if (!empty($validationResult['areas_for_improvement'])) {
            $feedback[] = "🔧 **Fix these issues:**";
            foreach (array_slice($validationResult['areas_for_improvement'], 0, 3) as $area) {
                $feedback[] = "• " . $area;
            }
        }

        // Show only the top 2 specific suggestions
        if (!empty($validationResult['suggestions'])) {
            $feedback[] = "\n💡 **Quick fixes:**";
            foreach (array_slice($validationResult['suggestions'], 0, 2) as $suggestion) {
                $feedback[] = "• " . $suggestion;
            }
        }

        return implode("\n", $feedback);
    }

    /**
     * Quick AI feedback for failed submissions
     */
    public function generateQuickFeedback($userCode, $requirements, $score)
    {
        try {
            $prompt = "As an HTML instructor, provide brief, encouraging feedback for a student whose code scored {$score}%. 

Requirements they need to meet:
" . implode("\n", $requirements) . "

Their code:
```html
{$userCode}
```

Provide 2-3 sentences of constructive feedback focusing on what they can improve. Be encouraging and specific.";

            $messages = [
                [
                    'role' => 'system',
                    'content' => 'You are an HTML instructor providing brief, constructive feedback.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ];
            
            return $this->nebiusClient->createChatCompletion($messages);

        } catch (\Exception $e) {
            Log::error('Quick feedback generation failed', ['error' => $e->getMessage()]);
            return "Keep working on meeting the requirements! Review the instructions carefully and ensure your HTML structure is complete.";
        }
    }
}
