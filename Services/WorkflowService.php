<?php

namespace App\Services;

use App\Models\Workflow;
use Illuminate\Support\Facades\Auth;

class WorkflowService
{
    public function submitDocument($document)
    {
        Workflow::create([
            'document_id' => $document->id,
            'initiator_id' => Auth::user()->nrc,
            'origin_department' => Auth::user()->department_code,
            'destination_department' => 'Section_Head', // first approver
            'action' => 'pending',
        ]);
    }

    public function approveStep(Workflow $workflow, $action, $comments = null)
    {
        $workflow->update([
            'action' => $action,
            'comments' => $comments,
        ]);

        $nextDepartment = $this->getNextDepartment($workflow->destination_department);

        if ($nextDepartment) {
            Workflow::create([
                'document_id' => $workflow->document_id,
                'initiator_id' => Auth::user()->nrc,
                'origin_department' => $workflow->destination_department,
                'destination_department' => $nextDepartment,
                'action' => 'pending',
            ]);
        }
    }

    public function rejectStep(Workflow $workflow, $comments = null)
    {
        $workflow->update([
            'action' => 'rejected',
            'comments' => $comments,
        ]);

        // Optionally mark document as rejected
        $workflow->document->update(['status' => 'rejected']);
    }

    private function getNextDepartment($current)
    {
        $sequence = ['Employee','Section Head', 'Finance', 'Dean', 'Stores'];
        $index = array_search($current, $sequence);
        return $sequence[$index + 1] ?? null;
    }
}
