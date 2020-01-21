/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/admin.css';

import 'admin-lte/plugins/fontawesome-free/css/all.min.css'
import 'admin-lte/dist/css/adminlte.min.css'

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
window.jQuery = $;
window.$ = $;

// Bootstrap 4
import bootstrap from 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
// AdminLTE App
import adminlte from 'admin-lte/dist/js/adminlte.min.js';

(function ($) {

    function readURL(input) {
        if (!(input.files && input.files[0])) {
            return;
        }

        let reader = new FileReader();
        reader.onload = function(e) {
            $(input).closest('.input-preview').find('img').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }

    $('input[type=file]').change(function() {
        readURL(this);
    });
})($);
