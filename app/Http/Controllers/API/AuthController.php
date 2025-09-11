<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\User_react;

use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $request -> validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);


        if(!Auth:: attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('mobileToken')->plainTextToken;
     
        
        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }


    public function register(Request $request){
  
       try{ 
          set_time_limit(300);
        $request -> validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
            'role' => 'required|in:admin,competitor'
        ]);

         $user = User_react::create([
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role
                                    ]);


    return response()->json([
        'message' => 'Registration successful',
        'user' => [
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role
        ]], 201);
    }
    
    catch(\Exception $e){ 

         return response()->json(['error' => 'Registration failed (success!!) ', 
         'details' => $e->getMessage()], 500);
    }

    }

    public function login_react(Request $request){
           // Validate incoming request
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'details' => $validator->errors()], 422);
            }

            // Find user by email
            $user = User_react::where('email', $request->email)->first();

            // Check if user exists and if the password matches
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'Unauthorized', 'details' => 'Invalid credentials'], 401);
            }


            // Generate a token for the user (Assuming you use Laravel Passport or Sanctum)
                $token = $user->createToken('YourAppName')->plainTextToken;  // If using Sanctum, or Passport if preferred.

                // Return success response with the token
                return response()->json([
                    'message' => 'Login successful',
                    'user' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'role' => $user->role
                    ],
                    'token' => $token
                ], 200);


    }

    //register post 
    public function getUsers() {
    $users = User_react::all();
    return response()->json(['users' => $users]);
    }

     public function register_test(){
        return response()->json([
            'message' => 'Registaration passed',
        ]);
    }

    public function deleteUsers(){
         User_react::truncate();
         return response()->json([
                  'message' => 'Registaration data has been deleted',
        ]);
    }




// AuthController.php



    public function logout(Request $request)
    {
        $request-> user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
