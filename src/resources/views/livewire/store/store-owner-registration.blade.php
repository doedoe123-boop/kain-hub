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
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
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
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
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
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z" />
                        </svg>
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
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
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
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                        </svg>
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
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
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
                        <svg class="w-4 h-4 text-amber-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
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
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Uploaded
                                    </span>
                                @endif
                            </div>
                            <div class="mt-2">
                                <label for="doc_{{ $doc['key'] }}" class="flex items-center justify-center w-full rounded-lg border-2 border-dashed border-gray-300 px-4 py-4 cursor-pointer hover:border-indigo-400 transition-colors">
                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
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
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Back
                    </button>
                @endif
            </div>

            <div>
                @if ($step < 5)
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm transition-colors duration-150">
                        Continue
                        <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
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
