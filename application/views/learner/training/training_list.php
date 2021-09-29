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

										if($course['course_self_time'] == "Time Restricted"){
											$showDuration = $free_course['duration'] > 1 ? $free_course['duration']. " Days" : $free_course['duration']." Day";
											$duration = $free_course['duration'] - 1;
											$enddate = strtotime('+'.$duration .' days', strtotime($free_course['start_day']. " " . $free_course['end_time']));
											$currentdays = time();
										}else{
											$enddate = $free_course['duration'] * 8 * 24 * 60;
											$currentdays = $free_course['session_time']?$free_course['session_time']:0;
										}
										// $startDateI = $free_course['date_str'];

										// $durationI = $free_course['duration'] - 1;
										// $enddateI = strtotime('+'.$duration .' days', $startDateI);
										if($currentdays <= $enddate){  ?> 
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
									<?php } 
									} 
								endforeach; ?>

								<?php foreach($paid_course_list as $paid_course):
									if($paid_course['date_str'] != '' || $paid_course['date_str'] != 0){
										if($course['course_self_time'] == "Time Restricted"){
											$showDuration = $paid_course['duration'] > 1 ? $paid_course['duration']. " Days" : $paid_course['duration']." Day";
											$duration = $paid_course['duration'] - 1;
											$enddate = strtotime('+'.$duration .' days', strtotime($paid_course['start_day']. " " . $paid_course['end_time']));
											$currentdays = time();
										}else{
											$enddate = $paid_course['duration'] * 8 * 24 * 60;
											$currentdays = $paid_course['session_time']?$paid_course['session_time']:0;
										}
									
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
														<p>USD: $ <?= $paid_course['pay_price']?></p>
													</h5>
													<ul class="courseUl">
														<li><?=nl2br(substr($paid_course['description'],0,300)); ?>...</li>
													</ul>
													<?php if(!$paid_course['pay_id']){ ?>
														<div style="width:160px; float:left; margin-top: -15px;">
															<a href="">
																<img style="width:150px" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png" alt="Buy now with PayPal" />
															</a>
															<br>
															<a href="">
																<img style="width:150px; float:left" alt="Visa Checkout" class="v-button" role="button" src="https://sandbox.secure.checkout.visa.com/wallet-services-web/xo/button.png">
															</a>
														</div>
														<!-- <a class="btnBlue" href="javascript:pay_now(<?=$paid_course['course_id']?>,<?=$paid_course['training_id']?>,<?=$paid_course['course_time_id']?>,<?=$paid_course['pay_price']?>)" >
															Pay Now
														</a> -->
													<?php }else if(!$paid_course['enroll_id']){ ?>
														<a class="btnBlue" href="javascript:booknow(<?=$paid_course['course_id']?>,<?=$paid_course['course_time_id']?>)" >
															<?=$term[enrollnow]?>
														</a>
													<?php } else{?>
														<a  class="btnBlue" href="javascript:booknow(<?=$paid_course['course_id']?>,<?=$paid_course['course_time_id']?>)" >
															<?=$term[viewcourse]?>
														</a>
													<?php }?>
													<a  class="btnBlue" href="<?=base_url()?>learner/training/viewDetail/<?=$paid_course['id']?>" >
														<?=$term[viewdetails] ?>
													</a>
												</div><!--col-8-->
											</div><!--row-->
										</div><!--whitePanel-->
									<?php } 
									} 
								endforeach; ?>
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
<div id="stripe_modal" class="modal-block modal-block-primary mfp-hide" style="max-width: 800px!important">
	<input type="hidden" id="price" name="price" class="form-control" >
	<section class="card">
		<header class="card-header">
			<h2 class="card-title"><?=$term[inviteuser]?></h2>
		</header>
		<div class="card-body">
			<p>You have to pay <strong></strong> to take part in this course</p>
			<!-- <div style="width:150px;" id="paypal-button-container"></div> -->
			<img style="width:150px; float:left" alt="Visa Checkout" class="v-button" role="button" src="https://sandbox.secure.checkout.visa.com/wallet-services-web/xo/button.png">
		</div>
		<footer class="card-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<a href="#add_exist_modal" class="btn btn-default add_exist_modal" style="color:#333"><i class="fas fa-plus"></i> <?=$term[inviteuser]?> </a>
					<a href="#add_modal" class="btn btn-default add_modal" style="color:#333"><i class="fas fa-plus"></i> <?=$term[add]?> </a>
					<button class="btn btn-default modal-change-dismiss"><?=$term[cancel]?></button>
				</div>
			</div>
			<div class="row">
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
							<label>Expiry Month / Year</label> 
							<span id="userEmail-info" class="info"></span>
							<br> 
							<select name="month" id="month" class="demoSelectBox">
								<option value="08">08</option>
								<option value="09">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select> 
							<select name="year" id="year"	class="demoSelectBox">
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
							<input type="text" name="cvc" id="cvc" class="demoInputBox cvv-input">
						</div>
					</div>
					<div>
						<input type="submit" name="pay_now" value="Submit" id="submit-btn" class="btnAction" onClick="stripePay(event);">
						<div id="loader">
							<img alt="loader" src="LoaderIcon.gif">
						</div>
					</div>
					<input type='hidden' name='amount' value='0.5'> 
					<input type='hidden' name='currency_code' value='USD'> 
					<input type='hidden' name='item_name' value='Test Product'> 
					<input type='hidden' name='item_number' value='PHPPOTEG#1'>
				</form>
			</div>
		</footer>
	</section>
</div>
<div id="paypal_modal" class="modal-block modal-block-primary mfp-hide" style="max-width: 800px!important">
	<input type="hidden" id="price" name="price" class="form-control" >
	<section class="card">
		<header class="card-header">
			<h2 class="card-title"><?=$term[inviteuser]?></h2>
		</header>
		<div class="card-body">
			<form method="post" class="form-horizontal" role="form" action="<?= base_url() ?>paypal/create_payment_with_paypal">
				<fieldset>
					<input title="item_name" name="item_name" type="hidden" value="ahmed fakhr">
					<input title="item_number" name="item_number" type="hidden" value="12345">
					<input title="item_description" name="item_description" type="hidden" value="to buy samsung smart tv">
					<input title="item_tax" name="item_tax" type="hidden" value="1">
					<input title="item_price" name="item_price" type="hidden" value="7">
					<input title="details_tax" name="details_tax" type="hidden" value="7">
					<input title="details_subtotal" name="details_subtotal" type="hidden" value="7">

					<div class="form-group">
						<div class="col-sm-offset-5">
							<button  type="submit"  class="btn btn-success">Pay Now</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
		<footer class="card-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<a href="#add_exist_modal" class="btn btn-default add_exist_modal" style="color:#333"><i class="fas fa-plus"></i> <?=$term[inviteuser]?> </a>
					<a href="#add_modal" class="btn btn-default add_modal" style="color:#333"><i class="fas fa-plus"></i> <?=$term[add]?> </a>
					<button class="btn btn-default modal-change-dismiss"><?=$term[cancel]?></button>
				</div>
			</div>
			<div class="row">
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
							<label>Expiry Month / Year</label> 
							<span id="userEmail-info" class="info"></span>
							<br> 
							<select name="month" id="month" class="demoSelectBox">
								<option value="08">08</option>
								<option value="09">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select> 
							<select name="year" id="year"	class="demoSelectBox">
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
							<input type="text" name="cvc" id="cvc" class="demoInputBox cvv-input">
						</div>
					</div>
					<div>
						<input type="submit" name="pay_now" value="Submit" id="submit-btn" class="btnAction" onClick="stripePay(event);">
						<div id="loader">
							<img alt="loader" src="LoaderIcon.gif">
						</div>
					</div>
					<input type='hidden' name='amount' value='0.5'> 
					<input type='hidden' name='currency_code' value='USD'> 
					<input type='hidden' name='item_name' value='Test Product'> 
					<input type='hidden' name='item_number' value='PHPPOTEG#1'>
				</form>
			</div>
		</footer>
	</section>
</div>
<!-- <?php if(!empty($successMessage)) { ?>
<div id="success-message"><?php echo $successMessage; ?></div>
<?php  } ?>
<div id="error-message"></div>



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
		$('#price').val(price);
		$('#payment_modal').modal();
        // swal({
		// 	title: "You have to pay $"+price+" to take part in this course",
		// 	buttons: true
		// }).then((willDelete) => {
		// 	if (willDelete) {
		// 	$.ajax({
		// 		url: "<?php echo base_url() ?>learner/training/pay_training",
		// 		type: 'POST',
		// 		data: {'course_id':training_id,'time_id':course_time_id,'ilt_course_id':course_id},
		// 		dataType : 'json',
		// 		success: function(data){
		// 			if(data == 'success') {
		// 				swal({
		// 					title: "You have successfully enroll this course. Please wait until course is started!",
		// 				});
		// 				setTimeout(function(){ location.reload(); }, 10000);
		// 			}else{
		// 				swal({
		// 					title: " Error!",
		// 				});
		// 			}
								
		// 		}
		// 	});
		// 	} else {
		// 	// return;
		// 	}
		// });
    }
    $("#location").on('change',(function () {
        window.location = $('#base_url').val()+ 'learner/training?location='+$("#location").val();
    }));
	$("#course_id").on('change',(function () {
        window.location = $('#base_url').val()+ 'learner/training?course='+$("#course_id").val();
    }));
</script>