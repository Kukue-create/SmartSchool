<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the fixed reference data: every subject and every class named in
     * the project brief, so they are ready to pick from at registration time.
     */
    public function run(): void
    {
        foreach (config('school.subjects') as $subjectName) {
            Subject::firstOrCreate(['name' => $subjectName]);
        }

        foreach (config('school.classes_by_level') as $level => $classes) {
            foreach ($classes as $className) {
                SchoolClass::firstOrCreate(['level' => $level, 'name' => $className]);
            }
        }

        $this->command?->info('Subjects and classes seeded. Register a Student via /students, a Teacher via /students/teachers, and a School Admin via /students/admin. Use /students/online with SYSTEM_ADMIN_PASSWORD for full owner access.');
    }
}
