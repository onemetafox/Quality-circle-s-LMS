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
                                        <option value="all"> Select Location </option>
                                        <?php foreach($location as $item){ ?>
                                            <option value="<?php echo $item['location']; ?>" <?php $location_name==$item['location']?print 'selected':print ''; ?>> <?php echo $item['location']; ?></option>
                                        <?php } ?>
                                    </select>
                                    
                                    <select id="course_id" name="course_id" style="border: 1px solid #ccc !important;padding: 8px 10px !important;">
                                        <option value="all"> Select Course </option>
                                        <?php foreach($course_filter_list as $courseitem){
											
											if($courseitem['date_str'] != ''){
											$currentday = time();
											$startDate = $courseitem['date_str'];
											$duration = $courseitem['duration'] - 1;
											$enddate = strtotime('+'.$duration.' days', $courseitem['date_str']);
		
											if($currentday >= $startDate && $currentday <= $enddate){
											
										?>
                                            <option value="<?php echo $courseitem['id']; ?>" <?php $course_name==$courseitem['id']?print 'selected':print ''; ?>> <?php echo ucfirst($courseitem['title']); ?></option>
                                        <?php } } } ?>
                                    </select>
								</div><!--sortSet-->
							</div><!--sortPanel-->
						</div><!--col-12-->
					</div><!--row-->
					
					<div class="row">
						<?php if($course_list){						
						?>
							<div class="col-sm-12">
								<?php foreach($course_list as $course):
									if($course['date_str'] != ''){
									$currentdays = time();
									$startDateI = $course['date_str'];
									$durationI = $course['duration'] - 1;
									$enddateI = strtotime('+'.$durationI.' days', $course['date_str']);

									if($currentdays >= $startDateI && $currentdays <= $enddateI){
								
									//$currentdays = strtotime(date('Y-n-d'));
									//if($currentdays <= $course['date_str']){																			
								?> 
									<div class="whitePanel">
										<div class="row">
											<div class="col-lg-4 col-md-5 col-sm-6">
												<div class="leftImgBox">
                                                	<?php 
														$courseimgpath = getCourseImgById($course['course_id']);
                                                        $imgName = end(explode('/', $courseimgpath));
                                                        if($imgName != '' && file_exists(getcwd().'/assets/uploads/company/course/'.$imgName)){								
                                                    ?>
                                                        <img src="<?php echo base_url($courseimgpath); ?>" class="rounded img-fluid" alt="learnerlearner">
                                                   	<?php }else{ ?>
                                                        <img src="<?php echo base_url().'assets/uploads/ilt-default.png'; ?>" class="rounded img-fluid" alt="learnerlearner">
                                                   	<?php } ?>
												</div><!--leftImgBox-->
											</div><!--col-4-->
                                            <?php
												$is_pay = 0;
												foreach($pay_course_list as $pay){
													if($pay['id'] == $course['id']){
														$is_pay = 1;
													}
												}
											?>
											<div class="col-lg-8 col-md-7 col-sm-6 courseInfo">
                                                <h5>
													<?php
                                                        $showDuration = $course['duration'] > 1 ? $course['duration']. " Days" : $course['duration']." Day";
                                                        $duration = $course['duration'] - 1;
                                                        //$enddate = strtotime(date('Y-m-d',$course['date_str']) .'+'.$duration .'days');
														$enddate = strtotime('+'.$duration .' days', $course['date_str']);
                                                    ?>
													
													<?php echo ucfirst($course['title']);?>, <?php echo $showDuration; ?> <br />
                                                    <p> Start Date: <?php echo date("M d, Y h:i:sa", $course['date_str']);?></p>
                                                    <?php if($duration > 0){ ?>
                                                        <p>End Date: <?php echo date("M d, Y h:i:sa", $enddate);?></p>
                                                    <?php }else{ ?>
                                                        <p>End Date: <?php echo date("M d, Y", $enddate).' 11:59:59pm';?></p>
                                                    <?php } ?>
                                                </h5>
                                                <ul class="courseUl">
													<li><?=nl2br(substr($course['description'],0,300)); ?>...</li>
												</ul>
		     	                               	<?php if($is_pay != 1){ ?>
                                                <a class="btnBlue" href="javascript:booknow(<?=$course['course_id']?>,<?=$course['id']?>)" >
                                                    <?=$term[enrollnow]?>
                                                </a>
                                                <?php
												/*
													$active = 'No';
													$start_date = $course['date_str'];
													$currentDate = time();
													if($currentDate >= $start_date && $currentDate <= $enddate){
														$active = 'Yes';
													}
													if($active == 'Yes'){
												?>  
                                                <a class="btnBlue" href="javascript:booknow(<?=$course['course_id']?>,<?=$course['id']?>)" >
                                                    <?=$term[enrollnow]?>
                                                </a>
                                                <?php }else{ ?>
                                                	<?php $startdatetime = date('d, M Y h:i:sa',$course['date_str']); ?>
                                                	<a href="javascript:void(0)" onclick='swal({title: "Please wait until course is started! Course start date time is: <?php echo $startdatetime ;?>"});' class="btnBlue">Enroll Now</a>
                                                <?php } */ ?>
                                                <?php } ?>
                                                <a class="btnBlue" href="<?=base_url()?>learner/training/viewDetail/<?=$course['id']?>" >
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

<script>
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
    $("#location").on('change',(function () {
        window.location = $('#base_url').val()+ 'learner/training?location='+$("#location").val();
    }));
	$("#course_id").on('change',(function () {
        window.location = $('#base_url').val()+ 'learner/training?course='+$("#course_id").val();
    }));
</script>