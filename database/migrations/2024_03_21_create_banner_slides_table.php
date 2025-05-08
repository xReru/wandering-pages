<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('banner_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->text('description');
            $table->string('image_path');
            $table->string('status')->default('active'); // active, inactive
            $table->string('type')->default('new_release'); // new_release, bestseller, coming_soon
            $table->string('button_text')->default('Buy Now');
            $table->string('button_link')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banner_slides');
    }
}; 