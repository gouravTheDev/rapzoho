<script>
      if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
      }
</script>

<?php 
	$link = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB);
  $userId = $_SESSION["userId"];
  $sql = "UPDATE ATHENEUM_NOTIFICATION SET STATUS = 'READ' WHERE USER_ID = '$partnerId'";
  $result = mysqli_query($link,$sql);

 ?>

 <?php if (!$_SESSION['LoggedIn']){
 	header("Location: signIn");
 }


 ?>

<?php if($_SESSION['LoggedIn']): ?>

<div class="container">
  <div id="fb-root"></div>
	
	 <div class="row">
        <div class="col-md-12">
          <h1 class="display-7 text-center">Notification</h1>

          <!-- ---------------USER DETAILS TABLE ------------- -->

          <div class="row">
          <div class="col-6 ml-auto mr-auto">
            <?php 
              $sqlNoti = "SELECT * FROM ATHENEUM_NOTIFICATION WHERE USER_ID='$partnerId' ORDER BY ID DESC";
              $resultNoti = mysqli_query($link, $sqlNoti);
              if(mysqli_num_rows($resultNoti)>0){
                while($row = mysqli_fetch_array($resultNoti,MYSQLI_ASSOC)){ 
                    $title = $row['TITLE'];
                    $msg = $row['MESSAGE'];
                    $link = $row['LINK'];
                  ?>
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <h4 class="card-text"><?php echo $msg ?></h4>
                      <a class="btn btn-success" href="<?php echo $link; ?>">Click</a>
                    </div> 
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card --> 
                <?php }
              }else{
                echo '<div class="alert alert-warning text-center">You have no notification yet</div>';
              } 
             ?>
          </div>
        </div>
          

        </div>
      </div>
</div>

<!-- MODAL FOR COURSE ACCESS DETAILS -->


<?php else: ?>
  <div class="row">
    <div class="col-md-6 col-lg-6 col-sm-12 ml-auto mr-auto">
      <div class="alert">You are not allowed to access the page. Please <a href="signIn">Sign in</a> to see the page.</div>
    </div>
  </div>

<?php endif; ?>
