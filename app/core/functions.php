<?php
ob_start();
function old_value($key)
{
    if (!empty($_POST[$key]))
        return $_POST[$key];
    return "";
}
function redirect($page)
{
    ob_end_clean();
    header('Location: ' . $page);
    die;
}
//SECURITY MODULE 
function getSecurityModules($pageNo)
{
    try {
        $response = [];

        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $pageSize = 20;
        $offset = ($pageNo - 1) * $pageSize;
        $query = "SELECT * FROM securitymodulestable ORDER BY RegisteredAt LIMIT :pageSize OFFSET :offset";

        $stm = $con->prepare($query);
        $stm->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $stm->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        $response['Success'] = true;
        $response['Structure'] = $result;
        $response['Error'] = null;
        $response['Message'] = null;

        return $response;
    } catch (PDOException $e) {

        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
function searchSecurityModule($seriesNo)
{
    try {
        $response = [];

        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $query = "SELECT * FROM securitymodulestable WHERE SeriesNo = :SeriesNo";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':SeriesNo', $seriesNo, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['Success'] = true;
        $response['Structure'] = $result;
        $response['Error'] = null;
        $response['Message'] = null;

        return $response;
    } catch (PDOException $e) {

        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
function getSecurityModulesCount()
{
    try {
        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
        $query = "SELECT COUNT(*) AS totalRows FROM securitymodulestable";
        $stm = $con->prepare($query);
        $stm->execute();
        $result = $stm->fetchColumn();
        return $result;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
function addSecurityModule(array $data = [])
{
    try {
        $response = [];

        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
        $query = "INSERT INTO securitymodulestable (RegisteredAt, RegisteredBy, SeriesNo, Nickname) VALUES (:RegisteredAt,:RegisteredBy,:SeriesNo,:Nickname)";

        $stm = $con->prepare($query);
        $stm->execute($data);

        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        $response['Success'] = true;
        $response['Structure'] = $result;
        $response['Error'] = null;
        $response['Message'] = "Security module registered";
        $_POST['SeriesNo'] = null;
        $_POST['Nickname'] = null;
        return $response;
    } catch (PDOException $e) {
        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
function validateSeriesNo($seriesNo)
{
    try {
        $response = [];

        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $query = "SELECT * FROM securitymodulestable WHERE SeriesNo = :SeriesNo";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':SeriesNo', $seriesNo, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['Success'] = true;
        $response['Structure'] = count($result) <= 0;
        $response['Error'] = null;
        $response['Message'] = false;
        return $response;
    } catch (PDOException $e) {
        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
function removeSecurityModule($seriesNo)
{
    try {
        $response = [];

        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $query = "DELETE FROM securitymodulestable WHERE SeriesNo = :seriesNo";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':seriesNo', $seriesNo, PDO::PARAM_STR);
        $stmt->execute();
        $rowCount = $stmt->rowCount();

        $response['Success'] = true;
        $response['Structure'] = null;
        $response['Error'] = null;
        $response['Message'] = "Security module '" . $seriesNo . "' was removed.";
        return $response;
    } catch (PDOException $e) {
        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
function editSecurityModule(array $data = [])
{
    try {
        $response = [];
        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
        $query = "UPDATE securitymodulestable 
                  SET SeriesNo = :SeriesNoEdit, 
                      Nickname = :Nickname, 
                      SMStatus = :SMStatus
                  WHERE SeriesNo = :SeriesNo";
        $stm = $con->prepare($query);
        $stm->bindParam(':SeriesNo', $data['SeriesNo'], PDO::PARAM_STR);
        $stm->bindParam(':SeriesNoEdit', $data['SeriesNoEdit'], PDO::PARAM_STR);
        $stm->bindParam(':Nickname', $data['Nickname'], PDO::PARAM_STR);
        $stm->bindParam(':SMStatus', $data['SMStatus'], PDO::PARAM_STR);
        $stm->execute($data);
        $rowCount = $stm->rowCount();

        if ($rowCount > 0) {
            $response['Success'] = true;
            $response['Structure'] = null;
            $response['Error'] = null;
            $response['Message'] = "Security module updated";
        } else {
            $response['Success'] = false;
            $response['Structure'] = null;
            $response['Error'] = "No rows updated. Invalid security module field value.";
            $response['Message'] = null;
        }
        return $response;
    } catch (PDOException $e) {
        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
//USER
function validateUsername($username)
{
    try {
        $response = [];

        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $query = "SELECT * FROM userstable WHERE Username = :uname";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':uname', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['Success'] = true;
        $response['Structure'] = count($result) <= 0;
        $response['Error'] = null;
        $response['Message'] = false;
        return $response;
    } catch (PDOException $e) {
        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
function validateEmail($email)
{
    try {
        $response = [];

        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $query = "SELECT * FROM userstable WHERE Email = :email";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['Success'] = true;
        $response['Structure'] = count($result) <= 0;
        $response['Error'] = null;
        $response['Message'] = false;
        return $response;
    } catch (PDOException $e) {
        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
function registerUser($data)
{
    try {
        $response = [];

        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $query = "INSERT INTO userstable(Username, Fullname, Email, HashPassword) VALUES (:_username,:_name,:_email,:_hashPassword)";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':_name', $data['Name'], PDO::PARAM_STR);
        $stmt->bindParam(':_username', $data['Username'], PDO::PARAM_STR);
        $stmt->bindParam(':_email', $data['Email'], PDO::PARAM_STR);
        $stmt->bindParam(':_hashPassword', $data['HashPassword'], PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['Success'] = true;
        $response['Structure'] = count($result) <= 0;
        $response['Error'] = null;
        $response['Message'] = 'User successfully created.';
        return $response;
    } catch (PDOException $e) {
        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
function getUsersCount()
{
    try {
        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
        $query = "SELECT COUNT(*) AS totalRows FROM userstable";
        $stm = $con->prepare($query);
        $stm->execute();
        $result = $stm->fetchColumn();
        return $result;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
function getUsers($pageNo)
{
    try {
        $response = [];

        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $pageSize = 20;
        $offset = ($pageNo - 1) * $pageSize;
        $query = "SELECT * FROM userstable LIMIT :pageSize OFFSET :offset";

        $stm = $con->prepare($query);
        $stm->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $stm->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        $response['Success'] = true;
        $response['Structure'] = $result;
        $response['Error'] = null;
        $response['Message'] = null;

        return $response;
    } catch (PDOException $e) {

        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
function removeUser($username)
{
    try {
        $response = [];

        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $query = "DELETE FROM userstable WHERE Username = :username";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $rowCount = $stmt->rowCount();

        $response['Success'] = true;
        $response['Structure'] = null;
        $response['Error'] = null;
        $response['Message'] = $username . " was removed.";
        return $response;
    } catch (PDOException $e) {
        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
function changePassword($data)
{
    try {
        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $query = "UPDATE userstable SET HashPassword = :_hpassword WHERE (Username = :_uname AND HashPassword = :_hpass)";

        $stm = $con->prepare($query);
        $stm->bindParam(':_hpassword', $data['NewHashPassword'], PDO::PARAM_STR);
        $stm->bindParam(':_hpass', $data['HashPassword'], PDO::PARAM_STR);
        $stm->bindParam(':_uname', $data['Username'], PDO::PARAM_STR);
        $stm->execute();
        $rowCount = $stm->rowCount();

        if ($rowCount > 0) {
            $response['Success'] = true;
            $response['Structure'] = null;
            $response['Error'] = null;
            $response['Message'] = "Password updated";
        } else {
            $response['Success'] = false;
            $response['Structure'] = null;
            $response['Error'] = "No rows updated. User or current password might be incorrect.";
            $response['Message'] = null;
        }
    } catch (PDOException $e) {
        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
    }
    return $response;
}
//GENERAL FUNCTIONS
function refreshPage()
{
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
//ACCOUNT
function validateLoginData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function login($data)
{
    try {
        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        $sql = "SELECT * FROM userstable WHERE (Username = :_username OR UPPER(Email) = UPPER(:_username)) AND HashPassword = :_hpassword";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':_username', $data['Username'], PDO::PARAM_STR);
        $stmt->bindParam(':_hpassword', $data['HashPassword'], PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            $response['Success'] = false;
            $response['Structure'] = null;
            $response['Error'] = "Account not found.";
            $response['Message'] = null;
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($data['RememberMe'])) {
                setcookie("remember_me", session_id(), time() + (30 * 24 * 60 * 60), "/");
                ini_set('session.gc_maxlifetime', 86400);
            }
            $_SESSION['Username'] = $row['Username'];
            $_SESSION['Name'] = $row['Fullname'];
            $_SESSION['Id'] = $row['id'];
            $_SESSION['Email'] = $row['Email'];

            $response['Success'] = true;
            $response['Structure'] = null;
            $response['Error'] = null;
            $response['Message'] = null;
        }
        return $response;
    } catch (PDOException $e) {
        $response['Success'] = false;
        $response['Structure'] = null;
        $response['Error'] = $e->getMessage();
        $response['Message'] = null;
        return $response;
    }
}
function logout()
{
    session_unset();
    session_destroy();
}

