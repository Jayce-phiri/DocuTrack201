<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    protected DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    
 public function store(Request $request)
{
    // Dump everything coming from the request
    dd($request->all());

    // Validation (optional if you want to see before validation)
    $validatedData = $request->validate([
        'department_code' => [
            'required',
            'string',
            'max:255',
            Rule::in(array_keys(Department::ALLOWED_DEPARTMENTS_CODES)),
        ],
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::in(array_values(Department::ALLOWED_DEPARTMENTS_CODES)),
        ],
        'description' => ['nullable', 'string'],
    ]);

    try {
        // Dump validated data before creating
        dd($validatedData);

        $department = $this->departmentService->createDepartment($validatedData);

        return redirect()->back()->with('success', 'Department created successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to create department: ' . $e->getMessage());
    }
}


    public function update(Request $request, Department $department)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $this->departmentService->updateDepartment($department, $request->all());
            return redirect()->back()->with('success', 'Department updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update department: ' . $e->getMessage());
        }
    }

   
    public function destroy(Department $department)
    {
        try {
            $this->departmentService->deleteDepartment($department);
            return redirect()->back()->with('success', 'Department deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete department: ' . $e->getMessage());
        }
    }
}
