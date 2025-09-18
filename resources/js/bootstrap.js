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

// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//     enabledTransports: ["ws", "wss"],
//     auth: {
//         headers: function() {
//             return {
//                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || '',
//                 "X-Guest-Token": window.guestToken || '',
//                 "X-Guest-Id": window.guestId || '',
//             };
//         }
//     },
// });
// console.log('Echo initialized',window.guestToken,window.guestId);
console.log('Initializing Echo with conversation data:', window.conversationData);

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

// Initialize Echo only if we have valid conversation data
if (isValidConversationData(window.conversationData)) {
    const { conversationId, guestToken } = window.conversationData;
    
    console.log('Creating Echo instance with:', {
        conversationId,
        hasGuestToken: !!guestToken
    });

    // Initialize Laravel Echo with Pusher
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
        authEndpoint: '/broadcasting/auth', // Laravel handles auth here
        auth: {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                ...(guestToken ? {
                    'X-GUEST-TOKEN': guestToken,
                    'X-GUEST-ID': window.conversationData.guestId || ''
                } : {})
            }
        }
    });

    // Subscribe to private conversation channel
    window.Echo.private(`conversation.${conversationId}`)
        .listen('.MessageSent', (event) => {
            console.log('📨 Received message event:', event);
        })
        .error((error) => {
            console.error('❌ Channel subscription error:', error);
        });
} else {
    console.warn('⚠️ Invalid or missing conversation data:', window.conversationData);
}

// window.initEcho = function({ guestToken, guestId }) {
//     window.Echo = new Echo({
//         broadcaster: "pusher",
//         key: import.meta.env.VITE_PUSHER_APP_KEY,
//         cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//         forceTLS: true,
//         enabledTransports: ["ws", "wss"],
//         authEndpoint: "/broadcasting/auth", 
//         withCredentials: true,
//         disableStats: true,
//         auth: {
//             headers: {
//                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
//                 "X-Guest-Token": guestToken,
//                 "X-Guest-Id": guestId
//             }
//         }
//     });
// };