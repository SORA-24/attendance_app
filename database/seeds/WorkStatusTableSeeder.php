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
        // リセット
        DB::table('work_statuses')->truncate();
        // 入れ込む
        DB::table('work_statuses')->insert([
            ['work_status' => '通常'],
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
// これだけ実行する場合
// php artisan db:seed --class=WorkStatusTableSeeder