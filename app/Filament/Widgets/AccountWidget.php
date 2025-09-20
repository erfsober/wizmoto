<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget as BaseAccountWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AccountWidget extends BaseAccountWidget
{
    public function render(): View
    {
        $user = Auth::guard('admin')->user();
        
        // Try to get the admin's image from Spatie MediaLibrary
        $avatar = null;
        if ($user && method_exists($user, 'getFirstMediaUrl')) {
            $avatar = $user->getFirstMediaUrl('image', 'image') ?: $user->getFirstMediaUrl('image');
        }
        
        return view('filament.widgets.account-widget', [
            'user' => $user,
            'avatar' => $avatar,
            'name' => $user->name ?? 'Admin',
            'email' => $user->email ?? '',
        ]);
    }
}
