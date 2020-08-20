<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditRecordsBreaktime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records',function(Blueprint $table){
            $table->integer('work_status')->nullable($value = true);
            $table->time('temporarily')->nullable($value = true);
            $table->text('comment')->nullable($value = true);
            $table->dropColumn('paid_holidays');
            $table->dropColumn('absenteeism');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
