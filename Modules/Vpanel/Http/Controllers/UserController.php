<?php

namespace Modules\Vpanel\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\File\Entities\File;
use Modules\Vpanel\Entities\User;

class UserController extends Controller
{
    public function index()
    {
        return view('vpanel::login');
    }

    public function getInfo(): JsonResponse
    {
        $response = null;
        $userId = Auth::id();
        if ($userId) {
            $response = User::getRecord($userId);
        }
        return response()->json($response);
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->login = $request->login;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $success = true;
            $message = 'Пользователь успешно создан';
        } catch (QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            $user->name = $request->name;
            $user->login = $request->login;
            $user->email = $request->email;
            if ($request->new_password) {
                $user->password = Hash::make($request->new_password);
            }

            $file = $request->file('avatar');
            if ($file) {
                $uploadedFile = File::upload($file);
                $user->avatar = $uploadedFile->id;
            }

            $user->save();
            $success = true;
            $message = 'Пользователь успешно обновлен';
        } catch (QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'error' => 'Пользователь не найден!',
        ])->onlyInput('email');
    }

    public function logout(Request $request): Redirector|Application|RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.show');
    }
}
