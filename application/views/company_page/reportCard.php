<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate/animate.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/fontawesome-all.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/magnific-popup/magnific-popup.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

<!-- Specific Page vendor CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.theme.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/jquery-multi-select/css/multi-select.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2/css/select2.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/dropzone/basic.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/dropzone/dropzone.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/datatables/media/css/dataTables.bootstrap4.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/pnotify/pnotify.custom.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/morris/morris.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.checkboxes.css"  />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/summernote/summernote-bs4.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/elusive-icons/css/elusive-icons.css">
<!-- Theme CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css">
<?php if (empty($edit_course)):?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/components.css">
<?php endif;?>
<!--    <link rel="stylesheet" href="--><?php //echo base_url(); ?><!--assets/css_company/main-style.css">-->

<!-- Skin CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/skins/default.css" />

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />
<style>
    body{
        background-image: none !important;
        background-color: white;
    }
    .card.mt-3{
        border: 1px solid rgba(0,0,0,.125) !important;
    }
    .table-border-th{
        border-bottom: 1px solid #B7BCB7 !important;
    }
    .table-border-td{
        border-bottom: 1px solid #E9EBE9 !important;
        width:25% !important;
    }
    div>i{
        font-size: 0px;
    }
</style>
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
            <div class="container">
                <?php if ($exam_type != "Manual"):?><h5 style="line-height: 30px;">Thank you for completing this quiz. Your certificate is below.</h5><?php endif;?>
            </div>
        </div>
        <?php if ($result == "Pass"):?>
            <header class="page-header">
                <h2><?=$term["exammanagement"]?></h2>
                <h5 style="text-align: right; margin-right: 50px"><a href="javascript:pagePrint()" class="btn btn-primary ml-3"><i class="fas fa-print"></i> Print and Download</a></h5>
            </header>
        <?php endif;?>
        <main role="main" class="container">
        <div class="container">
            <?php if ($result == "Pass"):?>
            <main role="main" class="content-body">
                <style>

                    .cert_span{
                        text-align: center;
                        font-size: 40px;
                        color: red;
                        padding: 20px;
                       
                    }
                    @font-face { 
                        font-family: GlacialIndifference-Regular; src: url('<?php echo base_url(); ?>assets/img/GlacialIndifference-Regular.otf'); 
                      } 
                    @font-face { 
                       font-family: GlacialIndifference-Bold; src: url('<?php echo base_url(); ?>assets/img/GlacialIndifference-Bold.otf'); 
                    } 
                    h6,h5 {
                       font-family: GlacialIndifference-Regular
                    }
                    h6.a {
                      font-family: GlacialIndifference-Bold
                    }    
                    h3 {
                        padding-top: 5px;
                        margin-top: 20px;
                        margin-bottom: 10px;
                        font-size: 1.6em;
                        font-weight: 400;
                        letter-spacing: normal;
                        line-height: 24px;
                    } 
                     h4 {
                        padding-top: 5px;
                        margin-top: 20px;
                        margin-bottom: 10px;
                        font-size: 1.3em;
                        font-weight: 400;
                        letter-spacing: normal;
                        line-height: 27px;
                    } 

                    html { background-color: white; }
                    .solid { 
                        border-style: solid;
                        margin-top:270px;
                        position: relative;
                        bottom:270px;  
                        background-color: #38b6ff
                         }
                    hr {
                       margin-top: 0.5rem;
                       border: 1px;
                    }
                    .row {
                        display: flex;
                        margin-right: -15px;
                        margin-left: -15px;
                    }
                    .col-md-4{
                        position: relative;
                        width: 100%;
                        min-height: 1px;
                        padding-right: 15px;
                        padding-left: 15px;
                        flex: 0 0 33.333333%;
                        max-width: 33.333333%;
                    }
                    *, *::before, *::after {
                        box-sizing: border-box;
                    }
                    
                </style>
                    
                <?php if($certificate['certificate_id'] == 1) {?>
                    <div class="container" style="height:640px;    width: 815px;">
                        <div class="row" style="height:640px;    width: 815px;">
                        &nbsp;
                            <div class="col-md-9" style="height:640px;    width: 815px;">                
                                
                                <div class="solid" style="height:640px;    width: 815px;">
                                  <div>
                                     <img src="<?php echo base_url(); ?>assets/img/download.jpg" alt="Certificate" align="left" style="width:202px;height:638px;">                    
                                  </div>
                                  <div>                                 
                                    <img src="<?php echo base_url(); ?>assets/img/logo-top.png" alt="Certificate" align="right" style="position: absolute;left:540px;top:10px;">
                                    <h1 style="color:white; position:relative; left:80px;font-family:merriweather;" ><font size="6"><b><I><?php echo strtoupper($certificate['COMPANY NAME']);?></I></b></font></h1>
                                    <h6 class="a" style="color:white;" align="center"><font size="2">HEREBY CERTIFIES THAT</font></h6>
                                    <h1 style="color:white; font-family:merriweather;" align="center"><font size="6"><?php echo strtoupper($certificate['PARTICIPANT NAME']);?></font></h1>
                                    <h6 style="color:white;" align="center"><font size="2">Participated in And Completed</font></h6>
                                    <h6 class="a" style="color:white;" align="center"><font size="2"><b><?php echo strtoupper($certificate['COURSE NAME']);?></b></font></h6>
                                    <h6 style="color:white;" align="center"><font size="2">Given on</font></h6>
                                    <h6 style="color:white;" align="center"><font size="2"><?php echo strtoupper($certificate['CERTIFICATION DATE']);?></font></h6>
                                    <h6 style="color:white;" align="center"><font size="2">AT</font></h6>
                                    <h6 style="color:white;" align="center"><font size="2"><?php echo $certificate['LOCATION'];?></font></h6>
                                    <h6 style="color:white;" align="center"><font size="2">And Has Been Awarded</font></h6>
                                    <h6 style="color:white;" align="center"><font size="2"><?php echo strtoupper($certificate['NUMBER']);?> CEU</font></h6>
                                    <h6 style="color:white;" align="center"><font size="2">Certificate #  00001111</font></h6>
                                    <!--<img src="<?php echo base_url(); ?>assets/img/output-onlinepngtools.png" alt="Certificate" align="right" style="position: absolute; left: 450px; bottom:15px; ">
                                    -->
                                    <div alt="Certificate" align="right" style="position: absolute; left: 450px; bottom:35px; ">
                                      <?php echo $certificate['SIGNATURE'];?> 
                                    </div>                  
                                    <hr width="25%" style="position: absolute;left: 560px; bottom: 50px; height: 2px; background: white; ">
                                    <hr width="79.5%" style="position: absolute;right: 285px;top: 308px; height: 5px; background: white; -webkit-transform:rotate(90deg);">
                                    <h6 style="color:white; position:absolute; left:630px; bottom:15px; "align="right"><font size="2">President</font></h6>
                                  </div>  
                               </div>
                              
                            </div>
                        </div>
                    </div>
                        <?php } elseif($certificate['certificate_id'] == 2){?>
                    <div class="container" style="height:920px;    width: 720px;">
                        <div class="row" style="height:920px;    width: 720px;">
                        &nbsp;
                            <div class="col-md-9" style="height:920px;    width: 720px;">                
                                
                                <div class="" style="height:920px;    width: 720px;">
                                  <div style="width:714px;height:110px;">
                                     <img src="<?php echo base_url(); ?>assets/img/top.png" alt="Certificate" style="width:714px;height:110px;">                    
                                  </div>
                                  <div style="padding-top:20px;">                                 
                                        <img src="<?php echo base_url(); ?>assets/img/quality circle log.png" alt="Certificate" style="position: absolute;left:340px;top:30px;height:120px;    width: 120px;">
                                        <br>
                                        <br>
                                        <h3 align="center">Quality Circle International Limied</h3>
                                        <h3 class="a"  align="center">Hereby Certifies</h3>
                                        <h3 class="a"  align="center">That</h3>
                                        <h1 style=" font-family:merriweather;" align="center"><font size="6"><?php echo strtoupper($certificate['PARTICIPANT NAME']);?></font></h1>
                                        <h3 class="a"  align="center">Has Successfully Completed</h3>
                                        <h3 class="a"  align="center"><b><?php echo strtoupper($certificate['COURSE NAME']);?></b></h3>
                                        <h4  align="center">Given on</h6>
                                        <h3  align="center"><b><?php echo date_format(date_create($certificate['CERTIFICATION DATE']),"M d, Y")?></b></h3>
                                        <h4  align="center">In</h4>
                                        <h3  align="center"><?php echo $certificate['LOCATION'];?></h3>
                                        <!-- <h6  align="center"><font size="2">And Has Been Awarded</font></h6> -->
                                        <div class="row">
                                            <div class = "col-md-4">
                                                <h6  align="center"><font size="2"><?php echo strtoupper($certificate['NUMBER']);?></font></h6>
                                                <h6 align="center">Certificate Number</h6>
                                            </div>
                                            <div class = "col-md-4">
                                                <h6  align="center"><b><?php echo date_format(date_create($certificate['CERTIFICATION DATE']),"M d, Y")?></b></h6>
                                                <h6 align="center">Certificate Date</h6>
                                            </div>
                                            <div class = "col-md-4">
                                                <h5 align="center"><?php echo($certificate['CATEGORY']);?></h5>

                                            </div>
                                        </div>
                                                                   
                                    
                                  </div> 
                                  <div style="width:714px;height:170px;position: relative;">
                                     <img src="<?php echo base_url(); ?>assets/img/bottom.png" alt="Certificate" style="width:714px;height:170px;">   
                                     <img src="<?php echo base_url(); ?>assets/img/ic.png" alt="Certificate" style="position: absolute; left:20px;  bottom:20px;height:80px; width: 200px;">
                                  </div> 

                               </div>
                              
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <form id="print_form" method="POST" action="<?= base_url()?>admin/demand/print_exam_certificate">
                        <input type="hidden" id="content" name="content">
                    </form>
                </main>
            <?php endif;?>
            <?php if ($exam_type != "Manual"):?>
                <div class="row">
                    <div class="col-md-9">
                        <table class="table table-responsive-md table-borderless">
                            <tr>
                                <th class="table-border-th" colspan="4">Your Score</th>
                            </tr>
                            <tr>
                                <td class="table-border-td">Name</td>
                                <td class="table-border-td"><?=$user_name?></td>
                                <td class="table-border-td">Score</td>
                                <td class="table-border-td"><?=$score?> / 100 Points (<?=$score?> %)</td>
                            </tr>
                            <tr>
                                <td class="table-border-td">Correct Answers</td>
                                <td class="table-border-td"><?=$correct_count?></td>
                                <td class="table-border-td">Incorrect Answers</td>
                                <td class="table-border-td"><?=$wrong_count?></td>
                            </tr>
                            <tr>
                                <td class="table-border-td">Passing Grade</td>
                                <td class="table-border-td"><?=round($pass_grade,2)?> %</td>
                                <td class="table-border-td">Time Taken</td>
                                <td class="table-border-td"><?=$time_taken?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <table class="table table-responsive-md table-borderless">
                            <tr>
                                <th class="table-border-th" colspan="4">Your Result</th>
                            </tr>
                            <tr>
                                <td class="table-border-td"style="color: green;"><?=$result?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php endif;?>
                <div class="row">
                    <div class="col-md-9">
                        <?php if(!empty($questions)):?>
                                <?php $qnum = 0;
                                foreach($questions as $question):?>
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <?php if ($exam_type == "Manual"):?>
                                        <h4 style="color: red">You have to wait until get approve about your paper. You will get your mark as soon</h4>
                                        <?php endif;?>
                                        <?php 
                                            if (isset($question['ques_file']) && !empty($question['ques_file'])) {
                                                echo '<img src="'.base_url('assets/uploads/exam/quiz/').$question['ques_file'].'" height="100" width="200" class="img-fluid rounded img-thumbnail border float-right" />';
                                            }
                                            echo $qnum+1;
                                            echo ". ";
                                            echo empty($question['ques_title'])?'Title is not provided':$question['ques_title']; 
                                        ?>
                                    </div>
                                <div class="card-body">
                                    <?php foreach ($answers as $answer):?>
                                        <?php if ($answer['quiz_id'] == $question['id']):?>
                                            <?php $userAns = $answer;?>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                    <?php
                                    $userAns['description'] = json_decode($userAns['description'],true);
                                        switch ($question['type']) {
                                            case 'multi-choice':
                                                $checkData = array(
                                                                'correctCheck'=>json_decode($question['content'],true)['correctCheck'],
                                                                'checkbox'=>json_decode($question['content'],true)['checkbox'],
                                                                'userAns'=>$userAns['description']
                                                            );

                                                $this->load->view('admin/exam/reportcard/multichoice', $checkData);
                                                break;
                                            case 'checkbox':
                                                $checkData = array(
                                                                'correctCheck'=>json_decode($question['content'],true)['correctCheck'],
                                                                'checkbox'=>json_decode($question['content'],true)['checkbox'],
                                                                'userAns'=>$userAns['description']
                                                            );
                                                $this->load->view('admin/exam/reportcard/checkbox', $checkData);
                                                break;
                                            case 'true-false':
                                                $checkData = array(
                                                            'tftext'=>json_decode($question['content'],true)['tf'],
                                                            'settrue'=>json_decode($question['content'],true)['settrue'],
                                                            'userAns'=>$userAns['description']
                                                        );
                                                $this->load->view('admin/exam/reportcard/true_false', $checkData);
                                                break;
                                            case 'fill-blank':
                                                $checkData = array('blank'=>json_decode($question['content'],true)['blank'],'userAns'=>$userAns['description']);
                                                $this->load->view('admin/exam/reportcard/fill_blank', $checkData);
                                                break;
                                            case 'essay':
                                                $checkData = array('userAns'=>$userAns['description']);
                                                $this->load->view('admin/exam/reportcard/essay', $checkData);
                                                break;
                                            case 'matching':
                                                $this->load->view(
                                                    'admin/exam/reportcard/matching',
                                                    array(
                                                        'content'=>json_decode($question['content'],true)['choice'],
                                                        'match'=>json_decode($question['content'],true)['match'],
                                                        'userAns'=>$userAns['description']
                                                    )
                                            );
                                                break;
                                            default:
                                                echo 1;
                                        }
                                    ?>
                                </div>
                                <?php ++$qnum; endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
        <script>
            var  baseurl = "<?php echo base_url($company['company_url'])?>/demand/";
            var  base_url = "<?php echo base_url($company['company_url'])?>/demand/";

            function pagePrint() {
        
                var content = $('.content-body').html();
                //alert(content); 
                $('#content').val(content);
                $('#print_form').submit(); 

                $.ajax({
                    //url: "<?= base_url()?>admin/demand/print_exam_certificate",
                    url:"",
                    type: 'POST',
                    data: {                
                        content: content,

                      },  
                    success: function (data, status, xhr) {              
                      new PNotify({
                          title: 'Success',
                          text: 'Certificate Print and Download',
                          type: 'success'
                      });               
                    },
                    error: function(){ 
                        new PNotify({
                            title: 'Error',
                            text: 'Failed!',
                            type: 'error'
                        });
                    }
                }); 
            }
        </script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.1.0.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/user.js"></script>