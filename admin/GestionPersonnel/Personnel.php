<?php
include("../connexion.php");
?>


<!DOCTYPE html>
<html>
<head>
<style>
	body {
  padding: 0;
  margin: 0;
  font-family: Arial, sans-serif;
  background-color: #f0f0f0;
}

nav {
      background-color: #45a000;
      color: #fff;
      text-align: center;
      padding: 1em;
    }

    nav a {
      color: #fff;
      text-decoration: none;
      padding: 10px 20px;
      margin: 0 10px;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    nav a:hover {
      color: #000;
      background-color: #45a569;
    }

.wrapper {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 20px;
}

.form{
  width: 35%; 
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  background-color: #fff;
  margin: 0 10px;
}

.table {
  width: 65%; 
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  background-color: #fff;
  margin: 0 10px;
}

form table,
.table table {
  width: 100%;
  border-collapse: collapse;
  border-radius: 20px;
}

.table table td,
.form table th,
.table table th {
  border: 1px solid #45a049;
  padding: 8px;
  text-align: left;
}

input[type='text'],
select,
input[type='number'],
textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-bottom: 10px;
}

input[type='submit'],
input[type='reset'] {
  padding: 10px 20px;
  border: none;
  background-color: #4CAF50;
  color: white;
  cursor: pointer;
  border-radius: 4px;
  font-size: 16px;
}

input[type='submit']:hover,
input[type='reset']:hover {
  background-color: #45a049;
}

.header {
  background-color: #333;
  color: #fff;
  text-align: center;
  padding: 1em;
}

.wrapper h1 {
  font-size: 36px;
  text-align: center;
}
</style>
</head>
<body>
  
  
  <?php
    include("../subMenu.php");
  ?>
	
  <div class="wrapper">
    <!-- Form section -->
    <div class="form">
        <form method="POST">
        <h1>Ajout Personnel</h1>
          <table>
            <tr>
              <td> ID Personnel </td>
              <td><input type="text" name="id" placeholder="Auto-Complete" disabled/></td>
            </tr>

            <tr>
              <td> Nom</td>
              <td><input type="text" name="Nom" /></td>
            </tr>

            <tr>
              <td> Prenom </td>
              <td><input type="text" name="Prenom" /></td>
            </tr>

            <tr>
              <td> phone</td>
              <td><input type="text" name="phone" /></td>
            </tr>

            <tr>
              <td> email </td>
              <td><input type="text" name="email" /></td>
            </tr>

            <tr>
              <td> Profile</td>
              <td>
              <select name="profil"  >
              <?php include '../../option/optionsprofil.php'; ?>           
            </select>
              </td>
            </tr>

            <!-- <tr>
              <td> Faculté</td>
              <td><input type="text" name="Faculte" /></td>
            </tr> -->

            <tr>
              <td colspan="2">
                <input type="submit" name="submit" value="Save" />
                <input type="reset" value="Cancel" />
              </td>
            </tr>
          </table>
        </form>
    </div>


    <?php 
    function countPers($connexion) {
      $sqlcountPersonne = "SELECT COUNT(*) FROM personne";
      $stmtsqlcountPersonne = $connexion->prepare($sqlcountPersonne);
      $stmtsqlcountPersonne->execute();
      return $stmtsqlcountPersonne->fetchColumn();
  }
  
  function countPersonPara($connexion, $profil) {
      $sqlcountPersonne = "SELECT COUNT(*) FROM personne WHERE profil = ?";
      $stmtsqlcountPersonne = $connexion->prepare($sqlcountPersonne);
      $stmtsqlcountPersonne->execute([$profil]);
      return $stmtsqlcountPersonne->fetchColumn();
  }

  function idToNom($connexion,$id_profil) {
    $sqlcountPersonne = "SELECT Nom FROM profil WHERE id_profil = ?";
    $stmtsqlcountPersonne = $connexion->prepare($sqlcountPersonne);
    $stmtsqlcountPersonne->execute([$id_profil]);
    return $stmtsqlcountPersonne->fetchColumn();
}
  
  if (isset($_POST['submit'])) {
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $phone = $_POST['phone'];
    $email =$_POST['email'];
    $profil =$_POST['profil'];

    
  
    $NombrePersonnne = countPersonPara($connexion, $profil) + 1;
    $idToNom = idToNom($connexion, $profil);
  
    $id = Strtoupper(substr($idToNom, 0, 1)) . "-" . $NombrePersonnne . "-" . date("Y");
     
  
      try {
          $connexion->beginTransaction();
  
          $insertPersonne = "INSERT INTO personne(id_personnel,Nom,prenom,phone,email,profil) VALUES(?,?,?,?,?,?)";
          $stmtInsert = $connexion->prepare($insertPersonne);
          $result = $stmtInsert->execute([$id,$Nom,$Prenom,$phone,$email,$profil]);
  
          if ($result) {
              // $updateOperation = "
              // UPDATE compte
              // SET solde = CASE
              //     WHEN ? = 'Retrait' THEN solde - ?
              //     WHEN ? = 'Virement' THEN solde + ?
              //     ELSE solde
              // END
              // WHERE id_compte = ?;";
  
              // $stmtUpdate = $connexion->prepare($updateOperation);
              // $resultUpdate = $stmtUpdate->execute([$Type, $Montant, $Type, $Montant, $Compte]);
  
              // if ($resultUpdate) {
                  $connexion->commit();
                  $error = "Successfully added";
              // } else {
              //     $connexion->rollBack();
              //     $error = "Data have not been updated";
              // }
          } else {
              $connexion->rollBack();
              $error = "Data have not been added";
          }
      } catch (Exception $e) {
          $connexion->rollBack();
          $error = "Transaction failed: " . $e->getMessage();
      }
  }
?>
    <!-- Table section -->
    <div class="table">
    <table>
            <tr>
              <th>id Personne</th>
              <th>Nom</th>
              <th>Prenom</th>
              <th>phone</th>
              <th>Email</th>
              <th>Profil</th>
              <th>Functions</th>
            </tr>
            <?php

                include("../connexion.php");
                $sql = "SELECT * FROM personne"; 
                $stmtSelect = $connexion->prepare($sql);
                $stmtSelect ->execute();
                $personnes = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
                foreach($personnes as $personne): 
                ?>
            <tr>
                <td> <?php echo $personne['id_personnel'];?></td>
                <td> <?php echo $personne['Nom'];?></td>
                <td> <?php echo $personne['prenom'];?></td>
                <td> <?php echo $personne['phone'];?></td>
                <td> <?php echo $personne['email'];?></td>
                <td> <?php echo $personne['profil'];?></td>                
                <td>Edit || Delete</td>
            </tr>
            <?php 
              endforeach;
            ?>
      </table>
      </div>
  </div>
 

</body>
</html>