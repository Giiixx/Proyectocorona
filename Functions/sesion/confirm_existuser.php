<?php
function confirm_existuser($id, $conn){
    $consult = $conn->prepare('SELECT idEstablecimiento FROM usuarios WHERE idEstablecimiento=:id');
    $consult->bindParam(':id', $id);
    $consult->execute();
    $result = $consult->fetch(PDO::FETCH_ASSOC);

    try {
        return count($result) > 0 ? TRUE : FALSE;
    } catch (\Throwable $th) {
        return FALSE;
    } 
}
?>