<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Livewire\Attributes\Url;

class Register extends BaseRegister
{
    #[Url]
    public string $token = '';

    public ?User $user = null;

    public ?array $data = [];

    public function mount(): void
    {
        $this->user = User::where('invite_token', $this->token)->firstOrFail();

        $this->form->fill([
            'name'  => $this->user->name,
            'email' => $this->user->email,
        ]);
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();
        $this->user->update([
            ...$data,
            'invite_token' => null,
        ]);

        app()->bind(
            SendEmailVerificationNotification::class,
        );

        event(new Registered($this->user));

        Filament::auth()->login($this->user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/register.form.email.label'))
            ->email()
            ->required()
            ->maxLength(255)
            ->disabled();
    }
}
