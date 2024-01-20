<?php

namespace Database\Seeders;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insert([
            [
                'groups' => 'General',
                'options' => 'web_name',
                'label' => 'Web Name',
                'value' => 'Learning Management System',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // [
            //     'groups' => 'General',
            //     'options' => 'web_url',
            //     'label' => 'Web URL',
            //     'value' => 'http://127.0.0.1:8000',
            //     'is_default' => true,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now()
            // ],
            [
                'groups' => 'General',
                'options' => 'web_description',
                'label' => 'Description',
                'value' => 'The Laravel Permission System is a system used to manage permissions in your application',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'General',
                'options' => 'web_keyword',
                'label' => 'Keyword',
                'value' => 'Easily create permissions in your application with the Laravel Permission System',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'General',
                'options' => 'web_author',
                'label' => 'Author',
                'value' => 'CV Web Media Solusi Digital',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'General',
                'options' => 'copyright',
                'label' => 'Copyright',
                'value' => 'CV. Web Media Solusi Digital',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'General',
                'options' => 'email',
                'label' => 'Email',
                'value' => 'contact@webmediadigital.com',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'General',
                'options' => 'phone',
                'label' => 'Telepon',
                'value' => '085642746374',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'General',
                'options' => 'address',
                'label' => 'Address',
                'value' => 'Banyuwangi, Jawa Timur, Indonesia',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'General',
                'options' => 'facebook',
                'label' => 'Facebook',
                'value' => 'https://www.facebook.com/webmedia',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'General',
                'options' => 'instagram',
                'label' => 'Instagram',
                'value' => 'webmedia.id',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'General',
                'options' => 'youtube',
                'label' => 'Youtube',
                'value' => 'Web Media Solusi Digital',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'Image',
                'options' => 'favicon',
                'label' => 'Favicon',
                'value' => 'favicon.png',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'Image',
                'options' => 'logo',
                'label' => 'Logo',
                'value' => 'logo.png',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'Config',
                'options' => 'maintenance_mode',
                'label' => 'Maintenance Mode',
                'value' => 'N',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'General',
                'options' => 'presence_entry_code',
                'label' => 'Presence Entry Code',
                'value' => 'presence123',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'groups' => 'General',
                'options' => 'ruang_wa_token',
                'label' => 'WA Gateway Token',
                'value' => 'isi_dengan_token_dari_ruang_wa',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
