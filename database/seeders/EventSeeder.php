<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Web Development Bootcamp 2026',
                'description' => 'Belajar membuat aplikasi web modern dengan Laravel 11, Tailwind CSS, dan Alpine.js dari dasar hingga mahir. Dilengkapi sesi live coding dan mentoring eksklusif!',
                'event_date' => now()->addDays(10)->format('Y-m-d'),
            ],
            [
                'title' => 'UI/UX & Design System Workshop',
                'description' => 'Temukan seni mendesain antarmuka yang bersih, intuitif, dan nyaman dipandang menggunakan skema warna pastel yang modern dan tipografi ramah pengguna.',
                'event_date' => now()->addDays(20)->format('Y-m-d'),
            ],
            [
                'title' => 'Laravel Meetup Indonesia',
                'description' => 'Ajang berkumpul para developer Laravel di Indonesia untuk berbagi pengalaman tentang implementasi Clean Architecture, MVC yang ketat, dan optimasi query database.',
                'event_date' => now()->addDays(30)->format('Y-m-d'),
            ],
            [
                'title' => 'Creative Pastel Arts Festival',
                'description' => 'Pameran karya seni rupa bertema warna pastel dan alam yang menenangkan. Terbuka untuk umum dengan berbagai aktivitas menarik seperti workshop melukis gratis.',
                'event_date' => now()->addDays(45)->format('Y-m-d'),
            ],
            [
                'title' => 'Digital Marketing Summit 2026',
                'description' => 'Pelajari strategi optimasi SEO terbaru, manajemen konten sosial media, dan analitik performa bisnis digital bersama para pakar industri terkemuka.',
                'event_date' => now()->addDays(60)->format('Y-m-d'),
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
