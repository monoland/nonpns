<?php

namespace App\Http\Controllers\Mono;

use App\Events\TeacherHasUpdated;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\VerifyResource;
use App\Models\Nominative;
use Illuminate\Support\Facades\Cache;

class WebController extends Controller
{
    /**
     * Undocumented function.
     */
    public function index()
    {
        TeacherHasUpdated::dispatch();
        return view('default');
    }

    /**
     * Undocumented function
     *
     * @param [type] $code
     */
    public function redirect($code)
    {
        $nominative = Cache::rememberForever("shorten.$code", function () use ($code) {
            return Nominative::with(['teacher', 'school'])->where('shorturl', $code)->first();
        });

        if ($nominative !== null) {
            return redirect()->away("https://app-bkd.bantenprov.go.id/sipandik/#/verify/$code");
        }

        abort(404);
    }

    public function verify($code)
    {
        $nominative = Nominative::with(['teacher', 'school'])->where('shorturl', $code)->first();

        if ($nominative) {
            return new VerifyResource($nominative);
        }

        return response()->json([
            'success' => false
        ], 404);
    }

    /**
     * Undocumented function.
     *
     * @param Request $request
     */
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Undocumented function.
     *
     * @param Request $request
     */
    public function profile(Request $request)
    {
        return User::updateRecord($request, $request->user());
    }

    /**
     * Undocumented function.
     *
     * @param Request $request
     */
    public function password(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|old_password',
            'password' => 'confirmed|max:8|different:old_password',
        ]);

        return User::updatePassword($request, $request->user());
    }

    /**
     * Undocumented function.
     *
     * @param Request $request
     */
    public function company(Request $request)
    {
        return new SettingResource(Setting::find('company'));
    }

    /**
     * Undocumented function.
     *
     * @param Request $request
     */
    public function menus(Request $request)
    {
        switch ($request->user()->authent->name) {
            case 'administrator':
                return response()->json([
                    'deskbar' => [
                        ['type' => 'item', 'icon' => 'dashboard', 'text' => 'Beranda', 'to' => ['name' => 'home']],
                        // master
                        ['type' => 'subheader', 'text' => 'Master', 'class' => 'mt-2'],
                        ['type' => 'item', 'icon' => 'filter_none', 'text' => 'Kantor Cabang', 'to' => ['name' => 'branch']],
                        ['type' => 'item', 'icon' => 'filter_none', 'text' => 'Mata Pelajaran', 'to' => ['name' => 'subject']],

                        // utilitas
                        ['type' => 'subheader', 'text' => 'Utilitas', 'class' => 'mt-2'],
                        ['type' => 'item', 'icon' => 'people', 'text' => 'Pengguna', 'to' => ['name' => 'user']],
                        ['type' => 'item', 'icon' => 'whatshot', 'text' => 'OAuth Klien', 'to' => ['name' => 'client']],
                    ],
                    'mobibar' => [
                        // master
                        ['type' => 'subheader', 'text' => 'Master', 'class' => 'mt-2'],
                        ['type' => 'item', 'icon' => 'filter_none', 'text' => 'Kantor Cabang', 'to' => ['name' => 'branch']],
                    ],
                    'homebar' => [
                        ['type' => 'item', 'icon' => 'dashboard', 'text' => 'Beranda', 'to' => ['name' => 'home']],
                        ['type' => 'item', 'icon' => 'perm_identity', 'text' => 'Profile', 'to' => ['name' => 'profile']],
                        ['type' => 'item', 'icon' => 'lock', 'text' => 'Katasandi', 'to' => ['name' => 'password']],
                    ],
                    'account' => [
                        ['type' => 'item', 'icon' => 'perm_identity', 'text' => 'Profile', 'to' => ['name' => 'profile']],
                        ['type' => 'item', 'icon' => 'lock', 'text' => 'Katasandi', 'to' => ['name' => 'password']],
                        ['type' => 'item', 'icon' => 'settings', 'text' => 'Setting', 'to' => ['name' => 'setting']],
                    ],
                ]);
                break;

            case 'verificator':
                return response()->json([
                    'deskbar' => [
                        ['type' => 'item', 'icon' => 'dashboard', 'text' => 'Beranda', 'to' => ['name' => 'home']],
                        // master
                        ['type' => 'subheader', 'text' => 'Master', 'class' => 'mt-2'],
                        ['type' => 'item', 'icon' => 'filter_none', 'text' => 'Kantor Cabang', 'to' => ['name' => 'branch']],

                    ],
                    'mobibar' => [
                        // master
                        ['type' => 'subheader', 'text' => 'Master', 'class' => 'mt-2'],
                        ['type' => 'item', 'icon' => 'filter_none', 'text' => 'Kantor Cabang', 'to' => ['name' => 'branch']],
                    ],
                    'homebar' => [
                        ['type' => 'item', 'icon' => 'dashboard', 'text' => 'Beranda', 'to' => ['name' => 'home']],
                        ['type' => 'item', 'icon' => 'perm_identity', 'text' => 'Profile', 'to' => ['name' => 'profile']],
                        ['type' => 'item', 'icon' => 'lock', 'text' => 'Katasandi', 'to' => ['name' => 'password']],
                    ],
                    'account' => [
                        ['type' => 'item', 'icon' => 'perm_identity', 'text' => 'Profile', 'to' => ['name' => 'profile']],
                        ['type' => 'item', 'icon' => 'lock', 'text' => 'Katasandi', 'to' => ['name' => 'password']],
                        ['type' => 'item', 'icon' => 'settings', 'text' => 'Setting', 'to' => ['name' => 'setting']],
                    ],
                ]);
                break;

            default:
                return response()->json([
                    'deskbar' => [
                        ['type' => 'item', 'icon' => 'dashboard', 'text' => 'Beranda', 'to' => ['name' => 'home']],

                        ['type' => 'subheader', 'text' => 'Master', 'class' => 'mt-2'],
                        ['type' => 'item', 'icon' => 'filter_none', 'text' => 'Pegawai', 'to' => ['name' => 'operator-teacher']],
                        ['type' => 'item', 'icon' => 'filter_none', 'text' => 'D.S.O', 'to' => ['name' => 'requirement']],
                    ],
                    'mobibar' => [],
                    'homebar' => [],
                    'account' => [
                        ['type' => 'item', 'icon' => 'perm_identity', 'text' => 'Profile', 'to' => ['name' => 'profile']],
                        ['type' => 'item', 'icon' => 'lock', 'text' => 'Katasandi', 'to' => ['name' => 'password']],
                    ],
                ]);
                break;
        }
    }
}
