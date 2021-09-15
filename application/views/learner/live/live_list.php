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
        <h2>Virtual Instructor Led Training</h2>

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
                                    <select id="course_id" name="course_id" style="border: 1px solid #ccc !important;padding: 8px 10px !important;">
                                        <option value=""> Select Course </option>
                                        <?php foreach($coursesfilter as $courseitem){
											if($courseitem['start_at'] != ''){
											$currentday = time();
											$startDateL = strtotime($courseitem['start_at']);
											$durationL = $courseitem['duration'] - 1;
											$enddateL = strtotime('+'.$durationL.' days', $startDateL);
		
											if($currentday <= $enddateL){
											//if(strtotime($courseitem['start_at']) >= $currentdays){
										?>
                                            <option value="<?php echo $courseitem['id']; ?>" <?php $courses_id==$courseitem['id']?print 'selected':print ''; ?>> <?php echo $courseitem['title']; ?></option>
                                        <?php } } } ?>
                                    </select>
								</div><!--sortSet-->
							</div><!--sortPanel-->
						</div><!--col-12-->
					</div><!--row-->					
					<div class="row">
						<?php if($course_list){?>
							<div class="col-sm-12">
								<?php foreach($course_list as $course){									
									if($course['start_at'] != ''){
									$currentdays = time();
									$startDateI = strtotime($course['start_at']);
									$durationI = $course['duration'] - 1;
									$enddateI = strtotime('+'.$durationI.' days', strtotime($course['start_at']));

									if($currentdays <= $enddateI){										
								?>
									<div class="whitePanel">
										<div class="row">
											<div class="col-lg-4 col-md-5 col-sm-6">
												<div class="leftImgBox">
													<?php
                                                        $imgName = end(explode('/', $course['img_path']));
                                                        if($imgName != '' && file_exists(getcwd().'/assets/uploads/company/course/'.$imgName)){								
                                                    ?>
                                                        <img src="<?php echo base_url($course['img_path']); ?>" class="rounded img-fluid" alt="learnerlearner">
                                                   	<?php }else{ ?>
                                                        <img src="<?php echo base_url().'assets/uploads/vilt-default.png'; ?>" class="rounded img-fluid" alt="learnerlearner">                                		
                                                   	<?php } ?>
												</div><!--leftImgBox-->
											</div><!--col-4-->
                                            
                                            <?php
												$showDuration = $course['duration'] > 1 ? $course['duration']. " Days" : $course['duration']." Day";												
												$duration = $course['duration'] - 1;
												$enddate = strtotime($course['start_at'] .'+'.$duration .'days');
											?>
											<div class="col-lg-8 col-md-7 col-sm-6 courseInfo">
												<h5><?php echo ucfirst($course['title']);?>, <?php echo $showDuration; ?></h5>
												<ul class="courseUl">
													<li>
														<a href="#"><?=$course['instructor_email']?>(instructor email address)</a>
													</li>
													<li style="color:#090;">
													 Start Date: <?php echo date("M d, Y h:i:sa", strtotime($course['start_at']));?>
													</li>
                                                    <li style="color:#090;">
                                                    <?php if($duration > 0){ ?>
                                                        End Date: <?php echo date("M d, Y h:i:sa", $enddate);?>
                                                    <?php }else{ ?>
                                                        End Date: <?php echo date("M d, Y", $enddate).' 11:59:59pm';?>
                                                    <?php } ?>
													</li>                                                    
                                                    <li>
													<?=nl2br(substr($course['about'],0,300));?>...
                                                    </li>                                                    
												</ul>  
		     	                               	<?php if(is_null($course['is_pay']['id'])){ ?>
                                                	<a href="javascript:enroll(<?php echo $course['course_id'] ?>,<?php echo $course['pay_type'] ?>,<?=$course['id']?>)" class="btnBlue">Enroll Now</a>
												<?php /*
														$activev = 'No';
														$start_datev = strtotime($course['start_at']);
														$currentDatevilt = time();
														$enddatev = $enddate;
														if($currentDatevilt >= $start_datev && $currentDatevilt <= $enddatev){
															$activev = 'Yes';
														}
														if($activev == 'Yes'){
													?>
												    <a href="javascript:enroll(<?php echo $course['course_id'] ?>,<?php echo $course['pay_type'] ?>,<?=$course['id']?>)" class="btnBlue">Enroll Now</a>
                                                    <?php }else{ ?>
                                                    	<?php $startdatetime = date('d, M Y h:i:sa',$start_datev); ?>
                                                    	<a href="javascript:void(0)" onclick='swal({title: "Please wait until course is started! Course start date time is: <?php echo $startdatetime ;?>"});' class="btnBlue">Enroll Now</a>
                                                    <?php } */ ?>
		                                        <?php }else {?>
                                                     <a href="javascript:view_course(<?php echo $course['course_id'] ?>,<?=$course['id']?>)" class="btnBlue">View Course</a>
                                                     <a href="<?=base_url()?>company/gosmartacademy.com/classes/view/<?=$course['id']?>" class="btnBlue">Start VILT Room</a>
		                                        <?php }  ?>
												<?php /*?><a href = "javascript:enroll(<?php echo $course['course_id'] ?>,<?php echo $course['pay_type'] ?>)" class="btnBlue">Enroll Now</a><?php */?>
                                                
                                                <?php /*?><a href="<?=base_url()?>learner/live/viewclass/<?=$course['virtual_course_id']?>" class="btnBlue">Course Details</a><?php */?>
                                                <a href="<?=base_url()?>learner/live/viewclass/<?=$course['id']?>" class="btnBlue">Course Details</a>
											</div><!--col-8-->
										</div><!--row-->
									</div><!--whitePanel-->
								<?php } } } ?>
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


<script type="text/javascript">
	var isLogin = "<?php echo $this->session->userdata ('isLoggedIn')?>";
	$(function(){
        $("ul.pagination a").addClass('page-link');
    });
	
	function enroll(id,pay_type,time_id){
		if(!isLogin){
			showLogin();
		}else{
			if(pay_type == 0){
				window.location = '<?=base_url()?>learner/demand/detail_course/' + id+'/'+time_id;
			}else if(pay_type == 1){
				swal({
				  title: "Are you sure?",
				  buttons: true
				}).then((willDelete) => {
				  if(willDelete) {
					window.location = "<?=base_url()?>learner/demand/pay_course/"+ id+'/'+time_id;
				  }else{
				    return;
				  }
				});
			}
		}
	}
	
	function view_course(id,time_id){
        if(!isLogin){
            showLogin();
        }else{
            window.location = '<?=base_url()?>learner/demand/detail_course/' + id+'/'+time_id;
        }
    }
	$("#course_id").on('change',(function () {
        window.location = $('#base_url').val()+ 'learner/live?course='+$("#course_id").val();
    }));
</script>


