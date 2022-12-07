<?php
function confirm_rol($id, $conn){
    $consult = $conn->prepare('SELECT id, roles_id FROM users WHERE id=:id');
    $consult->bindParam(':id', $id);
    $consult->execute();
    $result = $consult->fetch(PDO::FETCH_ASSOC);

    if($result['roles_id'] == 1){
        return TRUE;
    } else {
        return FALSE;
    }
}
?>