<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@eventapp.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@eventapp.com',
            'role' => 'user',
            'password' => bcrypt('password'),
        ]);

        // Create 15 dummy users to show pagination
        User::factory(15)->create(['role' => 'user']);

        $this->call(EventSeeder::class);

        // Seed some registrations using Query Builder
        $user = \App\Models\User::where('role', 'user')->first();
        $events = \App\Models\Event::limit(2)->get();

        foreach ($events as $event) {
            \Illuminate\Support\Facades\DB::table('event_registrations')->insert([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'status' => 'registered',
                'registered_at' => now()->subDays(rand(1, 5)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
