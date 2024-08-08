<?php 
function idToNom($connexion,$id_profil) {
    $sqlcountPersonne = "SELECT Nom FROM profil WHERE id_profil = ?";
    $stmtsqlcountPersonne = $connexion->prepare($sqlcountPersonne);
    $stmtsqlcountPersonne->execute([$id_profil]);
    return $stmtsqlcountPersonne->fetchColumn();
}
?>