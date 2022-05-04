
<?php
	$breadcrumb= array( 'name'=>$languageMantan['album'],
						'url'=>$urlAlbums.'listAlbums',
						'sub'=>array('name'=>$languageMantan['image'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>    
	<script type="text/javascript">
		var urlWeb="<?php echo $urlAlbums;?>";
		var urlNow="<?php echo $urlNow;?>";
		
		function deleteData(idAlbum,idIMG)
		{
			  var r= confirm("<?php echo $languageMantan['areYouSureYouWantToRemove'];?>");
			  if(r==true)
			  {
			      $.ajax({
				      type: "POST",
				      url: urlWeb+"deleteImgAlbum",
				      data: { idAlbum:idAlbum,idIMG:idIMG}
				    }).done(function( msg ) { 	
					  		window.location= urlNow;	
					 })
					 .fail(function() {
							window.location= urlNow;
						});  
			  }    
		}
		
		function editImage(idIMG,idAlbum,link)
		{
			var src= document.getElementById("images"+idIMG).src;
			var alt= document.getElementById("alt"+idIMG).innerHTML;
			var title= document.getElementById("title"+idIMG).innerHTML;
			var description= document.getElementById("description"+idIMG).innerHTML;
			
			document.getElementById("image").value= src;
			document.getElementById("note").value= alt;
			document.getElementById("idIMG").value= idIMG;
			document.getElementById("link").value= link;
			document.getElementById("title").value= title;
			document.getElementById("description").value= description;
			
			window.scrollTo(500,0);
		}
	</script>
	
	  <div class="clear"></div>
	  <div id="content">
	    <div class="taovienLimit" >
	        <table width="100%" cellspacing="0" class="table">
	            <tr>
	                <td width="100"><?php echo $languageMantan['nameAlbum'];?>:</td>
	                <td width="646"><?php echo $albums['Album']['title'];?></td>
	            </tr>
	            <tr>
	                <td width="100"><?php echo $languageMantan['datePosted'];?>:</td>
	                <td width="646">
		                <?php
			                $today= getdate($albums['Album']['time']);
			                echo $today['mday'].'/'.$today['mon'].'/'.$today['year'];
		                ?>
	                </td>
	            </tr>
	            <tr>
	                <td width="100"><?php echo $languageMantan['status'];?>:</td>
	                <td width="646">
		                <?php
			                if($albums['Album']['lock']==0)
			                {
				                echo $languageMantan['activate'];
			                }
			                else
			                {
				                echo $languageMantan['lock'];
			                }
		                ?>
	                </td>
	            </tr>
	            <tr>
	                <td><?php echo $languageMantan['keyWord'];?>:</td>
	                <td><?php echo $albums['Album']['key'];?></td>
	            </tr>
	        </table>
	     </div>
	     <div class="clear"></div>
	     <div style="padding-left: 10px;padding-top: 15px;" id="gallery">
	        <form action="<?php echo $urlAlbums;?>saveImgAlbum" method="post" name="dangtin" class="" >
	            <input type="hidden" value="<?php echo $albums['Album']['id'];?>" name="id" />
	            <input type="hidden" value="" name="idIMG" id="idIMG" />
	            <table class="table table-striped">
		            <tr>
			            <td width="100"><?php echo $languageMantan['image'];?> </td>
			            <td><?php showUploadFile('image','image',@$news['Album']['image']);?></td>
		            </tr>
					<tr>
			            <td><?php echo $languageMantan['title'];?></td>
			            <td><input type="text" name="title" id='title' value="" class="form-control" /></td>
		            </tr>
					<tr>
			            <td><?php echo $languageMantan['description'];?></td>
			            <td>
                            <textarea name="description" id='description' value="" class="form-control" cols="30" rows="7"></textarea>
                        </td>
		            </tr>
		            <tr>
			            <td><?php echo $languageMantan['information'];?></td>
			            <td>
                            <textarea name="note" id='note' value="" class="form-control" cols="30" rows="7"></textarea>
                        </td>
		            </tr>
		            <tr>
			            <td><?php echo $languageMantan['link'];?></td>
			            <td><input type="text" name="link" id='link' value="" class="form-control" /></td>
		            </tr>
		            <tr>
			            <td colspan="2">
				            <input type="submit" class="btn btn-default" value="<?php echo $languageMantan['save'];?>" />
			            </td>
		            </tr>
	            </table>
	        </form>
	        <div class="clear"></div>
	        <br /><br />
	        <?php if(isset($albums['Album']['img']) && count($albums['Album']['img'])>0){ ?>
		        <form action="" method="post" name="xoaIMG" class="taovienLimit" >
		            <input type="hidden" value="<?php echo $albums['Album']['id'];?>" name="id" />
		            <table class="table table-striped">
			            <tr>
				            <td><?php echo $languageMantan['ilustration']?></td>
							<td><?php echo $languageMantan['title']?></td>
							<td><?php echo $languageMantan['description']?></td>
				            <td><?php echo $languageMantan['information']?></td>
				            <td width="165"><?php echo $languageMantan['choose']?></td>
			            </tr>
			            <?php
			                $dem= -1;
			                foreach($albums['Album']['img'] as $img)
			                { $dem++; ?>
			                	<tr>
				                	<td>
					                	<img width="100" id="images<?php echo $dem;?>" src="<?php echo @$img['src'];?>">
				                	</td>
									<td>
					                	<p id="title<?php echo $dem;?>"><?php echo @$img['title'];?></p>
				                	</td>
									<td>
					                	<p id="description<?php echo $dem;?>"><?php echo @nl2br($img['description']);?></p>
				                	</td>
				                	<td>
					                	<p id="alt<?php echo $dem;?>"><?php echo @nl2br($img['alt']);?></p>
				                	</td>
				                	<td>
					                	 <span class="btn btn-default" onclick="editImage(<?php echo $dem;?>,'<?php echo $albums['Album']['id'];?>','<?php echo @$img['link'];?>');"><?php echo $languageMantan['edit'];?></span>
			                      	 &nbsp;
				                      	 <span class="btn btn-default" onclick="deleteData('<?php echo $albums['Album']['id'];?>',<?php echo $dem;?>);"><?php echo $languageMantan['delete'];?></span>
				                	</td>
			                	</tr>
			                <?php }
			            ?>
		            </table>
		        </form>
	        <?php }?>
	     </div>
	
	
	    </div>
	    <div id="themDanhsach"></div>
</div>
  