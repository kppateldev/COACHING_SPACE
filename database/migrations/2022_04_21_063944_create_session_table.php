<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('coach_id');
            $table->unsignedInteger('user_id');
            $table->date('date');
            $table->string('time');
            $table->dateTime('session_start_time');
            $table->dateTime('session_end_time');
            $table->text('like_to_discuss')->nullable();
            $table->text('user_notes')->nullable();
            $table->boolean('3days_before_email')->default(0)->comment('0=not sent, 1=sent');
            $table->boolean('1day_before_email')->default(0)->comment('0=not sent, 1=sent');
            $table->boolean('is_user_reviewed')->default(0)->comment('0=no, 1=yes');
            $table->text('session_report')->nullable();
            $table->enum('status',['upcoming','completed'])->default('upcoming');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
