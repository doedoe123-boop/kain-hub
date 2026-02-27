<div class="max-w-2xl mx-auto">
    {{-- Header --}}
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Register Your Store</h2>
        <p class="mt-2 text-sm text-gray-500">Complete the steps below to submit your store application.</p>
        @if ($this->sectorEnum)
            <div class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-200">
                <span class="text-xs font-medium text-indigo-700">{{ $this->sectorEnum->label() }}</span>
                <a href="{{ route('register.sector') }}" class="text-xs text-indigo-500 hover:text-indigo-700 underline">Change</a>
            </div>
        @endif
    </div>

    {{-- Step Progress Indicator --}}
    <div class="mb-10">
        <div class="flex items-center justify-between">
            @foreach ($this->stepLabels as $num => $label)
                <div class="flex flex-col items-center flex-1 {{ $num < count($this->stepLabels) ? 'relative' : '' }}">
                    {{-- Step circle --}}
                    <button
                        wire:click="goToStep({{ $num }})"
                        @class([
                            'w-9 h-9 rounded-full flex items-center justify-center text-xs font-semibold transition-all duration-200 border-2',
                            'bg-indigo-600 border-indigo-600 text-white' => $step >= $num,
                            'bg-white border-gray-300 text-gray-400' => $step < $num,
                            'cursor-pointer hover:border-indigo-400' => $num < $step,
                            'cursor-default' => $num >= $step,
                        ])
                        @if($num > $step) disabled @endif
                    >
                        @if ($step > $num)
                            <x-heroicon-o-check class="w-4 h-4" />
                        @else
                            {{ $num }}
                        @endif
                    </button>
                    {{-- Step label --}}
                    <span @class([
                        'mt-2 text-[10px] font-medium',
                        'text-indigo-600' => $step >= $num,
                        'text-gray-400' => $step < $num,
                    ])>{{ $label }}</span>

                    {{-- Connector line --}}
                    @if ($num < count($this->stepLabels))
                        <div class="absolute top-[18px] left-[calc(50%+22px)] right-[calc(-50%+22px)] h-0.5 {{ $step > $num ? 'bg-indigo-600' : 'bg-gray-200' }} transition-colors duration-200"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <form wire:submit="{{ $step === 5 ? 'register' : 'nextStep' }}">
        {{-- Step 1: Account Information --}}
        @if ($step === 1)
            <div class="bg-white rounded-xl border border-gray-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <x-heroicon-o-user class="w-5 h-5 text-indigo-600" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Account Information</h3>
                        <p class="text-sm text-gray-500">Your personal details for login and contact.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input wire:model="name" type="text" id="name"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 text-sm"
                                placeholder="Juan Dela Cruz">
                            @error('name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input wire:model="phone" type="tel" id="phone"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 text-sm"
                                placeholder="09171234567">
                            @error('phone') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input wire:model="email" type="email" id="email"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 text-sm"
                            placeholder="you@example.com">
                        @error('email') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input wire:model="password" type="password" id="password"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 text-sm"
                                placeholder="Min. 8 characters">
                            @error('password') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input wire:model="password_confirmation" type="password" id="password_confirmation"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 text-sm"
                                placeholder="Re-enter password">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Step 2: Store Information --}}
        @if ($step === 2)
            <div class="bg-white rounded-xl border border-gray-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <x-heroicon-o-building-storefront class="w-5 h-5 text-indigo-600" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Store Information</h3>
                        <p class="text-sm text-gray-500">Tell us about your business.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="storeName" class="block text-sm font-medium text-gray-700 mb-1">Store Name</label>
                            <input wire:model.live.debounce.300ms="storeName" type="text" id="storeName"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 text-sm"
                                placeholder="Nelson's Kitchen">
                            @error('storeName') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Store URL</label>
                            <input wire:model="slug" type="text" id="slug" readonly
                                class="block w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500 px-4 py-2.5 text-sm cursor-not-allowed">
                            @if ($slug)
                                <p class="mt-1.5 text-xs text-gray-500">
                                    Your store URL: <span class="font-mono text-indigo-600 font-medium">{{ $slug }}.{{ config('app.domain') }}</span>
                                </p>
                            @endif
                            @error('slug') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Store Description</label>
                        <textarea wire:model="description" id="description" rows="4"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5"
                            placeholder="Tell customers what makes your business special..."></textarea>
                        @error('description') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        @endif

        {{-- Step 3: Store Address --}}
        @if ($step === 3)
            <div class="bg-white rounded-xl border border-gray-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <x-heroicon-o-map-pin class="w-5 h-5 text-indigo-600" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Store Address</h3>
                        <p class="text-sm text-gray-500">Where is your store located?</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="addressLine" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                        <input wire:model="addressLine" type="text" id="addressLine"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 text-sm"
                            placeholder="123 Main Street, Barangay Name">
                        @error('addressLine') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City / Municipality</label>
                            <input wire:model="city" type="text" id="city"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 text-sm"
                                placeholder="Manila">
                            @error('city') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="postcode" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                            <input wire:model="postcode" type="text" id="postcode"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 text-sm"
                                placeholder="1000">
                            @error('postcode') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Step 4: Identity Verification --}}
        @if ($step === 4)
            <div class="bg-white rounded-xl border border-gray-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <x-heroicon-o-identification class="w-5 h-5 text-indigo-600" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Identity Verification</h3>
                        <p class="text-sm text-gray-500">Provide a valid government-issued ID for verification.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="idType" class="block text-sm font-medium text-gray-700 mb-1">ID Type</label>
                            <select wire:model.live="idType" id="idType"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 text-sm">
                                <option value="">Select ID type...</option>
                                @foreach(\App\PhilippineIdType::cases() as $type)
                                    <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                @endforeach
                            </select>
                            @error('idType') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="idNumber" class="block text-sm font-medium text-gray-700 mb-1">ID Number</label>
                            <input wire:model="idNumber" type="text" id="idNumber"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 text-sm"
                                placeholder="{{ $this->idFormatHint ?: 'Select an ID type first' }}">
                            @if($this->idFormatHint)
                                <p class="mt-1.5 text-xs text-gray-500">Format: {{ $this->idFormatHint }}</p>
                            @endif
                            @error('idNumber') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Step 5: Sector Compliance Documents --}}
        @if ($step === 5)
            <div class="bg-white rounded-xl border border-gray-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <x-heroicon-o-shield-check class="w-5 h-5 text-indigo-600" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Compliance Documents</h3>
                        <p class="text-sm text-gray-500">
                            Upload the required documents for the <span class="font-semibold text-indigo-600">{{ $this->sectorEnum?->label() }}</span> sector.
                        </p>
                    </div>
                </div>

                {{-- Info Banner --}}
                <div class="mb-6 rounded-lg bg-amber-50 border border-amber-200 p-3">
                    <div class="flex items-start gap-2">
                        <x-heroicon-s-exclamation-triangle class="w-4 h-4 text-amber-600 mt-0.5 flex-shrink-0" />
                        <div>
                            <p class="text-xs text-amber-800 font-medium">Documents marked with <span class="text-red-600">*</span> are required.</p>
                            <p class="text-xs text-amber-700 mt-0.5">Accepted formats: PDF, JPG, JPEG, PNG (max 5MB each).</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach ($this->sectorDocuments as $doc)
                        <div class="rounded-lg border {{ $doc['required'] ? 'border-gray-200' : 'border-dashed border-gray-200' }} p-4">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <div>
                                    <label for="doc_{{ $doc['key'] }}" class="text-sm font-medium text-gray-700">
                                        {{ $doc['label'] }}
                                        @if ($doc['required'])
                                            <span class="text-red-500">*</span>
                                        @else
                                            <span class="text-xs text-gray-400 font-normal">(Optional)</span>
                                        @endif
                                    </label>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $doc['description'] }}</p>
                                </div>
                                @if (isset($complianceFiles[$doc['key']]) && $complianceFiles[$doc['key']])
                                    <span class="inline-flex items-center gap-1 text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded-full flex-shrink-0">
                                        <x-heroicon-o-check-circle class="w-3 h-3" />
                                        Uploaded
                                    </span>
                                @endif
                            </div>
                            <div class="mt-2">
                                <label for="doc_{{ $doc['key'] }}" class="flex items-center justify-center w-full rounded-lg border-2 border-dashed border-gray-300 px-4 py-4 cursor-pointer hover:border-indigo-400 transition-colors">
                                    <div class="flex items-center gap-3 text-sm">
                                        <x-heroicon-o-arrow-up-tray class="w-5 h-5 text-gray-400" />
                                        <span class="text-gray-600">
                                            @if (isset($complianceFiles[$doc['key']]) && $complianceFiles[$doc['key']])
                                                Change file
                                            @else
                                                Choose file to upload
                                            @endif
                                        </span>
                                    </div>
                                    <input
                                        wire:model="complianceFiles.{{ $doc['key'] }}"
                                        type="file"
                                        id="doc_{{ $doc['key'] }}"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="sr-only"
                                    >
                                </label>
                                <div wire:loading wire:target="complianceFiles.{{ $doc['key'] }}" class="mt-2 text-xs text-indigo-600">
                                    <svg class="inline w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Uploading...
                                </div>
                            </div>
                            @error("complianceFiles.{$doc['key']}")
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Navigation Buttons --}}
        <div class="flex items-center justify-between mt-8">
            <div>
                @if ($step > 1)
                    <button type="button" wire:click="previousStep"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition-colors duration-150">
                        <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                        Back
                    </button>
                @endif
            </div>

            <div>
                @if ($step < 5)
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm transition-colors duration-150">
                        Continue
                        <x-heroicon-o-arrow-right class="w-4 h-4 ml-2" />
                    </button>
                @else
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm transition-colors duration-150 disabled:opacity-50"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="register">Submit Application</span>
                        <span wire:loading wire:target="register" class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Submitting...
                        </span>
                    </button>
                @endif
            </div>
        </div>
    </form>

    {{-- Footer note --}}
    <p class="mt-8 text-center text-sm text-gray-500">
        Already have a store?
        <span class="text-gray-600 font-medium">Sign in via your store's subdomain.</span>
    </p>
</div>
