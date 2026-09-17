<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SchoolAdmin;
use App\Models\User;
use App\Services\EmailGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SchoolAdminRegistrationController extends Controller
{
    protected function step1(Request $request): array
    {
        $data = $request->session()->get('registration.step1');

        abort_unless($data && $data['role'] === 'school_admin', 403, 'Please start registration again.');

        return $data;
    }

    public function create(Request $request)
    {
        $step1 = $this->step1($request);

        $previewEmail = EmailGenerator::generate($step1['full_name'], 'school_admin');

        return view('auth.register-school-admin', [
            'fullName' => $step1['full_name'],
            'previewEmail' => $previewEmail,
            'genders' => config('school.genders'),
        ]);
    }

    public function store(Request $request)
    {
        $step1 = $this->step1($request);

        $validated = $request->validate([
            'gender' => ['required', 'string', 'in:'.implode(',', config('school.genders'))],
            'nationality' => ['required', 'string', 'max:100'],
        ]);

        $email = EmailGenerator::generate($step1['full_name'], 'school_admin');

        DB::transaction(function () use ($step1, $validated, $email) {
            $user = User::create([
                'full_name' => $step1['full_name'],
                'username' => $step1['username'],
                'email' => $email,
                'password' => Hash::make($step1['password']),
                'role' => 'school_admin',
                'gender' => $validated['gender'],
                'nationality' => $validated['nationality'],
            ]);

            SchoolAdmin::create(['user_id' => $user->id]);
        });

        $request->session()->forget('registration.step1');

        return redirect()->route('login')
            ->with('status', "Registration complete! Your login email is {$email}. Please log in below. Note: School Administrators can view every record but cannot edit them.");
    }
}
