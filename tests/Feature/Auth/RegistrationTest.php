<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('new users are created with role \'new\'', function () {
    $payload = \App\Models\User::factory()->raw([
        'password' => 'password'
    ]);
    $payload['password_confirmation'] = $payload['password'];
    $this->post('/register', $payload);

    $this->assertDatabaseHas('users', [
        'email' => $payload['email'],
        'role' => \App\Enums\Role::NEW->value
    ]);
});
