<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-center mb-2">Register as a Store Owner</h2>
    <p class="text-sm text-center text-gray-500 mb-6">Create your account and submit your store application. We'll review your documents within 3–5 business days.</p>

    <form wire:submit="register" class="space-y-8">
        {{-- Section 1: Account Info --}}
        <fieldset>
            <legend class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Account Information</legend>
            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input wire:model="name" type="text" id="name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border text-sm"
                            placeholder="Juan Dela Cruz">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input wire:model="phone" type="tel" id="phone" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border text-sm"
                            placeholder="09171234567">
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input wire:model="email" type="email" id="email" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border text-sm"
                        placeholder="you@example.com">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input wire:model="password" type="password" id="password" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border text-sm">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input wire:model="password_confirmation" type="password" id="password_confirmation" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border text-sm">
                    </div>
                </div>
            </div>
        </fieldset>

        {{-- Section 2: Store Info --}}
        <fieldset>
            <legend class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Store Information</legend>
            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="storeName" class="block text-sm font-medium text-gray-700">Store Name</label>
                        <input wire:model.live.debounce.300ms="storeName" type="text" id="storeName" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border text-sm"
                            placeholder="Nelson's Kitchen">
                        @error('storeName') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700">Store URL</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input wire:model="slug" type="text" id="slug" readonly
                                class="block w-full rounded-md border-gray-300 bg-gray-50 text-gray-500 px-3 py-2 border text-sm">
                        </div>
                        @if ($slug)
                            <p class="mt-1 text-xs text-gray-500">
                                Your login URL: <span class="font-mono text-indigo-600">{{ $slug }}.{{ config('app.domain') }}</span>
                            </p>
                        @endif
                        @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Store Description</label>
                    <textarea wire:model="description" id="description" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        placeholder="Tell customers what makes your restaurant special..."></textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        {{-- Section 3: Store Address --}}
        <fieldset>
            <legend class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Store Address</legend>
            <div class="space-y-4">
                <div>
                    <label for="addressLine" class="block text-sm font-medium text-gray-700">Street Address</label>
                    <input wire:model="addressLine" type="text" id="addressLine" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border text-sm"
                        placeholder="123 Main Street">
                    @error('addressLine') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <input wire:model="city" type="text" id="city" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border text-sm"
                            placeholder="Manila">
                        @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="postcode" class="block text-sm font-medium text-gray-700">Postal Code</label>
                        <input wire:model="postcode" type="text" id="postcode" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border text-sm"
                            placeholder="1000">
                        @error('postcode') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </fieldset>

        {{-- Section 4: KYC / Documents --}}
        <fieldset>
            <legend class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Verification Documents</legend>
            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="idType" class="block text-sm font-medium text-gray-700">ID Type</label>
                        <select wire:model.live="idType" id="idType" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border text-sm">
                            <option value="">Select ID type...</option>
                            @foreach(\App\PhilippineIdType::cases() as $type)
                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
                            @endforeach
                        </select>
                        @error('idType') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="idNumber" class="block text-sm font-medium text-gray-700">ID Number</label>
                        <input wire:model="idNumber" type="text" id="idNumber" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border text-sm"
                            placeholder="{{ $this->idFormatHint ?: 'Select an ID type first' }}">
                        @if($this->idFormatHint)
                            <p class="mt-1 text-xs text-gray-500">Format: {{ $this->idFormatHint }}</p>
                        @endif
                        @error('idNumber') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label for="businessPermit" class="block text-sm font-medium text-gray-700">Business Permit / DTI Certificate</label>
                    <input wire:model="businessPermit" type="file" id="businessPermit"
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-1 text-xs text-gray-500">PDF, JPG, or PNG — max 5MB</p>
                    @error('businessPermit') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    <div wire:loading wire:target="businessPermit" class="mt-1 text-xs text-indigo-600">Uploading...</div>
                </div>
            </div>
        </fieldset>

        {{-- Submit --}}
        <div class="pt-4 border-t">
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="register">Submit Application</span>
                <span wire:loading wire:target="register">Submitting...</span>
            </button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Already have a store?
        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign in</a>
    </p>
</div>
