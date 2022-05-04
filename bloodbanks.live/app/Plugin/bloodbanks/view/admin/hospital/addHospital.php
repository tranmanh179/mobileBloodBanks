<link href="<?php echo $urlHomes . '/app/Plugin/bloodbanks/view/admin/style.css'; ?>" rel="stylesheet">

<?php
$breadcrumb = array('name' => 'Hospital',
    'url' => $urlPlugins . 'admin/bloodbanks-view-admin-hospital-listHospital.php',
    'sub' => array('name' => 'Add')
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
                <label>Account login (*)</label>
                <input type="text" name="user" class="form-control" id="user" required="" value="<?php echo @$data['Hospital']['user'];?>" >
            </div>
            <div class="form-group">
                <label>Password (*)</label>
                <input type="text" name="password" class="form-control" id="" value="" autocomplete="off" >
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="active" <?php if(!empty($data['Hospital']['status']) && $data['Hospital']['status']=='active') echo 'selected';?> >Active</option>
                    <option value="lock" <?php if(!empty($data['Hospital']['status']) && $data['Hospital']['status']=='lock') echo 'selected';?> >Lock</option>
                </select>
            </div>

            <div class="form-group">
                <label>Hospital name (*)</label>
                <input type="text" name="name" class="form-control" id="name" required="" value="<?php echo @$data['Hospital']['name'];?>">
            </div>
            <div class="form-group">
                <label>Address (*)</label>
                <input type="text" name="address" class="form-control" id="address" required="" value="<?php echo @$data['Hospital']['address'];?>">
            </div>
            <div class="form-group">
                <label>GPS coordinates (*)</label>
                <input type="text" name="gps" class="form-control" id="gps" required="" value="<?php if(!empty($data['Hospital']['gps']) ) echo implode(',', $data['Hospital']['gps']) ;?>">
            </div>
            <div class="form-group">
                <label>Email (*) </label>
                <input type="email" name="email" class="form-control" id="email" required="" value="<?php echo @$data['Hospital']['email'];?>">
            </div>

            <div class="form-group">
                <label>Phone (*)</label>
                <input type="text" name="phone" class="form-control" id="phone" required="" value="<?php echo @$data['Hospital']['phone'];?>">
            </div>

            <div class="form-group">
                <label>Avatar</label>
                <br>
                <?php showUploadFile('avatar', 'avatar', @$data['Hospital']['avatar']); ?>
            </div>
            
            
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

