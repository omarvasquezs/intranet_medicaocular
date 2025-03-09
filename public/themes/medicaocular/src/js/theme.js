$(function () {
    "use strict";

});

/**
 * Handle PDF viewer for amonestaciones
 */
$(document).ready(function() {
    // Add event delegation for PDF buttons in amonestaciones
    $(document).on('click', '.gc-action-button[href*="generate_amonestacion_pdf"]', function(e) {
        e.preventDefault();
        
        const pdfUrl = $(this).attr('href');
        console.log("Opening PDF URL:", pdfUrl);
        
        // Open in a new tab with target="_blank"
        const newWindow = window.open(pdfUrl, '_blank');
        
        // If popup blocked, fallback to direct location change
        if (!newWindow || newWindow.closed || typeof newWindow.closed === 'undefined') {
            console.log("Popup may be blocked, trying direct approach");
            // Fallback: Try to navigate directly
            window.location.href = pdfUrl;
        }
    });
});