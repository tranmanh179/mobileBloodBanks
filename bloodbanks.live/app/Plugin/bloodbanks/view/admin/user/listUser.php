<?php
$breadcrumb = array('name' => 'User',
    'url' => $urlPlugins . 'admin/bloodbanks-view-admin-user-listUser.php',
    'sub' => array('name' => 'List')
);
addBreadcrumbAdmin($breadcrumb);
?>   

<link href="<?php echo $urlHomes . '/app/Plugin/bloodbanks/view/admin/style.css'; ?>" rel="stylesheet">

<div class="clear"></div>

<div class="taovien" >
    <?php if (!empty($mess)) { ?>
        <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
    <?php } ?>
    <form action="" method="post" name="listForm">
        <div class="table-responsive">
            <table id="listTable" cellspacing="0" class="tableList">
                <tr>
                    <td align="center">Full name</td>
                    <td align="center">Phone</td>
                    <td align="center">Email</td>
                    <td align="center">Status</td>
                    <td align="center" colspan="2">Action</td>
                </tr>

                <?php
                if (!empty($listData)) {
                    foreach ($listData as $item) {
                        ?>
                        <tr>
                            <td><?php echo @$item['User']['fullname']; ?> </td>
                            <td><?php echo @$item['User']['phone']; ?> </td>
                            <td><?php echo @$item['User']['email']; ?> </td>
                            <td><?php echo @$item['User']['status']; ?> </td>
                            <td align="center" width="80" >
                                <a class="btn btn-primary"  href="<?php echo $urlPlugins . 'admin/bloodbanks-view-admin-user-changePassUser.php?id=' . $item['User']['id']; ?>" >Change pass</a>
                            </td>
                            <td align="center" width="80" >
                                <?php 
                                if($item['User']['status']=='active'){
                                    echo '<a class="btn btn-danger"  href="'.$urlPlugins . 'admin/bloodbanks-view-admin-hospital-changeStatusUser.php?id=' . $item['User']['id'].'&status=lock" onclick="return confirm(\'Do you want to change it?\');" >Lock</a>';
                                }else{
                                    echo '<a class="btn btn-primary"  href="'.$urlPlugins . 'admin/bloodbanks-view-admin-hospital-changeStatusUser.php?id=' . $item['User']['id'].'&status=active" onclick="return confirm(\'Do you want to change it?\');" >Active</a>';
                                }
                                ?>
                                
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
