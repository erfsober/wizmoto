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
console.log('conversationData',window.conversationData);
if (window.conversationData) {
    const { conversationId, guestToken } = window.conversationData;

    // Initialize Laravel Echo with Pusher
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
        authEndpoint: '/broadcasting/auth' // Laravel handles auth here
    });

    // If guestToken exists, send it in headers; otherwise, provider uses session
    const options = guestToken ? {
        auth: {
            headers: {
                'X-GUEST-TOKEN': guestToken
            }
        }
    } : {};

    // Subscribe to private conversation channel
    window.Echo.private(`conversation.${conversationId}`, options)
        .listen('MessageSent', (event) => {
            console.log('Received event:', event);
        
        });
}

window.initEcho = function({ guestToken, guestId }) {
    window.Echo = new Echo({
        broadcaster: "pusher",
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
        enabledTransports: ["ws", "wss"],
        authEndpoint: "/broadcasting/auth", 
        withCredentials: true,
        disableStats: true,
        auth: {
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "X-Guest-Token": guestToken,
                "X-Guest-Id": guestId
            }
        }
    });
};