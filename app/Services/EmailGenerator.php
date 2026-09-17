<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

/**
 * Generates the school email address exactly per the brief:
 * first letter of the person's first name + their full surname + role domain.
 * e.g. "Bethel Jengwa" (student) -> bjengwa@students.seke1.ac.zw
 */
class EmailGenerator
{
    public static function generate(string $fullName, string $role): string
    {
        $parts = preg_split('/\s+/', trim($fullName));
        $parts = array_values(array_filter($parts, fn ($p) => $p !== ''));

        $firstName = $parts[0] ?? 'user';
        $surname = count($parts) > 1 ? end($parts) : $firstName;

        $localPart = Str::lower(Str::substr($firstName, 0, 1).preg_replace('/[^A-Za-z]/', '', $surname));

        $domain = match ($role) {
            'student' => config('school.email_domains.student'),
            'teacher' => config('school.email_domains.teacher'),
            'school_admin' => config('school.email_domains.school_admin'),
            default => config('school.email_domains.student'),
        };

        $email = "{$localPart}@{$domain}";

        // Guarantee uniqueness by appending a number if the email is already taken,
        // e.g. two students both named Bethel Jengwa become bjengwa and bjengwa2.
        $candidate = $email;
        $suffix = 1;
        while (User::where('email', $candidate)->exists()) {
            $suffix++;
            $candidate = "{$localPart}{$suffix}@{$domain}";
        }

        return $candidate;
    }
}
