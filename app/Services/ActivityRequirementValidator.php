<?php

namespace App\Services;

use App\Models\Activity;
use DOMDocument;
use DOMNode;
use DOMXPath;

class ActivityRequirementValidator
{
    /**
     * Validate user code using deterministic metadata rules
     */
    public function validate(Activity $activity, string $userCode): array
    {
        $criteria = data_get($activity->metadata, 'validation_criteria', []);
        $domData = $this->prepareDom($userCode);

        if (empty($criteria) || !is_array($criteria)) {
            return [
                'rule_type' => 'none',
                'checks' => [],
                'score' => 100,
                'passed' => true,
                'has_checks' => false,
                'normalized_code' => mb_strtolower($userCode),
            ];
        }

        if ($this->isAssocArray($criteria)) {
            $result = $this->validateLegacyCriteria($criteria, $domData, $userCode);
            $ruleType = 'legacy';
        } else {
            $result = $this->validateStructuredCriteria($criteria, $domData, $userCode);
            $ruleType = 'structured';
        }

        return array_merge($result, [
            'rule_type' => $ruleType,
            'has_checks' => count($result['checks']) > 0,
            'normalized_code' => mb_strtolower($userCode),
        ]);
    }

    /**
     * Convert deterministic validation into the AI validation payload shape
     */
    public function toValidationResult(array $validation, array $instructions = [], bool $forcePass = false): array
    {
        $checks = $validation['checks'] ?? [];
        $total = count($checks);
        $passedCount = count(array_filter($checks, fn ($check) => $check['passed'] ?? false));
        $score = $forcePass ? 100 : ($validation['score'] ?? 0);
        $isCompleted = $forcePass ? true : (($validation['passed'] ?? false) && $total > 0);

        $requirementsAnalysis = [];
        $summaryDetails = [];
        $instructionDetails = [];
        $areasForImprovement = [];
        $positives = [];

        foreach ($checks as $index => $check) {
            $met = $forcePass ? true : ($check['passed'] ?? false);
            $description = $check['description'] ?? 'Requirement ' . ($index + 1);
            $message = $check['message'] ?? ($met ? 'Looks good' : 'Needs attention');

            $requirementsAnalysis[] = [
                'requirement' => $description,
                'met' => $met,
                'score' => $met ? 100 : 0,
                'explanation' => $message,
            ];

            $detailKey = 'requirement_' . ($index + 1);
            $summaryDetails[$detailKey] = [
                'passed' => $met,
                'message' => $message,
            ];
            $instructionDetails[$detailKey] = $met;

            if ($met) {
                $positives[] = $description;
            } else {
                $areasForImprovement[] = $description;
            }
        }

        $overallPassed = $forcePass ? $total : $passedCount;
        $percentage = $total > 0 ? round(($overallPassed / $total) * 100) : ($isCompleted ? 100 : 0);

        return [
            'ai_powered' => false,
            'overall_score' => $score,
            'completion_status' => $isCompleted ? 'passed' : 'failed',
            'is_completed' => $isCompleted,
            'requirements_analysis' => $requirementsAnalysis,
            'technical_validation' => $this->buildTechnicalSnapshot($validation['normalized_code'] ?? ''),
            'detailed_feedback' => $this->generateFeedback($validation, $forcePass),
            'suggestions' => array_map(
                fn ($item) => "Add or fix {$item}",
                array_slice($areasForImprovement, 0, 3)
            ),
            'positive_aspects' => array_slice($positives, 0, 2),
            'areas_for_improvement' => array_slice($areasForImprovement, 0, 3),
            'validation_summary' => [
                'overall' => [
                    'passed' => $overallPassed,
                    'total' => $total,
                    'percentage' => $percentage,
                ],
                'details' => $summaryDetails,
            ],
            'instruction_progress' => [
                'completed' => $overallPassed,
                'total' => $total,
                'percentage' => $percentage,
                'details' => $instructionDetails,
            ],
            'rule_checks' => $checks,
        ];
    }

    /**
     * Generate concise human feedback from deterministic validation
     */
    public function generateFeedback(array $validation, bool $wasAutoPassed = false): string
    {
        $checks = $validation['checks'] ?? [];
        $failed = array_values(array_filter($checks, fn ($check) => !($check['passed'] ?? false)));

        if (empty($failed)) {
            return $wasAutoPassed
                ? "✅ All required HTML checks passed, so we credited this activity even though AI feedback was unavailable."
                : "Great job! You satisfied every required HTML checkpoint for this activity.";
        }

        $lines = array_map(
            fn ($check) => '• ' . ($check['description'] ?? 'Fix the missing requirement'),
            array_slice($failed, 0, 4)
        );

        return "Please address these requirements and try again:\n" . implode("\n", $lines);
    }

    /**
     * Determine if an array is associative
     */
    private function isAssocArray(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * Prepare DOM helpers
     */
    private function prepareDom(string $html): array
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $content = '<?xml encoding="utf-8" ?>' . $html;
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        return [
            'dom' => $dom,
            'xpath' => new DOMXPath($dom),
        ];
    }

    private function validateLegacyCriteria(array $criteria, array $domData, string $userCode): array
    {
        $checks = [];
        $xpath = $domData['xpath'];
        $lowerCode = mb_strtolower($userCode);

        foreach ($criteria['required_elements'] ?? [] as $tag) {
            $passed = $xpath->query('//' . strtolower($tag))->length > 0;
            $checks[] = [
                'key' => "required_element_{$tag}",
                'description' => "Include the <{$tag}> element",
                'passed' => $passed,
                'message' => $passed ? "Found <{$tag}>." : "Add a <{$tag}> element.",
            ];
        }

        foreach ($criteria['required_attributes'] ?? [] as $tag => $attributes) {
            foreach ($attributes as $attribute => $expected) {
                $passed = $this->elementHasAttribute($xpath, $tag, $attribute, $expected);
                $expectedLabel = is_string($expected) ? "=\"{$expected}\"" : '';
                $checks[] = [
                    'key' => "required_attribute_{$tag}_{$attribute}",
                    'description' => "Ensure <{$tag}> has {$attribute}{$expectedLabel}",
                    'passed' => $passed,
                    'message' => $passed
                        ? "Attribute {$attribute} present on <{$tag}>."
                        : "Add {$attribute}{$expectedLabel} to <{$tag}>.",
                ];
            }
        }

        foreach ($criteria['structure_checks'] ?? [] as $index => $check) {
            $result = $this->evaluateStructureCheck($check, $xpath, $lowerCode);
            $checks[] = array_merge(
                [
                    'key' => "structure_check_{$index}",
                    'description' => $result['description'],
                ],
                $result
            );
        }

        $score = $this->calculateScore($checks);

        return [
            'checks' => $checks,
            'score' => $score,
            'passed' => $score >= 100 || $this->allChecksPassed($checks),
        ];
    }

    private function validateStructuredCriteria(array $criteria, array $domData, string $userCode): array
    {
        $checks = [];
        $totalPoints = 0;
        $earnedPoints = 0;

        foreach ($criteria as $index => $rule) {
            $points = (int)($rule['points'] ?? 10);
            $evaluation = $this->evaluateStructuredRule($rule, $domData, $userCode);
            $passed = $evaluation['passed'];
            $message = $evaluation['message'];

            $totalPoints += $points;
            if ($passed) {
                $earnedPoints += $points;
            }

            $checks[] = [
                'key' => 'rule_' . ($index + 1),
                'description' => $rule['description'] ?? 'Requirement ' . ($index + 1),
                'passed' => $passed,
                'message' => $message,
                'points' => $points,
            ];
        }

        $score = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;

        return [
            'checks' => $checks,
            'score' => $score,
            'passed' => $this->allChecksPassed($checks),
            'total_points' => $totalPoints,
            'earned_points' => $earnedPoints,
        ];
    }

    private function elementHasAttribute(DOMXPath $xpath, string $tag, string $attribute, $expected): bool
    {
        $nodes = $xpath->query('//' . strtolower($tag));
        if (!$nodes || $nodes->length === 0) {
            return false;
        }

        foreach ($nodes as $node) {
            if (!$node->hasAttributes()) {
                continue;
            }

            $value = $node->attributes->getNamedItem($attribute)?->nodeValue;
            if ($value === null) {
                continue;
            }

            if ($expected === true) {
                return true;
            }

            if (is_array($expected)) {
                foreach ($expected as $candidate) {
                    if (strcasecmp((string)$value, (string)$candidate) === 0) {
                        return true;
                    }
                }
            } else {
                if (strcasecmp((string)$value, (string)$expected) === 0) {
                    return true;
                }
            }
        }

        return false;
    }

    private function evaluateStructureCheck(array $check, DOMXPath $xpath, string $lowerCode): array
    {
        $type = $check['type'] ?? 'unknown';
        switch ($type) {
            case 'doctype':
                $passed = str_contains($lowerCode, '<!doctype');
                return [
                    'passed' => $passed,
                    'message' => $passed ? 'DOCTYPE found.' : 'Add <!DOCTYPE html> at the top.',
                    'description' => 'Include <!DOCTYPE html>',
                ];
            case 'nested':
                $parent = strtolower($check['parent'] ?? '');
                $child = strtolower($check['child'] ?? '');
                $passed = $parent && $child && $xpath->query("//{$parent}//{$child}")->length > 0;
                return [
                    'passed' => $passed,
                    'message' => $passed
                        ? "<{$child}> is nested in <{$parent}>."
                        : "Place <{$child}> inside <{$parent}>.",
                    'description' => "Nest <{$child}> inside <{$parent}>",
                ];
            case 'order':
                $first = strtolower($check['first'] ?? '');
                $second = strtolower($check['second'] ?? '');
                $firstPos = $first ? strpos($lowerCode, "<{$first}") : false;
                $secondPos = $second ? strpos($lowerCode, "<{$second}") : false;
                $passed = $firstPos !== false && $secondPos !== false && $firstPos < $secondPos;
                return [
                    'passed' => $passed,
                    'message' => $passed
                        ? "<{$first}> appears before <{$second}>."
                        : "Ensure <{$first}> comes before <{$second}>.",
                    'description' => "Order <{$first}> before <{$second}>",
                ];
            default:
                return [
                    'passed' => false,
                    'message' => 'Unknown structure requirement.',
                    'description' => 'Meet the structure requirement',
                ];
        }
    }

    private function evaluateStructuredRule(array $rule, array $domData, string $userCode): array
    {
        $type = $rule['test_type'] ?? 'contains';
        $expected = $rule['expected'] ?? '';
        $lowerCode = mb_strtolower($userCode);

        switch ($type) {
            case 'contains':
                $passed = $expected && str_contains($lowerCode, mb_strtolower($expected));
                break;
            case 'regex':
                $pattern = '~' . $expected . '~is';
                $passed = $expected && @preg_match($pattern, $userCode) === 1;
                break;
            case 'count':
                $minCount = (int)($rule['min_count'] ?? 1);
                $passed = $expected && $this->countOccurrences($lowerCode, mb_strtolower($expected)) >= $minCount;
                break;
            case 'structure':
                $tags = array_filter(array_map('trim', explode(',', (string)$expected)));
                $passed = !empty($tags) && $this->allTagsPresent($lowerCode, $tags);
                break;
            case 'structure_depth':
                $requiredDepth = (int)$expected;
                $depth = $this->calculateDomDepth($domData['dom']->documentElement ?? null);
                $passed = $depth >= $requiredDepth;
                break;
            case 'count_any':
                $needles = is_array($expected) ? $expected : [$expected];
                $minCount = (int)($rule['min_count'] ?? 1);
                $count = 0;
                foreach ($needles as $needle) {
                    $count += $this->countOccurrences($lowerCode, mb_strtolower((string)$needle));
                }
                $passed = $count >= $minCount;
                break;
            case 'no_uppercase_tags':
                $codeWithoutDoctype = preg_replace('/<!DOCTYPE[^>]+>/i', '', $userCode);
                $passed = !preg_match('/<\s*\/?[A-Z][A-Z0-9-]*/', $codeWithoutDoctype);
                break;
            default:
                $passed = $expected && str_contains($lowerCode, mb_strtolower($expected));
        }

        $description = $rule['description'] ?? 'Requirement';
        $message = $passed ? 'Requirement satisfied.' : ($rule['failure_message'] ?? $description);

        return [
            'passed' => $passed,
            'message' => $message,
        ];
    }

    private function calculateDomDepth(?DOMNode $node, int $depth = 0): int
    {
        if (!$node || !$node->hasChildNodes()) {
            return $depth;
        }

        $maxDepth = $depth;
        foreach ($node->childNodes as $child) {
            if ($child->nodeType === XML_ELEMENT_NODE) {
                $maxDepth = max($maxDepth, $this->calculateDomDepth($child, $depth + 1));
            }
        }

        return $maxDepth;
    }

    private function countOccurrences(string $haystack, string $needle): int
    {
        if ($needle === '') {
            return 0;
        }

        return substr_count($haystack, $needle);
    }

    private function allTagsPresent(string $code, array $tags): bool
    {
        foreach ($tags as $tag) {
            if (!str_contains($code, '<' . strtolower($tag))) {
                return false;
            }
        }
        return true;
    }

    private function calculateScore(array $checks): int
    {
        $total = count($checks);
        if ($total === 0) {
            return 0;
        }

        $passed = count(array_filter($checks, fn ($check) => $check['passed']));
        return round(($passed / $total) * 100);
    }

    private function allChecksPassed(array $checks): bool
    {
        foreach ($checks as $check) {
            if (!($check['passed'] ?? false)) {
                return false;
            }
        }
        return !empty($checks);
    }

    private function buildTechnicalSnapshot(string $normalizedCode): array
    {
        $hasHtml = str_contains($normalizedCode, '<html');
        $hasHead = str_contains($normalizedCode, '<head');
        $hasBody = str_contains($normalizedCode, '<body');

        return [
            'html_structure' => $hasHtml && $hasHead && $hasBody,
            'syntax_valid' => true,
            'semantic_quality' =>  min(100, max(40, strlen($normalizedCode) > 0 ? 80 : 40)),
            'accessibility' => min(100, max(40, strlen($normalizedCode) > 0 ? 75 : 40)),
        ];
    }
}

