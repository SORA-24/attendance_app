<?php

use Illuminate\Database\Seeder;

class MasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('masters')->insert([
            ['name' => '月の残業上限' ,'info' => '1620000' ],
            ['name' => '最低休憩時間' ,'info' =>  '3600'],
            ['name' => '通常  単価(１時間当たり)','info' =>  null],
            ['name' => '休日出勤 割増賃金','info' => '1.25' ],
            ['name' => '残業 割増賃金','info' => '1.25' ],
            ['name' => '45時間を超える 割増賃金','info' => '1.25' ],
        ]);
    }
}
