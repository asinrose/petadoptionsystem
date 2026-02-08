<x-guest-layout>
    <div class="mb-4 text-muted small">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary-custom">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>
