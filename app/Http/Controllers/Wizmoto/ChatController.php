<?php

namespace App\Http\Controllers\Wizmoto;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Message;
use App\Models\Provider;
use App\Models\Advertisement;
use App\Services\ChatEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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

        // Create the initial message
        $message = Message::create([
            'guest_id' => $guest->id,
            'provider_id' => $request->provider_id,
            'sender_type' => 'guest',
            'message' => $contextMessage
        ]);

        // Broadcast the message to the provider
        broadcast(new MessageSent($message));

        // ChatEmailService::sendGuestMessageToProvider($message);
        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent! The dealer will respond via this platform.',
            'conversation_link' => $guest->getConversationLink($request->provider_id),
            'privacy_notice' => 'Your email is kept private until you choose to share it.'
        ]);
    }

    /**
     * Send message as guest
     */
    public function sendGuestMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider_id' => 'required|exists:providers,id',
            'message' => 'required|string|max:1000',
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

        // Create the message
        $message = Message::create([
            'guest_id' => $guest->id,
            'provider_id' => $request->provider_id,
            'sender_type' => 'guest',
            'message' => $request->message
        ]);

        // Broadcast the message to the provider
        broadcast(new MessageSent($message));

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully!',
            'data' => $message
        ]);
    }

    /**
     * Get chat messages between guest and provider
     */
    public function getChatMessages(Request $request)
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

        // Get messages between this guest and provider
        $messages = Message::where('guest_id', $guest->id)
            ->where('provider_id', $request->provider_id)
            ->with(['guest', 'provider'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'guest' => $guest,
            'provider' => Provider::find($request->provider_id)
        ]);
    }

    /**
     * Show chat interface for guest
     */
    public function showGuestChat(Request $request, $providerId)
    {
        $provider = Provider::findOrFail($providerId);
        $guest = null;
        $conversations = [];

        // If guest_id is provided, verify token and load the specific conversation
        if ($request->has('guest_id') && $request->has('email') && $request->has('token')) {
            $guest = Guest::find($request->guest_id);
            
            if (!$guest) {
                abort(404, 'Guest not found');
            }

            // Verify token
            $expectedToken = md5($request->email . $providerId . env('APP_KEY'));
            if ($request->token !== $expectedToken) {
                abort(403, 'Invalid conversation link');
            }

            // Verify guest email matches
            if ($guest->email !== $request->email) {
                abort(403, 'Invalid conversation access');
            }

            // Get all conversations for this guest
            $conversations = Message::where('guest_id', $guest->id)
                ->with(['guest', 'provider'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('provider_id');
        }

        return view('wizmoto.chat.guest-chat', compact('provider', 'guest', 'conversations'));
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

    /**
     * Get conversation messages for provider dashboard
     */
    public function getProviderConversation(Request $request, $guestId)
    {
        $provider = Auth::guard('provider')->user();

        if (!$provider) {
            return response()->json([
                'success' => false,
                'message' => 'Not authenticated'
            ], 401);
        }

        $messages = Message::where('guest_id', $guestId)
            ->where('provider_id', $provider->id)
            ->with(['guest', 'provider'])
            ->orderBy('created_at', 'asc')
            ->get();

        $guest = Guest::find($guestId);

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Guest not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'guest' => $guest
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
