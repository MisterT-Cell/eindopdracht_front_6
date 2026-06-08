<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'gebruikersnaam' => 'required|string',
            'wachtwoord' => 'required|string',
        ]);

        $medewerker = DB::table('medewerkers')
            ->where('gebruikersnaam', $request->gebruikersnaam)
            ->first();

        if (!$medewerker || !Hash::check($request->wachtwoord, $medewerker->wachtwoord)) {
            return response()->json(['bericht' => 'Onjuiste inloggegevens.'], 401);
        }
        
        $token = bin2hex(random_bytes(32));

        DB::table('medewerkers')
            ->where('id', $medewerker->id)
            ->update(['token' => $token]);

        return response()->json(['token' => $token], 200);        
    }
}
