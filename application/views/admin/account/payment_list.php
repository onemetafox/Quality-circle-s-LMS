<section role="main" class="content-body">
	<header class="page-header">
		<h2><?=$term[invoicingaccounting]?></h2>
	
	</header>
<!--    <div class="row">-->
<!--        <div class="col-sm-12 col-md-6 col-xl-4">-->
<!--        <section class="card card-featured-left card-featured-secondary mb-4">-->
<!--            <div class="card-body">-->
<!--                <div class="widget-summary">-->
<!--                    <div class="widget-summary-col widget-summary-col-icon">-->
<!--                        <div class="summary-icon bg-warning">-->
<!--                            <i class="fas fa-euro-sign"></i>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="widget-summary-col">-->
<!--                        <div class="summary">-->
<!--                            <h4 class="title">--><?//=$term[totalinvoiceamount]?><!--</h4>-->
<!--                            <div class="info">-->
<!--                                <strong class="amount">€ --><?php //echo $invoice_amt; ?><!--</strong>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="summary-footer">-->
<!--                            <a class="text-muted text-uppercase"></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
<!--        </div>-->
<!--        <div class="col-sm-12 col-md-6 col-xl-4">-->
<!--            <section class="card card-featured-left card-featured-secondary mb-4">-->
<!--                <div class="card-body">-->
<!--                    <div class="widget-summary">-->
<!--                        <div class="widget-summary-col widget-summary-col-icon">-->
<!--                            <div class="summary-icon bg-secondary">-->
<!--                                <i class="fas fa-euro-sign"></i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="widget-summary-col">-->
<!--                            <div class="summary">-->
<!--                                <h4 class="title">--><?//=$term[totalopenamount]?><!--</h4>-->
<!--                                <div class="info">-->
<!--                                    <strong class="amount">€ --><?php //echo $open_amt; ?><!--</strong>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="summary-footer">-->
<!--                                <a class="text-muted text-uppercase"></a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </section>-->
<!--        </div>-->
<!--        <div class="col-sm-12 col-md-6 col-xl-4">-->
<!--            <section class="card card-featured-left card-featured-secondary mb-4">-->
<!--                <div class="card-body">-->
<!--                    <div class="widget-summary">-->
<!--                        <div class="widget-summary-col widget-summary-col-icon">-->
<!--                            <div class="summary-icon bg-success">-->
<!--                                <i class="fas fa-euro-sign"></i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="widget-summary-col">-->
<!--                            <div class="summary">-->
<!--                                <h4 class="title">--><?//=$term[totalpaidamount]?><!--</h4>-->
<!--                                <div class="info">-->
<!--                                    <strong class="amount">€ --><?php //echo (float)($invoice_amt - $open_amt); ?><!--</strong>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="summary-footer">-->
<!--                                <a class="text-muted text-uppercase"></a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </section>-->
<!--        </div>-->
<!--    </div>-->
	<!-- start: page -->
	<div class="row" style="padding-top: 0px;">
		<div class="col-lg-12">
			<section class="card">
				<header class="card-header">
                    <div class="card-actions">
                        <!--  -->
<!--                        <a class="modal-with-form export-excel" id="anchor_export" href="--><?//= base_url()?><!--admin/account/account_export">-->
<!--                            <button type="button" class="mb-1 mt-0 mr-1 btn btn-default" id="btn-export"><i class="fa fa-download"></i>--><?//=$term[exportexcel]?><!--</button>-->
<!--                        </a>-->
                    </div>
					<h2 class="card-title"><?=$term[paymentlist]?></h2>
				</header>
				<div class="card-body">
<!--                    <div class="row" style="margin-bottom: 15px;">-->
<!--                        <div class="col-lg-8">-->
<!---->
<!--                        </div>-->
<!--                        <div class="col-lg-2">-->
<!--                            <select class="form-control" id="filter_status">-->
<!--                                <option value="" selected>--><?//=$term[selectallstatus]?><!--</option>-->
<!--                                <option value="0">--><?//=$term[open]?><!--</option>-->
<!--                                <option value="1">--><?//=$term[paid]?><!--</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="col-lg-2">-->
<!--                            <button type="button" class="btn btn-primary" onclick="filterTable();" style="width: 100%;">--><?//=$term[filtertable]?><!--</button>-->
<!--                        </div>-->
<!--                    </div>-->
					<table class="table table-responsive-md table-hover mb-0" id="datatable_account_list" ></table>
				</div>
			</section>
		</div>
	</div>
<script>
	var $account_table = $('#datatable_account_list');

	function changestatus(id, status)
	{
		$.ajax({
            url: 'account/updatestatus',
            type: 'POST',
            data: {'id': id,'status': status},
            success: function (data, status, xhr) {	
            	$account_table.DataTable().ajax.reload('', false);	             	
            },
            error:function(){
				new PNotify({
                    title: '<?php echo $term['error']; ?>',
                    text: '<?php echo $term['thereissomeissuetryagainlater']; ?>',
					type: 'error'
				});	
			}
        });
	}

//    $.fn.dataTable.ext.search.push(
//        function( settings, data, dataIndex ) {
//            var pay_status = $('#filter_status').val();
//            if (pay_status == '')
//                return true;
//            else if (pay_status == data[8])
//                return true;
//            else
//                return false;
//        }
//    );

    function filterTable() {
        $account_table.DataTable().draw();
    }

	jQuery(document).ready(function() {
	    $('#anchor_export').on('click', function (e) {
            e.preventDefault();

            var selected = $account_table.DataTable().column(0).checkboxes.selected();
            var ids = [];
            $.each(selected, function(index, rowId){
                ids.push(rowId);
            });
            var link = $('#anchor_export').attr('href');
            link += "?ids=" + ids.toString();
            window.location.href = link;
        });

		var tbdata = $account_table.dataTable({
			"ordering": true,
			"info": true,
			"searching": true,

			"ajax": {
	            "type": "POST",
	            "async": true,
				"url": "<?=base_url()?>admin/account/getpaymentlist",
				"data": '',		
				"dataSrc": "data",
				"dataType": "json",
				"cache":    false,
	        },
	        
	        "columnDefs": [
            {
                "targets": [4],
                "createdCell": function (td, cellData, rowData, row, col) {
                    if(cellData == 'training'){
                        $(td).html('ILT Course');
                    } else if(cellData == 'live') {
                        $(td).html('VILT Course');
                    } else if (cellData == 'course'){
                        $(td).html('Demand Course');
                    }else if(cellData == 'plan'){
                        $(td).html('MemeberShip');
                    }else {
                        $(td).html('Book shopping');
                    }
                }
            },
               {
                "targets": [5],
                "createdCell": function (td, cellData, rowData, row, col) {
                    if(cellData != ''){
                        $(td).html(rowData['pay_date']);
                    } else {
                        $(td).html('---');
                    }
                }
            },{
                    "targets": [6],
                    "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).html('<a href="<?=base_url()?>learner/account/invoiceDetail/'+cellData+'"><i class="fa fa-eye"></i></a><span class="w-20"></span><a href="<?=base_url()?>learner/account/export/'+cellData+'" class="delete-row"><i style="color:red" class="fa fa-print"></i></a>');

                    }
            }],
	        "columns": [
                { "title": "<?=$term[title]?>", "data": "title", "class": "text-left", "width":30 },
	        	{ "title": "<?=$term[paymentmethod]?>", "data": "payment_method", "class": "text-left", "width":150 },
				{ "title": "<?=$term[amount]?>", "data": "amount", "class": "text-left", "width":60 },
	        	{ "title": "<?=$term[companyname]?>", "data": "name", "class": "text-left", "width":60 },
                { "title": "<?=$term[paymentreason]?>", "data": "object_type", "class": "text-left", "width":60 },
				{ "title": "<?=$term[paydate]?>", "data": "pay_date", "class": "text-center", "width":60 },
                { "title": "<?=$term[action]?>", "data": "id", "class": "text-center", "width":60 }
			],
			"lengthMenu": [
	            [5, 10, 20, 50, 150, -1],
	            [5, 10, 20, 50, 150, "All"] // change per page values here
	        ],
	        "scrollY": false,
			"scrollX": true,
			"scrollCollapse": false,
			"jQueryUI": true,							
			
			"paging": true,
			"pagingType": "full_numbers",			
	        "pageLength": 150, // default record count per page

			dom: '<"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>p',
			bProcessing: true,

            'select': {
                'style': 'multi'
            }
		});

	});


    function cancelAccount(id){
        (new PNotify({
            title: '<?php echo $term['confirmation']; ?>',
            text: '<?php echo $term['areyousurethatyouwanttodel']; ?>',

            icon: 'fas fa-question',
            confirm: {
                confirm: true
            },
            button: {
                closer: false,
                sticker: false
            },
            addclass: 'stack-modal',
            stack: {
                'dir1': 'down',
                'dir2': 'right',
                'modal':true
            }
        })).get().on('pnotify.confirm', function(){
            $.ajax({
                url: '<?php echo base_url('admin/account/remove_row'); ?>',
                type: 'POST',
                data: {
                    id: id,
                    status: 2   //1 : remove , 2: cancel (set price 0)
                },
                success: function (data, status, xhr) {
                    if(status == "success") {
                        $account_table.DataTable().ajax.reload('', false);
                    } else {
                        new PNotify({
                            title: '<?php echo $term['error']; ?>',
                            text: '<?php echo $term['thereissomeissuetryagainlater']; ?>',
                            type: 'danger'
                        });
                    }
                },
                error: function(){
                    new PNotify({
                        title: '<?php echo $term['error']; ?>',
                        text: '<?php echo $term['thereissomeissuetryagainlater']; ?>',
                        type: 'error'
                    });
                }
            });
        });
    }
    function deleteAccount(id){
        (new PNotify({
            title: "<?php echo $term['confirmation']; ?>",
            text: "<?php echo $term['areyousuretodelete']; ?>",
            icon: 'fas fa-question',
            confirm: {
                confirm: true
            },
            button: {
                closer: false,
                sticker: false
            },
            addclass: 'stack-modal',
            stack: {
                'dir1': 'down',
                'dir2': 'right',
                'modal':true
            }
        })).get().on('pnotify.confirm', function(){
            $.ajax({
                url: '<?php echo base_url('admin/account/remove_row'); ?>',
                type: 'POST',
                data: {
                    id: id,
                    status: 1   //1 : remove , 2: cancel (set price 0)
                },
                success: function (data, status, xhr) {
                    if(status == "success") {
                        $account_table.DataTable().ajax.reload('', false);
                    } else {
                        new PNotify({
                            title: '<?php echo $term['error']; ?>',
                            text: '<?php echo $term['thereissomeissuetryagainlater']; ?>',
                            type: 'danger'
                        });
                    }
                },
                error: function(){
                    new PNotify({
                        title: '<?php echo $term['error']; ?>',
                        text: '<?php echo $term['thereissomeissuetryagainlater']; ?>',
                        type: 'error'
                    });
                }
            });
        });
    }
	</script>
	<!-- end: page -->
</section>
