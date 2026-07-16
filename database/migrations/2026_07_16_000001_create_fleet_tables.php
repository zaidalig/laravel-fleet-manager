<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('driver')->after('email');
            $table->string('status')->default('active')->after('role');
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();
            $table->string('make');
            $table->string('model');
            $table->smallInteger('year')->nullable();
            $table->string('type')->default('car');
            $table->string('status')->default('available');
            $table->integer('odometer')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('license_number')->nullable();
            $table->date('license_expiry')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('trip_number')->unique();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained()->cascadeOnDelete();
            $table->string('start_location');
            $table->string('end_location');
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->decimal('distance_km', 8, 1)->default(0);
            $table->string('purpose')->nullable();
            $table->string('status')->default('planned');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('fuel_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trip_id')->nullable()->constrained()->nullOnDelete();
            $table->date('fueled_at');
            $table->decimal('liters', 8, 2);
            $table->decimal('cost', 10, 2);
            $table->integer('odometer')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->date('service_date');
            $table->string('title');
            $table->decimal('cost', 10, 2)->default(0);
            $table->date('next_service_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('maintenance_records');
        Schema::dropIfExists('fuel_logs');
        Schema::dropIfExists('trips');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('vehicles');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status']);
        });
    }
};
