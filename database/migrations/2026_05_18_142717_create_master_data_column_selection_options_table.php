<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_data_column_selection_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_data_column_id')->index();
            $table->string('option_value')->nullable();
            $table->string('option_label')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_data_column_selection_options');
    }
};
