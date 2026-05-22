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
    Schema::create('webhook_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('endpoint_id')->constrained()->onDelete('cascade');
        $table->string('method');
        $table->json('headers');
        $table->longText('body')->nullable();
        $table->string('content_type')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
    }
};
