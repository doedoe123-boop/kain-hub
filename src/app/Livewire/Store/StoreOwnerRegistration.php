<?php

namespace App\Livewire\Store;

use App\Models\Store;
use App\Models\User;
use App\PhilippineIdType;
use App\UserRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.guest')]
class StoreOwnerRegistration extends Component
{
    use WithFileUploads;

    // --- Account Info ---

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|max:20')]
    public string $phone = '';

    #[Validate('required|string|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    // --- Store Info ---

    #[Validate('required|string|max:255')]
    public string $storeName = '';

    #[Validate('required|string|max:255|unique:stores,slug')]
    public string $slug = '';

    #[Validate('required|string|max:1000')]
    public string $description = '';

    // --- Address ---

    #[Validate('required|string|max:255')]
    public string $addressLine = '';

    #[Validate('required|string|max:255')]
    public string $city = '';

    #[Validate('required|string|max:20')]
    public string $postcode = '';

    // --- KYC ---

    #[Validate('required|string|in:passport,drivers_license,national_id,sss,philhealth,postal_id')]
    public string $idType = '';

    #[Validate('required|string|max:100')]
    public string $idNumber = '';

    #[Validate('required|file|mimes:pdf,jpg,jpeg,png|max:5120')]
    public $businessPermit = null;

    /**
     * Auto-generate a slug when the store name changes.
     */
    public function updatedStoreName(string $value): void
    {
        $this->slug = Str::slug($value);
    }

    /**
     * Get the format hint for the currently selected ID type.
     */
    public function getIdFormatHintProperty(): string
    {
        $idType = PhilippineIdType::tryFrom($this->idType);

        return $idType ? $idType->formatHint() : '';
    }

    /**
     * Register the store owner and create their store.
     */
    public function register(): void
    {
        $this->validate();

        // Validate ID number format based on selected type
        $idType = PhilippineIdType::tryFrom($this->idType);

        if ($idType && ! preg_match($idType->pattern(), $this->idNumber)) {
            $this->addError('idNumber', "Invalid format for {$idType->label()}. Expected: {$idType->formatHint()}");

            return;
        }

        // Store the uploaded business permit
        $permitPath = $this->businessPermit->store('business-permits', 'local');

        // Create the user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'role' => UserRole::StoreOwner,
        ]);

        // Create the store with KYC details
        Store::create([
            'user_id' => $user->id,
            'name' => $this->storeName,
            'slug' => $this->slug,
            'description' => $this->description,
            'address' => [
                'line_one' => $this->addressLine,
                'city' => $this->city,
                'postcode' => $this->postcode,
            ],
            'id_type' => $this->idType,
            'id_number' => $this->idNumber,
            'business_permit' => $permitPath,
        ]);

        $user->assignRole('store_owner');

        event(new Registered($user));

        session()->flash('success', 'Your store application has been submitted! We will review your documents and notify you via email within 3–5 business days.');

        $this->redirect(route('register.store-owner.success'));
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.store.store-owner-registration');
    }
}
