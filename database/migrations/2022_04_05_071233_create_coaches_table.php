<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug');
            $table->string('name');
            $table->string('email', 250)->unique();
            $table->string('phone_number', 30)->nullable();
            $table->string('profile_image')->nullable();
            $table->string('tagline')->nullable();
            $table->string('short_description')->nullable();
            $table->text('about')->nullable();
            $table->text('coaching_level')->nullable();
            $table->text('strengths')->nullable();
            $table->float('avg_rating')->default(0)->nullable();
            $table->integer('rating_count')->default(0)->nullable();
            $table->string('calendly_link')->nullable();
            $table->boolean('is_active')->default(0)->comment('0=not active, 1=active');
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
        Schema::dropIfExists('coaches');
    }
}
