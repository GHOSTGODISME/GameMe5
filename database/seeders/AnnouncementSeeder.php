<?php

namespace Database\Seeders;

use App\Models\AnnQna;
use App\Models\AnnText;
use App\Models\AnnPolls;
use App\Models\AnnQnaAns;
use App\Models\Announcement;
use App\Models\AnnPollsResult;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     Announcement::create([
        'idclass' => '1', 
        'type' => 'AnnText',
        'created_at' => '2023-11-24 20:31:43',
        'user_id' => '2',
     ]);

     Announcement::create([
        'idclass' => '1', 
        'type' => 'AnnQna',
        'created_at' => '2023-11-24 20:31:43',
        'user_id' => '2',
     ]);


     Announcement::create([
        'idclass' => '1', 
        'type' => 'AnnPolls',
        'created_at' => '2023-11-24 20:31:43',
        'user_id' => '2',
     ]);


    AnnText::create([
        'annid' => '1', 
        'content' => 'Hi, Welcome Students!',

    ]);

    AnnQna::create([
        'ann_id' => '2', 
        'question' => 'What is your favourite color?',
    ]);

    AnnQnaAns::create([
        'quesid' => '1', 
        'content'=> 'Red',
        'userid'=> '1',
        'created_at' => '2023-11-24 20:35:43',
    ]);

    AnnPolls::create([
        'ann_id' => '3', 
        'question' => 'Black or White?',
        'option1' => 'Black',
        'option2'=> 'White',
    ]);

    AnnPollsResult::create([
        'polls_id'=> '1', 
        'option'=> '1',
        'user_id'=> '1',
    ]);


    }
}
