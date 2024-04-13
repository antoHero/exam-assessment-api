<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Requests\UpdateAssessmentRequest;
use App\Http\Resources\AssessmentResource;
use App\Models\Assessment;
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

    public function view(Assessment $assessment): JsonResponse
    {
        return $this->ok(new AssessmentResource($assessment), 'Assessment successfully retrieved', Response::HTTP_OK);
    }

    public function update(UpdateAssessmentRequest $request, Assessment $assessment): JsonResponse
    {
        $gateRequest = Gate::inspect('update-assessment', $assessment);
        if($gateRequest->allowed()) {
            $this->assessmentService->update_assessment($request->validated(), $assessment);
            return $this->ok(new AssessmentResource($assessment), 'Assessment successfully updated', Response::HTTP_OK);
        }
        return $this->unauthorized($gateRequest->message());
    }

    public function delete(Assessment $assessment): JsonResponse
    {
        $gateRequest = Gate::inspect('delete-assessment', $assessment);
        if($gateRequest->allowed()) {
            $assessment->delete();
            return $this->ok(null, 'Assessment successfully deleted', Response::HTTP_OK);
        }
        return $this->unauthorized($gateRequest->message());
    }
}
