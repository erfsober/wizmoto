<?php

namespace App\Http\Controllers\Wizmoto;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Message;
use App\Models\Provider;
use App\Models\Advertisement;
use App\Services\ChatEmailService;
use App\Enums\MessageSenderTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Conversation;

class ChatController extends Controller
{
    /**
     * Initiate chat between guest and provider (AutoScout24 style)
     */
    public function initiateChat(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'provider_id' => 'required|exists:providers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
            'advertisement_id' => 'nullable|exists:advertisements,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Create or find guest by email (AutoScout24 style)
        $guest = Guest::query()->where('email', $request->email)->where('phone', $request->phone)->first();
        if (!$guest) {
            $guest = Guest::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
        }

        // Create context message about the advertisement
        $contextMessage = $request->message;
        if ($request->advertisement_id) {
            $advertisement = Advertisement::find($request->advertisement_id);
            if ($advertisement) {
                $contextMessage = "Regarding: {$advertisement->title}\n\n" . $request->message;
            }
        }

        $conversation = Conversation::where('provider_id', $request->provider_id)
            ->where('guest_id', $guest->id)
            ->first();

        if (!$conversation) {

            // Create conversation
            $conversation = Conversation::create([
                'provider_id' => $request->provider_id,
                'guest_id' => $guest->id,

            ]);
        }

        // Create context message about the advertisement
        $contextMessage = $request->message;
        if ($request->advertisement_id) {
            $advertisement = Advertisement::find($request->advertisement_id);
            if ($advertisement) {
                $contextMessage = "Regarding: {$advertisement->title}\n\n" . $request->message;
            }
        }
        // Create the initial message
        $message = Message::create([
            'guest_id' => $guest->id,
            'provider_id' => $request->provider_id,
            'sender_type' => MessageSenderTypeEnum::GUEST->value,
            'message' => $contextMessage,
            'conversation_id' => $conversation->id
        ]);

        // Broadcast the message to the provider
        broadcast(new MessageSent($message));

        // ChatEmailService::sendGuestMessageToProvider($message);
        return response()->json([
            'conversation_link' => $conversation->getConversationLink(),
            'privacy_notice' => 'Your email is kept private until you choose to share it.',
            'success' => true,
            'message' => 'Your message has been sent! The dealer will respond via this platform.',
            'conversation_id' => $conversation->id,
            'guest_token' => $conversation->raw_guest_token,
            'expires_at' => $conversation->token_expires_at,
        ]);
    }

    /**
     * Send message as guest
     */
    public function sendGuestMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string|max:1000',
            'guest_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Find conversation and validate token
        $conversation = Conversation::find($request->conversation_id);
        if (!$conversation) {
            return response()->json([
                'success' => false,
                'message' => 'Conversation not found'
            ], 404);
        }

        // Validate guest token
        $expectedHash = $conversation->guest_token_hash;
        $providedHash = hash_hmac('sha256', $request->guest_token, config('app.key'));

        if (!hash_equals($expectedHash, $providedHash) || !$conversation->isTokenValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token'
            ], 403);
        }

        // Create the message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'guest_id' => $conversation->guest_id,
            'provider_id' => $conversation->provider_id,
            'sender_type' => MessageSenderTypeEnum::GUEST->value,
            'message' => $request->message
        ]);

        // Broadcast the message to the conversation
        broadcast(new MessageSent($message));

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully!',
            'data' => $message
        ]);
    }

    /**
     * Get chat messages for a conversation
     */
    public function getChatMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id',
            'guest_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Find conversation and validate token
        $conversation = \App\Models\Conversation::find($request->conversation_id);
        if (!$conversation) {
            return response()->json([
                'success' => false,
                'message' => 'Conversation not found'
            ], 404);
        }

        // Validate guest token
        $expectedHash = $conversation->guest_token_hash;
        $providedHash = hash_hmac('sha256', $request->guest_token, config('app.key'));

        if (!hash_equals($expectedHash, $providedHash) || !$conversation->isTokenValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token'
            ], 403);
        }

        // Get messages for this conversation
        $messages = Message::where('conversation_id', $conversation->id)
            ->with(['guest', 'provider'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'guest' => $conversation->guest,
            'provider' => $conversation->provider,
            'conversation' => $conversation
        ]);
    }

    /**
     * Show chat interface for guest
     */
    public function showGuestChat(Request $request, $providerId)
    {
        $provider = Provider::findOrFail($providerId);
        $guest = null;
        $conversation = null;

        // If conversation_id and token are provided, verify and load the conversation
        if ($request->has('conversation_id') && $request->has('guest_token')) {
            $conversation = Conversation::find($request->conversation_id);

            if (!$conversation) {
                abort(404, 'Conversation not found');
            }

            // Validate guest token
            $expectedHash = $conversation->guest_token_hash;
            $providedHash = hash_hmac('sha256', $request->guest_token, config('app.key'));

            if (!hash_equals($expectedHash, $providedHash) || !$conversation->isTokenValid()) {
                abort(403, 'Invalid or expired conversation link');
            }

            $guest = $conversation->guest;
        }

        return view('wizmoto.chat.guest-chat', compact('provider', 'guest', 'conversation'));
    }

    /**
     * Get conversation messages for guest
     */
    public function getGuestConversation(Request $request, $guestId)
    {
        $guest = Guest::find($guestId);

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Guest not found'
            ], 404);
        }

        $providerId = $request->get('provider_id');
        $email = $request->get('email');
        $token = $request->get('token');

        if (!$providerId) {
            return response()->json([
                'success' => false,
                'message' => 'Provider ID required'
            ], 400);
        }

        // Verify token for security
        if ($email && $token) {
            $expectedToken = md5($email . $providerId . env('APP_KEY'));
            if ($token !== $expectedToken || $guest->email !== $email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid access token'
                ], 403);
            }
        }

        $messages = Message::where('guest_id', $guest->id)
            ->where('provider_id', $providerId)
            ->with(['guest', 'provider'])
            ->orderBy('created_at', 'asc')
            ->get();

        $provider = Provider::find($providerId);

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'guest' => $guest,
            'provider' => $provider
        ]);
    }


    /**
     * Show provider's chat conversations
     */
    public function showProviderChats()
    {
        $provider = Auth::guard('provider')->user();

        // Get all conversations for this provider
        $conversations = Message::where('provider_id', $provider->id)
            ->with(['guest', 'provider'])
            ->select('guest_id', 'provider_id')
            ->distinct()
            ->get()
            ->groupBy('guest_id');

        return view('wizmoto.dashboard.messages', compact('provider', 'conversations'));
    }
    public function sendProviderMessage(Request $request)
    {
        $provider = Auth::guard('provider')->user();

        if (!$provider) {
            return response()->json([
                'success' => false,
                'message' => 'Not authenticated'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $conversation = Conversation::find($request->conversation_id);
        if (!$conversation || $conversation->provider_id !== $provider->id) {
            return response()->json([
                'success' => false,
                'message' => 'Conversation not found'
            ], 404);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'guest_id' => $conversation->guest_id,
            'provider_id' => $provider->id,
            'sender_type' => MessageSenderTypeEnum::PROVIDER->value,
            'message' => $request->message
        ]);

        broadcast(new MessageSent($message));

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully!',
            'data' => $message
        ]);
    }
    /**
     * Get conversation messages for provider dashboard
     */
    public function getProviderConversation(Request $request, $conversationId)
    {
        $provider = Auth::guard('provider')->user();

        if (!$provider) {
            return response()->json([
                'success' => false,
                'message' => 'Not authenticated'
            ], 401);
        }

        $conversation = Conversation::find($conversationId);
        if (!$conversation || $conversation->provider_id !== $provider->id) {
            return response()->json([
                'success' => false,
                'message' => 'Conversation not found'
            ], 404);
        }

        $messages = Message::where('conversation_id', $conversation->id)
            ->with(['guest', 'provider'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'guest' => $conversation->guest,
            'conversation' => $conversation
        ]);
    }

    /**
     * Guest shares email with provider
     */
    public function shareGuestEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider_id' => 'required|exists:providers,id',
            'guest_email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Find guest by email
        $guest = Guest::where('email', $request->guest_email)->first();
        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Guest not found'
            ], 404);
        }

        // Update email sharing preference
        $guest->update(['email_shared' => true]);

        // Send notification message to provider
        $message = Message::create([
            'guest_id' => $guest->id,
            'provider_id' => $request->provider_id,
            'sender_type' => 'system',
            'message' => "📧 {$guest->name} has shared their contact details with you.\nEmail: {$guest->email}" .
                ($guest->phone ? "\nPhone: {$guest->phone}" : "")
        ]);

        broadcast(new MessageSent($message));

        return response()->json([
            'success' => true,
            'message' => 'Your contact details have been shared with the dealer.'
        ]);
    }

    /**
     * Provider requests guest contact details
     */
    public function requestGuestContact(Request $request, $guestId)
    {
        $provider = Auth::guard('provider')->user();
        $guest = Guest::find($guestId);

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Guest not found'
            ], 404);
        }

        // Send system message to guest requesting contact sharing
        $message = Message::create([
            'guest_id' => $guest->id,
            'provider_id' => $provider->id,
            'sender_type' => 'system',
            'message' => "📞 {$provider->full_name} would like to contact you directly. Would you like to share your contact details?\n\n[Click 'Share Contact' button to allow direct contact]"
        ]);

        broadcast(new MessageSent($message));

        return response()->json([
            'success' => true,
            'message' => 'Contact request sent to customer.'
        ]);
    }
}
