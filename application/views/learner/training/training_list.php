<style type="text/css">
	.navbar-inverse .navbar-nav>li>a:focus, .navbar-inverse .navbar-nav>li>a:hover{
		color:#000!important;
	}
	.logo img{
		height: 40px;
	}
</style>
<!-- Bootstrap -->
<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png" />
<link href="<?php echo base_url(); ?>assets/css_company/main-style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css_company/responsive.css" rel="stylesheet">
<script src="https://www.paypal.com/sdk/js?client-id=AfvvmSMlwXTgLnGoXB9ygA7DXst7RDSb0dvScr8NvByZoUUUbrk3X9gGs-R8pXkeZnM8q9XRehZelBfD"> </script>
<script type="text/javascript" src="https://sandbox-assets.secure.checkout.visa.com/checkout-widget/resources/js/integration/v1/sdk.js"></script>
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

<![endif]-->
<script src="<?php echo base_url(); ?>assets/js_company/sweetalert.js"></script>

<section role="main" class="content-body" style="width:initial;">
    <header class="page-header">
        <h2>Instructor Led Training List</h2>
        <div class="right-wrapper">
        </div>
    </header>
    
    <input type="hidden" id="base_url" value="<?= base_url()?>">

	<div class="row demand-page">
		<div class="col-lg-12">
			<section class="card" style="padding: 0px">
		<header class="card-header">
		<h2 class="card-title">Training List</h2>
	</header>
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="catalogBox">
					<div class="row">
						<div class="col-sm-12">
							<div class="sortPanel">
								<div class="sortSet"> 
                                    <select id="location" name="location" style="border: 1px solid #ccc !important;padding: 8px 10px !important;">
                                        <option value=""> Select Location </option>
                                        <?php foreach($location as $item){ ?>
                                            <option value="<?php echo $item['location']; ?>" <?php $location_name==$item['location']?print 'selected':print ''; ?>> <?php echo $item['location']; ?></option>
                                        <?php } ?>
                                    </select>
                                    
                                    <select id="course_id" name="course_id" style="border: 1px solid #ccc !important;padding: 8px 10px !important;">
                                        <option value=""> Select Course </option>
                                        <?php foreach($course_filter_list as $courseitem){
											
											if($courseitem['date_str'] != ''){
											$currentday = time();
											$startDate = $courseitem['date_str'];
											$duration = $courseitem['duration'] - 1;
											$enddate = strtotime('+'.$duration.' days', $courseitem['date_str']);
		
											if($currentday <= $enddate){
											
										?>
                                            <option value="<?php echo $courseitem['id']; ?>" <?php $course_name==$courseitem['id']?print 'selected':print ''; ?>> <?php echo ucfirst($courseitem['title']); ?></option>
                                        <?php } } } ?>
                                    </select>
								</div><!--sortSet-->
							</div><!--sortPanel-->
						</div><!--col-12-->
					</div><!--row-->
					
					<div class="row">
						<?php if($free_course_list || $paid_course_list){						
						?>
							<div class="col-sm-12">
								<?php foreach($free_course_list as $free_course):
									if($free_course['date_str'] != '' || $free_course['date_str'] != 0){
									$currentdays = time();
									$startDateI = $free_course['date_str'];

									$durationI = $free_course['duration'] - 1;
									$enddateI = strtotime('+'.$duration .' days', $startDateI);
									if($currentdays <= $enddateI){
								?> 
									<div class="whitePanel">
										<div class="row">
											<div class="col-lg-4 col-md-5 col-sm-6">
												<div class="leftImgBox">
                                                	<?php 
														$courseimgpath = getCourseImgById($free_course['course_id']);
                                                        $imgName = end(explode('/', $courseimgpath));
                                                        if($imgName != '' && file_exists(getcwd().'/assets/uploads/company/course/'.$imgName)){								
                                                    ?>
                                                        <img src="<?php echo base_url($courseimgpath); ?>" class="rounded img-fluid" alt="learnerlearner">
                                                   	<?php }else{ ?>
                                                        <img src="<?php echo base_url().'assets/uploads/ilt-default.png'; ?>" class="rounded img-fluid" alt="learnerlearner">
                                                   	<?php } ?>
												</div><!--leftImgBox-->
											</div><!--col-4-->
											<div class="col-lg-8 col-md-7 col-sm-6 courseInfo">
                                                <h5>
													<?php
                                                        $showDuration = $free_course['duration'] > 1 ? $free_course['duration']. " Days" : $free_course['duration']." Day";
                                                        $duration = $free_course['duration'] - 1;
                                                        //$enddate = strtotime(date('Y-m-d',$free_course['date_str']) .'+'.$duration .'days');
														$enddate = strtotime('+'.$duration .' days', $free_course['date_str']);
                                                    ?>
													
													<?php echo ucfirst($free_course['title']);?>, <?php echo $showDuration; ?> <br />
                                                    <p> Start Date: <?php echo date("M d, Y h:i:sa", $free_course['date_str']);?></p>
                                                    <?php if($duration > 0){ ?>
                                                        <p>End Date: <?php echo date("M d, Y h:i:sa", $enddate);?></p>
                                                    <?php }else{ ?>
                                                        <p>End Date: <?php echo date("M d, Y", $enddate).' 11:59:59pm';?></p>
                                                    <?php } ?>
                                                </h5>
                                                <ul class="courseUl">
													<li><?=nl2br(substr($free_course['description'],0,300)); ?>...</li>
												</ul>
		     	                               	<?php if($free_course['enroll_id'] == ''){ ?>
                                                <a class="btnBlue" href="javascript:booknow(<?=$free_course['course_id']?>,<?=$free_course['course_time_id']?>)" >
                                                    <?=$term[enrollnow]?>
                                                </a>
                                                <?php }else { ?>
													<a class="btnBlue" href="javascript:viewcourse(<?=$free_course['course_id']?>)" >
														<?=$term[viewcourse]?>
													</a>
												<?php } ?>
                                                <a class="btnBlue" href="<?=base_url()?>learner/training/viewDetail/<?=$free_course['id']?>" >
													<?=$term[viewdetails] ?>
                                                </a>
											</div><!--col-8-->
										</div><!--row-->
									</div><!--whitePanel-->
								<?php } } endforeach; ?>

								<?php foreach($paid_course_list as $paid_course):
									if($paid_course['date_str'] != '' || $paid_course['date_str'] != 0){
									$currentdays = time();
									$startDateI = $paid_course['date_str'];

									$durationI = $paid_course['duration'] - 1;
									$enddateI = strtotime('+'.$duration .' days', $startDateI);
									
									if($currentdays <= $enddateI){
								?> 
									<div class="whitePanel">
										<div class="row">
											<div class="col-lg-4 col-md-5 col-sm-6">
												<div class="leftImgBox">
                                                	<?php 
														$courseimgpath = getCourseImgById($paid_course['course_id']);
                                                        $imgName = end(explode('/', $courseimgpath));
                                                        if($imgName != '' && file_exists(getcwd().'/assets/uploads/company/course/'.$imgName)){								
                                                    ?>
                                                        <img src="<?php echo base_url($courseimgpath); ?>" class="rounded img-fluid" alt="learnerlearner">
                                                   	<?php }else{ ?>
                                                        <img src="<?php echo base_url().'assets/uploads/ilt-default.png'; ?>" class="rounded img-fluid" alt="learnerlearner">
                                                   	<?php } ?>
												</div><!--leftImgBox-->
											</div><!--col-4-->
											<div class="col-lg-8 col-md-7 col-sm-6 courseInfo">
                                                <h5>
													<?php
                                                        $showDuration = $paid_course['duration'] > 1 ? $paid_course['duration']. " Days" : $paid_course['duration']." Day";
                                                        $duration = $paid_course['duration'] - 1;
                                                        //$enddate = strtotime(date('Y-m-d',$paid_course['date_str']) .'+'.$duration .'days');
														$enddate = strtotime('+'.$duration .' days', $paid_course['date_str']);
                                                    ?>
													
													<?php echo ucfirst($paid_course['title']);?>, <?php echo $showDuration; ?> <br />
                                                    <p> Start Date: <?php echo date("M d, Y h:i:sa", $paid_course['date_str']);?></p>
                                                    <?php if($duration > 0){ ?>
                                                        <p>End Date: <?php echo date("M d, Y h:i:sa", $enddate);?></p>
                                                    <?php }else{ ?>
                                                        <p>End Date: <?php echo date("M d, Y", $enddate).' 11:59:59pm';?></p>
                                                    <?php } ?>
													<p>USD $: <?= $paid_course['pay_price']?></p>
                                                </h5>
                                                <ul class="courseUl">
													<li><?=nl2br(substr($paid_course['description'],0,300)); ?>...</li>
												</ul>
												<?php if(!$paid_course['pay_id']){ ?>
													<div style="width:150px;" id="paypal-button-container"></div>
													<img style="width:150px; float:left" alt="Visa Checkout" class="v-button" role="button" src="https://sandbox.secure.checkout.visa.com/wallet-services-web/xo/button.png">

													<!-- <a class="btnBlue" href="javascript:pay_now(<?=$paid_course['course_id']?>,<?=$paid_course['training_id']?>,<?=$paid_course['course_time_id']?>,<?=$paid_course['pay_price']?>)" >
														Pay Now
													</a> -->
                                                <?php }else if(!$paid_course['enroll_id']){ ?>
													<a class="btnBlue" href="javascript:booknow(<?=$paid_course['course_id']?>,<?=$paid_course['course_time_id']?>)" >
														<?=$term[enrollnow]?>
													</a>
												<?php } else{?>
													<a style = "float:left; margin-top:-20px; margin-left: 20px" class="btnBlue" href="javascript:booknow(<?=$paid_course['course_id']?>,<?=$paid_course['course_time_id']?>)" >
														<?=$term[viewcourse]?>
													</a>
												<?php }?>
                                                <a style = "float:left; margin-top:-20px; margin-left: 20px" class="btnBlue" href="<?=base_url()?>learner/training/viewDetail/<?=$paid_course['id']?>" >
                                                     <?=$term[viewdetails] ?>
                                                </a>
											</div><!--col-8-->
										</div><!--row-->
									</div><!--whitePanel-->
								<?php } } endforeach; ?>
							</div><!--col-12-->
							<div class="col-sm-12 paginationBox">
	                            <?php echo $links ?>
							</div><!--col-12-->
						<?php }else{ ?>
							<div class="col-sm-12">
								<p style="text-align: center">No record found.</p>
							</div>
						<?php } ?>
					</div><!--row-->
				</div><!--courseBox-->
			</div><!--col-12-->
		</div><!--row-->
	</div><!--container-->
</section><!--sectionBox-->
</div>
</div>
</section>
<!-- <?php if(!empty($successMessage)) { ?>
<div id="success-message"><?php echo $successMessage; ?></div>
<?php  } ?>
<div id="error-message"></div>

<form id="frmStripePayment" action="" method="post">
    <div class="field-row">
        <label>Card Holder Name</label> <span id="card-holder-name-info"
            class="info"></span><br> <input type="text" id="name"
            name="name" class="demoInputBox">
    </div>
    <div class="field-row">
        <label>Email</label> <span id="email-info" class="info"></span><br>
        <input type="text" id="email" name="email" class="demoInputBox">
    </div>
    <div class="field-row">
        <label>Card Number</label> <span id="card-number-info"
            class="info"></span><br> <input type="text" id="card-number"
            name="card-number" class="demoInputBox">
    </div>
    <div class="field-row">
        <div class="contact-row column-right">
            <label>Expiry Month / Year</label> <span id="userEmail-info"
                class="info"></span><br> <select name="month" id="month"
                class="demoSelectBox">
                <option value="08">08</option>
                <option value="09">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select> <select name="year" id="year"
                class="demoSelectBox">
                <option value="18">2018</option>
                <option value="19">2019</option>
                <option value="20">2020</option>
                <option value="21">2021</option>
                <option value="22">2022</option>
                <option value="23">2023</option>
                <option value="24">2024</option>
                <option value="25">2025</option>
                <option value="26">2026</option>
                <option value="27">2027</option>
                <option value="28">2028</option>
                <option value="29">2029</option>
                <option value="30">2030</option>
            </select>
        </div>
        <div class="contact-row cvv-box">
            <label>CVC</label> <span id="cvv-info" class="info"></span><br>
            <input type="text" name="cvc" id="cvc"
                class="demoInputBox cvv-input">
        </div>
    </div>
    <div>
        <input type="submit" name="pay_now" value="Submit"
            id="submit-btn" class="btnAction"
            onClick="stripePay(event);">

        <div id="loader">
            <img alt="loader" src="LoaderIcon.gif">
        </div>
    </div>
    <input type='hidden' name='amount' value='0.5'> <input type='hidden'
        name='currency_code' value='USD'> <input type='hidden'
        name='item_name' value='Test Product'> <input type='hidden'
        name='item_number' value='PHPPOTEG#1'>
</form>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="vendor/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
<script>
function cardValidation () {
    var valid = true;
    var name = $('#name').val();
    var email = $('#email').val();
    var cardNumber = $('#card-number').val();
    var month = $('#month').val();
    var year = $('#year').val();
    var cvc = $('#cvc').val();

    $("#error-message").html("").hide();

    if (name.trim() == "") {
        valid = false;
    }
    if (email.trim() == "") {
    	   valid = false;
    }
    if (cardNumber.trim() == "") {
    	   valid = false;
    }

    if (month.trim() == "") {
    	    valid = false;
    }
    if (year.trim() == "") {
        valid = false;
    }
    if (cvc.trim() == "") {
        valid = false;
    }

    if(valid == false) {
        $("#error-message").html("All Fields are required").show();
    }

    return valid;
}
//set your publishable key
Stripe.setPublishableKey("pk_test_51Jd2byEWwNGFgT9SATl3loJc8b14cCa33BId6t2MZenaAFCKQeOHv14BHa3SLHSPtFiLKaoXXlaC2NKgWHVIOrAX00dsSDdfS0");

//callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    if (response.error) {
        //enable the submit button
        $("#submit-btn").show();
        $( "#loader" ).css("display", "none");
        //display the errors on the form
        $("#error-message").html(response.error.message).show();
    } else {
        //get token id
        var token = response['id'];
        //insert the token into the form
        $("#frmStripePayment").append("<input type='hidden' name='token' value='" + token + "' />");
        //submit form to the server
        $("#frmStripePayment").submit();
    }
}
function stripePay(e) {
    e.preventDefault();
    var valid = cardValidation();

    if(valid == true) {
        $("#submit-btn").hide();
        $( "#loader" ).css("display", "inline-block");
        Stripe.createToken({
            number: $('#card-number').val(),
            cvc: $('#cvc').val(),
            exp_month: $('#month').val(),
            exp_year: $('#year').val()
        }, stripeResponseHandler);

        //submit from callback
        return false;
    }
} -->
</script>
<script>
	var company_url = "<?= base_url('company/'.$company['url'])?>";
	function viewcourse(course_id){
		window.location = company_url + '/traing/view/' + course_id;	
	}
	// function onVisaCheckoutReady() {
	// 	V.init({
	// 		apikey: '{{VISA_CHECKOUT_ID}}',
	// 		paymentRequest:{
	// 		subtotal: '10.00',
	// 			currencyCode: 'USD'
	// 		},
	// 		settings: {
	// 			displayName: 'My Website'
	// 		}
	// 	});
	// }
	// const clientSecret = '{{CLIENT_SECRET}}';

	// V.on('payment.success', async (payment) => {
	// const intent = await stripe.confirmCardPayment(clientSecret, {
	// 	payment_method: {
	// 	card: {
	// 		visa_checkout: {
	// 		callid: payment.callid,
	// 		},
	// 	},
	// 	},
	// });
	// Perform logic for payment completion here
	// });
  	paypal.Buttons({
		style: {
			layout:  'horizontal',
			color:   'gold',
			shape:   'rect',
			label:   'paypal',
			tagline: 'false'
		},
		createOrder: function(data, actions) {
		// This function sets up the details of the transaction, including the amount and line item details.
		return actions.order.create({
			purchase_units: [{
			amount: {
				value: '0.01'
			}
			}]
		});
		},
		onApprove: function(data, actions) {
		// This function captures the funds from the transaction.
		return actions.order.capture().then(function(details) {
			// This function shows a transaction success message to your buyer.
			alert('Transaction completed by ' + details.payer.name.given_name);
		});
		}
	}).render('#paypal-button-container');
    function booknow(course_id,id) {
        $.ajax({
            url: $('#base_url').val()+'learner/training/booknow',
            type: 'POST',
            data: {'course_time_id': id, 'course_id': course_id},
            success: function (data, status, xhr) { 
                new PNotify({
                    title: 'Success',
                    text: 'Success Book Now',
                    type: 'success'
                });
                location.reload();
            },
            error: function(data){
                new PNotify({
                    title: '<?php echo $term['error']; ?>',
                    text: '<?php echo $term['alreadybooking']; ?>',
                    type: 'warning'
                });
            }
        });
    }
	function pay_now(course_id,training_id, course_time_id, price) {
        swal({
			title: "You have to pay $"+price+" to take part in this course",
			buttons: true
		}).then((willDelete) => {
			if (willDelete) {
			$.ajax({
				url: "<?php echo base_url() ?>learner/training/pay_training",
				type: 'POST',
				data: {'course_id':training_id,'time_id':course_time_id,'ilt_course_id':course_id},
				dataType : 'json',
				success: function(data){
					if(data == 'success') {
						swal({
							title: "You have successfully enroll this course. Please wait until course is started!",
						});
						setTimeout(function(){ location.reload(); }, 10000);
					}else{
						swal({
							title: " Error!",
						});
					}
								
				}
			});
			} else {
			// return;
			}
		});
    }
    $("#location").on('change',(function () {
        window.location = $('#base_url').val()+ 'learner/training?location='+$("#location").val();
    }));
	$("#course_id").on('change',(function () {
        window.location = $('#base_url').val()+ 'learner/training?course='+$("#course_id").val();
    }));
</script>