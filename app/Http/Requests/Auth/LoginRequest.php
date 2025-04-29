<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! $this->attemptAuthentication()) {
            RateLimiter::hit($this->throttleKey());

            $this->throwFailedAuthenticationException();
        }

        RateLimiter::clear($this->throttleKey());
    }

    protected function attemptAuthentication(): bool
    {
        return Auth::attempt(
            $this->only('email', 'password'),
            $this->boolean('remember')
        );
    }

    protected function throwFailedAuthenticationException(): void
    {
        Alert::error('Gagal!', 'Email atau password yang Anda masukkan salah.');

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        Alert::warning(
            'Peringatan!',
            "Anda telah melebihi batas percobaan login. Silakan coba lagi dalam {$seconds} detik."
        );

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
