// Countdown Timer Implementation
class CountdownTimer {
    constructor(element) {
        this.element = element;
        this.countdownText = element.querySelector('.countdown-text');
        
        // Add error handling for invalid duration
        const duration = parseInt(element.dataset.duration);
        if (isNaN(duration) || duration <= 0) {
            this.duration = 0;
            this.countdownText.textContent = 'Invalid campaign duration';
            return;
        }
        this.duration = duration;

        // Add error handling for invalid start date
        const startDate = new Date(element.dataset.start);
        if (isNaN(startDate.getTime())) {
            this.startDate = null;
            this.countdownText.textContent = 'Invalid start date';
            return;
        }
        this.startDate = startDate;
        
        this.intervalId = null;
        this.observer = null;
    }

    start() {
        // Convert days to total seconds
        const totalSeconds = this.duration * 24 * 60 * 60;

        const updateCountdown = () => {
            const now = new Date();
            const elapsedSeconds = Math.floor((now - this.startDate) / 1000);
            const remainingSeconds = totalSeconds - elapsedSeconds;

            if (remainingSeconds <= 0) {
                this.countdownText.textContent = 'Campaign Ended';
                this.cleanup();
                
                // Update campaign status to completed
                const campaignId = this.element.dataset.campaignId;
                if (campaignId) {
                    fetch(`/api/campaigns/${campaignId}/complete`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    }).then(() => {
                        // Update the status badge in the UI
                        const row = this.element.closest('tr');
                        if (row) {
                            const statusCell = row.querySelector('td:nth-child(8)');
                            if (statusCell) {
                                const badge = statusCell.querySelector('.badge');
                                if (badge) {
                                    badge.className = 'badge bg-info';
                                    badge.textContent = 'Completed';
                                }
                            }
                        }
                    }).catch(error => console.error('Error updating campaign status:', error));
                }
                return;
            }

            // Convert remaining seconds to days, hours, minutes, seconds
            const days = Math.floor(remainingSeconds / (24 * 60 * 60));
            const hours = Math.floor((remainingSeconds % (24 * 60 * 60)) / 3600);
            const minutes = Math.floor((remainingSeconds % 3600) / 60);
            const seconds = remainingSeconds % 60;

            // Format the display
            const formattedDays = String(days).padStart(2, '0');
            const formattedHours = String(hours).padStart(2, '0');
            const formattedMinutes = String(minutes).padStart(2, '0');
            const formattedSeconds = String(seconds).padStart(2, '0');

            this.countdownText.textContent = `${formattedDays}d ${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
        };

        // Update immediately and then every second
        updateCountdown();
        this.intervalId = setInterval(updateCountdown, 1000);

        // Setup observer for cleanup
        this.observer = new MutationObserver((mutations, obs) => {
            if (!document.body.contains(this.element)) {
                this.cleanup();
            }
        });

        this.observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    cleanup() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
            this.intervalId = null;
        }
        if (this.observer) {
            this.observer.disconnect();
            this.observer = null;
        }
    }
}

// Initialize all countdown timers when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const countdownTimers = document.querySelectorAll('.countdown-timer');
    countdownTimers.forEach(timer => {
        const isSubmitted = timer.dataset.submitted === 'true';
        
        if (isSubmitted && timer.dataset.start) {
            const countdownInstance = new CountdownTimer(timer);
            countdownInstance.start();
        }
    });
});