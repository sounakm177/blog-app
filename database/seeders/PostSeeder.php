<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 4; $i++){
            DB::table('posts')->insert([
                'title' => 'Lorazepam is a medication',
                'text' => 'Lorazepam is a medication primarily used to treat anxiety disorders and certain types of seizures. It belongs to a class of drugs known as benzodiazepines, which act on the central nervous system to produce a calming effect',
                'image' => 'post_images/blog'.$i.'.png',
                'created_by' => 1,
                'created_at' => Carbon::now()
            ]);
        } 
    }
}
