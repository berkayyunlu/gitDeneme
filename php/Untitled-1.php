 
<?php
function printArray($value)
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}

////////////////////////////////////////////////////

//selects all users from user table
$users = selectGetTable($conn, 'user');

$userIds = [];
$userTypeIds=[];

//sets userIds and userTypeIds arrays
foreach ($users as $user){
    $userIds[] = $user['id'];
    $userTypeIds[]=$user['type_id'];
}

//creating where IN strings with implode functions
$userIdsInString = implode(',', $userIds);
$userTypeIdsInString = implode(',', $userTypeIds);

//selects all userInfos with defined userIds
$sth = $conn->prepare("SELECT * FROM user_info WHERE user_id IN ($userIdsInString)");
$sth->execute();
$userInf = $sth->fetchAll(\PDO::FETCH_ASSOC);

//selects all userTypes with defined userTypeIds
$sth = $conn->prepare("SELECT * FROM user_type WHERE user_id IN ($userTypeIdsInString)");
$sth->execute();
$userType = $sth->fetchAll(\PDO::FETCH_ASSOC);

////////////////////////////////////////////////////

$user = selectGetTable($conn, 'user', 'id', 2);

$user_id = $user[0]['id'];
$user_type_id = $user[0]['user_type_id'];
$userInf = selectGetTable('user_info', 'user_id', $user_id, $conn);
$userType = selectGetTable('user_type', 'id', $user_type_id, $conn);


function userAllData($conn)
{

    $sth = $conn->prepare("SELECT u.full_name,u.age,ui.email,ui.phone,ut.name as type_name FROM user u inner join user_info ui on u.id =ui.user_id inner JOIN user_type ut on ut.id =u.user_type_id");
    $sth->execute();
    $value4 = $sth->fetchAll(\PDO::FETCH_ASSOC);
    return $value4;
}

function selectGetTable($conn, $table, $column = null, $value = null)
{
    ////////////////////////////////////////////////////
    $sqlStatement = "SELECT * FROM " . $table;

    if ($column !== null && $value !== null)
        $sqlStatement .= $column . " = " . $value;

    //$sqlStatement .= ($column !== null && $value !== null) ? $column . " = " . $value : '';

    //$sqlStatement .= $column ?? '';

    $sth = $conn->prepare($sqlStatement);

    $sth->execute();

    $data = $sth->fetchAll(\PDO::FETCH_ASSOC);

    return $data;
    ////////////////////////////////////////////////////
}

function selectGetAllTable($table, $conn)
{
    $sth = $conn->prepare("SELECT * FROM $table");
    $sth->execute();
    $value4 = $sth->fetchAll(\PDO::FETCH_ASSOC);
    return $value4;
}

$users = userAllData($conn);



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*$sth = $conn->prepare("SELECT * FROM user where id = 3");
$sth->execute();
$user = $sth->fetchAll(\PDO::FETCH_ASSOC);
printArray($user);

$sth = $conn->prepare("SELECT * FROM user_info where user_id = " . $user[0]['id']);
$sth->execute();
$userInf = $sth->fetchAll(\PDO::FETCH_ASSOC);
printArray($userInf);

$sth = $conn->prepare("SELECT * FROM user_type where id = " . $user[0]['id']);
$sth->execute();
$userType = $sth->fetchAll(\PDO::FETCH_ASSOC);
echo "<pre>";
print_r($userType);
echo "</pre>";
*/
$mergedUser = [];

$mergedUser['full_name'] = $user[0]['full_name'];
$mergedUser['email'] = $userInf[0]['email'];
$mergedUser['address'] = $userInf[0]['address'];
$mergedUser['type'] = $userType[0]['name'];

echo "<pre>";
print_r($mergedUser);
echo "</pre>";
/*$userArray =[$user,$userType,$userInf];
$userArray = $sth->fetchAll(\PDO::FETCH_ASSOC);
echo"<pre>";
print_r($userArray);
echo"</pre>";

print_r($userArray);*/
/**
 * user array
 * 
 * full_name
 * email
 * phone
 * address
 * type
 */


 

$save = $conn->prepare("UPDATE user set
                   
age=:age
where Userid=if(){$_POST['id']}");

$postArray = array(
'full_name' => $_POST['full_name'] ?? dd('full_name field is required!'),
'age' => $_POST['age'] ?? dd('age field is required!')
);

$insert = $save->execute($postArray);

$save = $conn->prepare("UPDATE user_info set
   
    email=:email
    address=:address,
    phone=:phone
    where id={$_POST['user_id']}");


$insert = $save->execute(array(
'email' => $_POST['email'],
'address' => $_POST['address'],
'phone' => $_POST['phone']
));

$delete =$conn ->prepare("DELETE from `user` u JOIN  `user_info`ui ON u.id =ui.user_id where id=:id");

$delete = $conn->prepare("DELETE from user  INNER JOIN user_info   ON user.id =user_info.user_id where user.full_name, user.age, user_info.email
user_info.phone,user_info.address");



$curl = new Curl("https://api.open5e.com/", true);

$result = $curl->getResult();

$content = new Curl($result->$category, true);

$contentInfo = $content->getResult()->results;



if ($category == "spells") {
    $indexes = [
        'name',
        'desc',
        'material',
        'range'
    ];
} else if ($category == "weapons") {
    $indexes = [
        'name',
        'category',
        'cost',
        'damage_dice'
    ];
} else if ($category == "monsters") {
    $indexes = [
        'name',
        'type',
        'size',
        'hit_points'
    ];
} else if ($category == "races") {
    $indexes = [
        'name',
        'desc',
        'age',
        'speed'
    ];
}



//

$modifiedContentInfo = setContentInfo($contentInfo, $indexes);

echo "<pre>";
print_r($modifiedContentInfo);
echo "</pre>";
}
}

function setContentInfo($contentInfo, array $indexes)
{
$return = [];

foreach (array_slice($contentInfo, 0, 10) as $key => $value) {
foreach ($indexes as $index) {
    $return[$key][$index] = $value->$index;
}
}

return $return;
}