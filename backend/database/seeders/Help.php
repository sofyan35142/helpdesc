<?php

namespace Database\Seeders;

use App\Models\helpdesk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Help extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        helpdesk::insert([
            'id_user' => auth()->user()->id,
            'keluhan' => 'Jalan rusak',
            'link_img' => url('/image/'),
            'deskripsi' => 'jalan di sekitar desa sebandung banyak yang berlubang',
            'foto' => 'keluhan.jpeg',
            'created_at' => now()
        ]);
    }
}
