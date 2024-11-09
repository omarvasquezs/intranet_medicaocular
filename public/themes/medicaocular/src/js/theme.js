import $ from 'jquery';
import 'jquery-ui/dist/jquery-ui.min.js';
import 'bootstrap';

$(function () {
    "use strict";

    $('[data-toggle="tooltip"]').tooltip();

    $('#publicaciones-tab').on('click.theme', function () {
        location.reload(true);
    });
});