<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPassFlgToUserAnswerHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_answer_headers', function (Blueprint $table) {
            //カラムを追加
            $table->boolean('pass_flg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_answer_headers', function (Blueprint $table) {
            $table->dropColumn('pass_flg');
        });
    }
}
