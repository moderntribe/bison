<?php

use App\Mail\InviteUser;
use App\Models\User;
use Illuminate\Support\Str;

describe('InviteUser mailable', function () {
    beforeEach(function () {
        seedRolesAndPermissions();
    });

    it('uses the invitation subject', function () {
        $user = User::factory()->make([
            'invite_token' => Str::random(60),
        ]);

        expect((new InviteUser($user))->envelope()->subject)
            ->toBe('You have been invited to join the team!');
    });

    it('includes a signed registration url with the invite token', function () {
        $user = User::factory()->create([
            'invite_token' => 'test-invite-token',
        ]);

        $mailable = new InviteUser($user);
        $content  = $mailable->content();

        expect($content->markdown)->toBe('mail.auth.invite-user')
            ->and($content->with['acceptUrl'])
            ->toContain('invite/register')
            ->toContain('token=test-invite-token')
            ->toContain('signature=');
    });
});
