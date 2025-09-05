<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

   
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Update user fields
    $user->fill($request->validated());

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    // Get the department code from the request
    $departmentCode = $request->department_code;

    // Create the department if it doesn't exist
    Department::firstOrCreate(
        ['department_code' => $departmentCode],
        [
            'name' => Department::ALLOWED_DEPARTMENTS_CODES[$departmentCode] ?? 'Unknown',
            'description' => null,
        ]
    );

    // Update or create corresponding Employee record
    Employee::updateOrCreate(
        ['nrc' => $request->nrc],
        [
            'name'            => $request->name,
            'email'           => $request->email,
            'position'        => $request->position,
            'department_code' => $departmentCode,
        ]
    );

    return redirect()->route('profile.edit')->with('status', 'Profile updated successfully.');
}


    
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
