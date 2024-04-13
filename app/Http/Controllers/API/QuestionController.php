<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\{Assessment, Question};
use App\Services\Assessment\QuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends BaseController
{
    public function __construct(
        public QuestionService $questionService
    ){}

    public function index(Assessment $assessment): JsonResponse
    {
        return $this->ok(QuestionResource::collection($assessment->questions), 'Questions successfully retrieved.', Response::HTTP_OK);
    }

    public function store(StoreQuestionRequest $request, Assessment $assessment): JsonResponse
    {
        $gateRequest = Gate::inspect('create-question', $assessment);
        if($gateRequest->allowed()) {
            $question = $this->questionService->create_question($request->validated(), $assessment);
            return $this->ok(new QuestionResource($question), 'Question successfully created.', Response::HTTP_CREATED);
        }
        return $this->unauthorized($gateRequest->message());
    }

    public function view(Question $question): JsonResponse
    {
        return $this->ok(new QuestionResource($question), 'Question successfully created.', Response::HTTP_OK);
    }
}
