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

    const { conversationId, guestToken, guestId } = data;

    // For guest chat, require all 3
    if (guestToken) {
        if (!guestId || !conversationId) {
            console.warn("❌ Missing required guest chat parameters");
            return false;
        }
        return true; // allow numeric IDs too
    }

    // For provider chat, require only conversationId
    return !!conversationId;
}

// Initialize Echo function
window.initEcho = function (conversationData) {
    if (!window.CHAT_CONFIG) {
        console.error("❌ Chat configuration not found");
        return false;
    }

    console.log("🔄 Initializing Echo with conversation data:", {
        conversationId: conversationData?.conversationId,
        hasGuestToken: !!conversationData?.guestToken,
    });

    // Disconnect existing Echo instance
    if (window.Echo) {
        console.log("🔌 Disconnecting existing Echo instance");
        window.Echo.disconnect();
    }

    // Validate conversation data
    if (!isValidConversationData(conversationData)) {
        console.warn("⚠️ Invalid conversation data:", conversationData);
        return false;
    }

    const { conversationId, guestToken, guestId } = conversationData;

    // Init Echo
    window.Echo = new Echo({
        broadcaster: "pusher",
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
        authEndpoint: "/broadcasting/auth",
        auth: {
            headers: {
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')?.content || "",
                ...(guestToken
                    ? {
                          "X-GUEST-TOKEN": guestToken,
                          "X-GUEST-ID": guestId,
                      }
                    : {}),
            },
        },
    });

    // Subscribe to conversation channel
    window.Echo.private(`conversation.${conversationId}`)
        .listen("MessageSent", (event) => {
            console.log("📨 Received message event:", event);
            window.dispatchEvent(
                new CustomEvent("messageSent", {
                    detail: event,
                })
            );
        })
        .error((error) => {
            console.error("❌ Channel subscription error:", error);
            window.dispatchEvent(
                new CustomEvent("echoError", {
                    detail: error,
                })
            );
        });

    return true;
};
