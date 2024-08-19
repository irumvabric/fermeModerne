
<?php
include("admin/connexion.php");

function idToNom($connexion,$id_profil) {
    $sqlcountPersonne = "SELECT Nom FROM profil WHERE id_profil = ?";
    $stmtsqlcountPersonne = $connexion->prepare($sqlcountPersonne);
    $stmtsqlcountPersonne->execute([$id_profil]);
    return $stmtsqlcountPersonne->fetchColumn();
}


    $sql = "select id_personne,nom,prenom,profil from personne";
    $result = $connexion->query($sql);

    // Generate options for the select input
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $idProfile = $row["profil"];

            $nomProfile = idToNom($connexion,$idProfile);


            echo '<option value="' . $row["id_personne"] . '">' . $row["nom"] .' '. $row["prenom"] . ' '.$nomProfile. '</option>';
        }
    } else {
        echo '<option value="">No personne available</option>';
    }

?>
