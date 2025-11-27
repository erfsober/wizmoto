<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\Guest;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Setting;
use Illuminate\Support\Str;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
class SupportChatController extends Controller
{
    public function index()
    {
        // Get or create supporter provider
        $supporter = Provider::where('username', 'wizmoto-support')->first();
        
        if (!$supporter) {
            // Create supporter if doesn't exist
            $whatsappNumber = Setting::get('whatsapp_number', '00393517455691');
            $supportEmail = Setting::get('support_email', 'support@wizmoto.com');
            
            $supporter = Provider::create([
                'username' => 'wizmoto-support',
                'first_name' => 'WizMoto',
                'last_name' => 'Support',
                'email' => $supportEmail,
                'password' => bcrypt('support123'),
                'phone' => $whatsappNumber,
                'whatsapp' => $whatsappNumber,
            ]);
        }
        // Get or create guest session
        $guestId = session('guest_id');
        $guest = null;
        
        if ($guestId) {
            $guest = Guest::find($guestId);
        }
        
        if (!$guest) {
            $guest = Guest::create([
                'name' => 'Guest User',
                'email' => 'guest@wizmoto.com',
            ]);
            session(['guest_id' => $guest->id]);
        }

        // Get or create conversation between guest and supporter
        $conversation = Conversation::where('guest_id', $guest->id)
            ->where('provider_id', $supporter->id)
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'guest_id' => $guest->id,
                'provider_id' => $supporter->id,
                'uuid' => Str::uuid(),
            ]);
        }

        // Get messages for this conversation
        $messages = Message::where('conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('wizmoto.support-chat', compact('supporter', 'guest', 'conversation', 'messages'));
    }

    public function initChat()
    {
        // Get or create supporter provider
        $supporter = Provider::where('username', 'wizmoto-support')->first();
        
        if (!$supporter) {
            // Create supporter if doesn't exist
            $whatsappNumber = Setting::get('whatsapp_number', '00393517455691');
            $supportEmail = Setting::get('support_email', 'support@wizmoto.com');
            
            $supporter = Provider::create([
                'username' => 'wizmoto-support',
                'first_name' => 'WizMoto',
                'last_name' => 'Support',
                'email' => $supportEmail,
                'password' => bcrypt('support123'),
                'phone' => $whatsappNumber,
                'whatsapp' => $whatsappNumber,
            ]);
        }

        // Get or create guest session
        $guestId = session('guest_id');
        $guest = null;
        
        if ($guestId) {
            $guest = Guest::find($guestId);
        }
        
        if (!$guest) {
            $guest = Guest::create([
                'name' => 'Guest User',
                'email' => 'guest@wizmoto.com',
            ]);
            session(['guest_id' => $guest->id]);
        }

        // Get or create conversation between guest and supporter
        $conversation = Conversation::where('guest_id', $guest->id)
            ->where('provider_id', $supporter->id)
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'guest_id' => $guest->id,
                'provider_id' => $supporter->id,
                'uuid' => Str::uuid(),
            ]);
        }

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id,
            'conversation_uuid' => $conversation->uuid,
            'supporter_name' => $supporter->first_name . ' ' . $supporter->last_name,
        ]);
    }

    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000',
                'conversation_uuid' => 'required|string',
            ]);

            $guestId = session('guest_id');
            if (!$guestId) {
                return response()->json(['error' => 'Guest session not found'], 400);
            }

            // Find conversation by UUID (like guest-provider system)
            $conversation = Conversation::where('uuid', $request->conversation_uuid)->first();
            if (!$conversation) {
                return response()->json(['error' => 'Conversation not found'], 404);
            }

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'guest_id' => $conversation->guest_id,
                'provider_id' => $conversation->provider_id,
                'sender_type' => 'guest',
                'message' => $request->message,
            ]);

            // Broadcast the message to the conversation
            broadcast(new MessageSent($message));

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to send message',
            ], 500);
        }
    }

    public function sendProviderMessage(Request $request)
    {
        try {
            // Require authentication like guest-provider system
            $provider = Auth::guard('provider')->user();
            if (!$provider) {
                return response()->json(['error' => 'Not authenticated'], 401);
            }

            $request->validate([
                'message' => 'required|string|max:1000',
                'conversation_uuid' => 'required|string',
            ]);

            // Get the supporter provider
            $supporter = Provider::where('username', 'wizmoto-support')->first();
            if (!$supporter) {
                return response()->json(['error' => 'Support provider not found'], 404);
            }

            // Find conversation by UUID (like guest-provider system)
            $conversation = Conversation::where('uuid', $request->conversation_uuid)->first();
            if (!$conversation) {
                return response()->json(['error' => 'Conversation not found'], 404);
            }

            // Verify this is a support conversation AND provider is authorized
            if ($conversation->provider_id !== $supporter->id) {
                return response()->json(['error' => 'Not a support conversation'], 400);
            }

            // Additional security: Only support provider can send messages
            if ($provider->username !== 'wizmoto-support') {
                return response()->json(['error' => 'Unauthorized to send support messages'], 403);
            }

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'guest_id' => $conversation->guest_id,
                'provider_id' => $supporter->id,
                'sender_type' => 'provider',
                'message' => $request->message,
            ]);

            // Broadcast the message to the conversation
            broadcast(new MessageSent($message));

            // Log for debugging

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to send message',
            ], 500);
        }
    }

    public function getMessages(Request $request)
    {
        $request->validate([
            'conversation_uuid' => 'required|string',
            'last_message_id' => 'nullable|integer',
        ]);

        // Find conversation by UUID (like guest-provider system)
        $conversation = Conversation::where('uuid', $request->conversation_uuid)->first();
        if (!$conversation) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        $lastMessageId = $request->last_message_id ?? 0;
        $query = Message::where('conversation_id', $conversation->id);
        
        // If last_message_id is provided, only get messages after that ID
        if ($lastMessageId > 0) {
            $query->where('id', '>', $lastMessageId);
        }
        
        $messages = $query->orderBy('created_at', 'asc')->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }
}
