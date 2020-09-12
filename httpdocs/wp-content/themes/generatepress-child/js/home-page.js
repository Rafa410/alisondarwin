(function($) {

    /* Detect current menu section when the user scrolls down */
    function detectCurrentSection() {
        let prevID;
        const topMenu = $( '#site-navigation' );
        const topMenuHeight = topMenu.outerHeight();
        let menuItems = topMenu.find("ul a");

        let scrollItems = menuItems.map(function() {
            let link = $(this).attr('href');
            let item = $( link.substring(link.indexOf('#')) );
            if (item.length) { 
                return item; 
            }
        });

        window.addEventListener('scroll', function() {
            // Get the current scroll position
            let currPos = $(this).scrollTop() + topMenuHeight;
            
            // Get id of current section
            let currSection = scrollItems.map(function(){
                if ($(this).offset().top < currPos) {
                    return this;
                }
            });

            // Get the id of the current element
            currSection = currSection[currSection.length - 1];
            let id = currSection && currSection.length ? currSection[0].id : '';

            if (id) {
                if (prevID !== id) {
                    prevID = id;
                    menuItems
                        .parent().removeClass('sfHover')
                        .end().filter("[href*='#"+id+"']").parent().addClass('sfHover');
                }
            }
            else {
                if (prevID) {
                    prevID = null;
                    menuItems.parent().removeClass('sfHover');
                }
            }
        })
    }

    /*
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


    /* Añade un placeholder que se mueve en el formulario de contacto y de suscripcion */
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


    /* Carga el script mc-validate.js de MailChimp cuando el usuario hace focus en el campo de email */
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


    /************** DOCUMENT READY **************/
    

    $(document).ready(function ($) {
        detectCurrentSection()
        touchableLinks();
        dynamicPlaceholder();
        loadMcValidate();
    });

}(jQuery));

