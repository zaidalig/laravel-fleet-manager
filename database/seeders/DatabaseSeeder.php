<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\FuelLog;
use App\Models\MaintenanceRecord;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Fleet Owner', 'email' => 'owner@example.com', 'password' => 'password', 'role' => 'owner', 'status' => 'active'],
            ['name' => 'Fleet Manager', 'email' => 'manager@example.com', 'password' => 'password', 'role' => 'manager', 'status' => 'active'],
            ['name' => 'Staff Driver', 'email' => 'driver@example.com', 'password' => 'password', 'role' => 'driver', 'status' => 'active'],
            ['name' => 'Read Only', 'email' => 'viewer@example.com', 'password' => 'password', 'role' => 'viewer', 'status' => 'inactive'],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $vehicles = [
            ['plate_number' => 'ABC-1001', 'make' => 'Toyota', 'model' => 'Corolla', 'year' => 2022, 'type' => 'car', 'status' => 'available', 'odometer' => 42000],
            ['plate_number' => 'XYZ-2002', 'make' => 'Ford', 'model' => 'Transit', 'year' => 2021, 'type' => 'van', 'status' => 'in_use', 'odometer' => 68000],
            ['plate_number' => 'TRK-3003', 'make' => 'Isuzu', 'model' => 'NPR', 'year' => 2020, 'type' => 'truck', 'status' => 'available', 'odometer' => 95000],
            ['plate_number' => 'BIK-4004', 'make' => 'Honda', 'model' => 'CB500', 'year' => 2023, 'type' => 'bike', 'status' => 'available', 'odometer' => 12000],
            ['plate_number' => 'VAN-5005', 'make' => 'Mercedes', 'model' => 'Sprinter', 'year' => 2019, 'type' => 'van', 'status' => 'maintenance', 'odometer' => 110000],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }

        $drivers = [
            ['employee_code' => 'DRV-001', 'name' => 'Ali Hassan', 'phone' => '+92 300 1111111', 'license_number' => 'LIC-1001', 'license_expiry' => now()->addYear()->toDateString(), 'status' => 'active', 'user_id' => 3],
            ['employee_code' => 'DRV-002', 'name' => 'Sara Khan', 'phone' => '+92 300 2222222', 'license_number' => 'LIC-1002', 'license_expiry' => now()->addMonths(8)->toDateString(), 'status' => 'active', 'user_id' => null],
            ['employee_code' => 'DRV-003', 'name' => 'Bilal Ahmed', 'phone' => '+92 300 3333333', 'license_number' => 'LIC-1003', 'license_expiry' => now()->addMonths(3)->toDateString(), 'status' => 'active', 'user_id' => null],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }

        $trips = [
            [
                'trip_number' => 'TRP-00001',
                'vehicle_id' => 2,
                'driver_id' => 1,
                'start_location' => 'Warehouse A',
                'end_location' => 'Client Site North',
                'started_at' => now()->subHours(2),
                'ended_at' => null,
                'distance_km' => 0,
                'purpose' => 'Delivery run',
                'status' => 'in_progress',
                'user_id' => 2,
            ],
            [
                'trip_number' => 'TRP-00002',
                'vehicle_id' => 1,
                'driver_id' => 2,
                'start_location' => 'HQ',
                'end_location' => 'Airport',
                'started_at' => now()->subDays(2)->setTime(9, 0),
                'ended_at' => now()->subDays(2)->setTime(11, 30),
                'distance_km' => 45.5,
                'purpose' => 'Executive pickup',
                'status' => 'completed',
                'user_id' => 1,
            ],
            [
                'trip_number' => 'TRP-00003',
                'vehicle_id' => 3,
                'driver_id' => 3,
                'start_location' => 'Depot',
                'end_location' => 'Industrial Zone',
                'started_at' => today()->setTime(14, 0),
                'ended_at' => null,
                'distance_km' => 0,
                'purpose' => 'Parts transfer',
                'status' => 'planned',
                'user_id' => 2,
            ],
            [
                'trip_number' => 'TRP-00004',
                'vehicle_id' => 4,
                'driver_id' => 1,
                'start_location' => 'HQ',
                'end_location' => 'City Center',
                'started_at' => now()->subDays(5)->setTime(10, 0),
                'ended_at' => now()->subDays(5)->setTime(10, 30),
                'distance_km' => 8.0,
                'purpose' => 'Cancelled courier',
                'status' => 'cancelled',
                'user_id' => 1,
            ],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }

        $fuelLogs = [
            ['vehicle_id' => 1, 'trip_id' => 2, 'fueled_at' => now()->subDays(2)->toDateString(), 'liters' => 40.5, 'cost' => 65.00, 'odometer' => 41950, 'user_id' => 2],
            ['vehicle_id' => 2, 'trip_id' => 1, 'fueled_at' => today()->toDateString(), 'liters' => 55.0, 'cost' => 88.00, 'odometer' => 68000, 'user_id' => 2],
            ['vehicle_id' => 3, 'trip_id' => null, 'fueled_at' => now()->subDays(7)->toDateString(), 'liters' => 80.0, 'cost' => 120.00, 'odometer' => 94800, 'user_id' => 1],
        ];

        foreach ($fuelLogs as $log) {
            FuelLog::create($log);
        }

        $maintenance = [
            ['vehicle_id' => 5, 'service_date' => now()->subMonths(2)->toDateString(), 'title' => 'Oil change & filters', 'cost' => 150.00, 'next_service_date' => now()->subDays(5)->toDateString(), 'notes' => 'Due for follow-up', 'user_id' => 2],
            ['vehicle_id' => 1, 'service_date' => now()->subMonth()->toDateString(), 'title' => 'Tire rotation', 'cost' => 80.00, 'next_service_date' => now()->addMonths(2)->toDateString(), 'user_id' => 1],
            ['vehicle_id' => 3, 'service_date' => now()->subWeeks(3)->toDateString(), 'title' => 'Brake inspection', 'cost' => 200.00, 'next_service_date' => now()->addDays(20)->toDateString(), 'user_id' => 2],
        ];

        foreach ($maintenance as $record) {
            MaintenanceRecord::create($record);
        }
    }
}
