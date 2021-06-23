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
?>

<!DOCTYPE html>
<html lang="en">
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
    <title>TapirTapau</title>
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
        <li><a class="active" href="index.php">Home</a></li>
        <li><a href="menu.php">Manage Menu</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul><br><br>

    <center>
        <b>Staf (Amin)</b><br>
        menguruskan senarai - makanan<br>

        <table>
            <?php
            $sql = "SELECT * FROM orderdb";
            if ($result = $mysqli->query($sql)) {
                while ($row = $result->fetch_array()) {
            ?>
            <tr>
                <th>Order ID</th>
                <th>Food</th>
                <th>Food Quantity</th>
                <th>Drink</th>
                <th>Drink Quantity</th>
            </tr>
            <tr>
                <td><?php echo $row['idOrder']; ?></td>
                <td><?php echo $row['orderFood']; ?></td>
                <td><?php echo $row['quantityFood']; ?></td>
                <td><?php echo $row['orderDrink']; ?></td>
                <td><?php echo $row['quantityDrink']; ?></td>
            </tr>
            <?php
                }
            }
            ?>
        </table>
    </center>
    <?php endif ?>
</body>
</html>