<?php

namespace App\Livewire\Auth;

use App\UserRole;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Attempt to authenticate the user.
     */
    public function authenticate(): void
    {
        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', __('auth.failed'));

            return;
        }

        session()->regenerate();

        $this->redirectIntended($this->dashboardRoute());
    }

    /**
     * Determine the dashboard route based on user role.
     */
    private function dashboardRoute(): string
    {
        return match (Auth::user()->role) {
            UserRole::Admin => '/admin',
            UserRole::StoreOwner => route('store.dashboard'),
            default => '/',
        };
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.auth.login');
    }
}
