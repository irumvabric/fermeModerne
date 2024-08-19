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
input[type='number'],
select,
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

     .error {
            width: 75%;
            font-size: 12px;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            border: 2px solid #ff0000;
            background-color:  #ff0000;
            color: wheat;
            margin-left:9%;
            margin-bottom: 10px;
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
        <h1>Ajout Operation</h1>
        <?php if (isset($error)) { ?>
            <div class="error"><?= $error ?></div>
        <?php } ?>
          <table>
            <tr>
              <td> ID Operation </td>
              <td><input type="text" name="idOperation" placeholder="Auto-complete" disabled/></td>
            </tr>

            <tr>
              <td> Description</td>
              <td><input type="text" name="Description" /></td>
            </tr>

            <tr>
              <td> Montant</td>
              <td><input type="text" name="Montant"></td>
            </tr>

            <tr>
              <td> Type </td>
              <td>
              <select name="Type"  >
                    <option value="Retrait">Retrait</option>
                    <option value="Virement">Virement</option>
            </select>
              </td>
            </tr>

            <tr>
              <td> Compte</td>
              <td>
              <select name="Compte"  >
              <?php include '../../option/optionsCompte.php'; ?>           
            </select>
              </td>
            </tr>

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

function countOperation($connexion) {
      $sqlcountOperation = "SELECT COUNT(*) FROM operation";
      $stmtsqlcountOperation = $connexion->prepare($sqlcountOperation);
      $stmtsqlcountOperation->execute();
      return $stmtsqlcountOperation->fetchColumn();
  }
  
  function countOperPara($connexion, $TypeOp) {
      $sqlcountOperation = "SELECT COUNT(*) FROM operation WHERE type = ?";
      $stmtsqlcountOperation = $connexion->prepare($sqlcountOperation);
      $stmtsqlcountOperation->execute([$TypeOp]);
      return $stmtsqlcountOperation->fetchColumn();
  }
  
  if (isset($_POST['submit'])) {
    $Description = $_POST['Description'];
    $Montant = $_POST['Montant'];
    $Type = $_POST['Type'];
    $Compte =$_POST['Compte'];
  
      $NombreOperation = countOperPara($connexion, $Type) + 1;
  
      if ($Type == 'Retrait') {
          $id = "R-" . substr($Compte, 0, 4) . "-" . $NombreOperation . "-" . date("Y");
      } else if ($Type == 'Virement') {
          $id = "V-" . substr($Compte, 0, 4) . "-" . $NombreOperation . "-" . date("Y");
      }
  
      try {
          $connexion->beginTransaction();
  
          $insertoperation = "INSERT INTO operation(id_operation, Description, montant, compte, type,Date) VALUES(?,?,?,?,?,Now())";
          $stmtInsert = $connexion->prepare($insertoperation);
          $result = $stmtInsert->execute([$id, $Description, $Montant, $Compte, $Type]);
  
          if ($result) {
              $updateOperation = "
              UPDATE compte
              SET solde = CASE
                  WHEN ? = 'Retrait' THEN solde - ?
                  WHEN ? = 'Virement' THEN solde + ?
                  ELSE solde
              END
              WHERE id_compte = ?;";
  
              $stmtUpdate = $connexion->prepare($updateOperation);
              $resultUpdate = $stmtUpdate->execute([$Type, $Montant, $Type, $Montant, $Compte]);
  
              if ($resultUpdate) {
                  $connexion->commit();
                  $success = "Successfully added";
              } else {
                  $connexion->rollBack();
                  $error2 = "Data have not been updated";
              }
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

<?php
    if(isset($_GET["supp"])){
        $Recusup=$_GET["supp"];
        $suputil=$connexion -> query ("delete * from cour where id=$Recusup");
    }
    ?>
    <!-- Table section -->
    <div class="table">
    <table>
            <tr>
              <th>id</th>
              <th>Description</th>
              <th>Montant</th>
              <th>Compte</th>
              <th>Type</th>
              <th>Date</th>

            </tr>
            <?php

                include("../connexion.php");
                $sql = "SELECT * FROM operation"; 
                $stmtSelect = $connexion->prepare($sql);
                $stmtSelect ->execute();
                $operations = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
                foreach($operations as $operation): 
                ?>
            <tr>
                <td> <?php echo $operation['id_operation'];?></td>
                <td><?php echo $operation['Description']; ?></td>
                <td> <?php echo $operation['montant'];?></td> 
                <td> <?php echo $operation['compte'];?></td> 
                <td> <?php echo $operation['type'];?></td> 
                <td> <?php echo $operation['Date'];?></td> 
                
            </tr>
            <?php 
              endforeach;
            ?>
      </table>
      </div>
  </div>
 
  

</body>
</html>