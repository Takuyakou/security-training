<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAnswerIdForeignUserAnswerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_answer_details', function (Blueprint $table) {
            $table->dropForeign('user_answer_details_answer_id_foreign');
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
            $table->foreign('answer_id')->references('id')->on('answers');
        });
    }
}
