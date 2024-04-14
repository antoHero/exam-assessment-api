<?php

namespace App\Services\Assessment;

use App\Http\Requests\{StoreQuestionRequest, UpdateQuestionRequest};
use App\Models\{Assessment, Option, Question};
use Illuminate\Support\Facades\DB;

class QuestionService {

    /**
     * create a question
     * @param \App\Http\Requests\StoreQuestionRequest|array $request
     * @param \App\Models\Assessment $assessment
     * @return \App\Models\Question
    */
    public function create_question(StoreQuestionRequest|array $request, Assessment $assessment): Question
    {
        return DB::transaction(function () use ($request, $assessment) {
            return $assessment->questions()->create($request);
        });
    }

    /**
     * create a question
     * @param \App\Http\Requests\UpdateQuestionRequest|array $request
     * @param \App\Models\Question $question
     * @return bool
    */
    public function update_question(UpdateQuestionRequest|array $request, Question $question): bool
    {
        return DB::transaction(function () use ($request, $question) {
            return $question->update([
                'question' => $request['question'] ?? $question->question,
                'type' => $request['type'] ?? $question->type,
                'marks' => $request['marks'] ?? $question->marks
            ]);
        });
    }

    /**
     * create an option for a question
     * @param \App\Http\Requests\StoreOptionRequest|array $request
     * @param \App\Models\Question $question
     * @return \App\Models\Option
    */
    public function create_option(StoreOptionRequest|array $request, Question $question): Option
    {
        return DB::transaction(function () use ($request, $question) {
            return $question->options()->create($request);
        });
    }
}