<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OauthClient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SsoController extends Controller
{
    /**
     * Menampilkan halaman login SSO.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showLoginForm(Request $request)
    {
        $client_id = $request->query('client_id');

        // Validasi client_id dan ambil client
        $client = OauthClient::where('client_id', $client_id)->first();

        if (!$client) {
            return redirect('/')->withErrors('Invalid client_id.');
        }

        return view('sso.login', compact('client'));
    }

    /**
     * Proses login SSO.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string|exists:oauth_clients,client_id',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $client = OauthClient::where('client_id', $request->client_id)->first();

        if (!$client) {
            return redirect()->back()->withErrors('Invalid client_id.');
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Generate token atau kode otorisasi
            $token = Str::random(60);

            // Simpan token ke cache dengan user_id sebagai nilai
            cache(['sso_token_' . $token => Auth::user()->id], now()->addMinutes(30));

            // Redirect kembali ke redirect_uri yang telah ditentukan
            return redirect()->to($client->redirect_uri . '?token=' . $token);
        }

        return redirect()->back()->withErrors('Invalid credentials.');
    }

    /**
     * Endpoint untuk menukar token dengan informasi pengguna.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tokenExchange(Request $request)
    {
        // Token sudah divalidasi oleh middleware 'verify.sso.token'
        $user = $request->get('sso_user');

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            // Tambahkan informasi lain jika diperlukan
        ]);
    }
}