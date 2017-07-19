// jQuery(document).ready(function($){
jQuery(document).bind('grav_blocks_js_loaded', function(){

    // Gallery Slider with Swiper
    if(typeof(Swiper) !== 'undefined')
    {
        // alert(2);
        jQuery('.block-container.block-quotes').each(function(index){

            var slider = jQuery(this);

            /* Add Slider Classes */
            slider.find('.items-container').addClass('block-slider-swiper block-slider-container');
            slider.find('.items').addClass('block-slider-wrapper');
            slider.find('.item').addClass('block-slider-slide');

            /* Add Navigations */
            slider.find('.block-slider-container').append(
                '<div class="block-slider-pagination"></div>' +
                '<div class="block-slider-button-prev"></div>' +
        	    '<div class="block-slider-button-next"></div>'
            );

            /* Initiate Swiper on block slider */
            new Swiper(slider.find('.block-slider-container'), {
                simulateTouch: false,
                loop: slider.attr('data-slider-loop') !== undefined ? parseFloat(slider.attr('data-slider-loop')) : 0,
                speed: (slider.attr('data-slider-speed') !== undefined ? parseFloat(slider.attr('data-slider-speed')) : 0.3) * 1000,
                autoplay: (slider.attr('data-slider-autoplay') !== undefined ? parseFloat(slider.attr('data-slider-autoplay')) : 0) * 1000,
                effect: slider.attr('data-slider-effect') !== undefined ? slider.attr('data-slider-effect') : 'fade',
                fade: {
                  crossFade: true
                },
                autoHeight: slider.attr('data-slider-autoheight') !== undefined ? parseFloat(slider.attr('data-slider-autoheight')) : 0,
                keyboardControl: true,
                prevButton: slider.find('.block-slider-button-prev'),
                nextButton: slider.find('.block-slider-button-next'),
                pagination: slider.find('.block-slider-pagination'),
                paginationClickable: true,
                containerModifierClass: 'block-slider-container-',
                slideClass: 'block-slider-slide',
                slideActiveClass: 'active',
                wrapperClass: 'block-slider-wrapper',
                bulletClass: 'block-slider-pagination-bullet',
                bulletActiveClass: 'active',
                paginationModifierClass: 'block-slider-pagination-',
                paginationHiddenClass: 'hidden',
                buttonDisabledClass: 'disabled',
                spaceBetween: 50

            });
        });
    }
});
