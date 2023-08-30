<?php

namespace App\Http\Controllers\Auth;
   
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class RegisterController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:6',
            'username' => 'required',
            'name' => 'required',
            'nik' => 'required',
            'wilayah_id' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required',
        ]);
   

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['status_user'] = 'y';
        $input['is_die'] = 'n';
        
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return response()->json([
            'message' => 'Data register berhasil ',
            'data' => $success
        ]);    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
             
        ]);

        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;
    
            return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
                'name' => $user->name,
                'level_user' => $user->level_user
            ]);
        } else {
            return response()->json([
                'message' => 'Login gagal',
            ], 401);
        }
    }
    
    public function logout(Request $request)
    {
        $user = $request->user();
    
        if ($user) {
            $user->currentAccessToken()->delete();
    
            return response()->json([
                'message' => 'Logout berhasil',
            ]);
        } else {
            return response()->json([
                'message' => 'Tidak ada pengguna yang diotentikasi',
            ], 400);
        }
    }
    



}