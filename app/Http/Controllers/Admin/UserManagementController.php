<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * System Administrator (owner) full edit access:
 * "The system admins can view any teachers or students details and can edit
 * anything, anything edited or updated from the system administrators must
 * update to everyone included while updating."
 * Because every role reads live from the same `users`/`students`/`teachers`
 * tables, a save here is immediately reflected everywhere else in the system -
 * there is no separate cache or duplicated record to keep in sync.
 */
class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['student.schoolClass', 'teacher', 'schoolAdmin']);

        if ($role = $request->query('role')) {
            $query->where('role', $role);
        }

        $users = $query->orderBy('full_name')->paginate(25)->withQueryString();

        return view('admin.users-index', compact('users'));
    }

    public function edit(User $user)
    {
        $user->load(['student.schoolClass', 'student.subjects', 'teacher.classes', 'teacher.subjects']);

        return view('admin.users-edit', [
            'targetUser' => $user,
            'genders' => config('school.genders'),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'gender' => ['required', 'in:'.implode(',', config('school.genders'))],
            'nationality' => ['required', 'string', 'max:100'],
        ]);

        $user->update($validated);

        return redirect()->route('system-admin.users.index')->with('status', "{$user->full_name}'s record was updated for everyone.");
    }

    public function destroy(User $user)
    {
        $name = $user->full_name;
        $user->delete();

        return redirect()->route('system-admin.users.index')->with('status', "{$name}'s account was removed.");
    }
}
