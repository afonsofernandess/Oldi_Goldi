<?php 

function isOnwhishlist($db, $itemID, $username) : bool{
    $stmt = $db->prepare('SELECT * FROM Whishlists WHERE item_id = ? AND username = ?');
    $stmt->execute(array($itemID, $username));
    $r = $stmt->fetch();

    if($r > 0) return true;
    else return false;
    
}
function addToWhishlist($db, $itemID, $username) : bool{
    $stmt = $db->prepare('INSERT INTO Whishlists (item_id, username) VALUES (? , ?)');
    $stmt->execute(array($itemID, $username));
    return true;
}

function removeFromWhishlist($db, $itemID, $username) : bool{
    $stmt = $db->prepare('DELETE FROM Whishlists WHERE item_id = ? AND username = ?');
    $stmt->execute(array($itemID, $username));
    return true;
}

function toggleWhishlist($db, $itemID, $username){
    if(isOnwhishlist($db, $itemID, $username)){
        removeFromWhishlist($db, $itemID, $username);
    }
    else{
        addToWhishlist($db, $itemID, $username);
    }
}



?>