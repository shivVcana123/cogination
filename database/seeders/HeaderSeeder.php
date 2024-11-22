<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('headers')->insert([
            [
                'category' => 'Home',
                'link' => '',
                'parent_id' => null,
            ],
            [
                'category' => 'About Us',
                'link' => 'about-us',
                'parent_id' => null,
            ],
            [
                'category' => 'Services',
                'link' => '',
                'parent_id' => null,
            ],
            [
                'category' => 'Real Estate Consulting Service',
                'link' => 'service/1',
                'parent_id' => 3,
            ],
            [
                'category' => 'Development',
                'link' => 'service/2',
                'parent_id' => 3,
            ],
            [
                'category' => 'Latest News',
                'link' => 'latest-news',
                'parent_id' => null,
            ],
            [
                'category' => 'Useful Links',
                'link' => 'useful-links',
                'parent_id' => null,
            ],
            [
                'category' => 'Contact us',
                'link' => 'contact',
                'parent_id' => null,
            ],

            // Add more entries as needed
        ]);
    }
}
