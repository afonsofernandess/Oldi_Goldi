<?php

function userExists($username, $password) : bool{
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT password from Users where username = ?');
    $stmt->execute(array($username));
    $result = $stmt->fetch();

    if ($result && password_verify($password, $result['password'])) {
        return true;
    } else {
        return false;
    }
}

function newUser($username, $name, $email, $password, $C_password) : bool{
    $options = ['cost' => 10];
    $db = getDatabaseConnection();
    $stmt = $db->prepare("INSERT OR IGNORE INTO Users (username,name,email,password) VALUES (?,?,?,?)");
    $stmt->execute(array($username,$name,$email,password_hash($password, PASSWORD_DEFAULT, $options)));
    return true;
}

function verify_UserPassword($db,$username,$password) : bool{
    $stmt = $db->prepare("SELECT password from Users where username = ?");
    $stmt->execute(array($username));
    $result = $stmt->fetch();
    if(password_verify($password, $result["password"])) return true;
    else return false;
}

function verify_UsernameExists($db,$username) : bool{
    $stmt = $db->prepare("SELECT count(*) from Users where username = ?");
    $stmt->execute(array($username));
    $result = $stmt->fetchColumn();
    if($result > 0) return true;
    else return false;
}

function verify_EmailExists($db,$email) : bool{
    $stmt = $db->prepare("SELECT count(*) from Users where email = ?");
    $stmt->execute(array($email));
    $result = $stmt->fetchColumn();
    if($result > 0) return true;
    else return false;
}

function verify_IfPasswordMatch($db,$username,$password){
    
    $stmt = $db->prepare("SELECT password from Users where username = ?");
    $stmt->execute(array($username));
    $result = $stmt->fetchColumn();
    if(password_verify($password, $result)) return true;
    else return false;

}

function ElevateUserToAdmin($db,$username){
    $stmt = $db->prepare("UPDATE Users SET isAdmin = 1 WHERE username = ?");
    $stmt->execute(array($username));
}

function getUserPermissions($db,$username){
    $stmt = $db->prepare("SELECT isAdmin from Users where username = ?");
    $stmt->execute(array($username));
    $result = $stmt->fetchColumn();
    return $result;
}


?>