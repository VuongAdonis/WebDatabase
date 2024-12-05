<?php
// phpinfo();

$serverName="LAPTOP-3N96E8CK";
$database="TESTBTL2";
$uid="";
$pass="";

$connection=[
    "Database" => $database,
    "Uid" => $uid,
    "PWD" => $pass
];

$conn = sqlsrv_connect($serverName, $connection);
if(!$conn)
    die(print_r(sqlsrv_errors(), true));

// $tsql = "select * from USERS";
// $stmt = sqlsrv_query($conn,$tsql);

// if($stmt == false)
// {
//     echo 'Error';
// }

// while($obj = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
// {
//     echo $obj['FName'].'</br>';
// }
// sqlsrv_free_stmt($stmt);
// sqlsrv_close($conn);

?>