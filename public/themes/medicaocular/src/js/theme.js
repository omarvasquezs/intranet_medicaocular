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
        
        // Extract ID from the PDF URL
        const idMatch = pdfUrl.match(/generate_amonestacion_pdf\/(\d+)/);
        const amonestacionId = idMatch ? idMatch[1] : null;
        
        // Set the iframe source to the PDF URL
        $('#pdfFrame').attr('src', pdfUrl);
        
        // Set the download link
        $('#downloadPdfBtn').attr('href', pdfUrl.replace('?view=inline', ''));
        
        // Set up sign button if we have an ID and we're in mis_amonestaciones
        if (amonestacionId && window.location.href.includes('mis_amonestaciones')) {
            const signUrl = window.location.origin + '/firmar_amonestacion/' + amonestacionId;
            $('#signPdfBtn').attr('href', signUrl).show();
        } else {
            $('#signPdfBtn').hide();
        }
        
        // Show the modal
        $('#pdfViewerModal').modal('show');
    });

    // Also listen for standard GroceryCRUD action buttons as a fallback
    $(document).on('click', 'a.btn-outline-dark[href*="generate_amonestacion_pdf"]', function(e) {
        e.preventDefault();
        
        const pdfUrl = $(this).attr('href');
        console.log("Opening PDF URL (fallback):", pdfUrl);
        
        // Extract ID from the PDF URL
        const idMatch = pdfUrl.match(/generate_amonestacion_pdf\/(\d+)/);
        const amonestacionId = idMatch ? idMatch[1] : null;
        
        // Set the iframe source to the PDF URL
        $('#pdfFrame').attr('src', pdfUrl);
        
        // Set the download link
        $('#downloadPdfBtn').attr('href', pdfUrl.replace('?view=inline', ''));
        
        // Set up sign button if we have an ID and we're in mis_amonestaciones
        if (amonestacionId && window.location.href.includes('mis_amonestaciones')) {
            const signUrl = window.location.origin + '/firmar_amonestacion/' + amonestacionId;
            $('#signPdfBtn').attr('href', signUrl).show();
            
            // Only show sign button if the document isn't already signed
            // We'll try to determine this by looking at the firmado column in the table
            const $row = $(this).closest('tr');
            const firmadoText = $row.find('td:contains("firmado"), td:contains("FIRMADO")').text();
            
            if (firmadoText && firmadoText.toLowerCase().includes('si')) {
                $('#signPdfBtn').hide();
            }
        } else {
            $('#signPdfBtn').hide();
        }
        
        // Show the modal
        $('#pdfViewerModal').modal('show');
    });
    
    // Clear iframe when modal is closed
    $('#pdfViewerModal').on('hidden.bs.modal', function () {
        $('#pdfFrame').attr('src', '');
    });
});