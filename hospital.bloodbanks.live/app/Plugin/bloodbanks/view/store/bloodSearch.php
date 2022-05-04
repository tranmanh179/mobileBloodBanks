<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/header.php'; ?>

<section role="main" class="content-body" id="fullscreen">
    <header class="page-header">
        <h2>Blood Search</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/"><i class="fa fa-home"></i></a>
                </li>
                <li><span>Blood Search</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
    <section class="panel">
        <ul class="title_p list-inline">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
            <li>Blood Search</li>
        </ul>
        
        <form action="" method="get">
            <div class="panel-body">           
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-md-3 form-group">
                        <label class="col-sm-6 control-label">Type blood <span class="required">*</span>:</label>
                        <div class="col-sm-6">
                            <select name="typeBlood" id="typeBlood" required class="form-control">
                                <option value="">Choice</option>
                                <option value="A+" <?php if(!empty($_GET['typeBlood']) && $_GET['typeBlood']=='A+') echo 'selected';?> >A+</option>
                                <option value="A-" <?php if(!empty($_GET['typeBlood']) && $_GET['typeBlood']=='A-') echo 'selected';?> >A-</option>
                                <option value="B+" <?php if(!empty($_GET['typeBlood']) && $_GET['typeBlood']=='B+') echo 'selected';?> >B+</option>
                                <option value="B-" <?php if(!empty($_GET['typeBlood']) && $_GET['typeBlood']=='B-') echo 'selected';?> >B-</option>
                                <option value="O+" <?php if(!empty($_GET['typeBlood']) && $_GET['typeBlood']=='O+') echo 'selected';?> >O+</option>
                                <option value="O-" <?php if(!empty($_GET['typeBlood']) && $_GET['typeBlood']=='O-') echo 'selected';?> >O-</option>
                                <option value="AB+" <?php if(!empty($_GET['typeBlood']) && $_GET['typeBlood']=='AB+') echo 'selected';?> >AB+</option>
                                <option value="AB-" <?php if(!empty($_GET['typeBlood']) && $_GET['typeBlood']=='AB-') echo 'selected';?> >AB-</option>
                                
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 form-group">
                        <label class="col-sm-6 control-label">Blood count (ml) <span class="required">*</span>:</label>
                        <div class="col-sm-6">
                            <input name="bloodCount" type="number" id="bloodCount" class="form-control" placeholder="" required="" value="<?php echo @$_GET['bloodCount'];?>">
                        </div>
                    </div>

                    <div class="col-md-3 form-group">
                        <label class="col-sm-6 control-label">Distance (km) <span class="required">*</span>:</label>
                        <div class="col-sm-6">
                            <select name="distance" id="distance" required class="form-control">
                                <option value="">Choice</option>
                                <?php 
                                for($i=1;$i<=10;$i++){
                                    $distanceShow= $i*10;
                                    if(!empty($_GET['distance']) && $_GET['distance']==$i){
                                        echo '<option selected value="'.$i.'">'.$distanceShow.'km</option>';
                                    }else{
                                        echo '<option value="'.$i.'">'.$distanceShow.'km</option>';
                                    }
                                }
                                ?>
                                
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
                <?php if(!empty($_GET['typeBlood']) && !empty($_GET['bloodCount'])){ ?>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#store" data-toggle="tab">Blood store</a></li>
                            <li><a href="#other" data-toggle="tab">Other Hospitals</a></li>
                            <li><a href="#donors" data-toggle="tab">Blood donors list</a></li>
                            <li><a href="#donorsMap" data-toggle="tab">Blood donors map</a></li>
                        </ul>
     
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="store"><?php echo @$messStore;?></div>
                            <div class="tab-pane" id="other">
                                <?php echo @$messHospital;?>
                                <?php 
                                if(!empty($listHospital)){
                                    echo '<div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover mb-none" id="">
                                                <thead>
                                                    <tr>
                                                        <th>Number</th>
                                                        <th>Hospital name</th>
                                                        <th>Phone</th>
                                                        <th>Email</th>
                                                        <th>Address</th>
                                                        <th>Exchange</th>
                                                        <th>Call</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                $stt= 0;
                                                foreach ($listHospital as $key => $value) {
                                                    $stt++;
                                                    $typeBlood= str_replace('+', '%2B', $_GET['typeBlood']);
                                                    echo '
                                                        <tr class="gradeX">
                                                            <td align="center">'.$stt.'</td>
                                                            <td>'.$value['Hospital']['name'].'</td>
                                                            <td>'.$value['Hospital']['phone'].'</td>
                                                            <td>'.$value['Hospital']['email'].'</td>
                                                            <td><a target="_blank" href="http://www.google.com/maps/place/'.$value['Hospital']['gps']['x'].','.$value['Hospital']['gps']['y'].'">'.$value['Hospital']['address'].'<a></td>
                                                            
                                                            <td class="actions" align="center">
                                                                <a title="Request" onclick="return confirm(\'Do you want to send this requirement?\')" href="'.$urlHomes . 'requestBloodToHospital?idHospital=' . $value['Hospital']['id'].'&typeBlood='.$typeBlood.'&bloodCount='.$_GET['bloodCount'].'" class="on-default edit-row"><i class="fa fa-exchange"></i></a>
                                                            </td>
                                                            <td class="actions" align="center">
                                                                <a title="Call phone" href="tel:'.$value['Hospital']['phone'].'" class="on-default edit-row"><i class="fa fa-phone"></i></a>
                                                            </td>
                                                        </tr>';
                                                }
                                    echo '      </tbody>
                                            </table>
                                        </div>';
                                }
                                ?>
                            </div>
                            <div class="tab-pane" id="donors">
                                <?php echo @$messUser;?>
                                <?php 
                                if(!empty($listUser)){
                                    echo '<p><a href="javascript:void(0);" onclick="sendnotificationAllUser();" class="btn btn-primary btn-sm"><i class="fa fa-bell-o" aria-hidden="true"></i> Send notification all</a></p>';

                                    echo '<div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover mb-none" id="">
                                                <thead>
                                                    <tr>
                                                        <th>Number</th>
                                                        <th>Full name</th>
                                                        <th>Distance</th>
                                                        <th>Evaluate</th>
                                                        <th>Phone</th>
                                                        <th>Call</th>
                                                        <th>Number donation</th>
                                                        <th>Last donation</th>
                                                        <th>Address</th>
                                                        <th>Notification</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                $stt= 0;
                                                foreach ($listUser as $key => $value) {
                                                    $stt++;
                                                    $evaluate= $value['evaluate'];
                                                    $textEvaluate= '';
                                                    switch ($evaluate) {
                                                        case 1: $textEvaluate= '<span style="color: green;">High</span>';break;
                                                        case 2: $textEvaluate= '<span style="color: green;">High</span>';break;
                                                        case 3: $textEvaluate= '<span style="color: red;">Low</span>';break;
                                                    }

                                                    echo '
                                                        <tr class="gradeX">
                                                            <td align="center">'.$stt.'</td>
                                                            <td>'.$value['infoUser']['User']['fullname'].'</td>
                                                            <td>'.number_format($value['distance']).'km</td>
                                                            <td>'.$textEvaluate.'</td>
                                                            <td>'.$value['infoUser']['User']['phone'].'</td>
                                                            <td class="actions" align="center">
                                                                <a title="Call phone" href="tel:'.$value['infoUser']['User']['phone'].'" class="on-default edit-row"><i class="fa fa-phone"></i></a>
                                                            </td>
                                                            <td>'.number_format($value['numberDonation']).'</td>
                                                            <td>'.date('d/m/Y',$value['lastDonation']).'</td>
                                                            <td>'.$value['infoUser']['User']['address'].'</td>
                                                            <td class="actions" align="center" id="notification-'.$value['infoUser']['User']['id'].'">
                                                                <a title="Send notification" onclick="sendnotification(\''.$value['infoUser']['User']['id'].'\')" href="javascript:void(0);" class="on-default edit-row"><i class="fa fa-bell-o" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>';
                                                }
                                    echo '      </tbody>
                                            </table>
                                        </div>';
                                }
                                ?>
                            </div>
                            <div class="tab-pane" id="donorsMap">
                                <div id="map" style="margin-top: 10px;">
                                    <div id="map_HS" style="height: 500px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </form>
    </section>
    <!-- end: page -->
</section>

<script type="text/javascript">
    function initMap() {
        var locations = [<?php
        if (!empty($listUser)) {
            $listShowMap= array();
            foreach ($listUser as $item) {
                if(empty($item['infoUser']['User']['avatar'])){
                    $item['infoUser']['User']['avatar']= 'http://hospital.bloodbanks.live/app/Plugin/bloodbanks/view/image/no-avatar.png';
                }
                $image = $item['infoUser']['User']['avatar'];
                $content = "";

                $content = $item['infoUser']['User']['fullname'];
                $content.=' - ' . number_format($item['distance']).'km';
                $content.='<br/><b>Phone</b>: ' . $item['infoUser']['User']['phone'];
                $content.='<br/><b>Number donation</b>: ' . number_format($item['numberDonation']);
                $content.='<br/><b>Last donation</b>: ' . date('d/m/Y',$item['lastDonation']);
                $content.='<br/><b>Address</b>: ' . $item['infoUser']['User']['address'];
                $content.='<br/><br/><center id=\'notification-map-'.$item['infoUser']['User']['id'].'\'><a href=\'javascript:void(0);\' onclick=\'sendnotification(`'.$item['infoUser']['User']['id'].'`);\' class=\'btn btn-primary btn-sm\'><i class=\'fa fa-bell-o\' aria-hidden=\'true\'></i> Send notification</a></center><br/>';

                $listShowMap[]= '["' . $content . '", ' . $item['infoUser']['User']['gps']['x'] . ', ' . $item['infoUser']['User']['gps']['y'] . ', "' . $image . '"]';
            }
            $listShowMap[]= '[]';
            echo implode(',', $listShowMap);
        }
        ?>];
        <?php
            echo 'var lat = '.$_SESSION['infoManager']['Hospital']['gps']['x'].';';
            echo 'var log = '.$_SESSION['infoManager']['Hospital']['gps']['y'].';';
        ?>

        var map = new google.maps.Map(document.getElementById('map_HS'), {
            zoom: 10,
            center: new google.maps.LatLng(lat, log),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [
                      {
                        "featureType": "administrative",
                        "elementType": "geometry",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      },
                      {
                        "featureType": "poi",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      },
                      {
                        "featureType": "road",
                        "elementType": "labels.icon",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      },
                      {
                        "featureType": "transit",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      }
                    ]
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;
        i= -1;
        marker = new google.maps.Marker({map: map});

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                //icon: locations[i][3]
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }


        var newPoint = {lat: lat, lng: log};
        marker.setIcon('http://hospital.bloodbanks.live/app/Plugin/bloodbanks/view/image/bloodIcon.png');
        marker.setPosition(newPoint);
        map.setCenter(newPoint);
        i = locations.length;

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent('Your location');
                infowindow.open(map, marker);
            }
        })(marker, i));
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php global $google_key_api;echo $google_key_api;?>&libraries=places&language=vi&region=VI&callback=initMap"
     async defer></script>

<script type="text/javascript">
    var typeBlood= '<?php echo @$_GET['typeBlood'];?>';
    var bloodCount= '<?php echo @$_GET['bloodCount'];?>';

    var allUser= [<?php 
                    if (!empty($listUser)) {
                        $listShowID= array();
                        foreach ($listUser as $item) {
                            $listShowID[]= "'".$item['infoUser']['User']['id']."'";
                        }
                        echo implode(',', $listShowID);
                    }
        ?>];

    function sendnotification(idUser)
    {
        $.ajax({
          method: "POST",
          url: "/sendNotification",
          data: { idUser: idUser, typeBlood: typeBlood, bloodCount: bloodCount }
        })
        .done(function( msg ) {
            $('#notification-'+idUser).html('Sent');
            $('#notification-map-'+idUser).html('Sent');
            console.log(msg);
        });
    }

    function sendnotificationAllUser()
    {
        $.ajax({
          method: "POST",
          url: "/sendNotificationAllUser",
          data: { listUser: JSON.stringify(allUser), typeBlood: typeBlood, bloodCount: bloodCount }
        })
        .done(function( msg ) {
            var n= allUser.length;
            var i;
            for(i=0;i<n;i++){
                $('#notification-'+allUser[i]).html('Sent');
                $('#notification-map-'+allUser[i]).html('Sent');
            }
            
            console.log(msg);
        });
    }
</script>

<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/footer.php'; ?>