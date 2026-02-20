<?php

namespace App\Livewire\Store;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.store')]
class StoreLogin extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Resolve the current store from the subdomain.
     */
    private function resolveCurrentStore(): ?Store
    {
        if (app()->bound('currentStore')) {
            return app('currentStore');
        }

        $host = request()->getHost();
        $domain = config('app.domain');

        if (! str_ends_with($host, '.' . $domain)) {
            return null;
        }

        $slug = str_replace('.' . $domain, '', $host);

        return Store::where('slug', $slug)->first();
    }

    /**
     * Attempt to authenticate the store owner.
     */
    public function authenticate(): void
    {
        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', __('auth.failed'));

            return;
        }

        $user = Auth::user();
        $store = $this->resolveCurrentStore();

        if (! $store) {
            Auth::logout();
            $this->addError('email', 'Unable to determine which store you are accessing.');

            return;
        }

        // Verify the authenticated user owns this store
        if (! $user->isStoreOwner() || $user->store?->id !== $store->id) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            $this->addError('email', 'You do not have access to this store.');

            return;
        }

        session()->regenerate();

        $this->redirect('/lunar');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.store.store-login');
    }
}
