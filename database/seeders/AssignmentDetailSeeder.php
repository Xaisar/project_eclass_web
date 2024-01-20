<?php

namespace Database\Seeders;

use App\Models\AssignmentDetail;
use Illuminate\Database\Seeder;

class AssignmentDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssignmentDetail::insert([
            [
                'assignment_id' => 1,
                'basic_competence_id' => 1,
            ],
            [
                'assignment_id' => 2,
                'basic_competence_id' => 2,
            ],
            [
                'assignment_id' => 3,
                'basic_competence_id' => 1,
            ],
            [
                'assignment_id' => 3,
                'basic_competence_id' => 2,
            ]
        ]);
    }
}
