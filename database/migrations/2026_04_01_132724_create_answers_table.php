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
        Schema::create('answers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('attempt_id')->constrained()->cascadeOnDelete();
        $table->foreignId('question_id')->constrained()->cascadeOnDelete();
        $table->foreignId('option_id')->nullable()->constrained()->nullOnDelete(); 
        $table->text('input_value')->nullable(); // For text/number typed answers
        $table->boolean('is_correct')->default(false);
        $table->integer('marks_awarded')->default(0);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
