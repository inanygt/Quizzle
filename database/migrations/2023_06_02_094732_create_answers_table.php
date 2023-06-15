<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->integer('question_id')->constrained()->onDelete('cascade');
            $table->string('text');
            $table->boolean('is_correct');
            $table->timestamps();
        });
    }

    public function down()
{
    Schema::table('questions', function (Blueprint $table) {
        $table->dropForeign(['correct_answer']);
    });

    Schema::dropIfExists('answers');
}

}
