<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('recipe_name');
            $table->string('image')->nullable();
            $table->text('detail')->nullable();
            $table->enum('status',['ACTIVE', 'INACTIVE'])->default('ACTIVE')->comment('ACTIVE, INACTIVE');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
            ->on('users')
            ->references('id')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
};
