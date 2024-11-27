document.addEventListener("DOMContentLoaded", function () {
    const auctionEndTimeElements = document.querySelectorAll(".auction-end-time");
    const auctionRemainingTimeElements = document.querySelectorAll(".auction-remaining-time");
    const auctionStatusElements = document.querySelectorAll(".auction-status");

    function updateRemainingTime() {
        const now = new Date();

        auctionEndTimeElements.forEach((element, index) => {
            const endTime = new Date(element.textContent);
            const remainingTime = endTime - now;

            if (auctionStatusElements[index].textContent == "Resumed") {
                auctionRemainingTimeElements[index].textContent = "Auction ended.";
            } else if (remainingTime > 0) {
                const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                if (days == 0) {
                    if (hours == 0) {
                        if (minutes == 0) {
                            auctionRemainingTimeElements[index].textContent = `${seconds} seconds`;
                        } else {
                            auctionRemainingTimeElements[index].textContent = `${minutes} minutes and ${seconds} seconds`;
                        }
                    } else {
                        auctionRemainingTimeElements[index].textContent = `${hours}h ${minutes}m ${seconds}s`;
                    }
                } else {
                    auctionRemainingTimeElements[index].textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                }
            } else {
                auctionRemainingTimeElements[index].textContent = "Auction ended.";
            }
        });
    }

    updateRemainingTime();
    setInterval(updateRemainingTime, 1000);
});
