<?php
require '../session.php';
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}

if(!isStaff()) {
    $_SESSION['msg'] = "Access denied";
    if (isAdmin()) {
        header('location: ../admin/index.php');
    } elseif (isCustomer()) {
        header('location: ../customer/index.php');
    } else {
        header('location: ../login.php');
    }
}

// call the addFood() function if btnAddFood is clicked
if (isset($_POST['btnAddFood'])) {
    addFood();
}

// REGISTER USER
function addFood()
{
    // call these variables with the global keyword to make them available in function
    global $mysqli, $errors, $nameFood, $priceFood, $foodType;

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $nameFood	= e($_POST['nameFood']);
    $priceFood	= e($_POST['priceFood']);
	$foodType	= e($_POST['foodType']);

    // form validation: ensure that the form is correctly filled
    if (empty($nameFood)) {
        array_push($errors, "Name is required");
    }
    if (empty($priceFood)) {
        array_push($errors, "Price is required");
    }
    if (empty($foodType)) {
        array_push($errors, "Type is required");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
		$query = "INSERT INTO fooddb (nameFood, priceFood, foodType) 
					VALUES('$nameFood', '$priceFood', '$foodType')";
		mysqli_query($mysqli, $query);
		$_SESSION['success']  = "New user successfully created!!";
		header('location: menu.php');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border: black;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
        }
    </style>

	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css"/>
    <title>TT</title>
</head>
<body>
    <center>
        <table>
            <tr>
                <th><img src="../img/tapir_logo.png" width="25%"/></th>
            </tr>
            <tr>
                <th><h3>TapirTapau(TT)</h3></th>
            </tr>
        </table>
    </center>

    <?php if (isset($_SESSION['user'])) : ?>
    <strong><?php echo $_SESSION['user']['username']; ?></strong>
    
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a class="active" href="menu.php">Manage Menu</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul><br><br>

	<?php echo display_error(); ?>
	<center>
		<form method="post" action="addFood.php">
			<table border="1">
				<tr>
					<td>Name</td>
					<td><input type="text" name="nameFood" placeholder="Ex: KitKat" value="<?php echo $nameFood; ?>"></td>
				</tr>
				<tr>
					<td>Price (RM)</td>
					<td><input type="number" name="priceFood" value="<?php echo $priceFood; ?>"></td>
				</tr>
				<tr>
					<td>Type</td>
					<td><select name="foodType">
							<option value="">-- Select type --</option>
							<option value="food">Food</option>
							<option value="drink">Drink</option>
						</select>
					</td>
				</tr>
				<tr>
					<th colspan="2"><button type="submit" name="btnAddFood">Add food</button></th>
				</tr>
			</table>
		</form>
	</center>
	<?php endif ?>
</body>
</html>