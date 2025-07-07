<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Registration successful!'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred during registration.'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            // Check if user exists first
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return response()->json([
                    'message' => 'Email not found.',
                    'errors' => [
                        'email' => ['The email address is not registered.']
                    ]
                ], 422);
            }

            // Check password
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Invalid password.',
                    'errors' => [
                        'password' => ['The password is incorrect.']
                    ]
                ], 422);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Login successful!'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during login.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function facebookLogin(Request $request)
    {
        $request->validate([
            'facebook_id' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|string|email',
        ]);

        $user = User::updateOrCreate(
            ['facebook_id' => $request->facebook_id],
            [
                'name' => $request->name,
                'email' => $request->email,
            ]
        );

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function redirectToInstagram()
    {
        return Socialite::driver('instagram')->redirect();
    }

    public function handleInstagramCallback()
    {
        try {
            $instagramUser = Socialite::driver('instagram')->user();
            
            $user = User::updateOrCreate(
                ['instagram_id' => $instagramUser->id],
                [
                    'name' => $instagramUser->name ?? $instagramUser->nickname,
                    'email' => $instagramUser->email,
                    'instagram_id' => $instagramUser->id,
                    'instagram_token' => $instagramUser->token,
                    'instagram_refresh_token' => $instagramUser->refreshToken,
                ]
            );

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Instagram authentication failed: ' . $e->getMessage()], 500);
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $user = User::updateOrCreate(
                ['facebook_id' => $facebookUser->id],
                [
                    'name' => $facebookUser->name ?? $facebookUser->nickname,
                    'email' => $facebookUser->email,
                    'facebook_id' => $facebookUser->id,
                    // Add token fields if you want to store them
                ]
            );

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Facebook authentication failed: ' . $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    // Get authenticated user profile info
    public function profile(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'country_id' => $user->country_id ?? null,
            'created_at' => $user->created_at,
        ]);
    }

    // Update profile (name/email)
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);
        $user->update($data);
        return response()->json(['message' => 'Profile updated successfully.', 'user' => $user]);
    }

    // Change password
    public function changePassword(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if (!\Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 422);
        }
        $user->password = \Hash::make($request->password);
        $user->save();
        return response()->json(['message' => 'Password changed successfully.']);
    }

    // Delete authenticated user
    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->delete();
        return response()->json(['message' => 'User account deleted successfully.']);
    }
} 