<?php

use App\Enums\RolesEnum;

describe('dashboard access', function () {
    it('redirects guests to the login page', function () {
        $this->get('/dashboard')
            ->assertRedirect();
    });

    it('allows authenticated users to access the dashboard', function () {
        $user = createUserWithRole(RolesEnum::EDITOR);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertSuccessful();
    });
});
