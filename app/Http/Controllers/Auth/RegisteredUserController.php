<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        // $messages = [
        //     'name.string' => 'Il nome deve essere una stringa.',
        //     'name.max' => 'Il nome non può superare i 255 caratteri.',
        //     'surname.string' => 'Il cognome deve essere una stringa.',
        //     'surname.max' => 'Il cognome non può superare i 255 caratteri.',
        //     'date_of_birth.date' => 'La data di nascita deve essere una data valida.',
        //     'email.required' => 'L\'indirizzo email è obbligatorio.',
        //     'email.email' => 'L\'indirizzo email deve essere un indirizzo email valido.',
        //     'email.unique' => 'L\'indirizzo email è già stato utilizzato.',
        //     'password.required' => 'La password è obbligatoria.',
        //     'password.confirmed' => 'La conferma della password non corrisponde.',
        // ];

        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date', function ($attribute, $value, $fail) {
                if ($value) {
                    $date = Carbon::parse($value);
                    if ($date->diffInYears(Carbon::now()) < 18) {
                        $fail('Devi essere maggiorenne per registrarti.');
                    }
                }
            }],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'date_of_birth' => $request->date_of_birth,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
