<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SsoLogin extends Component
{
    public $client_id;
    public $email;
    public $password;

    protected $rules = [
        'client_id' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|string',
    ];

    public function mount($client)
    {
        $this->client_id = $client->client_id;
    }

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->addError('password', 'Invalid credentials.');
            return;
        }

        // Generate token atau kode otorisasi
        $token = Str::random(60);

        // Simpan token ke cache dengan user_id sebagai nilai
        cache(['sso_token_' . $token => Auth::user()->id], now()->addMinutes(30));

        // Ambil redirect_uri dari OAuth client
        $client = \App\Models\OauthClient::where('client_id', $this->client_id)->first();

        // Redirect kembali ke redirect_uri dengan token
        return redirect()->to($client->redirect_uri . '?token=' . $token);
    }

    public function render()
    {
        return view('livewire.sso-login');
    }
}
