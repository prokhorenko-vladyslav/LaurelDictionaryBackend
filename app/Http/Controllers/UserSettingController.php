<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSettingUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function update(UserSettingUpdateRequest $request, string $alias)
    {
        $setting = User::current()->settings()->firstOrNew([
            'alias' => $alias
        ]);
        $setting->value = $request->input('value');
        $setting->user()->associate(User::current());
        $setting->saveOrFail();
    }
}
