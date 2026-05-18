<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_data_column_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id');
            $table->unsignedBigInteger('master_data_column_id');
            $table->unsignedBigInteger('master_data_column_selection_option_id')->nullable();
            $table->text('value')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('guest_id', 'mdca_guest_id_index');
            $table->index('master_data_column_id', 'mdca_column_id_index');
            $table->index('master_data_column_selection_option_id', 'mdca_option_id_index');

            $table->unique(
                ['guest_id', 'master_data_column_id'],
                'mdca_guest_column_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_data_column_answers');
    }
};
