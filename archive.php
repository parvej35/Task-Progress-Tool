<?php 
    
    require('action/configuration.php');

    if(!isset($_SESSION)) {
        session_start();
    }
    
    if(!isset($_SESSION['user_id'])){ 
      session_destroy();
      header("location:login.php");
    }
     
?>

<!DOCTYPE html>
<html lang="en">

<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Task Progress Tool</title>

  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/custom.css">
  <link rel="stylesheet" href="css/tingle.css">

  <link rel="shortcut icon" href="images/favicon.png" />
  
</head>

<body>
  <div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="padding-left:20px;width: 100%;">
        <a class="navbar-brand brand-logo" href="index.php" style="font-weight: bold;">
          Task Progress Tool
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.php" style="font-weight: bold;">
          Task Progress Tool
        </a>

      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item d-lg-flex">
            <a href="index.php" type="button" class="btn btn-primary btn-rounded btn-icon" title="Home">
              <i class="fa fa-home" style="padding-top: 12px;"></i>
            </a>
          </li>
          <li class="nav-item d-lg-flex">
            <a href="login.php" type="button" class="btn btn-danger btn-rounded btn-icon" title="Logout">
              <i class="fas fa-power-off" style="padding-top: 12px;"></i>
            </a>  
          </li>
        </ul>
      </div>
    </nav>
    
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel" style="width:100%;">          
        <div class="content-wrapper">
		      <div class="row">
            <div class="col-12 grid-margin">
              <div class="todo-container" style="width: 100%;">
                <div class="status">
                  <div id="no_status">
                    <h4>Draft <img src="images/loader.gif" id="loader_status_1" style="height: 25px; width: 25px;float: right;display: none;"></h4>

                    <?php

                      $sql = "SELECT id, title FROM tasks WHERE is_active = 0 AND status_id = 1 AND app_user_id = ".$_SESSION['user_id']." ORDER BY id DESC";
                      $tasks = mysqli_query($connection, $sql);
                      while($task = $tasks->fetch_assoc()){ ?>
                      <div class="todo" id="<?php echo $task['id']; ?>">
                        <?php echo $task['title']; ?>
                        <span class="restore" title="Restore" onclick="restoretask(<?php echo $task['id']; ?>)">&#8634;</span> 
                      <span class="close" title="Delete Forever" onclick="deletetaskforever(<?php echo $task['id']; ?>)">&times;</span>
                      </div>
                    <?php } ?>
                  </div>
                </div>

                <div class="status">
                  <h4>Postponed <img src="images/loader.gif" id="loader_status_2" style="height: 25px; width: 25px;float: right;display: none;"></h4>
                  <?php

                    $sql = "SELECT id, title FROM tasks WHERE is_active = 0 AND status_id = 2 AND app_user_id = ".$_SESSION['user_id']." ORDER BY id DESC";
                    $tasks = mysqli_query($connection, $sql);
                    while($task = $tasks->fetch_assoc()){ ?>
                    <div class="todo" id="<?php echo $task['id']; ?>">
                      <?php echo $task['title']; ?>
                      <span class="restore" title="Restore" onclick="restoretask(<?php echo $task['id']; ?>)">&#8634;</span> 
                      <span class="close" title="Delete Forever" onclick="deletetaskforever(<?php echo $task['id']; ?>)">&times;</span>
                    </div>
                  <?php } ?>
                </div>

                <div class="status">
                  <h4>In Progress <img src="images/loader.gif" id="loader_status_3" style="height: 25px; width: 25px;float: right;display: none;"></h4>
                  <?php

                    $sql = "SELECT id, title FROM tasks WHERE is_active = 0 AND status_id = 3 AND app_user_id = ".$_SESSION['user_id']." ORDER BY id DESC";
                    $tasks = mysqli_query($connection, $sql);
                    while($task = $tasks->fetch_assoc()){ ?>
                    <div class="todo" id="<?php echo $task['id']; ?>">
                      <?php echo $task['title']; ?>
                      <span class="restore" title="Restore" onclick="restoretask(<?php echo $task['id']; ?>)">&#8634;</span> 
                      <span class="close" title="Delete Forever" onclick="deletetaskforever(<?php echo $task['id']; ?>)">&times;</span>
                    </div>
                  <?php } ?>
                </div>

                <div class="status">
                  <h4>Completed <img src="images/loader.gif" id="loader_status_4" style="height: 25px; width: 25px;float: right;display: none;"></h4>
                  <?php

                    $sql = "SELECT id, title FROM tasks WHERE is_active = 0 AND status_id = 4 AND app_user_id = ".$_SESSION['user_id']." ORDER BY id DESC";
                    $tasks = mysqli_query($connection, $sql);
                    while($task = $tasks->fetch_assoc()){ ?>
                    <div class="todo" id="<?php echo $task['id']; ?>">
                      <?php echo $task['title']; ?>
                      <span class="restore" title="Restore" onclick="restoretask(<?php echo $task['id']; ?>)">&#8634;</span> 
                      <span class="close" title="Delete Forever" onclick="deletetaskforever(<?php echo $task['id']; ?>)">&times;</span>
                    </div>
                  <?php } ?>
                </div>

              </div>
            </div>
          </div>
        </div>
        
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?php echo date('Y'); ?> <a href="mailto:parvej35@gmail.com">Parvej Ahmed Chowdhury</a>. All rights reserved.</span>
          </div>
        </footer>
      </div>
    </div>
  </div>
  
  <script src="js/jQuery.3.2.1.js"></script>
  <script src="js/tingle.js"></script>
  <script src="js/scripts.js"></script>
  
  <script type="text/javascript">

      function deletetaskforever(id) {
          var modal = new tingle.modal({
              footer: true,
              stickyFooter: false,
              closeMethods: ['overlay', 'button', 'escape'],
              closeLabel: "Close",
              cssClass: ['custom-class-1', 'custom-class-2']
          });

          modal.setContent("<h3>Are you sure to delete this task permanently?</h3>");

          modal.addFooterBtn('Yes, Delete Permanently', 'tingle-btn tingle-btn--danger tingle-btn--pull-right', function() {
              $("#loader_status_1").show();

              $.ajax({
                  url:"action/delete_permanently.php",
                  type:'GET',
                  data:"id="+id,
                  success:function(){
                      $("#"+id).hide();  
                      $("#loader_status_1").hide();

                      var modal = new tingle.modal({
                          footer: true,
                          stickyFooter: false,
                          closeMethods: ['overlay', 'button', 'escape'],
                          closeLabel: "Close",
                          cssClass: ['custom-class-1', 'custom-class-2']
                      });

                      modal.setContent("<h4>Task permanently deleted.</h4>");

                      modal.addFooterBtn('Close', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {
                          modal.close();
                      });

                      modal.open();
                  }
              })
              modal.close();
          });

          modal.addFooterBtn('Cancel', 'tingle-btn tingle-btn--primary', function() {
              modal.close();
          });

          modal.open();
      }

      function restoretask(id) {
          var modal = new tingle.modal({
              footer: true,
              stickyFooter: false,
              closeMethods: ['overlay', 'button', 'escape'],
              closeLabel: "Close",
              cssClass: ['custom-class-1', 'custom-class-2']
          });

          modal.setContent("<h3>Are you sure to restore this task?</h3>");

          modal.addFooterBtn('Yes, Restore', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {
              $("#loader_status_1").show();

              $.ajax({
                  url:"action/restore.php",
                  type:'GET',
                  data:"id="+id,
                  success:function(){
                      $("#"+id).hide();  
                      $("#loader_status_1").hide();

                      var modal = new tingle.modal({
                          footer: true,
                          stickyFooter: false,
                          closeMethods: ['overlay', 'button', 'escape'],
                          closeLabel: "Close",
                          cssClass: ['custom-class-1', 'custom-class-2']
                      });

                      modal.setContent("<h4>Task successfully restored.</h4>");

                      modal.addFooterBtn('Close', 'tingle-btn tingle-btn--info tingle-btn--pull-right', function() {
                          modal.close();
                      });

                      modal.open();
                  }
              })
              modal.close();
          });

          modal.addFooterBtn('Cancel', 'tingle-btn tingle-btn--info', function() {
              modal.close();
          });

          modal.open();
      }

  </script>

  
</body>


</html>
