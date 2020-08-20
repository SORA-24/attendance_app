<?php

use Illuminate\Database\Seeder;

class WorkStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_statuses')->truncate();
        DB::table('work_statuses')->insert([
            ['work_status' => '平日勤務'],
            ['work_status' => '休日出勤'],
            ['work_status' => '公休日'],
            ['work_status' => '有給申請中'],
            ['work_status' => '有給休暇'],
            ['work_status' => '欠勤'],
        ]);

    }
}

// seederのファイルを作成
// php artisan make:seeder WorkStatusTableSeeder
// 実行
// php artisan db:seed 