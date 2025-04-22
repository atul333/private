document.addEventListener('DOMContentLoaded', function() {
    function updateCountdown() {
        const countdownElements = document.querySelectorAll('.countdown-timer');
        
        countdownElements.forEach(element => {
            const campaignId = element.dataset.campaignId;
            const duration = parseInt(element.dataset.duration);
            const startTime = element.dataset.start;
            const isSubmitted = element.dataset.submitted === 'true';
            const createdAt = element.dataset.createdAt;
            const countdownText = element.querySelector('.countdown-text');

            if (!isSubmitted) {
                // Handle 24-hour submission countdown
                const submissionDeadline = new Date(createdAt).getTime() + (24 * 60 * 60 * 1000);
                const now = new Date().getTime();
                const timeLeft = submissionDeadline - now;

                if (timeLeft <= 0) {
                    countdownText.textContent = 'Time expired! Campaign cancelled';
                    element.classList.add('text-red-500');
                    cancelCampaign(campaignId);
                    return;
                }

                const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                countdownText.textContent = `Submit link within: ${hours}h ${minutes}m ${seconds}s`;
                return;
            }

            // Handle campaign duration countdown
            const start = new Date(startTime);
            const now = new Date();
            const endTime = new Date(start.getTime() + (duration * 24 * 60 * 60 * 1000));
            const timeLeft = endTime - now;

            if (timeLeft <= 0) {
                countdownText.textContent = 'Campaign ended';
                element.classList.add('text-red-500');
                return;
            }

            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            countdownText.textContent = `Time remaining: ${days}d ${hours}h ${minutes}m ${seconds}s`;
        });
    }

    function cancelCampaign(campaignId) {
        fetch(`/publisher/campaign/${campaignId}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        }).catch(error => {
            console.error('Error cancelling campaign:', error);
        });
    }

    // Update countdown every second
    setInterval(updateCountdown, 1000);
    updateCountdown(); // Initial update
});