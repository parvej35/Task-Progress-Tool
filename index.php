<?php 
    
    require('action/configuration.php');

    if(!isset($_SESSION)) {
        session_start();
    }
    if(!isset($_SESSION['user_id'])){
        session_destroy();
        header("location:login.php");
        exit();
    }


    $topicsList = "<select id='topic_input' name='topic_input' class='tingle-input-box input'><option value=''></option>";

    $sql = "SELECT id, title FROM topic WHERE is_active = 1 AND app_user_id = ".$_SESSION['user_id']." ORDER BY title DESC";
    $topics = mysqli_query($connection, $sql);
    while($topic = $topics->fetch_assoc()) {
        $topicsList .= "<option value='" . $topic['id'] . "'>" . $topic['title'] . "</option>";
    }
    $topicsList .= "</select>";
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
          <!-- <li class="nav-item d-lg-flex">
            <a href="#" type="button" class="btn btn-primary btn-rounded btn-icon" title="Home">
              <i class="fa fa-home" style="padding-top: 12px;"></i>
            </a>
          </li> -->
          <li class="nav-item d-lg-flex">
            <a href="#" type="button" onclick="showModalToAddTopic()" class="btn btn-outline-primary btn-rounded btn-icon" title="Add Topic">
              <i class="fa fa-th-large" style="padding-top: 12px;"></i>
            </a>
          </li>
          <li class="nav-item d-lg-flex">
            <a href="#" type="button" onclick="showModalToAddTask()" class="btn btn-outline-success btn-rounded btn-icon" title="Add Task">
                <i class="fa fa-plus" style="padding-top: 12px;"></i>
            </a>
          </li>
          <li class="nav-item d-lg-flex">
            <a href="archive.php" type="button" class="btn btn-outline-info btn-rounded btn-icon" title="Archive">
              <i class="fas fa-trash" style="padding-top: 12px;"></i>                          
            </a>
          </li>
          <li class="nav-item d-lg-flex">
            <a href="login.php" type="button" class="btn btn-outline-danger btn-rounded btn-icon" title="Logout">
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
                <div class="status" id="status_1" style="background-color: lightsalmon;">
                  <div id="no_status">
                    <h4>Draft <img src="images/loader.gif" id="loader_status_1" style="height: 25px; width: 25px;float: right;display: none;"></h4>

                    <?php

                      $sql = "SELECT t1.id, t1.title AS title, t2.title AS topic FROM tasks t1 LEFT JOIN topic t2 ON t2.id = t1.topic_id WHERE t1.is_active = 1 AND t1.status_id = 1 AND t1.app_user_id = ".$_SESSION['user_id']." ORDER BY t1.title DESC";
                      $tasks = mysqli_query($connection, $sql);
                      while($task = $tasks->fetch_assoc()){ ?>
                      <div class="todo" draggable="true" id="<?php echo $task['id']; ?>">
                        <?= $task['topic']." : ".$task['title']; ?>
                        <span class="close" title="Delete" onclick="deleteTask(<?php echo $task['id']; ?>)">&times;</span>
                      </div>
                    <?php } ?>
                  </div>
                </div>

                <div class="status" id="status_2" style="background-color: lightslategrey;">
                  <h4>Postponed <img src="images/loader.gif" id="loader_status_2" style="height: 25px; width: 25px;float: right;display: none;"></h4>
                  <?php

                    $sql = "SELECT t1.id, t1.title AS title, t2.title AS topic FROM tasks t1 LEFT JOIN topic t2 ON t2.id = t1.topic_id WHERE t1.is_active = 1 AND t1.status_id = 2 AND t1.app_user_id = ".$_SESSION['user_id']." ORDER BY t1.title DESC";
                    $tasks = mysqli_query($connection, $sql);
                    while($task = $tasks->fetch_assoc()){ ?>
                    <div class="todo" draggable="true" id="<?php echo $task['id']; ?>">
                        <?= $task['topic']." : ".$task['title']; ?>
                        <span class="close" title="Delete" onclick="deleteTask(<?php echo $task['id']; ?>)">&times;</span>
                    </div>
                  <?php } ?>
                </div>

                <div class="status" id="status_3" style="background-color: lightseagreen;">
                  <h4>In Progress <img src="images/loader.gif" id="loader_status_3" style="height: 25px; width: 25px;float: right;display: none;"></h4>
                  <?php

                    $sql = "SELECT t1.id, t1.title AS title, t2.title AS topic FROM tasks t1 LEFT JOIN topic t2 ON t2.id = t1.topic_id WHERE t1.is_active = 1 AND t1.status_id = 3 AND t1.app_user_id = ".$_SESSION['user_id']." ORDER BY t1.title DESC";
                    $tasks = mysqli_query($connection, $sql);
                    while($task = $tasks->fetch_assoc()){ ?>
                    <div class="todo" draggable="true" id="<?php echo $task['id']; ?>">
                        <?= $task['topic']." : ".$task['title']; ?>
                        <span class="close" title="Delete" onclick="deleteTask(<?php echo $task['id']; ?>)">&times;</span>
                    </div>
                  <?php } ?>
                </div>

                <div class="status" id="status_4" style="background-color: lightgreen;">
                  <h4>Completed <img src="images/loader.gif" id="loader_status_4" style="height: 25px; width: 25px;float: right;display: none;"></h4>
                  <?php

                    $sql = "SELECT t1.id, t1.title AS title, t2.title AS topic FROM tasks t1 LEFT JOIN topic t2 ON t2.id = t1.topic_id WHERE t1.is_active = 1 AND t1.status_id = 4 AND t1.app_user_id = ".$_SESSION['user_id']." ORDER BY t1.title DESC";
                    $tasks = mysqli_query($connection, $sql);
                    while($task = $tasks->fetch_assoc()){ ?>
                    <div class="todo" draggable="true" id="<?php echo $task['id']; ?>">
                        <?= $task['topic']." : ".$task['title']; ?>
                        <span class="close" title="Delete" onclick="deleteTask(<?php echo $task['id']; ?>)">&times;</span>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?php echo date('Y'); ?>. All rights reserved.</span>
          </div>
        </footer>
      </div>
    </div>
  </div>
  
  <script src="js/jQuery.3.2.1.js"></script>
  <script src="js/tingle.js"></script>
  <script src="js/scripts.js"></script>
  
  <script type="text/javascript">

      function showModalToAddTopic(){
        var modal = new tingle.modal({
            footer: true,
            stickyFooter: false,
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: "Close",
            cssClass: ['custom-class-1', 'custom-class-2']
        });

        var htmlContent = "<input type='hidden' id='app_user_id' value='<?php echo $_SESSION['user_id']; ?>' />";
        htmlContent += "<label>Topic</label><input type='text' id='topic_input' class='tingle-input-box input' />";
        modal.setContent(htmlContent);

        modal.addFooterBtn('Save Topic', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {

            var result = createTopic();
            //if(result === "true") {
                modal.close();
                location.reload();
           // }

        });

        modal.addFooterBtn('Cancel', 'tingle-btn tingle-btn--danger', function() {
            modal.close();
        });

        modal.open();
      }

      function showModalToAddTask(){
          var modal = new tingle.modal({
              footer: true,
              stickyFooter: false,
              closeMethods: ['overlay', 'button', 'escape'],
              closeLabel: "Close",
              cssClass: ['custom-class-1', 'custom-class-2']
          });

          var htmlContent = "<input type='hidden' id='app_user_id' value='<?php echo $_SESSION['user_id']; ?>' />";
          htmlContent += "<label>Topic</label><?= $topicsList; ?>";
          htmlContent += "<label style='padding-top: 20px;'>Enter Task Description</label><input type='text' id='todo_input' class='tingle-input-box input' />";
          modal.setContent(htmlContent);

          modal.addFooterBtn('Save Task', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {

              var result = createTodo();
              if(result === "true") {
                  modal.close();
                  location.reload();
              }

          });

          modal.addFooterBtn('Cancel', 'tingle-btn tingle-btn--danger', function() {
              modal.close();
          });

          modal.open();
      }

      function deleteTask(id) {
          var modal = new tingle.modal({
              footer: true,
              stickyFooter: false,
              closeMethods: ['overlay', 'button', 'escape'],
              closeLabel: "Close",
              cssClass: ['custom-class-1', 'custom-class-2']
          });

          modal.setContent("<h3>Are you sure to delete this task?</h3>");

          modal.addFooterBtn('Yes, Delete', 'tingle-btn tingle-btn--danger tingle-btn--pull-right', function() {
              $("#loader_status_1").show();

              $.ajax({
                  url:"action/delete.php",
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

                      modal.setContent("<h4>Task successfully deleted.</h4>");

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

  </script>

  
</body>


</html>
