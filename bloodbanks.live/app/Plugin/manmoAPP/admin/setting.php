<style>
.tableList{
	width: 100%;
	margin-bottom: 20px;
	border-collapse: collapse;
    border-spacing: 0;
    border-top: 1px solid #bcbcbc;
    border-left: 1px solid #bcbcbc;
}
.tableList td{
	padding: 5px;
	border-bottom: 1px solid #bcbcbc;
    border-right: 1px solid #bcbcbc;
}
</style>
<?php
	$breadcrumb= array( 'name'=>'ManMo APP',
						'url'=>$urlPlugins.'theme/manmoAPP-admin-setting.php',
						'sub'=>array('name'=>'Cài đặt')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
<script type="text/javascript">
	
	function save()
	{
	    document.listForm.submit();
	}
</script>
<div class="thanhcongcu">

    <div class="congcu" onclick="save();">
        <input type="hidden" id="idChange" value="" />
        <span id="save">
            <input type="image" src="<?php echo $webRoot;?>images/save.png" />
        </span>
        <br/>
        <?php echo $languageMantan['save'];?>
    </div>
</div>

<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
	<?php
		echo $mess;
	?>
</div>
	
<div class="taovien">
    <form action="" method="post" name="listForm">
    	<table class="tableList">
    	<?php
    		

            echo '
                <tr>
                    <td>
                        <p><b>ID slide khuyến mại</b></p>
                        <input type="text" name="idSlideDiscount" value="'.@$data['Option']['value']['idSlideDiscount'].'" />
                        
                    </td>
                    <td>
                        <p><b>ID bài giới thiệu</b></p>
                        <input type="text" name="idNoticeIntroduce" value="'.@$data['Option']['value']['idNoticeIntroduce'].'" />
                        
                    </td>
                    <td>
                        <p><b>ID chuyên mục Mần Mò Blog</b></p>
                        <input type="text" name="idCategoryBlog" value="'.@$data['Option']['value']['idCategoryBlog'].'" />
                        
                    </td>

                    <td>
                        <p><b>ID chuyên mục tin khuyến mại</b></p>
                        <input type="text" name="idCategoryDiscount" value="'.@$data['Option']['value']['idCategoryDiscount'].'" />
                        
                    </td>
                </tr>

                
                ';
    	?>
    		
    	</table>


    </form>
</div>
