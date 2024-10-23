/* Created by Content Blocks */
// Frontend script for the contact-service content block
document.addEventListener('DOMContentLoaded', function() {
    const callLink = document.querySelector('.contact-service a');

    if (callLink) {
        callLink.addEventListener('click', function(event) {
            const phoneNumber = callLink.getAttribute('href');
            console.log(`Initiating call to: ${phoneNumber}`);
        });
    }
});
