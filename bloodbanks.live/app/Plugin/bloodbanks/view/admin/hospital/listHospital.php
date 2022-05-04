<?php
$breadcrumb = array('name' => 'Hospital',
    'url' => $urlPlugins . 'admin/bloodbanks-view-admin-hospital-listHospital.php',
    'sub' => array('name' => 'List')
);
addBreadcrumbAdmin($breadcrumb);
?>   

<link href="<?php echo $urlHomes . '/app/Plugin/bloodbanks/view/admin/style.css'; ?>" rel="stylesheet">

<div class="thanhcongcu">
    <a href="/plugins/admin/bloodbanks-view-admin-hospital-addHospital.php">
        <div class="congcu">
            <span>
                <input type="image"  src="<?php echo $webRoot; ?>images/add.png" />
            </span>
            <br/>
            Add
        </div>
    </a>

</div>
<div class="clear"></div>

<div class="taovien" >
    <?php if (!empty($mess)) { ?>
        <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
    <?php } ?>
    <p>Link login: <a href="http://hospital.bloodbanks.live" target="_blank">http://hospital.bloodbanks.live</a></p>
    <form action="" method="post" name="listForm">
        <div class="table-responsive">
            <table id="listTable" cellspacing="0" class="tableList">
                <tr>
                    <td align="center">User</td>
                    <td align="center">Name</td>
                    <td align="center">Address</td>
                    <td align="center">Phone</td>
                    <td align="center">Email</td>
                    <td align="center">Status</td>
                    <td align="center"  colspan="2">Action</td>
                </tr>

                <?php
                if (!empty($listData)) {
                    foreach ($listData as $item) {
                        ?>
                        <tr>
                            <td><?php echo @$item['Hospital']['user']; ?> </td>
                            <td><?php echo @$item['Hospital']['name']; ?> </td>
                            <td><?php echo @$item['Hospital']['address']; ?> </td>
                            <td><?php echo @$item['Hospital']['phone']; ?> </td>
                            <td><?php echo @$item['Hospital']['email']; ?> </td>
                            <td><?php echo @$item['Hospital']['status']; ?> </td>
                            <td align="center" width="80" >
                                <a class="btn btn-primary"  href="<?php echo $urlPlugins . 'admin/bloodbanks-view-admin-hospital-addHospital.php?id=' . $item['Hospital']['id']; ?>" >Edit</a>
                            </td>
                            <td align="center" width="80" >
                                <a class="btn btn-danger"  href="<?php echo $urlPlugins . 'admin/bloodbanks-view-admin-hospital-deleteHospital.php?id=' . $item['Hospital']['id']; ?>" onclick="return confirm('Are you sure you want to delete?');" >Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                }else {
                    echo '<tr><td colspan="6" align="center">Data is empty</td></tr>';
                }
                ?>

            </table>
        </div>
    </form>
</div>
