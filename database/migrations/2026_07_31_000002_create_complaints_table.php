<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complainant_name');
            $table->string('phone');
            $table->string('location');
            $table->string('region');
            $table->string('department');
            $table->text('description');
            $table->string('priority', 20)->default('normal');
            $table->string('status', 20)->default('new');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('complainant_name');
            $table->index('phone');
            $table->index('created_at');
            $table->index('status');
            $table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
