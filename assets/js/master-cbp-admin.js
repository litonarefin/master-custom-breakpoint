(function ($) {
  "use strict";

	  $(function () {
	    

		// jQuery(document).on('click', '.jltma-cbp-save', function(e){
		$('#jlmta-cbp-form').on('submit', function(e){
			e.preventDefault();

			var form = $( this ),
				form_data = form.serialize(),
				breakpoints_form = $('#breakpoints_form').val();

			console.log('Nonce', breakpoints_form);

			$.ajax({
				url: masteraddons.ajaxurl,
				method: 'POST',
				action: 'jltma_mcb_save_settings',
				data: { 
					'form_fields': form_data,
					'security': breakpoints_form,
					action: 'jltma_mcb_save_settings'
				},				
                // headers: {
                //     'X-WP-Nonce': nonce
                // },
				dataType: 'json',
			    success : function( result ){ 

			    	// var data = jQuery.parseJSON( result );
			    	console.log(result);


                    // setTimeout(function() {
                    //     modal.removeClass('loading');
                    // }, 1500 );


			    	// $('#update-company-name').modal('hide');

			    	// setTimeout(function(){// wait for 5 secs(2)
			     //       location.reload(); // then reload the page.(3)
			     //  	}, 2000);	    	
			    },
			    error : function(error){ 
			    	console.log('failed', error); 
			    }
			});

		});	


	  });

})(jQuery);
