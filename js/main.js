//@prepros-prepend plugins/*.js
//@prepros-append partials/ajax.js

//'use strict';

// IIFE - Immediately Invoked Function Expression
(function(AJAX) {

    AJAX(window.jQuery, window, document);    // The global jQuery object is passed as a parameter

}(function($, window, document) {             // The $ is now locally scoped

//var template;

    $(function() {                             // DOM is ready


// 
// // GET LINK URL
//         $('.menu-item').on('click', 'a', function(e) {
//             e.preventDefault();
//
//             var href = $(this).attr('href'),
//                 pageTitle = href.substr(href.lastIndexOf('/') + 1);
//             //var template = pageTitle;
//
//             //getFilterURL( pageTitle );
//             AJAXcall( pageTitle, function() {
//                 console.log('temp1: ' + template);
//             });
//
//
//
//         }); // end btn click



    }); // end doc ready



// AJAX REST API CALL
    function AJAXcall(pageTitle, callback) {

        var http = location.protocol.concat('//');
        var host = http.concat(window.location.hostname);


        if( pageTitle == 'blog' ) {            // PASS

                var URLfilter = 'posts?per_page=2';


        } else {
            var URLfilter = 'pages?filter[name]=' + pageTitle;
        }



        $.ajax({
            dataType: 'json',
            url: host + '/rest/wp-json/wp/v2/' + URLfilter/* + pageTitle*/,

            beforeSend: function() {

                $('.loader').delay(2000).queue( function() {
                    $(this).fadeIn(300);
                });


                $('#content').removeClass('in-right').addClass('out-left');
                console.log(this.url);

            }
        })
        .success( function(res) {

            var obj = res[0]
            var postType = obj.type // Post/Page


            if( !obj.format || obj.format == 'standard' ) {
                console.log('page w/o format');
                var template = Handlebars.compile( $('#' + postType + '').html() );    // Set general Template (Post/page)
            //    var template = Handlebars.compile( $('#page').html() );
            }
            else if( obj.type == 'post' ) {

            }

            $('#content').empty();
            $('.loader').stop(true, true).fadeOut();

            $.each(res, function(i, ctx) {

                //$('#content').append( Mustache.render(template, ctx) ).removeClass('out-left').addClass('in-right');
                $('#content').append( template(ctx) ).removeClass('out-left').addClass('in-right');

            });

        })
        .fail( function() {
            console.log('Fail!');
        });

    }; // end call




})); // end AJAX
