<?php
include("admin/connexion.php");


    $sql = "select id_profil,Nom from profil";
    $result = $connexion->query($sql);

    // Generate options for the select input
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row["id_profil"] . '">' . $row["Nom"] .'</option>';
        }
    } else {
        echo '<option value="">No classe id available</option>';
    }

?>

