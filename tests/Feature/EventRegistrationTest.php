<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Mail\EventRegisteredMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EventRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_for_free_event_instantly()
    {
        Mail::fake();

        $user = User::factory()->create(['role' => 'user']);
        $event = Event::factory()->create([
            'title' => 'Acara Gratis Keren',
            'price' => 0,
            'event_date' => now()->addDays(5)->format('Y-m-d'),
        ]);

        $response = $this->actingAs($user)
            ->post(route('events.register', $event));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Pendaftaran Anda berhasil! Sampai jumpa di acara! 🎉');

        $this->assertDatabaseHas('event_registrations', [
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => 'registered',
            'snap_token' => null,
        ]);

        Mail::assertSent(EventRegisteredMail::class, function ($mail) use ($user, $event) {
            return $mail->hasTo($user->email) &&
                   $mail->userName === $user->name &&
                   $mail->eventTitle === $event->title;
        });
    }

    public function test_user_registering_for_paid_event_gets_pending_status_and_snap_token()
    {
        Mail::fake();
        Http::fake([
            'https://app.sandbox.midtrans.com/snap/v1/transactions' => Http::response([
                'token' => 'mock-snap-token-12345',
                'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v1/pay?token=mock-snap-token-12345'
            ], 200)
        ]);

        // Put a server key config for testing
        config(['services.midtrans.server_key' => 'test-server-key']);

        $user = User::factory()->create(['role' => 'user']);
        $event = Event::factory()->create([
            'title' => 'Web Dev Bootcamp Premium',
            'price' => 150000,
            'event_date' => now()->addDays(10)->format('Y-m-d'),
        ]);

        $response = $this->actingAs($user)
            ->post(route('events.register', $event));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Pendaftaran berhasil dibuat! Menunggu pembayaran... 💳');
        $response->assertSessionHas('payment_snap_token', 'mock-snap-token-12345');

        $this->assertDatabaseHas('event_registrations', [
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => 'pending',
            'snap_token' => 'mock-snap-token-12345',
        ]);

        // Email should NOT be sent yet
        Mail::assertNotSent(EventRegisteredMail::class);
    }

    public function test_midtrans_callback_with_valid_signature_updates_registration_to_confirmed()
    {
        Mail::fake();
        
        $serverKey = 'test-server-key';
        config(['services.midtrans.server_key' => $serverKey]);

        $user = User::factory()->create(['role' => 'user']);
        $event = Event::factory()->create([
            'title' => 'Web Dev Bootcamp Premium',
            'price' => 150000,
            'event_date' => now()->addDays(10)->format('Y-m-d'),
        ]);

        // Create the pending registration
        $registrationId = DB::table('event_registrations')->insertGetId([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => 'pending',
            'snap_token' => 'mock-snap-token-12345',
            'registered_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $orderId = 'REG-' . $registrationId . '-' . time();
        $statusCode = '200';
        $grossAmount = '150000.00';
        
        // signature: SHA512(order_id + status_code + gross_amount + ServerKey)
        $signatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        $payload = [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signatureKey,
            'transaction_status' => 'settlement',
        ];

        $response = $this->postJson('/midtrans/callback', $payload);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Callback processed successfully']);

        $this->assertDatabaseHas('event_registrations', [
            'id' => $registrationId,
            'status' => 'confirmed',
        ]);

        // Email should be sent now
        Mail::assertSent(EventRegisteredMail::class, function ($mail) use ($user, $event) {
            return $mail->hasTo($user->email) &&
                   $mail->userName === $user->name &&
                   $mail->eventTitle === $event->title;
        });
    }

    public function test_midtrans_callback_with_invalid_signature_returns_400()
    {
        Mail::fake();
        
        config(['services.midtrans.server_key' => 'test-server-key']);

        $user = User::factory()->create(['role' => 'user']);
        $event = Event::factory()->create([
            'title' => 'Web Dev Bootcamp Premium',
            'price' => 150000,
        ]);

        $registrationId = DB::table('event_registrations')->insertGetId([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => 'pending',
            'snap_token' => 'mock-snap-token-12345',
            'registered_at' => now(),
        ]);

        $payload = [
            'order_id' => 'REG-' . $registrationId . '-' . time(),
            'status_code' => '200',
            'gross_amount' => '150000.00',
            'signature_key' => 'wrong-signature-key',
            'transaction_status' => 'settlement',
        ];

        $response = $this->postJson('/midtrans/callback', $payload);

        $response->assertStatus(400);
        $response->assertJson(['message' => 'Invalid signature key']);

        $this->assertDatabaseHas('event_registrations', [
            'id' => $registrationId,
            'status' => 'pending',
        ]);

        Mail::assertNotSent(EventRegisteredMail::class);
    }
}
