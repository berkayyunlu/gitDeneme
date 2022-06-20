<?php

include 'dataModel.php';

/*$listInf =$conn-> prepare("SELECT * from user where id=:user_id");
$listInf -> execute(array('user_id' =>$_GET['id']));

$checkInf=$listInf->fetchAll(\PDO::FETCH_ASSOC);*/

//echo $_GET['user'];
//echo $_REQUEST['user'];

if (!isset($_GET['id'])) {
    echo "User id is required";
    die();
}

$userId = $_GET['id'];

$user = selectGetTable($conn, 'user', 'id', $userId);
$userInf = selectGetTable($conn, 'user_info', 'user_id', $userId);
//printArray($user);
?>

<h1>Database PDO Registration Procedures </h1>
<form action="dataModel.php" method="POST">

    <input type="text" name="full_name" value="<?php echo $user['full_name'] ?>" required>
    <input type="email" name="email" value="<?php echo $userInf['email'] ?>" required>
    <input type="text" name="age" value="<?php echo $user['age'] ?>" required>
    <input type="text" name="address" value="<?php echo $userInf['address'] ?>" required>
    <input type="text" name="phone" value="<?php echo $userInf['phone'] ?>" required>
    <input type="hidden" name="id" value="<?php echo $user['id'] ?>" required>
    <button type="submit" name="update">Send</button>

    
</form>

<form action="index.php">

<button type="submit" name="return">Return</button>

</form>