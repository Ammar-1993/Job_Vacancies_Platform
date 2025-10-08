@php
    if (auth()->user()->role == 'admin') {
        $formAction = route('companies.update', ['company' => $company->id, 'redirectToList' => request('redirectToList')]);
    } else if (auth()->user()->role == 'company-owner') {
        $formAction = route('my-company.update');
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') . ' - ' . $company->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <form action="{{ $formAction }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Company Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold">Company Details</h3>
                    <p class="text-sm mb-2">Enter the company details</p>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}"
                            class="{{ $errors->has('name') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $company->address) }}"
                            class="{{ $errors->has('address') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                        <select name="industry" id="industry" value="{{ old('industry', $company->industry) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @foreach ($industries as $industry)
                                <option value="{{ $industry }}">{{ $industry }}</option>
                            @endforeach
                        </select>
                        @error('industry')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="website" class="block text-sm font-medium text-gray-700">Website (optional)</label>
                        <input type="text" name="website" id="website" value="{{ old('website', $company->website) }}"
                            class="{{ $errors->has('website') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('website')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Company Owner -->

                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold">Company Owner</h3>
                    <p class="text-sm mb-4">Enter the company owner details</p>

                    <div class="mb-4">
                        <label for="owner_name" class="block text-sm font-medium text-gray-700">Owner Name</label>
                        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $company->owner->name) }}"
                            class="{{ $errors->has('owner_name') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('owner_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Owner Email (read-only cannot be changed) -->
                    <div class="mb-4">
                        <label for="owner_email" class="block text-sm font-medium text-gray-700">Owner Email</label>
                        <input disabled type="email" name="owner_email" id="owner_email" value="{{ old('owner_email', $company->owner->email) }}"
                            class="{{ $errors->has('owner_email') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-100">
                        @error('owner_email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Owner Password (Can update the password) -->

                    <div class="mb-4">
                        <label for="owner_password" class="block text-sm font-medium text-gray-700">
                            Change Owner Password (Leave blank to keep the same)</label>
                        <div class="relative" x-data="{ showPassword: false }">
                            <x-text-input id="owner_password" class="block mt-1 w-full"
                                x-bind:type="showPassword ? 'text' : 'password'" name="owner_password"
                                autocomplete="current-password"  />

                            <button type="button" class="absolute inset-y-0 right-2 flex items-center text-gray-500"
                                @click="showPassword = !showPassword">

                                <!-- Eye Icon Open -->
                                <svg x-show="showPassword" width="800px" height="800px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
                                    <path
                                        d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z"
                                        stroke="#000000" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z"
                                        stroke="#000000" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                                <!-- Eye Icon Closed -->
                                <svg x-show="!showPassword" width="800px" height="800px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
                                    <path
                                        d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5"
                                        stroke="#000000" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>



                <div class="flex justify-end space-x-4">
                    @if (auth()->user()->role == 'company-owner')
                        <a href="{{ route('my-company.show') }}"
                            class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                            Cancel
                        </a>
                    @endif

                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('companies.index') }}"
                            class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                            Cancel
                        </a>
                    @endif

                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Company
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>