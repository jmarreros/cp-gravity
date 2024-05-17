(function( $ ) {
    'use strict';

    const data = {};

    $('.datos.cp .ginput_container_text').click(function(e){

        if (e.offsetX > $(this).width() - 70 ) {
            const code = $(this).find('input').val();

            $.ajax({
                url: cpgravity_var.ajaxurl,
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'dcms_get_data_cp',
                    nonce: cpgravity_var.nonce,
                    code: code
                }, beforeSend: function () {
                    // Clean inputs
                }
            })
            .done(function (res) {
                console.log(res);
            })
            .always(function () {
                // Enable elements
            });

        }

    });

})( jQuery );