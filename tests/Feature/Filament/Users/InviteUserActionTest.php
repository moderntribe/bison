<?php

use App\Enums\RolesEnum;
use App\Filament\Resources\Users\Actions\InviteUserAction;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Mail\InviteUser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

describe('InviteUserAction', function () {
    beforeEach(function () {
        Mail::fake();
        seedRolesAndPermissions();
    });

    it('creates an invited user and sends the invitation email', function () {
        InviteUserAction::handle([
            'name'  => 'Invited User',
            'email' => 'invited@example.com',
            'role'  => RolesEnum::EDITOR->value,
        ]);

        $user = User::query()->where('email', 'invited@example.com')->first();

        expect($user)->not->toBeNull()
            ->and($user->name)->toBe('Invited User')
            ->and($user->password)->toBeNull()
            ->and($user->invite_token)->not->toBeEmpty()
            ->and($user->hasRole(RolesEnum::EDITOR))->toBeTrue();

        Mail::assertSent(InviteUser::class, function (InviteUser $mail) use ($user) {
            return $mail->hasTo('invited@example.com')
                && $mail->user->is($user);
        });
    });

    it('can invite a user from the users list page', function () {
        $admin = createUserWithRole(RolesEnum::ADMIN);

        actingAsFilamentUser($admin);

        Livewire::test(ListUsers::class)
            ->callAction('invite-user', data: [
                'name'  => 'Filament Invitee',
                'email' => 'filament-invitee@example.com',
                'role'  => RolesEnum::ADMIN->value,
            ])
            ->assertNotified();

        $user = User::query()->where('email', 'filament-invitee@example.com')->first();

        expect($user)->not->toBeNull()
            ->and($user->hasRole(RolesEnum::ADMIN))->toBeTrue();

        Mail::assertSent(InviteUser::class);
    });
});
