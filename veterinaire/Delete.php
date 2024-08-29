<?php
include("../admin/connexion.php");
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
input[type='password'],
input[type='date'],
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
</style>
</head>
<body>
  
<?php
    include("subMenu.php");
  ?>
	
  <div class="wrapper">
    <!-- Form section -->
    <div class="form">
        <form method="POST">
        <h1>Ajout Sur Journal</h1>
        <table>
            <tr>
              <td> Personne </td>
              <td>
              <select name="personne" >
              <?php include '../option/optionsPersonne.php'; ?>           
            </select>
              </td>
            </tr>

            <tr>
              <td> Description	</td>
              <td><input type="text" name="Description" /></td>
            </tr>


            <tr>
              <td> Date	</td>
              <td><input type="Date" name="Date" /></td>
            </tr>

            <tr>
              <td> IDAnimal </td>
              <td>
              <select name="id_Animal"  >
              <?php include '../option/optionsAnimal.php'; ?>           
            </select>
              </td>
            </tr>

            <tr>
              <td> Produit(en litre) </td>
              <td><input type="number" name="Quantite" /></td>
            </tr>

            <tr>
            <tr>
              <td colspan="2">
                <input type="submit" name="submit" value="Update" />
                <input type="reset" value="Cancel" />
              </td>
            </tr>
          </table>
        </form>
    </div>

    <?php 
    if(isset($_POST['submit']))
    {
        
        $personne =$_POST['personne'];
        $Quantite = $_POST['Quantite'];
        $id_Animal = $_POST['id_Animal'];
        $Date = $_POST['Date'];
        $Description = $_POST['Description'];
                    
        $insertSalle = " Update journal SET idPersonne =?,Quantite =?,idAnimal =?,Date =?,Description =?" ;
        $stmtInsert = $connexion->prepare($insertSalle) ;
        $result = $stmtInsert->execute([$personne,$Quantite,$id_Animal,$Date,$Description]) ;

        if($result){
          $success = "Updated the  Journal";
        }else{
          $error = "Not Updated to the Journal ";
         }
    }
?>
    <!-- Table section -->
    <div class="table">
    <table>
            <tr>
              <th>id User</th>
              <th>Personne</th>
              <th>Description</th>
              <th>id_animal</th>
              <th>Quantite</th>
              <th>Date</th>
              <!-- <th>Actions</th> -->
            </tr>
            <?php

                $sql = "SELECT * FROM journal"; 
                $stmtSelect = $connexion->prepare($sql);
                $stmtSelect ->execute();
                $journals = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);


                foreach($journals as $journal): 

                ?>
            <tr>
                <td> <?php echo $journal['idUser'];?></td> 
                <td> <?php echo $journal['idPersonne'];?></td>
                <td> <?php echo $journal['Description'];?></td> 
                <td> <?php echo $journal['idAnimal'];?></td> 
                <td> <?php echo $journal['Quantite'];?></td> 
                <td> <?php echo $journal['Date'];?></td> 
                <!-- <td>
                <button class="delete-btn" data-id="<?php echo $utilisateur['id_personne']; ?>">Delete</button>
                <button class="edit-btn" data-id="<?php echo $utilisateur['id_personne']; ?>">Edit</button>
            </td> -->
            </tr>
            <?php 
              endforeach;

              // $id = $_GET['id'];

              // Prepare and execute the DELETE statement
              $sql = "DELETE FROM utilisateur WHERE id_personne = :id";
              $stmt = $connexion->prepare($sql);
              $stmt->bindParam(':id', $id);
              $stmt->execute();

              // echo json_encode(['success' => $stmt->rowCount() > 0]);

            ?>
      </table>
      </div>
   
  </div>
 
  <script>
      const deleteButtons = document.querySelectorAll('.delete-btn');
      const editButtons = document.querySelectorAll('.edit-btn');

      deleteButtons.forEach(button => {
      button.addEventListener('click', (event) => {
        const id = event.target.dataset.id;
        // Add confirmation dialog or other user interaction
        if (confirm('Are you sure you want to delete this user?')) {
            // Send delete request to PHP script using AJAX or Fetch API
            fetch(`/delete_user.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        event.target.closest('tr').remove();
                    } else {
                        // Handle error
                    }
                })
                .catch(error => {
                    // Handle error
                });
        }
    });
});

editButtons.forEach(button => {
      button.addEventListener('click', (event) => {
        const id = event.target.dataset.id;
        // Add confirmation dialog or other user interaction
        if (confirm('Are you sure you want to delete this user?')) {
            // Send delete request to PHP script using AJAX or Fetch API
            fetch(`/delete_user.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        event.target.closest('tr').remove();
                    } else {
                        // Handle error
                    }
                })
                .catch(error => {
                    // Handle error
                });
        }
    });
});

  </script>

</body>
</html>