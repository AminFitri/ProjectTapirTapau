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
        <li><a href="index.php">Home</a></li>
        <li><a class="active" href="menu.php">Manage Menu</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul><br><br>

    <center>
        <form method="post" action="index.php">
            <table border="1">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th></th>
                </tr>

                <a href="addFood.php" >Add food/drink</a><br><br>
                
                <?php
                $sql = "SELECT * FROM fooddb";
                if ($result = $mysqli->query($sql)) {
                    while ($row = $result->fetch_array()) {
                ?>

                <tr>
                    <td><input type="text" name="foodName" value="<?php echo $row['foodName']; ?>" required /></td>
                    <td><input type="number" name="foodPrice" value="<?php echo $row['foodPrice']; ?>" required /></td>
                    <td>
                        <select>
                            <?php $foodType = $row['foodType']; ?>
                            <option value="food" <?php if($foodType=="food") echo 'selected="selected"'; ?> >Food</option>
                            <option value="drink" <?php if($foodType=="drink") echo 'selected="selected"'; ?> >Drinks</option>
                        </select>
                        
                    </td>
                    <th>
                        <a href="editFood.php?id=<?php echo $row['idFood']; ?>" >Edit</a>
                        |
                        <a href="deleteFood.php?id=<?php echo $row['idFood']; ?>" >Delete</a>
                    </th>
                </tr>

                <?php
                    }
                }
                ?>
            </table>
        </form>
    </center>
    <?php endif ?>
</body>
</html>