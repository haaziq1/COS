<?php
session_start();

extract($_REQUEST);
include("../connection.php");
$gtotal=array();
$ar=array();
$total=0;
if(isset($_GET['product']))//product id
{
	$product_id=$_GET['product'];
}
else
{
	$product_id="";
}

if(isset($_SESSION['cust_id']))
 {
 $loc = $_POST['deliv'];
 $pay = $_POST['payment'];
 $cust_id=$_SESSION['cust_id'];
 $qq=mysqli_query($con,"select * from tblcustomer where fld_email='$cust_id'");
	 $qqr= mysqli_fetch_array($qq);
 }
if(empty($cust_id))
{
	header("location:index.php?msg=you must login first");
}


if(!empty($product_id && $cust_id))
{
$qty = $_SESSION['qty'];
if(mysqli_query($con,"insert into tblcart (fld_product_id,fld_customer_id,fld_product_quantity) values ('$product_id','$cust_id','$qty') "))
{
	echo "success";
	$product_id="";
	//$prod_qty="";
	header("location:cart.php");
}
else
{
	echo "failed";
}
}
if(isset($del))
{
	
	//echo $del;
	if(mysqli_query($con,"delete from tblcart where fld_cart_id='$del' && fld_customer_id='$cust_id'"))
	{
		header("location:deletecart.php");
	}
	
}
 
 
 if(isset($logout))
 {
	 session_destroy();
	 
	 header("location:../index.php");
 }
 if(isset($login))
 {
	 session_destroy();
	 
	 header("location:index.php");
 }
 
 //update section
  $cust_details=mysqli_query($con,"select * from tblcustomer where fld_email='$cust_id'");
  $det_res=mysqli_fetch_array($cust_details);
  $fld_name=$det_res['fld_name'];
  $fld_email=$det_res['fld_email'];
  $fld_mobile=$det_res['fld_mobile'];
  $fld_password=$det_res['password'];
  if(isset($update))
  {
	   
	 if(mysqli_query($con,"update tblcustomer set fld_name='$name',fld_mobile='$mobile',password='$pswd' where fld_email='$fld_email'"))
      {
	   header("location:customerupdate.php");
	  }
  }
  
  $query=mysqli_query($con,"select tbfood.foodname,tbfood.fldvendor_id,tbfood.cost,tbfood.cuisines,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id from tbfood inner  join tblcart on tbfood.food_id=tblcart.fld_product_id where tblcart.fld_customer_id='$cust_id'");
  $re=mysqli_num_rows($query);
  
?>

<html>
<head>
  <title>Cart </title>
		<!--bootstrap files-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<!--bootstrap files-->
		
		<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
		<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Permanent+Marker" rel="stylesheet">

     <style>
		ul li{list-style:none;}
		ul li a {color:black;text-decoration:none; }
		ul li a:hover {color:black;text-decoration:none; }
		
	 </style>
	 <script>
		  function del(id)
		  {
			  if(confirm('are you sure you want to cancel order')== true)
			  {
				  window.location.href='cancelorder.php?id=' +id;
			  }
		  }
		</script>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #0197A5;">
  
	<a class="navbar-brand" href="../index.php"><img src="../img/USP Logo.png" style="display: inline-block;"></a>
		<a class="navbar-brand" href="../index.php"><span style="color:white;font-family: 'Permanent Marker', cursive;font-size:22pt;">NaBukDiSh</span>
		<span style="color:white;font-family:'Permanent Marker', cursive;font-size:18pt;">&copy</span>
		<br>
		<span style="color:white;font-family: 'Permanent Marker', cursive;font-size:12pt;">Food Ordering System</span>
	</a>

    <?php
	if(!empty($cust_id))
	{
	?>
	<a class="navbar-brand" style="color:black; text-decoratio:none;"><i class="far fa-user"><?php if(isset($cust_id)) { echo $qqr['fld_name']; }?></i></a>
	<?php
	}
	?>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
	
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="../index.php" style="color:black;font-weight:700">Home</a>
        </li>
		<li class="nav-item dropright">
			<a class="nav-link dropdown-toggle" href="#" style="color:#063344;font-weight:650" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Menus
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="border:1px solid black;">
			<div class="dropdown-header" align="center" 
				style="background-color:#0197A5; color:white; font-family: 'Times New Roman'; font-style:italic; font-weight:bold;">
				MEAL TYPE
			</div>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#">Breakfast Specials</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="../menu.php#lunch">Lunch Specials</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#">Dinner Specials</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="../menu.php">All</a>
			</div>
		</li>

        <li class="nav-item">
          <a class="nav-link" href="../aboutus.php" style="color:#063344;font-weight:650">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="../contact.php" style="color:#063344;font-weight:650">Contact</a>
        </li>
		
		<li class="nav-item">
		  <form method="post">
          <?php
			if(empty($cust_id))
			{
			?>
			<span style="color:black; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:red;" id="cart"  class="badge badge-light">4</span></i></span>
			
			&nbsp;&nbsp;&nbsp;
			<button class="btn btn-outline-danger my-2 my-sm-0" name="login">Log In</button>&nbsp;&nbsp;&nbsp;
            <?php
			}
			else
			{
			?>
			<a href="cart.php"><span style="color:green; font-size:30px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:green;" id="cart"  class="badge badge-light"><?php if(isset($re)) echo $re; ?></span></i></span></a>
			<button class="btn btn-success my-2 my-sm-0" name="logout" type="submit">Log Out</button>&nbsp;&nbsp;&nbsp;
			<?php
			}
			?>
			</form>
        </li>
      </ul>
    </div>
</nav>
<!--navbar ends-->

<br><br>
<div class="middle" style="padding:60px; border:0px solid #0197A5;  width:100%; ">
       <!--tab heading-->
	   <ul class="nav nav-tabs nabbar_inverse" id="myTab" style="margin-top:30; background:#0197A5;border-radius:10px 10px 10px 10px;" role="tablist">
          <li class="nav-item">
             <a class="nav-link active" style="color:#063344; font-weight:650;" id="viewitem-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="viewitem" aria-selected="true" >View Cart</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" style="color:#063344; font-weight:650;" id="manageaccount-tab" data-toggle="tab" href="#manageaccount" role="tab" aria-controls="manageaccount" aria-selected="false">Account Settings</a>
          </li>
		  <li class="nav-item">
              <a class="nav-link" style="color:#063344; font-weight:650;" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">Orders</a>
          </li>
       </ul>
	   <br><br>
		<!--tab 1 starts-->   
	   <div class="tab-content" id="myTabContent">
	   
            <div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="home-tab">
                 <table class="table">
                  <tbody>
					<tr style="font-weight:bold;">
						<td></td>
						<td>Food name</td>
						<td>Price</td>
						<td>Description</td>
						<td>Vendor</td>
						<td>Quantity Ordered</td>
						<td></td>
						<td>Product Total</td>
					</tr>





	               <?php
	                  $query=mysqli_query($con,"select tbfood.foodname,tbfood.fldvendor_id,tbfood.cost,tbfood.cuisines,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id, tblcart.fld_product_quantity from tbfood inner  join tblcart on tbfood.food_id=tblcart.fld_product_id where tblcart.fld_customer_id='$cust_id'");
	                  $re=mysqli_num_rows($query);
	                   if($re)
	                    {
		                 while($res=mysqli_fetch_array($query))
		                  {
			                $vendor_id=$res['fldvendor_id'];
			               $v_query=mysqli_query($con,"select * from tblvendor where fldvendor_id='$vendor_id'");
			               $v_row=mysqli_fetch_array($v_query);
			               $em=$v_row['fld_email'];
			               $nm=$v_row['fld_name'];
	                ?>
                      <tr>
                         <td><image src="../image/restaurant/<?php echo $em."/foodimages/".$res['fldimage'];?>" height="80px" width="100px"></td>
                         <td><?php echo $res['foodname'];?></td>
                         <td><?php echo "$".$res['cost'];?></td>
                         <td><?php echo $res['cuisines'];?></td>
                         <td><?php echo $nm; ?></td>
						 <td><?php echo $res['fld_product_quantity'];?></td>
						 <td><?php $pro = ($res['cost']*$res['fld_product_quantity']); ?></td>
						 <td><?php echo "$" .$pro;?></td>

		                <form method="post" enctype="multipart/form-data">
                           <td><button type="submit" name="del"  value="<?php echo $res['fld_cart_id']?>" class="btn btn-danger">Delete</button></td>
                        </form>
                        <td><?php $total=$total+($res['cost']*$res['fld_product_quantity']); $gtotal[]=$total;  ?></td>
                      </tr>
					  
                   <?php
	                    }
						?>
						<tr>
					  <td>
					  <h5 style="color:red;">Grand total</h5>
					  </td>
					  <td>
					  <h5><i class="fas fa-dollar-sign"></i>&nbsp;<?php echo end($gtotal); ?></h5>
					  </td>
					  <td>
					  
					  </td>
					  <td></td>

					   <!--Delivery location section-->
						<form method="post" action="cart.php">
						<div class="w3-container">
							<div class="column">
							
							<label <button type="button" style=" color:black; font-weight:bold; text-transform:uppercase;" class="btn btn-default"> Choose a Delivery Location:</label>

							<select name="deliv" <button type="button" style=" color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-primary">
							  <option> USP locations</option>
							  <option value="ICT Building A">ICT Building A</option>
							  <option value="ICT Building B">ICT Building B</option>
							  <option value="Lower Campus Hub">Lower Campus Hub</option>
							  <option value="SLS Hub">SLS Hub</option>
							  <option value="FBE Offices">FBE Offices</option>
							  <option value="FSTE Offices">FSTE Offices</option>
							  <option value="Library">Library</option>
							  <option value="SCIMS Offices">SCIMS Offices</option>
							</select>
							
							 <!-- Payment option section-->
							
							<label <button type="button" style=" color:black; font-weight:bold; text-transform:uppercase;" class="btn btn-default"> Choose a Payment Option:</label>
							
							<select name="payment" <button type="button" style=" color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-primary">
							  <option value="Payroll Deduction">Payroll Deduction</option>
							  <option value="Cash on Delivery">Cash on Delivery</option>
							</select>
							
							<button type="submit" name="deliver" class="btn btn-success">Submit</button>
							
 
							</form>
							
						</div>
						</div>
					  
					  <td style="padding:30px; text-align:center;">
							<a href="../menu.php#lunch"><button type="button" style=" color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-success">Continue Shopping</button></a>		
					  </td>

					  <td style="padding:30px; text-align:center;">
						 <a href="order.php?cust_id=<?php echo $cust_id; ?>&loc=<?php echo $loc; ?>&pay=<?php echo $pay; ?>"><button type="button" style=" color:white; font-weight:bold; text-transform:uppercase;" class="btn btn-warning">Proceed to checkout</button></a>
					  </td>

					  <td></td>
					  </tr>
						<?php
	                  }
					  else
					  {
	                 ?>
					 <tr><button type="button" class="btn btn-outline-success"><a href="../menu.php" style="color:green; text-decoration:none;">No Items In cart Let's Shop Now</a></button></tr>
					 <?php
					  }
					 ?>
                 </tbody>
	      </table>	
		  <span style="color:green; text-align:centre;"><?php if(isset($success)) { echo $success; }?></span>
         </div>	 
		<!--tab 1 ends-->	   	
		
		<!--tab 2 starts-->
            <div class="tab-pane fade" id="manageaccount" role="tabpanel" aria-labelledby="manageaccount-tab">
			    <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" id="name" value="<?php if(isset($fld_name)){ echo $fld_name;}?>" class="form-control" name="name" required="required"/>
                    </div>
					
					<div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" id="email" name="email" value="<?php if(isset($fld_email)){ echo $fld_email;}?>" class="form-control"  readonly/>
                    </div>
					<div class="form-group">
                      <label for="mobile">Mobile</label>
                      <input type="tel" id="mobile" class="form-control" name="mobile" pattern="[6-9]{1}[0-9]{2}[0-9]{3}[0-9]{4}" value="<?php if(isset($fld_mobile)){ echo $fld_mobile;}?>" placeholder="" required>
                    </div>
					
                   <div class="form-group">
                      <label for="pwd">Password:</label>
                     <input type="password" name="pswd" value="<?php if(isset($fld_password)) { echo $fld_password; }?>"class="form-control"  id="pwd" required/>
                   </div>
 
                  <button type="submit" name="update" style="background:#ED2553; border:1px solid #ED2553;" class="btn btn-primary">Update</button>
                  <div class="footer" style="color:red;"><?php if(isset($ermsg)) { echo $ermsg; }?><?php if(isset($ermsg2)) { echo $ermsg2; }?></div>
			 </form>
			</div>
			<!--tab 2 ends-->
		
			 <!--tab 3 starts-->
            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
			    <table class="table">
				<th>Order Number</th>
				<th>Item Name</th>
				<th>Price</th>
				<th>Delivery Location</th>
				<th>Payment Option</th>
				<th>Cancel order</th>
				    <tbody>
					<?php
					$quer_res=mysqli_query($con,"select * from tblorder where fld_email_id='$cust_id' && fldstatus='In Process'");
					while($roww=mysqli_fetch_array($quer_res))
					{   
				         $fid=$roww['fld_food_id'];
				         $qr=mysqli_query($con,"select * from tbfood where food_id='$fid'");
						 $qrr=mysqli_fetch_array($qr);?>
					   <tr>
					   <td><?php echo $roww['fld_order_id']; ?></td>
					   <?php
					   if(empty($qrr['foodname']))
					   {
					   ?>
					   <td><span style="color:red;">Product Not Available Now</span></td>
					   <?php
					   }
					   else
					   {
						   ?>
						    <td><?php echo $qrr['foodname']; ?></td>
						   <?php
					   }
					   ?>
					  
					   <td><?php echo $qrr['cost']; ?></td>
					   <td><?php echo $roww['delivery_location']; ?></td>
					   <td><?php echo $roww['payment_option']; ?></td>
					   <td><a href="#" onclick="del(<?php echo $roww['fld_order_id'];?>);"><button type="button" class="btn btn-danger">Cancel Order</button></a></td>
					   </tr>
					 <?php
					}
					 ?>  
					</tbody>
				</table>
			</div>
			<!--tab 3 ends-->
	  </div>
	</div>  	 
<br><br> <br><br> <br><br>
<?php
include("footer.php");
?>  

</body>
</html>