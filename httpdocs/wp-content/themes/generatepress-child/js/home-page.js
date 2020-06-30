(function($) {


    /** TOUCHABLE LINKS
    * Deshabilita el link al pulsar en una noticia por primera vez desde móvil o tablet para mostrar
    * la descripcion y despues vuelve a habilitar el link.
    */
    function touchableLinks() {
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

        if (isMobile) {

            const link = document.querySelectorAll('.banner-link');

            for (let i = 0; i < link.length; i++) {
                link[i].addEventListener('click', clickedLink);
            }

            function clickedLink(e) {
                e.preventDefault();
                this.removeEventListener('click', clickedLink);
            }

        }
    }


    /* DYNAMIC PLACEHOLDER
    * Script para poner un placeholder que se mueve en el formulario de contacto y de suscripcion
    */
    function dynamicPlaceholder() {
        let i = 0;

        $('.dynamic-input').focus(function () { // Añadir clase 'has-focus'

            i = $(".dynamic-input").index($(this));
            $('.dynamic-placeholder').eq(i).addClass('has-focus');

            if (i == 2) {
                setTimeout(function () {
                    $('.dynamic-msg').text('Mensaje*');
                }, 1000);
            }
            if (i == 5) {
                $('.dynamic-input option:first-child').text('');
                $('.dynamic-zone').css('opacity', '1')
                setTimeout(function () {
                    $('.dynamic-zone').text('Zona');
                }, 1000);
            }

        });

        $('.dynamic-input').on('input', function () { // Añadir/Quitar clase 'has-input'

            i = $(".dynamic-input").index($(this));

            if ($('.dynamic-input').eq(i).val() == '') {
                $('.dynamic-placeholder').eq(i).removeClass('has-input');
            }
            else {
                if (!$('.dynamic-placeholder').eq(i).hasClass('has-input')) {
                    $('.dynamic-placeholder').eq(i).addClass('has-input');
                }
            }

        });

        $('.dynamic-input').focusout(function () { // Quitar clase 'has-focus'

            i = $(".dynamic-input").index($(this));
            $('.dynamic-placeholder').eq(i).removeClass('has-focus');

            if (!$('.dynamic-placeholder').eq(i).hasClass('has-input')) {
                if (i == 2) {
                    setTimeout(function () {
                        $('.dynamic-msg').text('¿En qué podemos ayudarte?');
                    }, 1000);

                }
                if (i == 5) {
                    setTimeout(function () {
                        $('.dynamic-zone').text(' - Selecciona una zona - ').css('opacity', '0');
                        $('.dynamic-input option:first-child').text(' - Selecciona una zona - ');
                    }, 1000);
                }

            }

        });
    }


    /**
     * Carga el script mc-validate.js de MailChimp
     * cuando el usuario hace focus en el campo de email
     */
    function loadMcValidate() {
        const $form = $( '#mc_embed_signup' );
        if ( $form.length ) {
            $form.one( 'focusin', '.email', function() {
                $.ajax({
                    type: "GET",
                    url: '/wp-content/themes/generatepress-child/js/external-js/mc-validate.js',
                    dataType: "script",
                    cache: true
                });  
            })
        }
    }


    /** Ya no es necesario, ahora se pueden traducir los links con translatepress
     * DYNAMIC CONTACT LINKS
     * Cambia el enlace que hay en la información de contacto según el idioma seleccionado
     */
    /* function dynamiContactLinks() {
        const email = document.querySelectorAll('#contact-info .elementor-icon-list-item a')[0];
        const phone = document.querySelectorAll('#contact-info .elementor-icon-list-item a')[1];

        email.href = 'mailto:' + email.innerText.slice(2, -2); // Elimina los 2 primeros ( '· ' ) y últimos ( ' ·' ) caracteres
        phone.href = 'https://wa.me/' + phone.innerText.replace(/\s+/g, '').slice(2, -1); // Primero quita los espacios y después los 2 primeros caracteres ( '·+' ) y el último caracter (·)
    }*/


    /************** DOCUMENT READY **************/
    

    $(document).ready(function ($) {
        touchableLinks();
        dynamicPlaceholder();
        loadMcValidate();
    });

}(jQuery));

