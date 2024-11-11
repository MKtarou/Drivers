<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Groups;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Groups::create(['g_name' => '南ファミリー', 'g_pass' => '南と愉快な奴隷たち', 'g_goal' => 5000000]);
        Groups::create(['g_name' => '内山組', 'g_pass' => 'シャバの空気がうめぇ', 'g_goal' => 10000000]);
        Groups::create(['g_name' => '福谷ファミリー', 'g_pass' => '人生下手軍団', 'g_goal' => 2000000]);
        Groups::create(['g_name' => '浅井ファミリー', 'g_pass' => '浅井のドリーム球団', 'g_goal' => 7000000]);
        Groups::create(['g_name' => '井石システムず', 'g_pass' => 'iseki音楽団', 'g_goal' => 6000000]);
    }
}
