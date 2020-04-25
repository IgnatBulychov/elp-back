<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'title' => 'Header',
            'description' => 'Description',
            'about' => 'About...',
            'phone' => '79210000000',
            'email' => 'no-reply@elp.com',
            'viber' => '79210000000',
            'telegram' => '79210000000',
            'whatsapp' => '79210000000',
            'facebook' => 'facebook.com',
            'instagram' => 'instagram.com',
            'map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3623018.9846834633!2d33.620826349999994!3d63.67951539999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sru!2sru!4v1587845667375!5m2!1sru!2sru" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>'
        ]);
    }
}
