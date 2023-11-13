<?php require_once('config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('header.php') ?>
<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  <style>
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
      backdrop-filter: contrast(1);
    }
    #page-title{
      text-shadow: 6px 4px 7px black;
      font-size: 3.5em;
      color: #fff4f4 !important;
      background: #8080801c;
    }
  </style>
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>
<div class="login-box">
<?php if($_settings->chk_flashdata('success')): ?>
    <script>
      alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
    </script>
    <?php endif;?> 
  <!-- /.login-logo -->
  <div class="card card-primary rounded-0 shadow my-2">
    <div class="card-body">
      <p class="login-box-msg">Please enter your credentials</p>
      <form id="login-form" action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="email" autofocus placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control"  name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row align-items-end">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block btn-sm btn-flat">Log In</button>
          </div>
          <div class="col-12 text-center">
            Not a member? <a href="register.php">Register</a> now
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<script>
  $(document).ready(function(){
    end_loader();
    $('#login-form').submit(function(e){
        e.preventDefault();
        var _this = $(this)
            $('.err-msg').remove();
        var el = $('<div>')
            el.addClass('alert alert-danger err-msg')
            el.hide()
        start_loader();
        $.ajax({
            url:_base_url_+"classes/login.php?f=login",
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
                    if (resp.role === 'Buyer') {
                        location.href="buyer/?page=dashboard";
                    } else {
                        location.href="agent/?page=dashboard";
                    }
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
  })
</script>
</body>
</html>