
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', [
                'cash',
                'gcash',
                'bank_transfer'
            ])->default('cash');

            $table->string('reference_number')->nullable();

            $table->enum('status', [
                'pending',
                'paid',
                'refunded'
            ])->default('pending');

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
