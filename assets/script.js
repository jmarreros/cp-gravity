(function ($) {
    'use strict';

    generic_fill_fields('.grupo1');
    generic_fill_fields('.grupo2');
    generic_fill_fields('.grupo3');
    generic_fill_fields('.grupo4');

    function generic_fill_fields(grupo_sel) {
        let data = {};

        const cpContainer = $(grupo_sel + '.cp .ginput_container_text');
        const cpDesc = $(grupo_sel + '.cp .gfield_description');

        const cities = $(grupo_sel + '.cities select'); // Dynamic select

        const ciudad = $(grupo_sel + '.ciudad input');
        const municipio = $(grupo_sel + '.municipio input');
        const provincia = $(grupo_sel + '.provincia input');
        const comunidad = $(grupo_sel + '.comunidad input');

        let ajaxInProgress = false;

        $(cities).change(function () {
            if (data) {
                const current = $(this).val();

                // Search current in data
                const result = data.filter(item => item.ciudad === current);

                if (result.length > 0) {
                    $(ciudad).val(result[0].ciudad);
                    $(municipio).val(result[0].municipio);
                    $(provincia).val(result[0].provincia);
                    $(comunidad).val(result[0].ca);
                }
            }
        });


        $(cpContainer).find('input').on('focusout', function () {
            if (!ajaxInProgress) {
                ajax_call();
            }
        });

        $(cpContainer).click(function (e) {
            if (e.offsetX > $(this).width() - 70) {
                if (!ajaxInProgress) {
                    ajax_call();
                }
            }
        });

        $(document).ajaxStart(function () {
            ajaxInProgress = true;
        });

        $(document).ajaxStop(function () {
            ajaxInProgress = false;
        });

        function ajax_call() {
            const code = $(cpContainer).find('input').val();
            $.ajax({
                url: cpgravity_var.ajaxurl,
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'dcms_get_data_cp',
                    nonce: cpgravity_var.nonce,
                    code: code
                }, beforeSend: function () {
                    $(cpDesc).show();
                    $(cities).find('option').remove().end();
                    $(ciudad).val('');
                    $(municipio).val('');
                    $(provincia).val('');
                    $(comunidad).val('');
                }
            })
                .done(function (res) {
                    if (res.success) {
                        if (res.data.length > 0) {

                            if (res.data.length > 1) {
                                $(cities).append('<option value="">Selecciona una localidad</option>');
                            }

                            res.data.forEach(item => {
                                $(cities).append('<option value="' + item.ciudad + '">' + item.ciudad + '</option>');
                            });

                            data = res.data;

                            if (res.data.length === 1) {
                                $(cities).change();
                            }

                        } else {
                            alert('No se han encontrado resultados');
                        }
                    }
                })
                .always(function () {
                    $(cpDesc).hide();
                });
        }
    }

})(jQuery);