<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("select p.*, pt.type, CONCAT(u.first_name, ' ', u.last_name) as fullname from properties p join agents a on p.agent_id = a.id join users u on a.user_id = u.id join property_types pt on p.type_id = pt.id where p.id = '{$_GET['id']}' and p.deleted_date is null");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
        if(isset($id)){
            $image_arry = [];
            $img_qry = $conn->query("SELECT * FROM `property_images` where property_id = '{$_GET['id']}'");
            $image_arry = $img_qry->fetch_array();

            $amenity_arr = [];
            $amentiy_qry = $conn->query("select a.amenity from property_amenities pa join properties p on pa.property_id = p.id join amenities a on pa.amenity_id = a.id where pa.property_id = '{$_GET['id']}'");
            while($row = $amentiy_qry->fetch_assoc()){
                $amenity_arr[] = $row;
            }
        }
        if(isset($agent_id)){
            $agent_det = [];
            $agent = $conn->query("SELECT u.mobile, u.email, u.role, CONCAT(u.first_name,' ', u.last_name) as fullname FROM agents a join users u on a.user_id = u.id where a.id = '{$agent_id}' ");
            $agent_det = $agent->fetch_array();
        }
    }else{
        echo '<script> alert("Unknown Real Estate\'s ID."); location.replace("./?page=real_estate"); </script>';
    }
}else{
    echo '<script> alert("Real Estate\'s ID is required to access the page."); location.replace("./?page=real_estate"); </script>';
}
?>
<style>
    .view-image img{
        width:100%;
        height:10vh;
        object-fit:scale-down;
        object-position: center center;
    }
    .mapouter{position:relative;text-align:right;height:500px;width:100%;}
    .gmap_canvas {overflow:hidden;background:none!important;height:500px;width:100%;}
</style>
<div class="content py-3">
    <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
            <h4 class="card-title">Estate Details</b></h4>
        </div>
        <div class="card-body">
            <div class="row gx-4 gx-lg-5 align-items-top">
                <div class="col-md-6">
                    <img class="card-img-top mb-5 mb-md-0 border border-dark" loading="lazy" id="display-img" src="<?php echo validate_image(isset($image_arry['thumbnail_path']) ? $image_arry['thumbnail_path'] : "") ?>" alt="..." />
                    <div class="mt-2 row gx-2 gx-lg-3 row-cols-4 row-cols-md-3 row-cols-xl-4 justify-content-start">
                        <div class="col">
                            <a href="javascript:void(0)" class="view-image active"><img src="<?php echo validate_image(isset($image_arry['thumbnail_path']) ? $image_arry['thumbnail_path'] : "") ?>" loading="lazy"  class="img-thumbnail bg-gradient-dark" alt=""></a>
                        </div>
                        <?php 
                        if(isset($id)):
                        if(is_dir(base_app."uploads/estate_".$id)):
                        $fileO = scandir(base_app."uploads/estate_".$id);
                            foreach($fileO as $k => $img):
                                if(in_array($img,array('.','..')))
                                    continue;
                        ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bolder border-bottom border-primary pb-1"><?php echo $name ?></h1>
                    <fieldset>
                        <legend class="h4 text-muted">Details</legend>
                        <div class="row">
                            <div class="col-6">
                                <span class="text-muted">Type: </span><?= isset($type) ? $type : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">Purpose: </span><?= isset($purpose) ? $purpose : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">Area: </span><?= isset($area) ? $area : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">Price (CAD): </span><?= isset($price) ? format_num($price) : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">Location: </span><?= $address_line . ' ' . $city . ' ' .  $country . ' ' . $postal_code ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">Status: </span> 
                                <?php if(isset($status) && $status == "Active"): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Available</span>
                                <?php elseif(isset($status) && $status == "Sold"): ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Unavailable</span>
                                <?php else: ?>
                                    <span class="badge badge-warning px-3 rounded-pill">Pending</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </fieldset>
                    <p class="lead"><?php echo stripslashes(html_entity_decode($description)) ?></p>
                    <fieldset>
                        <legend class="h4 text-muted">Amenities</legend>
                        <div class="row">
                        <?php  if(isset($amenity_arr) && count($amenity_arr) > 0): ?>
                            <?php foreach($amenity_arr as $v): ?>
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <span class="badge badge-success text-light rounded mr-2"><i class="fa fa-check"></i></span> <?= $v['amenity'] ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <center><small class="text-mute"><i>No Amenities listed.</i></small></center>
                        <?php endif; ?>
                    </fieldset>
                </div>
            </div>
            <?php if(isset($coordinates)): ?>
            <div class="row">
                <div class="col-md-12">
                    <h4>Map Location</h4>
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe width="100%" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=<?= str_replace(" ","",$coordinates) ?>&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            </br>
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                    <div class="card card-outline card-info rounded-0 shadow">
                        <div class="card-header">
                            <h4 class="cart-title"><b>Agent Details:</b></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- <div class="col-4 text-center">
                                    <img src="<?= validate_image(isset($agent_det['avatar']) ? $agent_det['avatar'] : "") ?>" alt="Agent Image" class="img-fluid img-thumbnail w-100 bg-gradient-gray border" id="agent-avatar">
                                </div> -->
                                <div class="col-8">
                                    <dl>
                                        <dt class="text-muted"><b>Fullname</b></dt>
                                        <dd class="pl-2"><?= isset($agent_det['fullname']) ? $agent_det['fullname'] : "" ?></dd>
                                        <dt class="text-muted"><b>Mobile</b></dt>
                                        <dd class="pl-2"><?= isset($agent_det['mobile']) ? $agent_det['mobile'] : "" ?></dd>
                                        <dt class="text-muted"><b>Email</b></dt>
                                        <dd class="pl-2"><?= isset($agent_det['email']) ? $agent_det['email'] : "" ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

$(function(){
    $('.view-image').click(function(){
        var _img = $(this).find('img').attr('src');
        $('#display-img').attr('src',_img);
        $('.view-image').removeClass("active")
        $(this).addClass("active")
    })
})
</script>