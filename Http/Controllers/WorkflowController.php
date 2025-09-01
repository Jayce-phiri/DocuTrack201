<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    protected $workflowService;

    public function __construct(WorkflowService $workflowService)
    {
        $this->workflowService = $workflowService;
    }

    public function submit($document){
        $this->workflowService->submit($document);
        return response()->json(['message' => 'Document submitted successfully']);
    }

    public function approve(WorkflowRequest $request, Workflow $workflow)
    {
    
        $this->workflowService->approveStep($workflow, $request->input('action'), $request->input('comments'));
        return response()->json(['message' => 'Document approved successfully']);
    }

    public function reject(WorkflowRequest $request, Workflow $workflow)
    {
        $this->workflowService->rejectStep($workflow, $request->input('comments'));
        return response()->json(['message' => 'Document rejected successfully']);
    }
}