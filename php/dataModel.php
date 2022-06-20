<?php

include 'init.php';

function printArray($value)
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}

function dd($string)
{
    echo "<pre>";
    print_r($string);
    echo "</pre>";
    die();
}

/*/$user = selectGetTable('user','id',2,$conn);
$user_id = $user[0]['id'];
$user_type_id=$user[0]['user_type_id'];
$userInf=selectGetTable('user_info','user_id',$user_id,$conn);
$userType=selectGetTable('user_type','id',$user_type_id,$conn);*/


function userAllData($conn)
{

    $sth  = $conn->prepare("SELECT u.id, u.full_name,u.age,ui.email,ui.phone,ui.address,ut.name AS type_name FROM user u INNER JOIN user_info ui ON
    u.id =ui.user_id 
    INNER JOIN user_type ut on ut.id =u.user_type_id");
    $sth->execute();
    $value4 = $sth->fetchAll(\PDO::FETCH_ASSOC);
    return $value4;
}

//function selectGetTable ($table,$value1,$value2,$conn)   {
//    $sth = $conn->prepare("SELECT * FROM $table where $value1 = ".$value2 );
//    $sth->execute();
//    $value4 = $sth->fetchAll(\PDO::FETCH_ASSOC);
//    return $value4;
//    
//    }
function selectGetAllTable($table, $conn)
{
    $sth = $conn->prepare("SELECT * FROM $table");
    $sth->execute();
    $value4 = $sth->fetchAll(\PDO::FETCH_ASSOC);
    return $value4;
}

function selectGetTable($conn, $table, $column = null, $value = null)
{
    ////////////////////////////////////////////////////
    $sqlStatement = "SELECT * FROM " . $table;

    if ($column !== null && $value !== null)
        $sqlStatement .= " WHERE " . $column . " = " . $value;

    $sth = $conn->prepare($sqlStatement);

    $sth->execute();

    if ($column !== null && $value !== null)
        $data = $sth->fetch(\PDO::FETCH_ASSOC);
    else
        $data = $sth->fetchAll(\PDO::FETCH_ASSOC);

    return $data;
}

if (isset($_POST['update'])) {

    $userId = $_POST['id'] ?? dd("Not found user id");

    $sql = "UPDATE user SET full_name=:full_name, age=:age WHERE id=:id;";

    $updateArray = array(
        'id' => $userId,
        'full_name' => $_POST['full_name'] ?? dd("Empty full name field"),
        'age' => $_POST['age'] ?? dd("Empty age field")
    );

    $save = $conn->prepare($sql);
    $updateFlag = $save->execute($updateArray);

    $userId = $_POST['id'] ?? dd("Not found user id");

    $sql1 = "UPDATE user_info SET email=:email, phone=:phone, address=:address WHERE id=:id;";

    $updateArray1 = array(
        'id' => $userId,
        'email' => $_POST['email'] ?? dd("Empty full name field"),
        'phone' => $_POST['phone'] ?? dd("Empty age field"),
        'address' => $_POST['address'] ?? dd("Empty address field")
    );

    $save = $conn->prepare($sql1);
    $updateFlag = $save->execute($updateArray1);



    /*
    $save = $conn->prepare("UPDATE user_info set 
                         email=:email,
                         phone=:phone,
                         address=:address
                         where id=$userId");

    $updateInfo = array(
        'email' => $_POST['email'] ?? "Empty email field",
        'phone' => $_POST['phone'] ?? "Empty email field",
        'address' => $_POST['address'] ?? "Empty address field"
    );
    $insert = $save->execute($updateInfo);
    */

    if ($updateFlag) {
        ob_start();
        header("Location:http://localhost:8100/edit.php?id=" . $userId);
        ob_end_flush();
        die();
    } /*else {


        //echo "kayıt başarısız";
        Header("Location:duzenle.php?durumno&bilgilerim_id=$bilgilerim_id");
        exit;
    }
    */
}





if (isset($_GET['deleteinf']) && $_GET['deleteinf'] == "ok") {

    $userId = $_GET['id'] ?? dd("not found user id");

    $delete1 = $conn->prepare("DELETE from user_info where user_id=:id");
    $deleteArray1 = array('id' => $userId);
    $control1 = $delete1->execute($deleteArray1);

    $delete = $conn->prepare("DELETE from user where id=:id");
    $deleteArray = array('id' => $userId);
    $control = $delete->execute($deleteArray);

    if ($control1 && $control) {
        ob_start();
        header("Location:http://localhost:8100/index.php");
        ob_end_flush();
        die();
    }
}

if (isset($_POST['insert'])) {


    $saveUser = $conn->prepare("INSERT into user set
        full_name=:full_name,
        age=:age,
        user_type_id=:user_type_id
        ");

    $userInsertArray = array(
        'full_name' => $_POST['full_name'],
        'age' => $_POST['age'],
        'user_type_id' => $_POST['user_type_id']
    );

    $insert1 = $saveUser->execute($userInsertArray);
    $userId = $conn->lastInsertId();

    $saveUserInfo = $conn->prepare("INSERT into user_info set
            user_id=:user_id,
            email=:email,
            phone=:phone,
            address=:address
        ");

    $insert = $saveUserInfo->execute(array(
        'user_id' => $userId,
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address']
    ));

    /* $saveUserType =$conn ->prepare("INSERT into user_type set
    ")
*/

    /*$saveUserType =$conn->prepare("INSERT into user_type set 
    name=:")
*/
    if ($insert && $insert1) {
        // echo "Kayıt başarılı";
        Header("Location:index.php");
    }
}

//$saveUser1 =$conn ->prepare(Ins)
