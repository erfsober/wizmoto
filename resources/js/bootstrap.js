import axios from "axios";
window.axios = axios;

window.axios.defaults.baseURL = "https://wizmoto.com";
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

// Helper function to validate conversation data
function isValidConversationData(data) {
    if (!data || typeof data !== "object") {
        console.warn("❌ Invalid conversation data object");
        return false;
    }

    // For UUID-based approach, we don't need complex validation
    // Just check if we have the basic structure
    return true;
}

// Check if Echo is ready
window.isEchoReady = function() {
    return typeof window.Echo !== 'undefined' && window.Echo !== null;
};

// Initialize Echo function for public channels
window.initEcho = function (conversationData) {
    if (!window.CHAT_CONFIG) {
        console.error("❌ Chat configuration not found");
        return false;
    }

    console.log("🔄 Initializing Echo for public channels");

    // Disconnect existing Echo instance
    if (window.Echo) {
        console.log("🔌 Disconnecting existing Echo instance");
        window.Echo.disconnect();
    }

    // Init Echo for public channels (no authentication needed)
    window.Echo = new Echo({
        broadcaster: "pusher",
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
    });

    // Dispatch connected event
    window.dispatchEvent(
        new CustomEvent("echoConnected", {
            detail: { status: "connected" },
        })
    );

    return true;
};
