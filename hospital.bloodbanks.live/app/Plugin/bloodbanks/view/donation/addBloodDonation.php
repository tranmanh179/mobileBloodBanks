<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/header.php'; ?>

<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

<section role="main" class="content-body" id="fullscreen">
    <header class="page-header">
        <h2>Add Blood Donation</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/"><i class="fa fa-home"></i></a>
                </li>
                <li><span>Add Blood Donation</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
    <section class="panel">
        <ul class="title_p list-inline">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
            <li>Add Blood Donation</li>
        </ul>
        
        <form action="" method="post">
            <input type="hidden" name="idUser" id="idUser" value="<?php echo @$save['Donation']['idUser'];?>">
            <div class="panel-body">           
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Image <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <?php                    
                                showUploadFile('image','image',@$save['Donation']['image'],0);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Date blood donation<span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <input name="dateBloodDonation" class="form-control datepicker" placeholder="date/month/year" required="" value="<?php echo @$save['Donation']['dateBloodDonation'];?>">
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Identify card <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <input name="identifyCard" id="identifyCard" class="form-control" placeholder="" required="" value="<?php echo @$save['Donation']['identifyCard'];?>">
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Phone :</label>
                        <div class="col-sm-9">
                            <input name="phone" id="phone" class="form-control" placeholder="" required="" value="<?php echo @$save['Donation']['phone'];?>">
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Fullname <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <input name="fullname" id="fullname" class="form-control" placeholder="" required="" value="<?php echo @$save['Donation']['fullname'];?>">
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Birthday <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <input name="birthday" id="birthday" class="form-control datepicker" placeholder="date/month/year" required="" value="<?php echo @$save['Donation']['birthday'];?>">
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Address <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <input name="address" id="address" class="form-control" placeholder="" required="" value="<?php echo @$save['Donation']['address'];?>">
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Type blood <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <select name="typeBlood" id="typeBlood" required class="form-control">
                                <option value="">Choice</option>
                                <option value="A+" <?php if(!empty($save['Donation']['typeBlood']) && $save['Donation']['typeBlood']=='A+') echo 'selected';?> >A+</option>
                                <option value="A-" <?php if(!empty($save['Donation']['typeBlood']) && $save['Donation']['typeBlood']=='A-') echo 'selected';?> >A-</option>
                                <option value="B+" <?php if(!empty($save['Donation']['typeBlood']) && $save['Donation']['typeBlood']=='B+') echo 'selected';?> >B+</option>
                                <option value="B-" <?php if(!empty($save['Donation']['typeBlood']) && $save['Donation']['typeBlood']=='B-') echo 'selected';?> >B-</option>
                                <option value="O+" <?php if(!empty($save['Donation']['typeBlood']) && $save['Donation']['typeBlood']=='O+') echo 'selected';?> >O+</option>
                                <option value="O-" <?php if(!empty($save['Donation']['typeBlood']) && $save['Donation']['typeBlood']=='O-') echo 'selected';?> >O-</option>
                                <option value="AB+" <?php if(!empty($save['Donation']['typeBlood']) && $save['Donation']['typeBlood']=='AB+') echo 'selected';?> >AB+</option>
                                <option value="AB-" <?php if(!empty($save['Donation']['typeBlood']) && $save['Donation']['typeBlood']=='AB-') echo 'selected';?> >AB-</option>
                                
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Blood count <span class="required">*</span>:</label>
                        <div class="col-sm-9">
                            <select name="bloodCount" required class="form-control">
                                <option value="">Choice</option>
                                <option value="250" <?php if(!empty($save['Donation']['bloodCount']) && $save['Donation']['bloodCount']==250) echo 'selected';?> >250ml</option>
                                <option value="350" <?php if(!empty($save['Donation']['bloodCount']) && $save['Donation']['bloodCount']==350) echo 'selected';?> >350ml</option>
                                <option value="450" <?php if(!empty($save['Donation']['bloodCount']) && $save['Donation']['bloodCount']==450) echo 'selected';?> >450ml</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="col-sm-3 control-label">Blood donation event :</label>
                        <div class="col-sm-9">
                            <select name="idSchedule" class="form-control">
                                <option value="">Choice</option>
                                <?php 
                                if(!empty($listAllSchedule)){
                                    foreach($listAllSchedule as $item){
                                        if((!empty($save['Donation']['idSchedule']) && $save['Donation']['idSchedule']==$item['Schedule']['id']) || (!empty($_SESSION['idScheduleChoice']) && $item['Schedule']['id']==$_SESSION['idScheduleChoice']) ){
                                            echo '<option selected value="'.$item['Schedule']['id'].'">'.$item['Schedule']['title'].'</option>';
                                        }else{
                                            echo '<option value="'.$item['Schedule']['id'].'">'.$item['Schedule']['title'].'</option>';
                                        }
                                        
                                    }
                                }
                                ?>
                            </select>
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

<script type="text/javascript">
    $(function() {
        function split( val ) {
          return val.split( /,\s*/ );
        }

        function extractLast( term ) {
          return split( term ).pop();
        }


        $( "#identifyCard" )
        // don't navigate away from the field on tab when selecting an item
        .bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            source: function( request, response ) {
                $.getJSON( "/getUserAPI", {
                    term: extractLast( request.term ),
                    value:'id',
                    field: 'identifyCard'
                }, response );
            },
            search: function() {
                // custom minLength
                var term = extractLast( this.value );
                if ( term.length < 2 ) {
                    return false;
                }
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
                var terms = split( this.value );
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push( ui.item.label );
               
                $('#identifyCard').val(ui.item.identifyCard);  
                $('#phone').val(ui.item.phone);  
                $('#fullname').val(ui.item.fullname);  
                $('#birthday').val(ui.item.birthday);  
                $('#address').val(ui.item.address);  
                $('#typeBlood').val(ui.item.typeBlood);  
          
                return false;
            }
        });


        $( "#phone" )
        // don't navigate away from the field on tab when selecting an item
        .bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            source: function( request, response ) {
                $.getJSON( "/getUserAPI", {
                    term: extractLast( request.term ),
                    value:'id',
                    field: 'phone'
                }, response );
            },
            search: function() {
                // custom minLength
                var term = extractLast( this.value );
                if ( term.length < 2 ) {
                    return false;
                }
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
                //console.log(ui);
                var terms = split( this.value );
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push( ui.item.label );
               
                $('#identifyCard').val(ui.item.identifyCard);  
                $('#phone').val(ui.item.phone);  
                $('#fullname').val(ui.item.fullname);  
                $('#birthday').val(ui.item.birthday);  
                $('#address').val(ui.item.address);  
                $('#typeBlood').val(ui.item.typeBlood);  
                
                return false;
            }
        });
    });
</script>

<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/footer.php'; ?>