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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('status')->default('Pendiente');
            $table->integer('team_local_score')->default(0);
            $table->integer('team_visitor_score')->default(0);
            $table->foreignId('team_local_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('team_visitor_id')->constrained('teams')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
