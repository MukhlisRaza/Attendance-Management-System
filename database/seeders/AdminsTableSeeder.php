<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('admins')->delete();
        $adminRecords = [
            ['id' => 1, 'name' => 'saqlain abbas', 'type' => 'admin', 'mobile' => '+923025496045', 'email' => 'admin@gmail.com', 'password' => bcrypt('admin123'), 'image' => '', 'status' => 1],
            ['id' => 2, 'name' => 'ahmad faraz', 'type' => 'admin', 'mobile' => '+923023212234', 'email' => 'ahmad@gmail.com', 'password' => bcrypt('ahmad123'), 'image' => '', 'status' => 1],
        ];

        DB::table('admins')->insert($adminRecords);
    }
}
