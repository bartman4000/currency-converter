/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// var $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

// loads the jquery package from node_modules
var $ = require('jquery');

// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
$(document).ready(function() {

    $("#form_save").on('click', function(e) {

        // Stop form from submitting normally
        e.preventDefault();
        $("#form_save").attr("disabled","disabled");

        // Get some values from elements on the page:
        var $form = $("#form"),
            amount = $form.find( "input[id='form_amount']" ).val();

        // Send the data using post
        var posting = $.get( '/api/convert?from=rub&to=pln&amount='+amount);

        // Put the results in a div
        posting.done(function( data ) {
            $( "#result" ).empty().append( 'PLN: '+data.result );
        });

        $("#form_save").removeAttr("disabled");
    });

});

