<?php

namespace App\Services\Assessment;

use App\Http\Requests\{StoreAnswerRequest, StoreQuestionRequest, UpdateQuestionRequest};
use App\Models\{Answer, Assessment, Option, Question};
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

    /**
     * create an option for a question
     * @param \App\Http\Requests\UpdateOptionRequest|array $request
     * @param \App\Models\Option $option
     * @return bool
    */
    public function upate_option(UpdateOptionRequest|array $request, Option $option): bool
    {
        return DB::transaction(function () use ($request, $option) {
            $question = $option->question;
            if($request['question_type'] === 'single' && $question->options()->where('isAnswer', true)->first() && $request['isAnswer'] === true) {
                return false;
            }
            return $option->update([
                'content' => $request['content'] ?? $option->content,
                'isAnswer' => $request['isAnswer'] ?? $option->isAnswer
            ]);
        });
    }

    /**
     * submit an answer
     * @param \App\Http\Requests\StoreAnswerRequest|array $request
     * @param \App\Models\Question $question
     * @return \App\Models\Answer
    */
    public function submit_answer(StoreAnswerRequest|array $request, Question $question): Answer
    {
        return DB::transaction(function () use ($request, $question) {
            $userId = auth()->user()->id;
            return Answer::updateOrCreate(
                [
                    'question_id' => $question->id,
                    'user_id' => $userId
                ],
                [
                'selected_options' => $request['selected_options'],
                'question_id' => $question->id,
                'assessment_id' => $question->assessment->id,
                'user_id' => $userId
            ]);
        });
    }
}