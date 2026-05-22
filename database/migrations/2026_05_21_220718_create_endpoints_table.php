<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endpoints');
    }

    public function up(): void
{
    Schema::create('endpoints', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('token')->unique();
        $table->timestamps();
    });
}
};
