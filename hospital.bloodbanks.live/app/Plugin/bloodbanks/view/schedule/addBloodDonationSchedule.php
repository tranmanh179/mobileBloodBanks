<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/header.php'; ?>

<section role="main" class="content-body" id="fullscreen">
    <header class="page-header">
        <h2>Add Blood Donation Schedule</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/"><i class="fa fa-home"></i></a>
                </li>
                <li><span>Add Blood Donation Schedule</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
    <section class="panel">
        <ul class="title_p list-inline">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
            <li>Add Blood Donation Schedule</li>
        </ul>
        
        <form action="" method="post">
            <div class="panel-body">           
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Day event <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <input name="time" class="form-control datepicker" placeholder="date/month/year" required="" value="<?php echo @$save['Schedule']['time'];?>">
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Title <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <input name="title" class="form-control" placeholder="" required="" value="<?php echo @$save['Schedule']['title'];?>">
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Image <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <?php                    
                                showUploadFile('image','image',@$save['Schedule']['image'],0);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Description <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <textarea name="description" rows="5" class="form-control" placeholder=""><?php echo @$save['Schedule']['description'];?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Content <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <?php
                                showEditorInput('content','content',@$save['Schedule']['content'],1);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="panel-footer">
                <div class="row">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </footer>
        </form>
    </section>
    <!-- end: page -->
</section>

<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/footer.php'; ?>