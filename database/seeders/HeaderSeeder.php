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
                'parent_id' => null,
            ],
            [
                'category' => 'About Us +',
                'parent_id' => null,
            ],
            [
                'category' => 'About Us',
                'parent_id' => 2,
            ],
            [
                'category' => 'Our Approach',
                'parent_id' => 2,
            ],
            [
                'category' => 'Accreditation & Certifications',
                'parent_id' => 2,
            ],
            [
                'category' => 'ADHD',
                'parent_id' => null,
            ],
            [
                'category' => 'Autism',
                'parent_id' => null,
            ],
            [
                'category' => 'Assessment',
                'parent_id' => null,
            ],
            [
                'category' => 'Fees',
                'parent_id' => null,
            ],
           

            // Add more entries as needed
        ]);
    }
}
