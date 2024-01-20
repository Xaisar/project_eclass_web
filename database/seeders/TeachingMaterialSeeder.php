<?php

namespace Database\Seeders;

use App\Models\TeachingMaterial;
use Illuminate\Database\Seeder;

class TeachingMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeachingMaterial::insert([
            [
                'course_id' => 2,
                'core_competence_id' => 1,
                'basic_competence_id' => 5,
                'type' => 'file',
                'attachment' => 'file.pdf',
                'name' => 'Testing materi file',
                'description' => 'Materi untuk testing',
                'is_share' => true
            ],
            [
                'course_id' => 2,
                'core_competence_id' => 1,
                'basic_competence_id' => 5,
                'type' => 'image',
                'attachment' => 'image.jpg',
                'name' => 'Testing materi image',
                'description' => 'Materi untuk image',
                'is_share' => true
            ],
            [
                'course_id' => 2,
                'core_competence_id' => 1,
                'basic_competence_id' => 5,
                'type' => 'video',
                'attachment' => 'video.mp4',
                'name' => 'Testing materi video',
                'description' => 'Materi untuk video',
                'is_share' => true
            ],
            [
                'course_id' => 2,
                'core_competence_id' => 1,
                'basic_competence_id' => 5,
                'type' => 'audio',
                'attachment' => 'audio.mp3',
                'name' => 'Testing materi audio',
                'description' => 'Materi untuk audio',
                'is_share' => true
            ],
            [
                'course_id' => 2,
                'core_competence_id' => 1,
                'basic_competence_id' => 5,
                'type' => 'youtube',
                'attachment' => 'https://www.youtube.com/watch?v=5yTgAwbFECY',
                'name' => 'Testing materi youtube',
                'description' => 'Materi untuk youtube',
                'is_share' => true
            ],
            [
                'course_id' => 2,
                'core_competence_id' => 1,
                'basic_competence_id' => 5,
                'type' => 'article',
                'attachment' => 'https://webmediadigital.com',
                'name' => 'Testing materi article',
                'description' => 'Materi untuk article',
                'is_share' => true
            ],
        ]);
    }
}
