<?php
if(!isset($_GET['SeriesNo']))
{
    header('Content-Type: application/json');
    $data = array(
        'Registered' => false,
    );
    $jsonData = json_encode($data);
    echo $jsonData;
    return $jsonData;
}
else
{
    $response = [];

        $string = "mysql:hostname=".DBHOST.";dbname=".DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $query = "SELECT * FROM securitymodulestable WHERE SeriesNo = :SeriesNo";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':SeriesNo', $_GET['SeriesNo'], PDO::PARAM_STR); 
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
        header('Content-Type: application/json');
        $data = array(
            'Registered' => count($result) > 0,
        );
        $jsonData = json_encode($data);
        echo $jsonData;
        return $jsonData;
}