<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Resources\AssessmentResource;
use App\Services\Assessment\AssessmentService;
use Illuminate\Http\{JsonResponse};
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AssessmentController extends BaseController
{
    public function __construct(
        public AssessmentService $assessmentService
    ){}

    public function store(StoreAssessmentRequest $request): JsonResponse
    {

        $gateRequest = Gate::inspect('create-assessment');
        if($gateRequest->allowed()) {
            $assessment = $this->assessmentService->create_assessment($request->validated());
            return $this->ok(new AssessmentResource($assessment), 'Assessment created successfully', Response::HTTP_CREATED);
        }
        return $this->unauthorized($gateRequest->message());
    }
}
