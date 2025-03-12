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
    $(document).on('click', 'a.btn-outline-dark[href*="generate_amonestacion_pdf"], a.dropdown-item[href*="generate_amonestacion_pdf"]', function(e) {
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
        
        // Check if we're in mis_amonestaciones page and have an ID
        if (amonestacionId && window.location.href.includes('mis_amonestaciones')) {
            // Create a sign URL for the button
            const signUrl = window.location.origin + '/firmar_amonestacion/' + amonestacionId;
            $('#signPdfBtn').attr('href', signUrl);
            
            // Check if this document is already signed by looking for firmado status in the row
            const $row = $(this).closest('tr');
            let docIsSigned = false;
            
            // First try to find a cell that explicitly says "firmado"
            $row.find('td').each(function(index) {
                const cellText = $(this).text().trim().toLowerCase();
                // Look for a cell with value "SI" that corresponds to firmado
                if ((cellText === 'si') && 
                    ($row.closest('table').find('th').eq(index).text().toLowerCase().includes('firmado'))) {
                    docIsSigned = true;
                    return false; // break the loop
                }
            });
            
            // If we couldn't determine it from column headers, check if this is an API response
            if (!docIsSigned && $row.data('firmado') === 1) {
                docIsSigned = true;
            }
            
            // Now check a direct AJAX query to get the latest firmado status
            $.ajax({
                url: window.location.origin + '/check_amonestacion_status/' + amonestacionId,
                method: 'GET',
                async: false, // Make this synchronous for simplicity
                success: function(response) {
                    if (response && response.firmado === 1) {
                        docIsSigned = true;
                    }
                }
            });
            
            // Show or hide the sign button based on signed status
            if (docIsSigned) {
                $('#signPdfBtn').hide();
            } else {
                $('#signPdfBtn').show();
            }
        } else {
            // Not in mis_amonestaciones or no ID, hide sign button
            $('#signPdfBtn').hide();
        }
        
        // Show the modal
        $('#pdfViewerModal').modal('show');
    });
    
    // Clear iframe when modal is closed
    $('#pdfViewerModal').on('hidden.bs.modal', function () {
        $('#pdfFrame').attr('src', '');
    });
    
    // If there's no status checking endpoint, fall back to checking the database directly
    // Make the AJAX check optional with a try/catch
    function checkAmonestacionStatus(id) {
        try {
            let isSigned = false;
            $.ajax({
                url: window.location.origin + '/check_amonestacion_status/' + id,
                method: 'GET',
                async: false,
                success: function(data) {
                    if (data && data.firmado === 1) {
                        isSigned = true;
                    }
                }
            });
            return isSigned;
        } catch (e) {
            console.warn("Could not check amonestacion status:", e);
            return false;
        }
    }
});