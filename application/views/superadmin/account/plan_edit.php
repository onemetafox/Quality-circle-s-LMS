<section role="main" class="content-body">
    <header class="page-header">
        <h2><?=$term[companymanagement]?></h2>
        <div class="right-wrapper">

        </div>
    </header>
    <input type="hidden" id="base_url" value="<?= base_url()?>">
    <!-- start: page -->
    <div class="row">
        <div class="col-lg-12">

                <form id="add-form" action="<?= base_url()?>superadmin/company" method="POST" novalidate="novalidate" enctype="multipart/form-data">
                    <section class="card">
                        <header class="card-header">
                            <div class="card-actions">
                                <a class="btn btn-default" href="<?= base_url()?>superadmin/account/subscription"><i class="fas fa-table"></i> <?=$term[subscriptionlist]?></a>
                            </div>
                            <h2 class="card-title"><?=$term[form]?></h2>
                        </header>
                        <div class="card-body">
                            <input type="hidden" name="id" id="id" value="<?php print $id?>">
                            <div class="form-group row">
                                <label class="col-sm-2 control-label text-sm-right pt-2"><?=$term[name]?><span class="required">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" value="<?php print $name ?>" id="name" name="name" class="form-control" placeholder="subscription name"required>

                                </div>
                                <?php if($price_type == 0):?>
                                <label class="col-sm-2 control-label text-sm-right pt-2"><?=$term[price]?><span class="required">*</span></label>
                                <div class="col-sm-4">
                                    <input type="number" value="<?php print $price ?>" id="price" name="price" class="form-control" placeholder="company name" min="0" required>
                                </div>
                                <?php endif;?>
                            </div>
                            <?php if($price_type != 2):?>
                            <div class="form-group row">
                                <label class="col-sm-2 control-label text-sm-right pt-2"><?=$term[user].' '.$term[limit] ?><span class="required">*</span></label>
                                <div class="col-sm-4">
                                    <input type="number" value="<?php print $user_limit ?>" id="user_limit" name="user_limit" class="form-control" min="0" required>
                                </div>
                                <label class="col-sm-2 control-label text-sm-right pt-2"><?=$term[library].' '.$term[limit] ?><span class="required">*</span></label>
                                <div class="col-sm-4">
                                    <input type="number" value="<?php print $library_limit ?>" id="library_limit" name="library_limit" class="form-control" min="0" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 control-label text-sm-right pt-2"><?=$term[ondemand].' '.$term[limit] ?><span class="required">*</span></label>
                                <div class="col-sm-4">
                                    <input type="number" value="<?php print $demand_limit ?>" id="demand_limit" name="demand_limit" class="form-control" min="0" required>
                                </div>
                                <label class="col-sm-2 control-label text-sm-right pt-2"><?=$term[viltroom].' '.$term[user].' '.$term[limit] ?><span class="required">*</span></label>
                                <div class="col-sm-4">
                                    <input type="number" value="<?php print $vilt_user_limit ?>" id="vilt_user_limit" name="vilt_user_limit" class="form-control" min="0" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 control-label text-sm-right pt-2"><?=$term[viltroom].' '.$term[limit] ?><span class="required">*</span></label>
                                <div class="col-sm-4">
                                    <input type="number" value="<?php print $vilt_room_limit ?>" id="vilt_room_limit" name="vilt_room_limit" class="form-control" min="0" required>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>
                        <footer class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a id="sendBtn" data-loading-overlay="" data-loading-overlay-options="{ 'startShowing': false }"  class="btn btn-primary modal-add-confirm" style="color:white; padding-left: 20px;padding-right: 20px;"><?php print $term[update]?></a>
                                    <button type="reset" class="btn btn-default"><?=$term[reset]?></button>
                                </div>
                            </div>
                        </footer>
                    </section>
                </form>

        </div>
    </div>
    
    <!-- end: page -->
</section>

<script>

    jQuery(document).ready(function() {

        $('[data-plugin-ios-switch]').each(function () {
            var $this = $(this);

            $this.themePluginIOS7Switch();
        });
    });


    $(document).on('click', '.modal-add-confirm', function (e) {
        e.preventDefault();
        var frm = $('#add-form');
        frm.validate({
            highlight: function( label ) {
                $(label).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function( label ) {
                $(label).closest('.form-group').removeClass('has-error');
                label.remove();

            },
            errorPlacement: function( error, element ) {
                var placement = element.closest('.input-group');
                if (!placement.get(0)) {
                    placement = element;
                }
                if (error.text() !== '') {
                    placement.after(error);
                }
            }
        });

        if(frm.valid()) {
            send_action(frm);
        }

    });

    function send_action(frm){
        var formData = new FormData($('#add-form')[0]);
        $("#sendBtn").trigger('loading-overlay:show');
        $.ajax({
            url: $('#base_url').val()+'superadmin/account/subscription_save',
            type: 'POST',
            data: formData,
            processData:false,
            contentType: false,
            success: function (data, status, xhr) {
                $("#sendBtn").trigger('loading-overlay:hide');
                new PNotify({
                    title: '<?php echo $term['success']; ?>',
                    text: '<?php echo $term['succesfullyupdated']; ?>',
                    type: 'success'
                });
                location.reload();
            },
            error: function(){
                $("#sendBtn").trigger('loading-overlay:hide');
                new PNotify({
                    title: '<?php echo $term['error']; ?>',
                    text: '<?php echo $term['thereissomeissuetryagainlater']; ?>',
                    type: 'error'
                });
            }
        });
    }
</script>