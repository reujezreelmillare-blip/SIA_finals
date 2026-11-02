
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gowns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('size', 30);
            $table->string('color', 50);
            $table->decimal('rental_price', 10, 2);
            $table->decimal('deposit_price', 10, 2)->default(0);
            $table->string('image')->nullable();
            $table->enum('status', [
                'available',
                'unavailable',
                'maintenance'
            ])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gowns');
    }
};
