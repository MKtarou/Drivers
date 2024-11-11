<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\users;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        users::create(['group_id' => 1 , 'u_name' => '南小次郎' ,'u_pass' => 'minami', 'u_goal' => 50000]);
        users::create(['group_id' => 1 , 'u_name' => '南こたろう' ,'u_pass' => 'mimi', 'u_goal' => 50000]);
        users::create(['group_id' => 2 , 'u_name' => 'ボス内山' ,'u_pass' => 'boss', 'u_goal' => 500000]);
        users::create(['group_id' => 2 , 'u_name' => '内山' ,'u_pass' => 'uchiyama', 'u_goal' => 500000]);
        users::create(['group_id' => 3 , 'u_name' => '福谷' ,'u_pass' => 'fukutani', 'u_goal' => 50000]);
        users::create(['group_id' => 3 , 'u_name' => 'ふくた２' ,'u_pass' => 'fukuta2', 'u_goal' => 50000]);
        users::create(['group_id' => 4 , 'u_name' => '浅井しょうへい' ,'u_pass' => 'asai', 'u_goal' => 50000]);
        users::create(['group_id' => 4 , 'u_name' => 'あさい' ,'u_pass' => 'asa1', 'u_goal' => 50000]);
        users::create(['group_id' => 5 , 'u_name' => '移籍' ,'u_pass' => 'いせき', 'u_goal' => 50000]);
        users::create(['group_id' => 5 , 'u_name' => 'music' ,'u_pass' => 'iseki', 'u_goal' => 50000]);
    }
}
