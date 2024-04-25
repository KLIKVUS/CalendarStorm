<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('active')->default(true);

            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();

            $table->string('name');
            $table->mediumText('description');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
