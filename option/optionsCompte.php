<?php
include("admin/connexion.php");


    $sql = "select 	id_compte,Type from compte";
    $result = $connexion->query($sql);

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row["id_compte"] . '">' .$row["id_compte"] . '-'.$row["Type"].'</option>';
        }
    } else {
        echo '<option value="">No classe available</option>';
    }

?>

