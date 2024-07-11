<x-guest-layout>
    <form method="POST" action="{{ route('admin-actors-submit') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Actor Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="actor_name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="birthdate" :value="__('Actor Birthdate')" />

            <x-text-input id="birthdate" class="block mt-1 w-full"
                            type="date"
                            name="actor_birthdate" required />

            <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Create') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
