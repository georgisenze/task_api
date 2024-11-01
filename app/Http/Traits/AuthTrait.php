<?php

namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait AuthTrait
{

    public function signUp($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            $tokenResult = $user->createToken('authtoken');
            $token = $tokenResult->plainTextToken;
            DB::commit();
            return response()->json(['user' => $user, 'accessToken' => $token], Response::HTTP_OK);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de l\'enregistrement.' . $th], Response::HTTP_BAD_REQUEST);
        }
    }

    public function signIn($data)
    {
        try {
            DB::beginTransaction();
            $user = User::where('email', $data['email'])->first();
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return response()->json([
                    'message' => 'Email ou mot de passe invalide.'
                ], Response::HTTP_UNAUTHORIZED);
            }
            $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
            DB::commit();
            return response()->json(['token_type' => 'Bearer', 'accessToken' => $token,], Response::HTTP_OK);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de l\'enregistrement.' . $th], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getUser()
    {
        $user = User::where('id', auth()->user()->id)->with('tasks')->first();
        return response()->json(['datas' => $user], Response::HTTP_OK);
    }


    public function signOut()
    {
        auth()->user()->tokens()->delete();
        return response()->json(["message" => "Successfully logged out"]);
    }
}
