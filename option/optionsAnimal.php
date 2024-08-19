<?php
include("admin/connexion.php");


    $sql = "select id_animal,Type from animaux";
    $result = $connexion->query($sql);

    // Generate options for the select input
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row["id_animal"] . '">' . $row["id_animal"] .' '. $row["Type"]. '</option>';
        }
    } else {
        echo '<option value="">No classe id available</option>';
    }

?>

