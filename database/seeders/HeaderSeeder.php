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
                'link' => '/',
            ],
            
            [
                'category' => 'ADHD',
                'parent_id' => null,
                'link' => 'adhd',
            ],
            [
                'category' => 'Autism',
                'parent_id' => null,
                'link' => 'autism',
            ],
            [
                'category' => 'Assessment',
                'parent_id' => null,
                'link' => 'assessment',
            ],
            [
                'category' => 'About Us +',
                'parent_id' => null,
                'link' => null,
            ],
            [
                'category' => 'About Us',
                'parent_id' => 5,
                'link' => 'about',
            ],
            [
                'category' => 'Our Approach',
                'parent_id' => 5,
                'link' => 'our-approach',
            ],
            [
                'category' => 'Accreditation & Certifications',
                'parent_id' => 5,
                'link' => 'accreditation',
            ],
            [
                'category' => 'Fees',
                'parent_id' => null,
                'link' => 'fee',
            ],
           

            // Add more entries as needed
        ]);
    }
}
