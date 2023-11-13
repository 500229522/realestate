<?php require_once('../config.php'); ?>
 <!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('../header.php') ?>
  <body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs text-sm" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
     <?php require_once('topBarNav.php') ?>
     <?php require_once('navigation.php') ?>
              
     <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home';  ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper pt-2">
     
        <!-- Main content -->
        <section class="content  text-dark">
          <div class="container-fluid">
            <?php 
              if(!file_exists($page.".php") && !is_dir($page)){
                  include '../page_not_found.php';
              }else{
                if(is_dir($page))
                  include $page.'/dashboard.php';
                else
                  include $page.'.php';
              }
            ?>
          </div>
        </section>
        <div class="modal fade" id="confirm_modal" role='dialog'>
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
            </div>
            <div class="modal-body">
                <div id="delete_content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
            </div>
        </div>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php require_once('../footer.php') ?>
  </body>
</html>
