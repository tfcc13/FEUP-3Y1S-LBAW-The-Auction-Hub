document.addEventListener("DOMContentLoaded", function () {
    function updateBidCardRemainingTime() {
        const now = new Date();

        document.querySelectorAll(".auction-end-time").forEach((endTimeElement, index) => {
            const endTime = new Date(endTimeElement.textContent.trim());
            const remainingTime = endTime - now;

            const remainingTimeElement = document.querySelectorAll(".auction-remaining-time")[index];
            const statusElement = document.querySelectorAll(".auction-status")[index];

            if (!remainingTimeElement || !statusElement) return;

            if (statusElement.textContent.trim() === "Resumed") {
                remainingTimeElement.textContent = "Auction ended.";
            } else if (remainingTime > 0) {
                const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                if (days > 0) {
                    remainingTimeElement.textContent = `${days}d ${hours}h ${minutes}m`;
                } else if (hours > 0) {
                    remainingTimeElement.textContent = `${hours}h ${minutes}m ${seconds}s`;
                } else if (minutes > 0) {
                    remainingTimeElement.textContent = `${minutes}m ${seconds}s`;
                } else {
                    remainingTimeElement.textContent = `${seconds}s`;
                }
            } else {
                remainingTimeElement.textContent = "Auction ended.";
            }
        });
    }

    // Initial setup for existing cards
    updateBidCardRemainingTime();
    setInterval(updateBidCardRemainingTime, 1000);
});
