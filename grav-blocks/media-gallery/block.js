jQuery(document).ready(function($){

    // Gallery Slider with Swiper
    if(typeof(Swiper) !== 'undefined')
    {
        $('.block-media-gallery-format-slider .block-media-items-container').before('<div class="media-items-slider-pagination"></div>' +
        '<div class="media-items-slider-prev"></div>' +
    	'<div class="media-items-slider-next"></div>');

        $('.block-media-gallery-format-slider .block-media-items-container').each(function(index){

            var block_index = $(this).closest('.block-container').attr('data-block-index');

            var numSlidesSmall = parseFloat($(this).attr('data-columns-small'));
            var numSlidesMedium = parseFloat($(this).attr('data-columns-medium'));
            var numSlidesLarge = parseFloat($(this).attr('data-columns-large'));
            var numSlidesXlarge = parseFloat($(this).attr('data-columns-xlarge'));

            new Swiper($(this), {
                simulateTouch: false,
                loop: true,
                autoHeight: true,
                keyboardControl: true,
                nextButton: '.block-index-'+block_index+' .media-items-slider-next',
                prevButton: '.block-index-'+block_index+' .media-items-slider-prev',
                pagination: '.block-index-'+block_index+' .media-items-slider-pagination',
                paginationClickable: true,
                slideClass: 'media-item',
                wrapperClass: 'media-items',
                slidesPerView: numSlidesXlarge,
                slidesPerGroup: numSlidesXlarge,
                spaceBetween: 50,
                breakpoints: {
                    1440: {
                        slidesPerView: numSlidesLarge,
                        slidesPerGroup: numSlidesLarge,
                        spaceBetween: 50
                    },
                    1024: {
                        slidesPerView: numSlidesMedium,
                        slidesPerGroup: numSlidesMedium,
                        spaceBetween: 50
                    },
                    640: {
                        slidesPerView: numSlidesSmall,
                        slidesPerGroup: numSlidesSmall,
                        spaceBetween: 50
                    }
                }
            });
        });

    }

    // Gallery Images Popup with Colorbox
    if(jQuery().colorbox)
    {
        $('.block-media-gallery-format-gallery').each(function(index)
        {
            var block_index = $(this).closest('.block-container').attr('data-block-index');
            $(this).find('.gallery-'+block_index).colorbox({rel:'gallery-'+block_index, width: '90%', height: '90%'});
        });
    }


});
