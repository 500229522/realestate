<!-- <?php 
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

            $amenity_ids = [];
            $amentiy_qry = $conn->query("select * from amenities where id in (select amenity_id from property_amenities where property_id = '{$_GET['id']}')");
            while($row = $amentiy_qry->fetch_assoc()){
                $amenity_ids[] = $row['id'];
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
?> -->
<style>
    img#cimg{
		max-height: 20vh;
		width: 100%;
		object-fit: scale-down;
		object-position: center center;
	}
</style>
<div class="card card-outline rounded-0 card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Add New " ?> Estate</h3>
	</div>
	<div class="card-body">
		<form action="" id="property-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="row">
                <div class="col-md-6">
                    <label for="name" class="control-label">Estate Name</label>
                    <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" required value="<?php echo isset($name) ?$name : '' ?>" />
                </div>
                <div class="col-md-6">
                    <label for="type_id" class="control-label">Real Estate Type</label>
                    <select name="type_id" id="type_id" class="form-control form-control-sm rounded-0" required>
                    <option value=""></option>
                    <?php
                        $qry = $conn->query("SELECT * FROM `property_types` where deleted_date is null order by `type` asc");
                        while($row= $qry->fetch_assoc()):
                    ?>
                    <option value="<?php echo $row['id'] ?>" <?php echo isset($type_id) && $type_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['type'] ?></option>
                    <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="purpose" class="control-label">Purpose</label>
                    <select name="purpose" id="purpose" class="form-control form-control-sm rounded-0" required="required">
                        <option>For Sale</option>
                        <option>For Rent</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="area" class="control-label">Area (Sqft)</label>
                    <input type="text" name="area" id="area" class="form-control form-control-sm rounded-0" required value="<?php echo isset($area) ?$area : '' ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="price" class="control-label">Price (CAD)</label>
                    <input type="text" name="price" id="price" class="form-control form-control-sm rounded-0" required value="<?php echo isset($price) ? $price : '' ?>" />
                </div>
                <div class="col-md-6">
                    <label for="amenity_ids" class="control-label">Amenities</label>
                    <select name="amenity_ids[]" id="amenity_ids" class="form-control form-control-sm -rounded-0 select2" multiple required>
                        <option value=""></option>
                        <?php
                            $qry = $conn->query("SELECT * FROM `amenities` where deleted_date is null ".(isset($id) ? " or id = '{$row['id']}' ": "")." order by `amenity` asc");
                            while($row= $qry->fetch_assoc()):
                        ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($row['id']) && isset($amenity_ids) && in_array($row['id'],$amenity_ids) ? 'selected' : '' ?>><?php echo $row['amenity'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="address_line" class="control-label">Address<sup></sup></label>
                    <input name="address_line" id="address_line" class="form-control form-control-sm rounded-0" value="<?=isset($address_line) ? $address_line : "" ?>"></input>
                </div>
                <div class="col-md-6">
                    <label for="city" class="control-label">City<sup></sup></label>
                    <input name="city" id="city" class="form-control form-control-sm rounded-0" value="<?=isset($city) ? $city : "" ?>"></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="postal_code" class="control-label">Postal Code<sup></sup></label>
                    <input name="postal_code" id="postal_code" class="form-control form-control-sm rounded-0" value="<?=isset($postal_code) ? $postal_code : "" ?>"></input>
                </div>
                <div class="col-md-6">
                    <label for="country" class="control-label">Country<sup></sup></label>
                    <input name="country" id="country" class="form-control form-control-sm rounded-0" value="<?=isset($country) ? $country : "" ?>"></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="coordinates" class="control-label">Map Coordinates</label>
                    <input name="coordinates" id="coordinates" class="form-control form-control-sm rounded-0" required value="<?php echo isset($coordinates) ?$coordinates : '' ?>" />
                </div>
                <div class="col-md-6">
                    <label for="status" class="control-label">Status</label>
                    <select name="status" id="status" class="form-control form-control-sm rounded-0">
                        <option value="Active" <?php echo isset($status) && $status == "Active" ? 'selected' : '' ?>>Active</option>
                        <option value="Pending" <?php echo isset($status) && $status == "Pending" ? 'selected' : '' ?>>Pending</option>
                        <option value="Sold" <?php echo isset($status) && $status == "Sold" ? 'selected' : '' ?>>Sold</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
				<label for="description" class="control-label">Description</label>
                <textarea name="description" id="" cols="5" rows="2" class="form-control form no-resize summernote"><?php echo isset($description) ? $description : ''; ?></textarea>
			</div>

            <div class="row">
                <div class="col-md-6">
                    <label for="" class="control-label">Thumbnail</label>
                    <div class="custom-file custom-file-sm rounded-0">
                        <input type="hidden" name="thumbnail_path" value="<?= isset($image_arry['thumbnail_path']) ? $image_arry['thumbnail_path'] : "" ?>">
                        <input type="file" class="custom-file-input rounded-0 form-control-sm" id="customFile" name="img" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg">
                        <label class="custom-file-label rounded-0" for="customFile">Choose file</label>
                    </div>
                    <div class="text-center">
                        <img src="<?php echo validate_image(isset($image_arry['thumbnail_path']) ? $image_arry['thumbnail_path'] : "") ?>" alt="" id="cimg" class="img-fluid img-thumbnail bg-gradient-gray">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="" class="control-label">Other Images</label>
                    <div class="custom-file">
                    <input type="file" class="custom-file-input rounded-circle" id="customFile" name="imgs[]" multiple accept="image/png, image/jpeg" onchange="displayImg2(this,$(this))">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <div class="row my-3">
                    <?php 
                    if(isset($id)):
                    $upload_path = "uploads/estate_".$id;
                    if(is_dir(base_app.$upload_path)): 
                    ?>
                    <?php 
                    
                        $file= scandir(base_app.$upload_path);
                        foreach($file as $img):
                            if(in_array($img,array('.','..')))
                                continue;
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="d-flex align-items-center img-item w-100">
                            <span><img src="<?php echo base_url.$upload_path.'/'.$img ?>" width="150px" height="100px" style="object-fit:cover;" class="img-thumbnail" alt=""></span>
                            <span class="ml-4"><button class="btn btn-sm btn-default text-danger rem_img" type="button" data-path="<?php echo base_app.$upload_path.'/'.$img ?>"><i class="fa fa-trash"></i></button></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="property-form"><?php echo isset($id) ? "Update ": "Save" ?></button>
		<a class="btn btn-flat btn-default" href="?page=dashboard">Cancel</a>
	</div>
</div>
<script>
     function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('label', input.files[0].name);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
			$('#cimg').attr('src', "<?php echo validate_image('') ?>");
            _this.siblings('label','Choose File');
		}
	}
    function displayImg2(input,_this) {
        console.log(input.files)
        var fnames = []
        Object.keys(input.files).map(k=>{
            fnames.push(input.files[k].name)
        })
        _this.siblings('.custom-file-label').html(fnames.join(", "))
	    
	}
    function delete_img($path){
        start_loader()
        
        $.ajax({
            url: _base_url_+'classes/property.php?f=delete_img',
            data:{path:$path},
            method:'POST',
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occured while deleting an Image","error");
                end_loader()
            },
            success:function(resp){
                $('.modal').modal('hide')
                if(typeof resp =='object' && resp.status == 'success'){
                    $('[data-path="'+$path+'"]').closest('.img-item').hide('slow',function(){
                        $('[data-path="'+$path+'"]').closest('.img-item').remove()
                    })
                    alert_toast("Image Successfully Deleted","success");
                }else{
                    console.log(resp)
                    alert_toast("An error occured while deleting an Image","error");
                }
                end_loader()
            }
        })
    }
	$(document).ready(function(){
        $('.rem_img').click(function(){
            _conf("Are sure to delete this image permanently?",'delete_img',["'"+$(this).attr('data-path')+"'"])
        })
       
        $('.select2').select2({placeholder:"Please Select here",width:"relative"})
        if(parseInt("<?php echo isset($category_id) ? $category_id : 0 ?>") > 0){
            console.log('test')
            start_loader()
            setTimeout(() => {
                $('#category_id').trigger("change");
                end_loader()
            }, 750);
        }
		$('#property-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/property.php?f=save",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=property_list";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            if(!!resp.id)
                            $('[name="id"]').val(resp.id)
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        $('.summernote').summernote({
		        height: 100,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'codeview', 'help' ] ]
		        ]
		    })
	})
</script>