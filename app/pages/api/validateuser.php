<?php
$jsonInput = file_get_contents('php://input');
$data = json_decode($jsonInput, true);

if (!$data || !isset($data['Username']) || !isset($data['HashPassword'])) {
    // Invalid JSON structure or missing values
    header('Content-Type: application/json', true, 400);
    $response = array(
        'Success' => false,
        'Structure' => null,
        'Error' => array(
            'Code' => 400,
            'Message' => "Invalid JSON structure or missing values."
        )
    );
} else {
    try {
        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM userstable WHERE (Username = :_username OR UPPER(Email) = UPPER(:_username)) AND HashPassword = :_hpassword";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':_username', $data['Username'], PDO::PARAM_STR);
        $stmt->bindParam(':_hpassword', $data['HashPassword'], PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) == 0) {
            // Account not found
            header('Content-Type: application/json', true, 401);
            $response = array(
                'Success' => false,
                'Structure' => null,
                'Error' => array(
                    'Code' => 401,
                    'Message' => "Account not found."
                )
            );
        } else {
            // Success
            header('Content-Type: application/json', true, 200);
            $response = array(
                'Success' => true,
                'Structure' => null,
                'Error' => null
            );
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        header('Content-Type: application/json', true, 500);
        $response = array(
            'Success' => false,
            'Structure' => null,
            'Error' => array(
                'Code' => 500,
                'Message' => "Internal Server Error: " . $e->getMessage()
            )
        );
    }
}

// Respond with JSON data
echo json_encode($response);
