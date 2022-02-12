<style>
.ui-pnotify-container {
	height: 130px;
}
</style>
<section role="main" class="content-body">
  <header class="page-header">
    <h2>Enrolled Courses</h2>
    <div class="right-wrapper">
      <ol class="breadcrumbs">
        <li> <a href="<?php echo base_url(); ?>home"> <i class="fas fa-home"></i> </a> </li>
        <li><span>
          <?=$term["exam"]?>
          </span></li>
        <li><span>
          <?=$term["examlist"]?>
          </span></li>
      </ol>
    </div>
  </header>
  
  
  <!-- start: page -->
  <div class="row">
    <div class="col-lg-12">
      <section class="card">
        <header class="card-header">
          <h2 class="card-title">Enrolled Courses</h2>
        </header>
        <div class="card-body">
        
        <footer class="card-footer">
            <div class="row">
            	<div class="col-md-6"></div>
                <div class="col-md-6">
                	<form id="searchForm" type="post">
                    <div class="row">
                       <div class="col-sm-4">
                            <select class="form-control" id="course_type" name="course_type">
                                <option value="">Select Course Type</option>                                                                                
                                <option value="0">ILT</option>                                        
                                <option value="1">VILT</option>
                                <option value="2">ON-DEMAND</option>
                  			</select>
                       </div>
                       <div class="col-sm-5">
                            <select data-plugin-selecttwo="" class="form-control" id="course_title" name="course_title">
                                <option value="">Select Course</option>  
                                <?php if(isset($mydata['data']) && !empty($mydata['data'])){ ?>
              					<?php foreach($mydata['data'] as $myenrollsearch){ ?>
                                	<option value="<?php echo $myenrollsearch['id'] ?>"><?php echo $myenrollsearch['title'] ?></option>
                                <?php } } ?>
                  			</select>
                       </div>
                       <div class="col-sm-3">
                            <a onclick="searchData();" class="btn btn-primary" id="searchBTN">Search</a>
                            <a href="<?php echo base_url('instructor/examhistory/enrolledcourse');?>" class="btn btn-default">Reset</a>
                       </div>
                   	</div>
                   	</form>
                </div>
            </div>
        </footer>
  		
        <div id="replaceHtml">
          <table class="table table-responsive-md table-striped table-hover mb-0 dataTable no-footer" id="datatable_examlist" role="grid" style="width: 1563px;">
            <thead style="background-color:#1D2127; color:#FFF">
            <td><b>S.No.</b></td>
              <td><b>Course Title</b></td>
              <td><b>Course Type</b></td>
              <td><b>Total Count</b></td>
              <td><b>Action</b></td>
                </thead>
            <tbody>
              <?php if(isset($mydata['data']) && !empty($mydata['data'])){ ?>
              <?php foreach($mydata['data'] as $mkey => $myenroll){
                    if($myenroll['type'] == 0){
                        $course_type = 'ILT';
                    }elseif($myenroll['type'] == 1){
                        $course_type = 'VILT';
                    }else{
                        $course_type = 'Demand';
                    }
                ?>
              <tr role="row" class="odd">
                <td class="center sorting_<?php $myenroll['no']  ?>"><?php echo $myenroll['no'] ?></td>
                <td class="text-left"><?php echo $myenroll['title'] ?></td>
                <td class="text-left"><?php echo $course_type; ?></td>
                <td class="text-left"><?php echo $myenroll['count'] ?></td>
                <?php if($myenroll['type'] == 2){ ?>
                <td class=" text-left"><a style="background-color:#1D2127; color:#FFF; border:0px;" target="_blank" class="btn btn-default btn-sm" id="append_view_<?php echo $myenroll['id'] ?>" href="<?= base_url()?>admin/examhistory/enrolled_course_users/<?php echo $myenroll['id'] ?>/0">View</a></td>
                <?php }else{ ?>
                <td class=" text-left"><a style="background-color:#1D2127; color:#FFF; border:0px;" class="btn btn-default btn-sm" id="append_view_<?php echo $myenroll['id'] ?>" href="javascript:void(0)" onclick="getEnrolled(<?php echo $myenroll['id'] ?>)">View</a></td>
                <?php } ?>
              </tr>
              <?php $course_times = getCourseDetail($myenroll['id'],$myenroll['type']); 
                    if($course_times != ''){							
                  ?>
              <tr style="display:none;" role="row" class="odd" id="sub_tr_<?php echo $myenroll['id'] ?>">
                <td colspan="5"><table width="100%">
                    <thead style="background-color:#1D2127; color:#FFF">
                    <td><b>S.No.</b></td>
                      <td><b>Course Title</b></td>
                      <td><b>Schedule Date</b></td>
                      <td><b>Total Count</b></td>
                      <td><b>Action</b></td>
                        </thead>
                      <?php foreach($course_times as $keys => $courseSchedule){ 
                        
                        $totalEnCount = getScheTotalCount($myenroll['id'],$courseSchedule['time_id']); 
                        ?>
                    <tr role="row" class="odd">
                      <td><?php echo $keys+1; ?></td>
                      <td class="text-left"><?php echo $courseSchedule['title'] ?></td>
                      <?php if($myenroll['type'] == 1){ 
                            $stringDate = strtotime($courseSchedule['start_at']);
                            ?>
                      <td class="text-left"><?php echo date('F d,Y',strtotime($courseSchedule['start_at'])) ?></td>
                      <?php } ?>
                      <?php if($myenroll['type'] == 0){ 
                                $stringDate = $courseSchedule['date_str'];
                                if($courseSchedule['date_str'] != ''){
                            ?>
                      <td class="text-left"><?php echo date('F d,Y',$courseSchedule['date_str']) ?></td>
                      <?php } else{ ?>
                      <td class="text-left">Not Available</td>
                      <?php } } ?>
                      <td class="text-left"><?php echo $totalEnCount;?></td>
                      <td class="text-left"><a target="_blank" class="btn btn-default btn-sm" id="append_view_<?php echo $courseSchedule['id'] ?>" href="<?= base_url()?>admin/examhistory/enrolled_course_users/<?php echo $myenroll['id'] ?>/<?php echo $courseSchedule['time_id'] ?>/<?php echo $stringDate;?>">View</a></td>
                    </tr>
                    <?php } ?>
                  </table></td>
              </tr>
              <?php }}} ?>
            </tbody>
          </table>
          </div>
        </div>
      </section>
    </div>
  </div>
  
  <!-- end: page --> 
</section>
<script type="text/javascript">
	function getEnrolled(div_id){
		if($('#sub_tr_'+div_id).is(':visible')){
			$('#sub_tr_'+div_id).hide();
		}else{
			$('#sub_tr_'+div_id).show();
		}
	}
	
	function searchData(){
		$('#searchBTN').html('Searching');
		$.ajax({
			type: 'POST',
			url: "<?= base_url()?>instructor/examhistory/searchResult/",
			data: $('#searchForm').serialize(),
			success: function(msg){
				$('#replaceHtml').html(msg);
				$('#searchBTN').html('Search');
				return false;
				
			},error: function(ts){
				$('#searchBTN').html('Search'); 
				console.log(ts);
			}
		});
	}
</script> 
