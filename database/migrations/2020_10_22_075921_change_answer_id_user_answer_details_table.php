<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAnswerIdUserAnswerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_answer_details', function (Blueprint $table) {
            //データ型を変更(bigint → varchar(255))
            $table->string('answer_id', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_answer_details', function (Blueprint $table) {
            $table->unsignedBigInteger('answer_id')->change();
        });
    }
}
