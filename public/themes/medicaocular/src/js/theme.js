(function ($) {
    "use strict";
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    $('#publicaciones-tab').on('click', function() {
        location.reload();
    });
})(jQuery);