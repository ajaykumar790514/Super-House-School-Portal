<script type="text/javascript">



	var spinner = `<div class="text-left"><div class="spinner-border spinner-border-sm" role="status">

			  <span class="sr-only"></span>

			</div> </div>`;



	toastr.options = {

	  "positionClass": "toast-bottom-right"

	}



	$(document).ready(function(){

		$("body").on('click', '#search_btn', function(e){

			// e.preventDefault();

			if($( "#search-box" ).val() !='')

	        {

	            $("#search-form").submit();

	        }else{

	        	alert("Please enter value");

	        }

		});



		$("#search-form").submit(function(){

			if($( "#search-box" ).val() == '')

	        {

	            alert("Please enter value");

	      		return false

	        }		  

		});



       // console.log('<?=base_url()?>home/autocompleteData');

		// sercher script

		$("#search-box").keyup(function(e){

           

            

	        if($( "#search-box" ).val() == '')

	        {

	            $("#result").fadeOut();

	            return

	        }

            

         

			$.ajax({

				url: '<?=base_url()?>home/autocompleteData',

				method: 'POST',

				datatype: 'json',

				data: {search:$( "#search-box" ).val()},

				success: function (data) {

				var ele = '';

				$.each(JSON.parse(data), function(index,value){

				    ele = ele + `<a class="dropdown-item" href="${value.page}"><img src="<?= IMGS_URL ?>${value.photo}" height="40px">${value.name}</a>`;

				});

				$("#result").fadeIn();

				$('#result').html(ele);

				$("#main-body").click(function(){

				    $("#result").fadeOut();

				    return

				 });

				}

			});

    

		});	

     

     

     

       $("body").on('click', '#search_btnmobile', function(e){

			// e.preventDefault();

			if($( "#search-boxmobile" ).val() !='')

	        {

	            $("#search-formmobile").submit();

	        }else{

	        	alert("Please enter value");

	        }

		});

     

        $("#search-formmobile").submit(function(){

			if($( "#search-boxmobile" ).val() == '')

	        {

	            alert("Please enter value");

	      		return false

	        }		  

		});

        //for mobile view search

		$("#search-boxmobile").keyup(function(e){

	        if($( "#search-boxmobile" ).val() == '')

	        {

	            $("#result-mobile").fadeOut();

	            return

	        }

			$.ajax({

				url: '<?=base_url()?>home/autocompleteData',

				method: 'POST',

				datatype: 'json',

				data: {search:$( "#search-boxmobile" ).val()},

				success: function (data) {

				var ele = '';

				$.each(JSON.parse(data), function(index,value){

				    ele = ele + `<a class="dropdown-item" href="${value.page}"><img src="<?= IMGS_URL ?>${value.photo}">${value.name}</a>`;

				});

				$("#result-mobile").fadeIn();

				$('#result-mobile').html(ele);

				$("#main-body").click(function(){

				    $("#result-mobile").fadeOut();

				    return

				 });

				}

			});

		});	



		$("body").mouseup(function(){ 

	        $("#result").fadeOut();

	    });



		// get otp for login

		$('body').on('click', '.login-btn', function(e){

			let mobile = $('input[name=email]').val();

			let btn = $(this);

			if( mobile.length != 10 )

            {

                $('.error.mobile').html('<i class="fas fa-times text-danger"></i>&nbsp;Mobile Number should be of 10 digit');

                $('input[name=email]').focus();

            	return false;

            }

            $.ajax({

                url: '<?=base_url()?>login/generate_otp',

                type: 'POST',

                data: {mobile:mobile},

                dataType: 'json',

                beforeSend: function() {

                    btn.attr("disabled", true);

                    btn.text("Generating...");

                }, 

                success: function(response) {

                    if(response.status == true){

                    	btn.text("Submit OTP").removeAttr("disabled").removeClass('login-btn').addClass('submit-otp');

                    	$('.number-field').slideUp();

                    	$('.otp-field').fadeIn();

                    	$('.otp-success').text(response.message)

                    }else{

                        btn.removeAttr("disabled");

                        btn.text("Get OTP");

                        $('.error.mobile').html('<i class="fas fa-times text-danger"></i>&nbsp;'+response.message);

                    }

                },

                error: function (response) {

                    $('.error.mobile').html('<i class="fas fa-times text-danger"></i>&nbsp;'+response.message);

                    btn.removeAttr("disabled");

                    btn.text("Get OTP");

                }

            });

		});

		// end generate otp for login



		// Check OTP

		$("body").on('click', '.submit-otp', function(e){

	        let chid = $("#checkout_id").val();

	        let mobile = $('input[name=mobile]').val();

	        let otp = $('input[name=otp]').val();

	        let btn = $(this);

	        let signed = 0;

		    if($("#signed_in").prop("checked") == true)

            {

                signed = '1';

            }



		    $.ajax({

		        url: '<?=base_url()?>login/verify_otp',

		        type: 'POST',

		        data: {mobile:mobile,otp:otp,signed:signed},

		        dataType: 'json',

		        beforeSend: function() {

                    btn.attr("disabled", true);

                    btn.text("Please wait...");

                },

		        success: function(response) {

		            if(response.status == 'profile_not_exists'){

                        $('input[name=mobile_number]').val(mobile);

                        $(".login-input").slideUp();

                        $(".profile-input").fadeIn();

                    }else if(response.status == 'profile_exists'){

		                if(chid == '1')

		                {

		                    window.location = "checkout";

		                }else{

		                    location.reload();

		                }

		            }else{

		                btn.removeAttr("disabled");

		                btn.text("Submit OTP");

		                $(".otp-error-message").html('<i class="fas fa-times text-danger"></i>&nbsp;'+response.message);

		            }          

		        },

		        error: function (response) {

	                $(".otp-error-message").html('<i class="fas fa-times text-danger"></i>&nbsp;'+response.message);

	                btn.removeAttr("disabled");

	                btn.text("Submit OTP");

	            }

		    });

		});

		// End Check OTP



		// Profile Submit ajax

		$("body").on('click', '.profile-btn', function(e){

			e.preventDefault();

			let btn = $(this);

			let signed = 0;

		    if($("#signed_in").prop("checked") == true)

		    {

		        signed = '1';

		    }

		    let gender = $('input[name=gender]:checked').val();

		    let fname = $('input[name=fname]').val();

		    let lname = $('input[name=lname]').val();

		    let email = $('input[name=email]').val();

		    let mobile = $('input[name=mobile_number]').val();

		    if( !fname )

		    {

		    	$('span.fname').html('<i class="fas fa-times text-danger"></i>&nbsp; Please Enter First Name');

		    	return false;

		    }else{

		    	$('span.fname').html('');

		    }

		    if( !lname )

		    {

		    	$('span.lname').html('<i class="fas fa-times text-danger"></i>&nbsp; Please Enter Last Name');

		    	return false;

		    }else{

		    	$('span.lname').html('');

		    }

		    // if( !email )

		    // {

		    // 	$('span.email').html('<i class="fas fa-times text-danger"></i>&nbsp; Please Enter Email');

		    // 	return false;

		    // }else{

		    // 	$('span.email').html('');

		    // }

		    if( !gender )

		    {

		    	$('span.gender').html('<i class="fas fa-times text-danger"></i>&nbsp; Please Select Gender');

		    	return false;

		    }else{

		    	$('span.gender').html('');

		    }

    		let files = $('input[name=photo]')[0].files[0];

		    let formdata=new FormData();

		    formdata.append("photo",files);

		    formdata.append("fname",fname);

		    formdata.append("lname",lname);

		    formdata.append("email",email);

		    formdata.append("mobile",mobile);

		    formdata.append("gender",gender);

		    formdata.append("signed",signed);

		    $.ajax({

		        url: '<?=base_url()?>login/submit_profile',

		        type: 'POST',

		        data: formdata,

		        contentType: false,

		        processData: false,

		        dataType: 'json',

		        beforeSend: function() {

                    btn.attr("disabled", true);

                    btn.text("Please wait...");

                }, 

		        success: function(response) {

		            if(response.status == true)

		            {

		                location.reload();

		            }else{

		                btn.removeAttr("disabled");

		                btn.html("Submit");

		                $("#profile-error-msg").html('<i class="fas fa-times text-danger"></i>&nbsp;'+response.message);

		            }          

		                },

		        error: function (response) {

                    $("#profile-error-msg").html('<i class="fas fa-times text-danger"></i>&nbsp;'+response.message);

                    btn.removeAttr("disabled");

                    btn.html("Submit");

                }

		    });

		});

		// End Profile Submit





		$('body').on('submit', '#check-pincode-new', function (e) {

        e.preventDefault();

        let dataString = $("#check-pincode-new").serialize();

        $.ajax({

            url: "<?= base_url('home/check_delivery_area'); ?>",

            method: "POST",

            data: dataString,

            success: function (data) {

                if (data.trim() == 'SUCCESS') {

                    $("#available-msg").html("<h5 class='text-success mt-1'>Delivery available here in this pincode.</h5>");

                } else {

                    $("#available-msg").html("<h5 class='text-danger mt-1'>Delivery not available in this pincode. Kindly check your pincode.</h5>");

                }

            }

        });

    });



	    $('.custom-menu').on('mouseenter', function() { $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(500); });

		$('.custom-menu').on('mouseleave', function() { $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(500); });

	});



		// Add to Cart



		const cart_count_increment = (item_qty) => {

			let total_cart = parseInt( $('#cart_countmobile').text() );

			$("#cart_count").html(parseInt(total_cart)+parseInt(item_qty)+' item');

            $("#cart_countmobile").html(parseInt(total_cart)+parseInt(item_qty));

		}



		const cart_count_decrement = (item_qty) => {

			let total_cart = parseInt($('#cart_countmobile').text());

			$("#cart_count").html(parseInt(total_cart)-parseInt(item_qty)+' item');

            $("#cart_countmobile").html(parseInt(total_cart)-parseInt(item_qty));

			// setTimeout( () => {

			// 	// let total_cart = $('.cart-div ul.cart_product li').length;

			// 	let total_cart = parseInt($('#cart_count').text());

			// 	$("#cart_count").html(parseInt(total_cart)-parseInt(item_qty)+' item');	

			// }, 500);

			

		}



		const empty_cart = () => {

			setTimeout( () => {

			let total_cart = $('.cart-sidebar .cart-list-product.count-cart-item').length;

				if( parseInt(total_cart) <= 0 ){

					$('.cart-empty').html(`<h6 class="mb-3 mt-0 mb-3">Your cart is empty. There are no items left in cart.</h6>`);

				}

			}, 500);

		}



        

		const add_to_cart = (pid,btn,type=1) => {

   

			$(btn).attr('disabled', true);

			let qty = $(`.qty-val${pid}`).val();

			let unit = $(btn).parents('.product').find('.pro_unit').text();

			let item_qty = qty;

		    $.ajax({

			    url: '<?=base_url()?>home/add_to_cart',

			    method: "POST",

			    data: {

			        product_id:pid,

			        qty : qty,

			        unit: unit,

                    type:type

			    },

			    success: function(response){

			    	cart_count_increment(item_qty);

			    	$(`.add-to-cart-div-${pid}`).html(response);

			        $(".cart-div").load('<?=base_url()?>home/cart_view/');

                    if(type==2)

                        {

                        $(`.add-to-cart-div-${pid} a`).addClass('plusminus');

                        }

                       

			        $(btn).attr('disabled', false);

			        toastr.success('Item added to cart');			        

			    },

			});

		}



		const add_to_cart_by_btn = (pid,btn,type=1) => {

			//$(btn).attr('disabled', true);

			let qty = $('.newcart_btn').find('.count-number-input').val();

			if(qty=='' || qty==undefined)

			{

				final_qty = '1';

			}else

			{

				final_qty = qty;

			}

			//let unit = $(btn).parents('.product').find('.pro_unit').text();

			let item_qty = final_qty;

		    $.ajax({

			    url: '<?=base_url()?>home/add_to_cart_by_btn',

			    method: "POST",

			    data: {

			        product_id:pid,

			        qty : final_qty,

			        //unit: unit,

                    //type:type

			    },

			    success: function(response){

			    	cart_count_increment(item_qty);

			    	//$(`.add-to-cart-div-${pid}`).html(response);

			        $(".cart-div").load('<?=base_url()?>home/cart_view/');

                    if(type==2)

                        {

                        $(`.add-to-cart-div-${pid} a`).addClass('plusminus');

                        }

                       

			        //$(btn).attr('disabled', false);

			        toastr.success('Item added to cart');			        

			    },

			});

		}



		function increase_quantity_by_btn(btn){

	        let value = $(btn).parents('.newcart_btn').find('.count-number-input').val();

	        value++;

	        $(btn).parents('.newcart_btn').find('.count-number-input').val(value);

	    }



	    function decrease_quantity_by_btn(btn){

	        let value = $(btn).parents('.newcart_btn').find('.count-number-input').val();

	        if (value > 1) {

	            value--;

	            $(btn).parents('.newcart_btn').find('.count-number-input').val(value);

	        }

	    }



		var timer1;

        var timeout = 500;

		const cookie_increase_quantity = (pid, btn) => {

			$('.loader-button').show();

		    let input = $(btn).data('target');

		    let total = parseInt( $(input).val() );

		    total++;

		    $(input).val(total);

		    clearTimeout(timer1);

            timer1 = setTimeout(function(){

			    $.ajax({

				    url: '<?=base_url()?>home/update_cookie_cart',

				    method: "POST",

				    data: {

				        qty:total,

				        pid:pid,

				    },

				    success: function(data){

				    	let item_qty = 1;

				    	cart_count_increment(item_qty);

				        $(".cart-div").load('<?=base_url()?>home/cart_view/');

                        $(".cart-div-main").load('<?=base_url()?>home/cart_main_view/');

				    },

				});

				$('.loader-button').hide();

			}, timeout);

		}



		const cookie_decrease_quantity = (pid,btn,type=1) => {

          	$('.loader-button').show();

		    let input = $(btn).data('target');

		    let total = parseInt( $(input).val() );

		    total--;

		    if( total == 0 ){

		    	$(`.add-to-cart-div-${pid}`).html(spinner);

		    	$(input).val(1);

		    }else{

		    	$(input).val( total );

		    }

		    clearTimeout(timer1);

            timer1 = setTimeout(function(){

			    $.ajax({

				    url: '<?=base_url()?>home/update_cookie_cart',

				    method: "POST",

				    data: {

				        qty:total,

				        pid:pid,

                        type:type

				    },

				    success: function(data){

				    	let item_qty = 1;

				    	cart_count_decrement(item_qty);

				    	if( total <=0 ){

				    		$(`.add-to-cart-div-${pid}`).html(data);

                            

				    		//$(`#cart_btn${pid}`).attr('onclick', `add_to_cart(${pid},this)`).fadeIn('slow');				    		



				    	}

				        $(".cart-div").load('<?=base_url()?>home/cart_view/');

                        $(".cart-div-main").load('<?=base_url()?>home/cart_main_view/');

				    },

				});

				$('.loader-button').hide();

			}, timeout);

		}



		const cookie_quantity_by_input = (pid, btn) => {

			$('.loader-button').show();

		    let input = $('.qty-val'+pid);

		    let total = parseInt( $(btn).val() );

		    if( total == 0 ){

		    	$(`.add-to-cart-div-${pid}`).html(spinner);

		    	$(input).val(1);

		    }else{

		    	$(input).val( total );

		    }

		    clearTimeout(timer1);

            timer1 = setTimeout(function(){

			    $.ajax({

				    url: '<?=base_url()?>home/update_cookie_cart',

				    method: "POST",

				    data: {

				        qty:total,

				        pid:pid,

				    },

				    success: function(data){

				        $(".cart-div").load('<?=base_url()?>home/cart_view/');

                        $(".cart-div-main").load('<?=base_url()?>home/cart_main_view/');

                        $.ajax({

						    url: '<?=base_url()?>home/update_cookie_cart_count',

						    method: "POST",

						    data: {

						        qty:total,

						    },

						    success: function(data2){

						        //console.log(data2);		        

						        $("#cart_count").html(data2+' item');

                             $("#cart_countmobile").html(data2);

						    },

						});

				    },

				});

				$('.loader-button').hide();

			}, timeout);

		}



        const delete_cookie_cart_all=()=>{

         $.ajax({

			    url: '<?=base_url()?>home/delete_cookie_cart_all',

			    method: "POST",

			    data: {

			       

			    },

			    success: function(data){

			        $(".cart-div").load('<?=base_url()?>home/cart_view/');

                    $(".cart-div-main").load('<?=base_url()?>home/cart_main_view/');

                    $("#cart_count").html('0 item');

                    $("#cart_countmobile").html('0');

                   toastr.success('Cart Cleared Successfully');

			    },

			});

        }

        

		const delete_cart_all=(btn)=> {

		    $.ajax({

			    url: '<?=base_url()?>home/delete_cart_all/',

			    method: "POST",

			    data: {

			    },

			    beforeSend: function() {

                    $(btn).attr("disabled", true);

                },

			    success: function(data){

			    	$(btn).attr("disabled", false);

			    	$(".cart-div").load('<?=base_url()?>home/cart_view/');

                    $(".cart-div-main").load('<?=base_url()?>home/cart_main_view/');

                    $("#cart_count").html('0 item');

                    $("#cart_countmobile").html('0');

                    toastr.success('Cart Cleared Successfully');

			    },

			});

		}

        

		const delete_cookie_cart = (pid) => {

			let item_qty = $('.qty-val'+pid).val();

		    $.ajax({

			    url: '<?=base_url()?>home/delete_cookie_cart',

			    method: "POST",

			    data: {

			        pid:pid,

			    },

			    success: function(data){

			    	cart_count_decrement(item_qty);

//                    $(`#cart_btn${pid}`).attr('onclick', `add_to_cart(${pid},this)`).html(`<i class="fi-rs-shopping-bag-add"></i>`).fadeIn('slow');

			        $(".cart-div").load('<?=base_url()?>home/cart_view/');

                    $(".cart-div-main").load('<?=base_url()?>home/cart_main_view/');

                    //$(`.add-to-cart-div-${pid}`).html("<a aria-label='Add To Cart' class='action-btn hover-up' id='cart_btn"+pid+"' onclick='add_to_cart("+pid+",this)' href='javascript:void(0)'><i class='fi-rs-shopping-bag-add'></i> add to cart</a>");

			    },

			});

		}





		// const increase_quantity



		function increase_quantity(cart_id,pid,btn) {

			$('.loader-button').show();

		    let input = $(btn).data('target');

		    let total = parseInt( $(input).val() );

		    total++;

		    $(input).val(total);

		    clearTimeout(timer1);

            timer1 = setTimeout(function(){

			    if( cart_id ){

				    $.ajax({

					    url: '<?=base_url()?>home/update_cart/',

					    method: "POST",

					    data: {

					        qty:total,

					        pid:pid,

					        cart_id:cart_id,

					    },

					    success: function(data){

					        $(".cart-div").load('<?=base_url()?>home/cart_view/');

                            $(".cart-div-main").load('<?=base_url()?>home/cart_main_view/');

					        // for checkout page

					        if( $('.checkout_cart').length ){

					        	$(".checkout_cart").load('<?=base_url()?>checkout/checkout_cart', function(){

					        		let total_payable = $('.sub-total').text();

					       // 		let cod_limit = $('input[name=cod_limit]').val();

					       // 		let coin = $('input[name=online_coin]').is(':checked') ? parseFloat($('input[name=online_coin]').val()) : 0;

					       // 		$('button.pay-btn-cod').text(`Continue <?= $shop_detail->currency; ?>${total_payable-coin}`).attr('onclick', `make_cod_payment(${cod_limit},${total_payable-coin})`);

					        		$('button.make-online-payment').text(`Continue <?= $shop_detail->currency; ?>${total_payable}`);

									$("#subamount").val(total_payable);

					        	});

					        }



					        let item_qty = 1;

				    		cart_count_increment(item_qty);

					    },

					});

				}

				$('.loader-button').hide();

			}, timeout);

		}



		function quantity_by_input(cart_id, pid, btn) {

			$('.loader-button').show();

		    let input = $('.qty-val'+pid);

		    let total = parseInt( $(btn).val() );

		    if( total == 0 ){

		    	$(`.add-to-cart-div-${pid}`).html(spinner);

		    	$(input).val(1);

		    }else{

		    	$(input).val( total );

		    }

		    clearTimeout(timer1);

            timer1 = setTimeout(function(){

			    $.ajax({

				    url: '<?=base_url()?>home/update_cart',

				    method: "POST",

				    data: {

				        qty:total,

				        pid:pid,

				        cart_id:cart_id,

				    },

				    success: function(data){

				        $(".cart-div").load('<?=base_url()?>home/cart_view/');

                        $(".cart-div-main").load('<?=base_url()?>home/cart_main_view/');

                        // for checkout page

                        if( $('.checkout_cart').length ){

				        	$(".checkout_cart").load('<?=base_url()?>checkout/checkout_cart', function(){

				        		let total_payable = $('.total-payable').text();

				        		let cod_limit = $('input[name=cod_limit]').val();

				        		let coin = $('input[name=online_coin]').is(':checked') ? parseFloat($('input[name=online_coin]').val()) : 0;

				        		$('button.pay-btn-cod').text(`Continue <?= $shop_detail->currency; ?>${total_payable-coin}`).attr('onclick', `make_cod_payment(${cod_limit},${total_payable-coin})`);

				        		$('button.make-online-payment').text(`Continue <?= $shop_detail->currency; ?>${total_payable-coin}`);

								$("#subamount").val(total_payable-coin);

				        	});

				        }



				        $.ajax({

						    url: '<?=base_url()?>home/update_cookie_cart_count',

						    method: "POST",

						    data: {

						        qty:total,

						    },

						    success: function(data2){

						        //console.log(data2);		        

						        $("#cart_count").html(data2+' item');  

                             $("#cart_countmobile").html(data2);

						    },

						});

				    },

				});

				$('.loader-button').hide();

			}, timeout);

		}



		function decrease_quantity(cart_id,pid,btn,type=1) {

           

           	$('.loader-button').show();

		    let input = $(btn).data('target');

		    let total = parseInt( $(input).val() );

		    total--;

		    if( total == 0 ){

		    	$(input).val(1);

		    	$(`.add-to-cart-div-${pid}`).html(spinner);

		    }else{

		    	$(input).val( total );

		    }

		    clearTimeout(timer1);

            timer1 = setTimeout(function(){

			    if( cart_id ) {

				    $.ajax({

					    url: '<?=base_url()?>home/update_cart/',

					    method: "POST",

					    data: {

					        qty:total,

					        pid:pid,

					        cart_id:cart_id,

                            type:type

					    },

					    beforeSend: function() {

	                        $(btn).attr("disabled", true);

	                    },

					    success: function(data){

					    	$(btn).attr("disabled", false);

					    	$(".cart-div").load('<?=base_url()?>home/cart_view/');

                            $(".cart-div-main").load('<?=base_url()?>home/cart_main_view/');

					        if( total <=0 ){

					        	$(`.add-to-cart-div-${pid}`).html(data);

					        	//$(`#cart_btn${pid}`).attr('onclick', `add_to_cart(${pid},this)`).html(`<i class="fi-rs-shopping-bag-add"></i>`).fadeIn('slow');

					    		//cart_count_decrement();

					    	}

					        // for checkout page

					        if( $('.checkout_cart').length ){

					        	// empty_cart();

					        	$(".checkout_cart").load('<?=base_url()?>checkout/checkout_cart', function(){

					        		let total_payable = $('.sub-total').text();

					       // 		let cod_limit = $('input[name=cod_limit]').val();

					       // 		let coin = $('input[name=online_coin]').is(':checked') ? parseFloat($('input[name=online_coin]').val()) : 0;

					       // 		$('button.pay-btn-cod').text(`Continue <?= $shop_detail->currency; ?>${total_payable-coin}`).attr('onclick', `make_cod_payment(${cod_limit},${total_payable-coin})`);

					        		$('button.make-online-payment').text(`Continue <?= $shop_detail->currency; ?>${total_payable}`);

									$("#subamount").val(total_payable);

					        	});

					        }



					        let item_qty = 1;

				    		cart_count_decrement(item_qty);

					    },

					});

				}

				$('.loader-button').hide();

			}, timeout);

		}

    

		function delete_cart(cart_id,pid,btn) {

           	let item_qty = $('.qty-val'+pid).val();

		    $.ajax({

			    url: '<?=base_url()?>home/delete_cart/',

			    method: "POST",

			    data: {

			        pid:pid,

			        cart_id:cart_id

			    },

			    beforeSend: function() {

                    $(btn).attr("disabled", true);

                },

			    success: function(data){

			    	$(btn).attr("disabled", false);

			    	$(".cart-div").load('<?=base_url()?>home/cart_view/');

                    $(".cart-div-main").load('<?=base_url()?>home/cart_main_view/');

			        cart_count_decrement(item_qty);

                    $(`.add-to-cart-div-${pid}`).html("<a aria-label='Add To Cart' class='action-btn hover-up' id='cart_btn"+pid+"' onclick='add_to_cart("+pid+",this)' href='javascript:void(0)'><i class='fi-rs-shopping-bag-add'></i></a>");

//			    	$(`#cart_btn${pid}`).attr('onclick', `add_to_cart(${pid},this)`).html(`<i class="fi-rs-shopping-bag-add"></i>`);

			        

			        // for checkout page

			        if( $('.checkout_cart').length ){

			        	empty_cart();

			        	$(".checkout_cart").load('<?=base_url()?>checkout/checkout_cart', function(){

			        		let total_payable = $('.total-payable').text();

			        		let cod_limit = $('input[name=cod_limit]').val();

			        		let coin = $('input[name=online_coin]').is(':checked') ? parseFloat($('input[name=online_coin]').val()) : 0;

			        		$('button.pay-btn-cod').text(`Continue ₹${total_payable-coin}`).attr('onclick', `make_cod_payment(${cod_limit},${total_payable-coin})`);

			        		$('button.make-online-payment').text(`Continue ₹${total_payable-coin}`);

							$("#subamount").val(total_payable-coin);

			        	});

			        }

			        toastr.success('Item Deleted');

			    },

			});

		}



	function add_to_wishlist(pid){

		$.ajax({

            url: '<?=base_url()?>home/add_to_wishlist',

            method: "POST",

            data: {

                pid:pid,

            },

            success: function(data){

            	// console.log(data);
				setTimeout(function() {
                  location.reload();
                 }, 1000);

            	$('.wishlist').addClass('text-danger').attr('onclick', '').attr('title', 'Already added');

                toastr.success('Item added to wishlist');

            },

        });

	}



	function remove_to_wishlist(btn,pid){		

		$.ajax({

            url: '<?=base_url()?>home/remove_to_wishlist',

            method: "POST",

            data: {

                pid:pid,

            },

            success: function(data){
				setTimeout(function() {
                  location.reload();
                 }, 1000);
            	let rowCount = $('#wishlist-table tr').length;

            	console.log(rowCount);

            	$(btn).parents('tbody').remove();

                toastr.success('Item Removed from wishlist');

                if (rowCount < 3) {

                	$('#wishlist-table tr').remove();

                	$('#wishlist-table').append('<h3 class="text-center">Not Found Any Products</h3>');

                }

            },

        });

	}



	const remove_wishlist = (id) => {

        toastr.warning("<br /><button type='button' value='yes'>Yes</button><button type='button' value='no' >No</button>",'Are you sure you want to remove this item?',

        {

            allowHtml: true,

            // closeButton : true,

            onclick: function (toast) {

                value = toast.target.value

                if (value == 'yes') {

                    $.ajax({

                        url: '<?=base_url()?>user/users/remove_wishlist',

                        method: "POST",

                        data: {

                            id:id,

                        },

                        success: function(data){

                        	toastr.remove();

                            toastr.success('Item Removed from wishlist');

                            $(`#wishlist_${id}`).remove();

                        },

                    });

                }else{

                    toastr.remove();

                }

            }



        });

    };



    const set_map_pro = (elem, inventory_id) => {

    	let parent = $(elem).parents(`.product_${inventory_id}`);

    	let inv = $(elem).val();

    	let unit = $('option:selected', elem).attr('data-unit');

    	let rate = $('option:selected', elem).attr('data-rate');

    	let mrp = $('option:selected', elem).attr('data-mrp');

    	let is_parent = $('option:selected', elem).attr('data-is_parent');

    	let parent_cat_id = $('option:selected', elem).attr('data-parent_cat_id');

    	let photo = $('option:selected', elem).attr('data-photo');

    	let name = $('option:selected', elem).attr('data-name');

    	let qty = parseInt($('option:selected', elem).attr('data-qty'));

    	let product_id = $('option:selected', elem).attr('data-product_id');

        let product_code = $('option:selected', elem).attr('data-code');

         

    	let check_cart = $(`.cart-div input.qty-val${inv}`).length;

        



    	let cart_style = 'btn-secondary';

    	let cart_onclick = `add_to_cart(${inv},this)`;

    	let cart_title = 'Add to cart';

    	let html = '';

        

    	let footer = `<div class="product-action-1 show add-to-cart-div-${inv}" style="position:static">`;

    	if( check_cart > 0 ){

    		footer += $(`.cart-div span.count-number${inv}`).html();

    	}else{

    		if( qty <= 0 ){

	           footer +=`<a aria-label="Add To Cart" class="action-btn hover-up" href="#">N/A</a>`; 		

	    	}

            else{

            footer +=`<a aria-label="Add To Cart" class="action-btn hover-up" id="cart_btn${inv}" onclick="${cart_onclick}" href="javascript:void(0)"><i class="fi-rs-shopping-bag-add"></i></a>`;

	    	

            }

    	}



    	footer += `</div>`;

    

		if( $(elem).parent('.p-detail').length <= 0 ){

            

			parent.find('img').attr('src', `${img_url+photo}`);

			parent.find('a').attr('href', '<?=base_url()?>product-detail/${inv}/${is_parent}/${parent_cat_id}')

			parent.find('.pro-title').text(name);

			parent.find('.pro_unit').text(unit);

            parent.find('.rate').text(rate);

            parent.find('.old-price').text(mrp);

			parent.find('.product-action-1').html(footer);

		}else{

			$('.d-unit').text(unit);

			$('.d-mrp').text(mrp);

			$('.d-rate').text(`₹ ${rate}`);

			$('.d-save').text('You Save ₹'+(parseFloat(mrp)-parseFloat(rate)) );

			$('.d-code').text('Product Code: '+product_code);

            $('.product-action-1').html(footer);

		

			$.get(`<?=base_url()?>home/get_detail_mapped_image?pro_id=${product_id}`, function(data){

				data = JSON.parse(data);

                

				$('#sync1').replaceWith(data.sync1);

				$('#sync2').replaceWith(data.sync2);

				//sync_initt();

                 $(".product-image-slider").slick("slickRemove");

                $(".slider-nav-thumbnails").slick("slickRemove");

               productDetailsSlider();               

			});

    	}

    }



     function productDetailsSlider() {

 

        $('.product-image-slider').not('.slick-initialized').slick({

            slidesToShow: 1,

            slidesToScroll: 1,

            arrows: false,

            fade: false,

            asNavFor: '.slider-nav-thumbnails',

        });



        $('.slider-nav-thumbnails').not('.slick-initialized').slick({

            slidesToShow: 5,

            slidesToScroll: 1,

            asNavFor: '.product-image-slider',

            dots: false,

            focusOnSelect: true,

            prevArrow: '<button type="button" class="slick-prev"><i class="fi-rs-angle-left"></i></button>',

            nextArrow: '<button type="button" class="slick-next"><i class="fi-rs-angle-right"></i></button>'

        });



        // Remove active class from all thumbnail slides

        $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');



        // Set active class to first thumbnail slides

        $('.slider-nav-thumbnails .slick-slide').eq(0).addClass('slick-active');



        // On before slide change match active thumbnail to current slide

        $('.product-image-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {

            var mySlideNumber = nextSlide;

            $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');

            $('.slider-nav-thumbnails .slick-slide').eq(mySlideNumber).addClass('slick-active');

        });



        $('.product-image-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {

            var img = $(slick.$slides[nextSlide]).find("img");

            $('.zoomWindowContainer,.zoomContainer').remove();

            $(img).elevateZoom({

                zoomType: "inner",

                cursor: "crosshair",

                zoomWindowFadeIn: 500,

                zoomWindowFadeOut: 750

            });

        });

        //Elevate Zoom

        if ( $(".product-image-slider").length ) {

            $('.product-image-slider .slick-active img').elevateZoom({

                zoomType: "inner",

                cursor: "crosshair",

                zoomWindowFadeIn: 500,

                zoomWindowFadeOut: 750

            });

        }

        //Filter color/Size

        $('.list-filter').each(function () {

            $(this).find('a').on('click', function (event) {

                event.preventDefault();

                $(this).parent().siblings().removeClass('active');

                $(this).parent().toggleClass('active');

                $(this).parents('.attr-detail').find('.current-size').text($(this).text());

                $(this).parents('.attr-detail').find('.current-color').text($(this).attr('data-color'));

            });

        });

        //Qty Up-Down

        $('.detail-qty').each(function () {

            var qtyval = parseInt($(this).find('.qty-val').text(), 10);

            $('.qty-up').on('click', function (event) {

                event.preventDefault();

                qtyval = qtyval + 1;

                $(this).prev().text(qtyval);

            });

            $('.qty-down').on('click', function (event) {

                event.preventDefault();

                qtyval = qtyval - 1;

                if (qtyval > 1) {

                    $(this).next().text(qtyval);

                } else {

                    qtyval = 1;

                    $(this).next().text(qtyval);

                }

            });

        });



        $('.dropdown-menu .cart_list').on('click', function (event) {

            event.stopPropagation();

  

        });

    }

    function sync_initt(){

$('#sync1').owlCarousel({singleItem:true,items:1,slideSpeed:1000,pagination:false,navigation:true,autoPlay:2500,dots:false,nav:true,navigationText:["<i class='mdi mdi-chevron-left'></i>","<i class='mdi mdi-chevron-right'></i>"],afterAction:syncPositionn,responsiveRefreshRate:200,});

$('#sync2').owlCarousel({items:5,navigation:true,dots:false,pagination:false,nav:true,navigationText:["<i class='mdi mdi-chevron-left'></i>","<i class='mdi mdi-chevron-right'></i>"],responsiveRefreshRate:100,afterInit:function(el){el.find(".owl-item").eq(0).addClass("synced");}});

}



function syncPositionn(el){var current=this.currentItem;$("#sync2").find(".owl-item").removeClass("synced").eq(current).addClass("synced")

if($("#sync2").data("owlCarousel")!==undefined){center(current)}}



	function user_login(btn) {

		dataString = $("#login-form").serialize();

        $.ajax({

            type: "POST",

            url: base_url+"login/user_login",

            data: dataString,

            dataType: 'json',

            beforeSend: function() {

                $(btn).attr("disabled", true);

                $(btn).text("Process...");

            },

            success: function(data){ 

            // console.log(data);             

              if (data.status == false) {

              	$(btn).text("Login").removeAttr("disabled");

                $("#error-login-form").html('');

                $("#error-login-form").html(data.error);

              }



              if (data.status == true) {

                $("#error-login-form").html('');

               // window.location.href = base_url+'profile';   

                window.location.href = base_url;               

              }

            }

        });

        return false;  //stop the actual form post !important!

	}

</script>