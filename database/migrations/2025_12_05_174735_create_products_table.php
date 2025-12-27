<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // اسم المنتج
            $table->string('category')->nullable();  // الفئة
            $table->decimal('price', 8, 2);          // السعر
            $table->integer('quantity')->default(0); // الكمية في المخزون
            $table->text('description')->nullable(); // وصف
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
