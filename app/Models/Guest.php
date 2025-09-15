<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guest extends Model
{
    

    protected $casts = [
        'email_shared' => 'boolean',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public static function createGuestSession($name, $email, $phone = null)
    {
        return self::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'email_shared' => false 
        ]);
    }


    public function getDisplayEmailAttribute()
    {
        if ($this->email_shared) {
            return $this->email;
        }
        
        // Mask email like: j****@gmail.com
        $parts = explode('@', $this->email);
        if (count($parts) !== 2) return '****@****.com';
        
        $username = $parts[0];
        $domain = $parts[1];
        
        if (strlen($username) <= 2) {
            $masked_username = str_repeat('*', strlen($username));
        } else {
            $masked_username = substr($username, 0, 1) . str_repeat('*', strlen($username) - 2) . substr($username, -1);
        }
        
        return $masked_username . '@' . $domain;
    }
        public function getConversationLink($providerId)
    {
        $token = md5($this->email . $providerId . env('APP_KEY'));
        return route('chat.guest.show', $providerId) . '?guest_id=' . $this->id . '&email=' . urlencode($this->email) . '&token=' . $token;
    }
}
