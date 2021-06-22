<!DOCtype html>
<html>
    <head>
        <title>Macro Super Center</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"></script>
        <link rel="stylesheet" href="style/mainStyle.css">
        <script type="text/javascript" src="javascript/mainSlideShow.js"></script>
    </head>

    <body>

    <?php 
            session_start();
            $system_userName= $_SESSION['regName'];
            $system_userID = $_SESSION['uid'];  
            $system_type = $_SESSION['stype'];       
        ?> 

    <header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand">Macro Super Center</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="home.php">Home</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" aria-current="page" href="search.php">Search</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" aria-current="page" href="cart.php">Cart</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" aria-current="page" href="sellerhub.php">Seller hub</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" aria-current="page" href="about.php">About</a>
          </li>
        </ul>
        <form class="d-flex">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
          <a class="nav-link" aria-current="page" href="logout.php"><?php if($system_userName==""){ echo "";} else {echo $system_userName;} ?></a>
          </li>
          <li class="nav-item">
          <a class="nav-link" aria-current="page" href="signup.php">Sign up</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" aria-current="page" href="login.php">Log in</a>
          </li>
          </ul>
        </form>
      </div>
    </div>
  </nav>
</header>


        <br><br>
        <br><br>

        <?php if($system_type == "Seller" || $system_type == "Admin"){  ?>

<div class="container d-flex justify-content-center">
<form>
<div class="row">
    <div class="col d-flex justify-content-around">
    <h1><i>Hi <?php echo $system_userName ?>.</i></h1>
    </div>
  </div>

<br>

  <div class="row">
    <div class="col d-flex justify-content-around">
    <a href="sellerhub/sh_InsertNewItem.php">
    <input type="button" class="btn btn-success btn-lg" value="Insert New Item">
    </a>
    </div>
    <div class="col d-flex justify-content-around">
    <a href="sellerhub/sh_UpdatePrice.php">
    <input type="button" class="btn btn-secondary btn-lg" value="Update Price">
    </a>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col col-md-auto d-flex justify-content-around">
    <a href="sellerhub/sh_AddNewStock.php">
    <input type="button" class="btn btn-primary btn-lg" value="Add New Stock">
    </a>
    </div>
    <div class="col col-md-auto d-flex justify-content-around">
    <a href="sellerhub/sh_RemoveStock.php">
    <input type="button" class="btn btn-warning btn-lg" value="Remove Stock">
    </a>
    </div>
    <div class="col col-md-auto d-flex justify-content-around">
    <a href="sellerhub/sh_DeleteItem.php">
    <input type="button" class="btn btn-danger btn-lg" value="Delete Items">
    </a>
    </div>
  </div>
  </form>
</div>

        <?php
            $servername = "localhost:3306";
            $username = "root";
            $password = "";
            $dbname = "wadproject";
            
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
              die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "SELECT COUNT(`itemNo`) FROM `itemsdb`";
            $result = mysqli_query($conn, $sql);
            $itemCount = 0;

            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_assoc($result)) {
                $itemCount = $row["COUNT(`itemNo`)"];
              }
            } else {
              echo "0 results";
            }
            
            $sql = "SELECT `itemNo` FROM `itemsdb` ";
            $result = mysqli_query($conn, $sql);
            $itemNumArray;

            for($i = 0; $i < $itemCount; $i++){
              $sql = "SELECT `itemNo` FROM `itemsdb` LIMIT ".$i.",1";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                  $itemNumArray[$i] = $row["itemNo"];
                }
              }
              else {
                echo "0 results";
              }
            }
            mysqli_close($conn);
        ?>

	<div class="container">
    <form>
		<table class="table text-center">
			<thead>
				<tr>
					<th><b>Item ID</b></th>
					<th><b>Name</b></th>
					<th><b>Qty</b></th>
					<th><b>Unit</b></th>
					<th><b>Unit Price (LKR.)</b></th>
				</tr>
			</thead>
      <br>
			<tfoot>

<?php
          $servername = "localhost:3306";
          $username = "root";
          $password = "";
          $dbname = "wadproject";
        
          $conn = mysqli_connect($servername, $username, $password, $dbname);
          if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
          }
          
          for($x = 0; $x < $itemCount; $x++){
            $sql = "SELECT `itemNo`, `name`, `unit`, `qty`, `unitprice` FROM `itemsdb` LIMIT ".$x.",1";
            $result = mysqli_query($conn, $sql);
          
            if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {  ?>

				<tr>
					<th><?php echo $row["itemNo"]; ?></th>
					<th><?php echo $row["name"]; ?></th>
					<th><?php echo $row["qty"]; ?></th>
					<th><?php echo $row["unit"]; ?></th>
					<th>LKR. <?php echo $row["unitprice"]; ?>.00</th>
				</tr>

              <?php
            }
            
            } else {
              echo "0 results";
            }
          }
          mysqli_close($conn);
        ?>



			</tfoot>
		</table>
    </form>
	</div>

<?php } else { ?>
<br><br><br><br><br><br><br>
<div class="container d-flex justify-content-center">
<form>
<div class="row">
    <div class="col d-flex justify-content-around">
    <h1><i>Sorry <?php echo $system_userName ?>. You are not a <b>Seller</b>.</i></h1>
    </div>
  </div>
  </form>
  </div>
  <br><br><br><br><br><br><br><br><br><br>


<?php } ?>


<br><br>
<br><br>
        <footer class="bg-dark text-center text-white">
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
  <p>Developed By <b>tharindu_johnson</b></p>
  </div>
</footer>
    </body>
</html>