@extends('layouts.web')

@section('title')
{{ __('Reset Password') }}
@endsection

@section('content')
<div class="lg:mt-20 flex max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 lg:max-w-1xl">
    
        <div class="w-full px-6 py-8 md:px-8">
            <h2 class="text-2xl text-center text-gray-700 dark:text-white"><strong>Black</strong>Cat</h2>

            <p class="text-xl text-center text-gray-600 dark:text-gray-200 mt-2">{{ __('Reset password') }}</p>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="uid" value="{{ $uid }}">
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="mt-4 flex">
                    @error('password')
                    <div x-data="{ errorOpen : true }">
                        <div class="w-full text-white bg-red-500 mb-2" x-show="errorOpen">
                            <div class="container flex items-center justify-between px-6 py-4 mx-auto">
                                <div class="flex">
                                    <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                                        <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"></path>
                                    </svg>

                                    <p class="mx-3">{{ $message }}</p>
                                </div>

                                <button type="button" class="p-1 transition-colors duration-200 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none" x-on:click="errorOpen = false">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    @enderror
                    <div class="block w-full">
                        <div class="flex justify-between">
                        <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="password">{{  __('New password') }}</label>
                        </div>

                        <input class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" type="password" id="password" name="password" required autocomplete="new-password">
                    </div>
                </div>
                <div class="mt-4 flex">
                    <div class="block w-full">
                        <div class="flex justify-between">
                        <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="password_confirm">{{  __('Confirm new password') }}</label>
                        </div>

                        <input class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" type="password" required autocomplete="new-password" id="password_confirm" name="password_confirmation">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-700 focus:ring-opacity-80" id="submit">
                        Set new password
                    </button>
                </div>
            </form>
        </div>
    
</div>
@endsection

@section("script")

@endsection
