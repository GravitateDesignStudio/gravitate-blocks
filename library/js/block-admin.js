jQuery(document).ready(function($)
{

    // NOTE gravBlockData is from localized script passed from php in gravitate-blocks.php

    gravBlocks = {};

    gravBlocks.init = function(){
        // Loop through all block list "popup" templates
        // 
        // These are the dropdown lists that appear when clicking "Add Content"
        // in a flexible field section
        $('.tmpl-popup').each(function () {
            var $gravpopup = $($(this).html());

            // loop through blocks and add additional choices if necessary
            $.each(gravBlockData, function (index, value) {
                var blockName = index;

                $.each(value.choices, function(index, value) {
                    if (index) {
                        $gravpopup.find('[data-layout="' + blockName + '"]').first().parent().after('<li><a href="#" data-layout="grid" data-min="" data-max="" data-format="format-'+index+'">Grid - '+value+'</a></li>');
                    }
                });
            });

            // update the "popup" tempate HTML
            try {
                $(this).html($gravpopup[0].outerHTML);
            } catch (e) {
                // safety net to prevent an uncaught error if $gravpopup is undefined
            }
        });

        gravBlocks.setClick();
    }

    gravBlocks.setClick = function(){
        $('[data-event="add-layout"]').on('click touch', function(e){
            $(document).on('click touch', e, gravBlocks.addFormat);
        });
    }

    gravBlocks.addFormat = function(e){
        if(e.target.dataset.layout && e.target.dataset.layout == 'grid'){
            if(e.target.dataset.format){
                acf.add_action('append', function($el){
                    gravBlocks.setClick();
                    var format = $el.find('[id$='+e.target.dataset.layout+'_'+e.target.dataset.format+']');
                    $(format).click();
                });
            } else {
                acf.add_action('append', function($el){
                    gravBlocks.setClick();
                    var format = $el.find('[id$='+e.target.dataset.layout+'_format]');
                    $(format).click();
                });
            }
        }

        if(e.target.dataset.layout){
            $(document).off('click touch', gravBlocks.addFormat);
        }
    }

    gravBlocks.init();
});
