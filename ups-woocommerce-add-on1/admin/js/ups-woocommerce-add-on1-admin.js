(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready( function() {

		$("#connect_account_now").click(function () {
			var valid = true,
			  errorMessage = "";
	  
			if (
				$("#gls_username").val() == "" || 
				$("#gls_username").val() == "undefined"
			) {
			  errorMessage = "please enter GLS username \n";
			  valid = false;
			  alert(errorMessage);
			  if (!valid && errorMessage.length > 0) {
				return false;
			  }
			}
	  
			if (
			  $("#gls_password").val() == "" ||
			  $("#gls_password").val() == "undefined"
			) {
			  errorMessage = "please enter your GLS Password \n";
			  valid = false;
			  alert(errorMessage);
			  if (!valid && errorMessage.length > 0) {
				return false;
			  }
			}
	  
			if (
			  $("#account_number").val() == "" ||
			  $("#account_number").val() == "undefined"
			) {
			  errorMessage = "please enter your Account number \n";
			  valid = false;
			  alert(errorMessage);
			  if (!valid && errorMessage.length > 0) {
				return false;
			  }
			}
	  
			if ($('input[name="terms_condition"]').is(":not(:checked)")) {
			  errorMessage = "please accept terms and conditions \n";
			  valid = false;
			  alert(errorMessage);
			  if (!valid && errorMessage.length > 0) {
				return false;
			  }
			}

			var connect_account_form_nonce = $('#connect_account_form_nonce').val();
			var gls_username = $('#gls_username').val();
			var gls_password = $('#gls_password').val();
			var account_number = $('#account_number').val();
			var terms_check = $('input[name="terms_condition"]:checked').val();
			$.ajax({
				type : "POST",
				dataType : "json",
				url : upsAjaxaddon1.ajaxurl,
				data : {
					action: "create_connection", 
					connect_account_form_nonce : connect_account_form_nonce, 
					gls_username : gls_username, 
					gls_password : gls_password, 
					account_number : account_number, 
					terms_check : terms_check,
				},
				success: function(response) {
					if (response.success == true){
						location.reload();
					}else{
						jQuery(".error-tag").show();
					}
				}
			});
		});

		$(".delete-connection-action").click(function () {
			var account_form_nonce = $('#account_form_nonce').val();
			var delete_id = $(this).data("id");
			$.ajax({
				type : "POST",
				dataType : "json",
				url : upsAjaxaddon1.ajaxurl,
				data : {
					action: "delete_connection",
					account_form_nonce : account_form_nonce, 
					delete_id : delete_id,
				},
				success: function(response) {
					if (response.success == true){
						location.reload();
					}else{
						jQuery(".error-tag").show();
					}
				}
			});
		});

		$('.ups-global-checkout-add-method').change(function(){
			var ups_checkout_data_form_nonce = $('#ups_checkout_data_form_nonce').val();
			var method_id = $(this).find(':selected').attr('data-id');
			var zone_id = $(this).find(':selected').attr('data-zone');
			var method_action = $(this).find(':selected').attr('data-action');
			$.ajax({
				type : "POST",
				dataType : "json",
				url : upsAjaxaddon1.ajaxurl,
				data : {
					action: "ups_add_shipping_method_to_zone",
					ups_checkout_data_form_nonce : ups_checkout_data_form_nonce, 
					method_id : method_id,
					zone_id : zone_id,
					method_action : method_action,
				},
				success: function(response) {
					console.log(response.result.instance_id);
					if (response.success == true){
						location.reload();
					}else{
						if(response.result){
							jQuery("#error_zone_"+response.result.zone_id).show();
						}
					}
				}
			});
		});
	});

})( jQuery );
