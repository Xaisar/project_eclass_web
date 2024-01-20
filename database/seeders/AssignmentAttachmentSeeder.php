<?php

namespace Database\Seeders;

use App\Models\AssignmentAttachment;
use Illuminate\Database\Seeder;

class AssignmentAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssignmentAttachment::insert([
            [
                'assignment_id' => 1,
                'attachment_type' => 'file',
                'attachment' => 'Testing.pdf',
            ],
            [
                'assignment_id' => 1,
                'attachment_type' => 'link',
                'attachment' => 'https://webmediadigital.com',
            ],
            [
                'assignment_id' => 2,
                'attachment_type' => 'link',
                'attachment' => 'https://webmediadigital.com',
            ],
            [
                'assignment_id' => 3,
                'attachment_type' => 'link',
                'attachment' => 'https://webmediadigital.com',
            ],
        ]);
    }
}
