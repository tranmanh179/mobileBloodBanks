<link href="<?php echo $urlHomes . '/app/Plugin/bloodbanks/view/admin/style.css'; ?>" rel="stylesheet">

<?php
$breadcrumb = array('name' => 'User',
    'url' => $urlPlugins . 'admin/bloodbanks-view-admin-user-listUser.php',
    'sub' => array('name' => 'Change password')
);
addBreadcrumbAdmin($breadcrumb);
?>   

<div class="taovien row">
    <?php if (!empty($mess)) { ?>
        <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
    <?php } ?>
    <form action="" method="post" name="">
        <div class="taovien col-md-12 col-sm-12 col-xs-12" >
            <div class="form-group">
                <label>Old password (*)</label>
                <input type="text" name="passOld" class="form-control" id="" value="" autocomplete="off" >
            </div>

            <div class="form-group">
                <label>New password (*)</label>
                <input type="text" name="passNew" class="form-control" id="" value="" autocomplete="off" >
            </div>

            <div class="form-group">
                <label>Re-entered new password (*)</label>
                <input type="text" name="passNewAgain" class="form-control" id="" value="" autocomplete="off" >
            </div>
            
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

