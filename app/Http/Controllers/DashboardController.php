<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OauthClient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Halaman Dashboard
    public function index()
    {
        return view('dashboard');
    }

    // Manajemen Pengguna
    public function users()
    {
        $users = User::with('authorization')->paginate(10);
        return view('dashboard.users.index', compact('users'));
    }

    // Edit Pengguna
    public function editUser($id)
    {
        $user = User::with('authorization')->findOrFail($id);
        return view('dashboard.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|in:user,developer',
        ]);

        $user = User::findOrFail($id);
        $user->authorization->update([
            'role' => $request->role,
        ]);

        return redirect()->route('dashboard.users')->with('success', 'User updated successfully.');
    }

    // Manajemen OAuth Clients
    public function clients()
    {
        $clients = OauthClient::with('user')->paginate(10);
        return view('dashboard.clients.index', compact('clients'));
    }

    public function createClient()
    {
        return view('dashboard.clients.create');
    }

    public function storeClient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'redirect_uri' => 'required|url',
        ]);

        $client = OauthClient::create([
            'name' => $request->name,
            'client_id' => Str::random(40),
            'client_secret' => Str::random(80),
            'redirect_uri' => $request->redirect_uri,
            'user_id' => auth::id(),
        ]);

        return redirect()->route('dashboard.clients')->with('success', 'Client created successfully.');
    }

    public function deleteClient($id)
    {
        $client = OauthClient::findOrFail($id);
        $client->delete();

        return redirect()->route('dashboard.clients')->with('success', 'Client deleted successfully.');
    }
}