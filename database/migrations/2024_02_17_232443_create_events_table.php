<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('active')->default(true);

            $table->foreignId('calendar_id')->constrained('calendars')->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->string('color');

            $table->dateTime('beginning');
            $table->dateTime('ending');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
