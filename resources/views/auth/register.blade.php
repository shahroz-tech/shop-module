@extends('layouts.app')

@section('content')

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form action="/auth/register" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                    <div class="mt-2">
                        <input id="name" type="text" name="name" value="{{ old('email') }}"
                               required autocomplete="name"
                               class="block w-full rounded-md px-3 py-1.5 text-base text-gray-900
                outline-1 -outline-offset-1 placeholder:text-gray-400 sm:text-sm/6
                {{ $errors->has('name')
                    ? 'border-red-500 outline-red-500 focus:outline-red-600'
                    : 'bg-white outline-gray-300 focus:outline-indigo-600' }}">
                    </div>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autocomplete="email"
                               class="block w-full rounded-md px-3 py-1.5 text-base text-gray-900
                outline-1 -outline-offset-1 placeholder:text-gray-400 sm:text-sm/6
                {{ $errors->has('email')
                    ? 'border-red-500 outline-red-500 focus:outline-red-600'
                    : 'bg-white outline-gray-300 focus:outline-indigo-600' }}">
                    </div>
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="block w-full rounded-md px-3 py-1.5 text-base text-gray-900
                outline-1 -outline-offset-1 placeholder:text-gray-400 sm:text-sm/6
                {{ $errors->has('password')
                    ? 'border-red-500 outline-red-500 focus:outline-red-600'
                    : 'bg-white outline-gray-300 focus:outline-indigo-600' }}">
                    </div>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900">Confirm Password</label>
                    </div>
                    <div class="mt-2">
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="current-password"
                               class="block w-full rounded-md px-3 py-1.5 text-base text-gray-900
                outline-1 -outline-offset-1 placeholder:text-gray-400 sm:text-sm/6
                {{ $errors->has('password-confirmation')
                    ? 'border-red-500 outline-red-500 focus:outline-red-600'
                    : 'bg-white outline-gray-300 focus:outline-indigo-600' }}">
                    </div>
                    @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign in
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Not a member?
                <a href="/auth/register" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign up</a>
            </p>
        </div>
    </div>

@endsection
