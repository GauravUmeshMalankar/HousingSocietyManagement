<html>
<head>
 <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<title>First Php file</title>
  <script src="js/bootstrap.bundle.min.js"></script>
 <script src="js/dist/umd/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
<div class="row">

<div class="col">
<br><p style='color:blue;font-size:60pt'>Welcome To HTML</p>
</div>
</div>
<div class="row">
<div class="col">
&nbsp;
</div>
<div class="col">

<form class="row g-3" method="post">
  <div class="col-auto">
    <label>Enter Farmer ID</label>
    <input type="text"  class="form-control-plaintext" name="txtFId" >
  </div>
 <div class="col-auto">
    <label >Farmer Name</label>
    <input type="text" class="form-control-plaintext" name="txtName" >
  </div>
 <div class="col-auto">
    <label for="staticEmail2">Address</label>
    <input type="text" class="form-control-plaintext" name="txtAddr" >
  </div>
 <div class="col-auto">
    <label >Contact</label>
    <input type="text" class="form-control-plaintext" name="txtContact" >
  </div>
 <div class="col-auto">
   &nbsp;
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3" name="btnAdd">Add</button>
  </div>
</form>

</div>
<div class="col">

<?php
//Function
if(isset($_POST["btnAdd"]))
{
$conn = mysqli_connect("localhost","root","","agri");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
$id=$_POST["txtFId"];
$name=$_POST["txtName"];
$addr=$_POST["txtAddr"];
$contact=$_POST["txtContact"];
$sql="insert into farmer values(".$id.",'".$name." ','".$addr."' ,".$contact.")";
$r=mysqli_query($conn,$sql);

}
function showData()
{
$conn = mysqli_connect("localhost","root","","agri");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}


$sql="select * from farmer";
$r=mysqli_query($conn,$sql);
echo "<table border='1' class='table table-dark table-striped'><thead>
<tr><th>ID</th><th>Name</th><th>Address</th><th>Contact</th></tr></thead><tbody>";
if(mysqli_num_rows($r) >0)
{
	//while($x=mysqli_fetch_row($r))
	while($x=mysqli_fetch_assoc($r))
	{
	   echo "<tr><td>".$x['FId']."</td><td>".$x['Name']."</td><td>".$x['Addr']."</td><td>".$x['Contact']."</td></tr>";

//echo "<tr><td>".$x[0]."</td><td>".$x[1]."</td><td>".$x[2]."</td><td>".$x[3]."</td></tr>";
	}
}
else
{
	echo "<tr><td colspan='4'>No Records found in Farmer Table</td></tr>";
}
echo "</tbody></table>";
mysqli_close($conn);
}
showData();

?>
</div>

</div>
</div>
</body>
</html>