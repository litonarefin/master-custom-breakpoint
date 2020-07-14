(function ($) {
  "use strict";

	  $(function () {

		jQuery("#jlmta-cbp-form").submit(function(e){
			e.preventDefault();

			var form = $( this ),
				form_data = form.serializeArray(),
				breakpoints_form = $('#breakpoints_form').val();
                form.addClass('loading');

			$.ajax({
				url: masteraddons.ajaxurl,
				method: 'POST',
				data: { 
					form_fields: form_data,
					'security': breakpoints_form,
					action: 'jltma_mcb_save_settings'
				},
				// dataType: 'json',
			    success : function( data ){ 
					form.prepend( '<div class="updated"><p>Saved Breakpoints</p></div>' );

                    setTimeout(function() {
                        form.removeClass('loading');
                        form.find('.updated').remove();
                    }, 700 );
			    },
			    error : function(error){ 
			    	console.log('failed', error); 
			    }
			});

		});	


	  });

})(jQuery);
