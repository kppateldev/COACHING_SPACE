<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_template', function (Blueprint $table) {
           $table->increments('id');
            $table->unsignedInteger('header_id');
            $table->unsignedInteger('footer_id');
            $table->string('title');
            $table->string('subject');
            $table->text('body');
            $table->enum('status',['1','2'])->default('1')->comment('1 for active, 2 for inactive');
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
        Schema::dropIfExists('email_template');
    }
}
