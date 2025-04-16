import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Debug sidebar links and track redirects
document.addEventListener("DOMContentLoaded", function () {
    console.log("Debug: DOM Content Loaded");
    console.log("Current URL:", window.location.href);

    // Track Projects navigation
    if (window.location.pathname.includes("projects")) {
        console.log("You are on the projects page now!");
    }

    // Track navigation by overriding history state methods
    const originalPushState = history.pushState;
    history.pushState = function () {
        console.log("Navigation detected - pushState to:", arguments[2]);
        return originalPushState.apply(this, arguments);
    };

    const originalReplaceState = history.replaceState;
    history.replaceState = function () {
        console.log("Navigation detected - replaceState to:", arguments[2]);
        return originalReplaceState.apply(this, arguments);
    };

    // Add click event listener to all links
    document.querySelectorAll("a").forEach((link) => {
        const href = link.getAttribute("href");
        if (href) {
            console.log("Found link:", href);

            // Add specific tracking for projects links
            if (href.includes("projects")) {
                console.log("Found projects link:", link);

                // Track clicks on this link
                link.addEventListener("click", function (e) {
                    console.log(
                        "Projects link clicked, navigating to:",
                        this.getAttribute("href")
                    );
                });
            }

            // Add general click tracking
            link.addEventListener("click", function (e) {
                console.log("Link clicked:", this.getAttribute("href"));
            });
        }
    });
});
