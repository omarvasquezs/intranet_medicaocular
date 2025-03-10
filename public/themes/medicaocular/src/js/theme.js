$(function () {
    "use strict";

});

/**
 * Handle PDF viewer for amonestaciones
 */
$(document).ready(function() {
    // Add event delegation for PDF buttons in amonestaciones using our custom class
    $(document).on('click', '.view-pdf', function(e) {
        e.preventDefault();
        
        const pdfUrl = $(this).data('pdf-url');
        console.log("Opening PDF URL:", pdfUrl);
        
        // Set the iframe source to the PDF URL
        $('#pdfFrame').attr('src', pdfUrl);
        
        // Set the download link
        $('#downloadPdfBtn').attr('href', pdfUrl.replace('?view=inline', ''));
        
        // Show the modal
        $('#pdfViewerModal').modal('show');
    });

    // Also listen for standard GroceryCRUD action buttons as a fallback
    $(document).on('click', 'a.btn-outline-dark[href*="generate_amonestacion_pdf"]', function(e) {
        e.preventDefault();
        
        const pdfUrl = $(this).attr('href');
        console.log("Opening PDF URL (fallback):", pdfUrl);
        
        // Set the iframe source to the PDF URL
        $('#pdfFrame').attr('src', pdfUrl);
        
        // Set the download link
        $('#downloadPdfBtn').attr('href', pdfUrl.replace('?view=inline', ''));
        
        // Show the modal
        $('#pdfViewerModal').modal('show');
    });
});