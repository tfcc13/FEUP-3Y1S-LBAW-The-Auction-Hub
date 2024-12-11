document.addEventListener("DOMContentLoaded", function () {


    const auctionDataElement = document.getElementById("auction-data");
    if (!auctionDataElement) return;

    const auctionStateUrl = auctionDataElement.dataset.auctionUrl;
    const interval = 30000; // 30 s

    setInterval(() => {
        fetch(auctionStateUrl)
            .then(response => response.json())
            .then(data => {
                const stateElement = document.getElementById('auction-state');
                if (stateElement.textContent !== data.state) {
                    stateElement.textContent = data.state;
                    location.reload(); 
                }
            })
            .catch(error => console.error('Error fetching auction state:', error));
    }, interval);

});
