<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('order_date');
            $table->unsignedInteger('total_amount')->nullable();
            $table->timestamps();
            $table->index(['order_date', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
