import axios from "axios";
window.axios = axios;

window.axios.defaults.baseURL = "https://wizmoto.com";

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

// Helper function to validate conversation data
function isValidConversationData(data) {
    if (!data || typeof data !== 'object') {
        console.warn('❌ Invalid conversation data object');
        return false;
    }

    const { conversationId, guestToken, guestId } = data;

    // For guest chat, we need all three values
    if (guestToken) {
        if (!guestId || !conversationId) {
            console.warn('❌ Missing required guest chat parameters');
            return false;
        }
        return typeof guestToken === 'string' && 
               typeof guestId === 'string' && 
               typeof conversationId === 'string' && 
               conversationId.length > 0;
    }

    // For provider chat, we only need conversationId
    return typeof conversationId === 'string' && conversationId.length > 0;
}

// Initialize Echo function that can be called when conversation data is ready
window.initEcho = function(conversationData) {
    console.log('🔄 Initializing Echo with conversation data:', conversationData);

    // Disconnect existing Echo instance if it exists
    if (window.Echo) {
        console.log('🔌 Disconnecting existing Echo instance');
        window.Echo.disconnect();
    }

    // Validate conversation data
    if (!isValidConversationData(conversationData)) {
        console.warn('⚠️ Invalid conversation data:', conversationData);
        return false;
    }

    const { conversationId, guestToken, guestId } = conversationData;
    
    console.log('🔐 Creating Echo instance with:', {
        conversationId,
        hasGuestToken: !!guestToken,
        hasGuestId: !!guestId
    });

    // Initialize Laravel Echo with Pusher
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                ...(guestToken ? {
                    'X-GUEST-TOKEN': guestToken,
                    'X-GUEST-ID': guestId
                } : {})
            }
        }
    });

    // Subscribe to private conversation channel
    window.Echo.private(`conversation.${conversationId}`)
        .listen('.MessageSent', (event) => {
            console.log('📨 Received message event:', event);
            // Dispatch a custom event that the blade files can listen to
           
        })
        .error((error) => {
            console.error('❌ Channel subscription error:', error);
        
        });

    return true;
};