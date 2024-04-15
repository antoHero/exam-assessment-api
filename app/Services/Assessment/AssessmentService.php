<?php

namespace App\Services\Assessment;

use App\Http\Requests\{StoreAssessmentRequest, UpdateAssessmentRequest};
use App\Models\{Answer, Assessment, Option};
use Illuminate\Support\Facades\DB;

class AssessmentService
{
    /**
     * create an assessment
     * @param App\Http\Requests\StoreAssessmentRequest|array $request
     * @return App\Models\Assessment
    */

    public function create_assessment(StoreAssessmentRequest|array $request): Assessment
    {
        return DB::transaction(function () use($request) {
            return Assessment::create([
                'user_id' => auth()->id(),
                'title' => $request['title'],
                'instructions' => $request['instructions'],
                'date' => $request['date'],
                'duration' => $request['duration'],
                'expected_score' => $request['expected_score'],
            ]);
        });
    }

    /**
     * create an assessment
     * @param App\Http\Requests\StoreAssessmentRequest|array $request
     * @param App\Models\Assessment $assessment
     * @return bool
    */

    public function update_assessment(UpdateAssessmentRequest|array $request, Assessment $assessment): bool
    {
        return DB::transaction(function () use($request, $assessment) {
            return $assessment->update([
                'title' => $request['title'] ?? $assessment->title,
                'instructions' => $request['instructions'] ?? $assessment->instructions,
                'date' => $request['date'] ?? $assessment->date,
                'duration' => $request['duration'] ?? $assessment->duration,
                'expected_score' => $request['expected_score'] ?? $assessment->expected_score,
            ]);
        });
    }

    /**
     * get a users' assessment results
     * @param App\Models\Assessment $assessment
     * @return int
    */

    public function get_users_assessment_result(Assessment $assessment): int
    {
        $userAnsers = Answer::whereUserId(auth()->user()->id)->whereAssessmentId($assessment->id)->get();

        if(!$userAnsers) {
            return 'not found';
        }
        $score = 0;
        foreach($userAnsers as $answer) {

            $selectedOptions = $answer->selected_options;

            $attemptScore = 0;

            foreach($selectedOptions as $optionId) {
                // retrieve the question
                $option = Option::findOrFail($optionId);
                $question = $option->question;

                $correctOptions = $question->options()->where('isAnswer', true)->pluck('id')->toArray();

                if($this->optionsAreCorrect($correctOptions, $selectedOptions)) {
                    $attemptScore += $question->marks;
                }
            }

            $score += $attemptScore;
        }

        return $score;
    }

    private function optionsAreCorrect($correctOptions, $selectedOptions)
    {
        return ($correctOptions === $selectedOptions);
    }
}