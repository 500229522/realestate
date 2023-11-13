<?php 
$buyer = $conn->query("SELECT * FROM users where id ='".$_settings->userdata('id')."'");
foreach($buyer->fetch_array() as $k =>$v){
	if(!is_numeric($k))
		$$k = $v;
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="buyer-profile">	
				<input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6">
						<label for="firstname" class="control-label">First Name <sup>*</sup></label>
						<input type="text" name="first_name" id="first_name" class="form-control form-control-sm rounded-0" required="required" value="<?=isset($first_name) ? $first_name : "" ?>" autofocus>
					</div>
					<div class="col-md-6">
						<label for="lastname" class="control-label">Last Name <sup>*</sup></label>
						<input type="text" name="last_name" id="last_name" class="form-control form-control-sm rounded-0" required="required" value="<?=isset($last_name) ? $last_name : "" ?>">
					</div>
				</div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="mobile" class="control-label">Mobile<sup>*</sup></label>
                        <input type="text" name="mobile" id="mobile" class="form-control form-control-sm rounded-0" required="required" value="<?=isset($mobile) ? $mobile : "" ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="control-label">Role</label>
                        <select name="role" id="role" class="form-control form-control-sm rounded-0" required="required">
                            <option <?=isset($role) && $role == 'Buyer' ? "selected" : "" ?>>Buyer</option>
                            <option <?=isset($role) && $role == 'Agent' ? "selected" : "" ?>>Agent</option>
                        </select>
                    </div>
                 </div>
                 <div class="row">
                        <div class="col-md-6">
                            <label for="address_line1" class="control-label">Address Line<sup></sup></label>
                            <input name="address_line1" id="address_line1" class="form-control form-control-sm rounded-0" value="<?=isset($address_line1) ? $address_line1 : "" ?>"></input>
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
				<hr>
				<div class="row">
					<div class="col-md-6">
						<label for="email" class="control-label">Email <sup>*</sup></label>
						<input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" required="required" value="<?=isset($email) ? $email : "" ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="password" class="control-label">New Password <sup>*</sup></label>
						<div class="input-group input-group-sm">
							<input type="password" name="password" id="password" class="form-control form-control-sm rounded-0">
							<div class="input-group-append">
								<button class="btn btn-outline-default rounded-0 pass_view" tabindex="-1" type="button"><i class="fa fa-eye-slash"></i></button>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<label for="cpassword" class="control-label">Confirm New Password <sup>*</sup></label>
						<div class="input-group input-group-sm">
							<input type="password" id="cpassword" class="form-control form-control-sm rounded-0">
							<div class="input-group-append">
								<button class="btn btn-outline-default rounded-0 pass_view" tabindex="-1" type="button"><i class="fa fa-eye-slash"></i></button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary" form="buyer-profile">Update</button>
				</div>
			</div>
		</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	$('.pass_view').click(function(){
        const group =  $(this).closest('.input-group')
        const type = group.find('input').attr('type')
        if(type == 'password'){
            group.find('input').attr('type','text').focus()
            $(this).html("<i class='fa fa-eye'></i>")
        }else{
            group.find('input').attr('type','password').focus()
            $(this).html("<i class='fa fa-eye-slash'></i>")
        }
    })
	$('#buyer-profile').submit(function(e){
        e.preventDefault();
        var _this = $(this)
            $('.err-msg').remove();
        var el = $('<div>')
            el.addClass('alert alert-danger err-msg')
            el.hide()
        if($("#password").val() != $("#cpassword").val()){
            el.text("Passwords does not match.")
            _this.prepend(el)
            el.show('slow')
            $("html, body").scrollTop(0);
            return false;
        }
        start_loader();
        $.ajax({
            url:_base_url_+"classes/profile.php?f=update_buyer",
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
                    location.reload();
                }else if(resp.status == 'failed' && !!resp.msg){
                        el.text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $("html, body").scrollTop(0);
                        end_loader()
                }else{
                    alert_toast("An error occured",'error');
                    end_loader();
                    console.log(resp)
                }
            }
        })
    })

</script>