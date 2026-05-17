<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('couples', function (Blueprint $table) {
            $table->id();
            $table->string('bride_name');
            $table->string('groom_name');
            $table->string('bride_photo')->nullable();
            $table->string('groom_photo')->nullable();
            $table->text('bride_bio')->nullable();
            $table->text('groom_bio')->nullable();
            $table->date('wedding_date');
            $table->string('main_venue');
            $table->string('hero_image')->nullable();
            $table->string('quote')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('couples');
    }
};
