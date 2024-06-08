<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ strtok($user->name, ' ') . '\'s profile' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Profile Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('users.update', $user) }}"
                              class="grid grid-cols-4 gap-6 mt-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <label class="bg-gray-400 rounded aspect-square border-0">
                                <img id="preview_img"
                                     class="h-full w-full object-center object-cover rounded border-0"
                                     src="{{ $user->image ? asset('/storage/images/' . $user->image) : 'https://www.spict.org.uk/wp-content/uploads/2019/04/placeholder.png' }}">
                                <input name="image" accept=".png, .jpg, .jpeg" onchange="loadFile(event)" type="file"
                                       class="absolute opacity-0"
                                       oninvalid="this.setCustomValidity('Please select a image')">
                            </label>

                            <div class="mt-6 space-y-6 col-span-3">
                                <div>
                                    <x-input-label for="name" :value="__('Name')"/>
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                                  :value="old('name', $user->name)"
                                                  required autofocus autocomplete="name"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('Email')"/>
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                                  readonly
                                                  :value="old('email', $user->email)" required autocomplete="username"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')"/>

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                        <div>
                                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                                {{ __('Your email address is unverified.') }}

                                                <button form="send-verification"
                                                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Update user') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>


                </div>
            </div>
        </div>
    </div>

    <script>
        const loadFile = function (event) {
            let output = document.getElementById('preview_img');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
</x-app-layout>
