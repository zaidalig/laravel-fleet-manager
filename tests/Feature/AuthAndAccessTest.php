<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_owner_can_view_dashboard(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner@test.local',
            'password' => 'password',
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/')->assertOk();
    }

    public function test_owner_can_access_vehicles_trips_and_users(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner-all@test.local',
            'password' => 'password',
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/vehicles')->assertOk();
        $this->actingAs($user)->get('/trips')->assertOk();
        $this->actingAs($user)->get('/users')->assertOk();
    }

    public function test_driver_can_access_trips_but_not_vehicles_or_users(): void
    {
        $user = User::create([
            'name' => 'Driver',
            'email' => 'driver@test.local',
            'password' => 'password',
            'role' => 'driver',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/trips')->assertOk();
        $this->actingAs($user)->get('/vehicles')->assertForbidden();
        $this->actingAs($user)->get('/users')->assertForbidden();
    }

    public function test_viewer_cannot_access_trips(): void
    {
        $user = User::create([
            'name' => 'Viewer',
            'email' => 'viewer@test.local',
            'password' => 'password',
            'role' => 'viewer',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/trips')->assertForbidden();
    }

    public function test_owner_can_export_fuel_report(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner-fuel@test.local',
            'password' => 'password',
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/reports/fuel')->assertOk();

        $this->actingAs($user)->get('/reports/fuel?export=1')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->assertHeader('Content-Disposition', 'attachment; filename=fuel-report.csv');
    }

    public function test_driver_cannot_access_fuel_report(): void
    {
        $user = User::create([
            'name' => 'Driver',
            'email' => 'driver-fuel@test.local',
            'password' => 'password',
            'role' => 'driver',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/reports/fuel')->assertForbidden();
    }
}
