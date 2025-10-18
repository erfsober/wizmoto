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
                'conversation_id' => 'required|exists:conversations,id',
            ]);

            $guestId = session('guest_id');
            if (!$guestId) {
                return response()->json(['error' => 'Guest session not found'], 400);
            }

            $message = Message::create([
                'conversation_id' => $request->conversation_id,
                'sender_type' => 'guest',
                'sender_id' => $guestId,
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
            $request->validate([
                'message' => 'required|string|max:1000',
                'conversation_id' => 'required|exists:conversations,id',
            ]);

            // Get the supporter provider
            $supporter = Provider::where('username', 'wizmoto-support')->first();
            if (!$supporter) {
                return response()->json(['error' => 'Support provider not found'], 404);
            }

            // Get the conversation from the request
            $conversation = Conversation::find($request->conversation_id);
            if (!$conversation) {
                return response()->json(['error' => 'Conversation not found'], 404);
            }

            // Verify this is a support conversation
            if ($conversation->provider_id !== $supporter->id) {
                return response()->json(['error' => 'Not a support conversation'], 400);
            }

            $message = Message::create([
                'conversation_id' => $request->conversation_id,
                'sender_type' => 'provider',
                'sender_id' => $supporter->id,
                'message' => $request->message,
            ]);

            // Broadcast the message to the conversation
            broadcast(new MessageSent($message));

            // Log for debugging
            \Log::info('Provider message sent to support chat', [
                'message_id' => $message->id,
                'conversation_id' => $conversation->id,
                'conversation_uuid' => $conversation->uuid,
                'sender_type' => $message->sender_type,
                'message' => $message->message
            ]);

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
        $conversationId = $request->conversation_id;
        $lastMessageId = $request->last_message_id ?? 0;

        $query = Message::where('conversation_id', $conversationId);
        
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