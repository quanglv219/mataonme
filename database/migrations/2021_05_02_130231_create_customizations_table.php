<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('fontSize')->nullable();
            $table->integer('fontWeight')->nullable();
            $table->text('fontColor')->nullable();
            $table->text('fontColorHover')->nullable();
            $table->text('pageBackground')->nullable();
            $table->text('buttonBackground')->nullable();
            $table->text('buttonBackgroundHover')->nullable();
            $table->text('buttonBorderSize')->nullable();
            $table->text('buttonBorderSizeHover')->nullable();
            $table->text('buttonBorder')->nullable();
            $table->text('buttonBorderHover')->nullable();
            $table->text('borderRadius')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customizations');
    }
}
