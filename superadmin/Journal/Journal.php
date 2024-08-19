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
input[type='password'],
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
    include("../subMenu.php");
  ?>
	
  <div class="wrapper">
    <!-- Form section -->
    <div class="form">
        <form method="POST">
        <h1>Ajout Utilisateur</h1>
        <table>
            <tr>
              <td> Personne </td>
              <td>
              <select name="personne"  >
              <?php include '../../option/optionsPersonne.php'; ?>           
            </select>
              </td>
            </tr>

            <tr>
              <td> Prenom	</td>
              <td><input type="number" name="Prenom" /></td>
            </tr>

            <tr>
              <td> Telephone </td>
              <td><input type="text" name="Telephone" /></td>
            </tr>

            <tr>
              <td> Email	</td>
              <td><input type="number" name="Email" /></td>
            </tr>

            <tr>
              <td> Username </td>
              <td><input type="text" name="Username" /></td>
            </tr>

            <tr>
              <td> Password	</td>
              <td><input type="password" name="Password" /></td>
            </tr>

            <tr>
              <td> Profile</td>
              <td>
              <select name="profil"  >
              <?php include '../../option/optionsprofil.php'; ?>           
            </select>
              </td>
            </tr>

   

            <tr>
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
    if(isset($_POST['submit']))
    {
        
        $nom =$_POST['nom'];
        $Prenom = $_POST['Prenom'];
        $Telephone = $_POST['Telephone'];
        $Email = $_POST['Email'];
        $Username = $_POST['Username'];
        $Password = $_POST['Password'];
        $Profil = $_POST['Profil'];
       
        // generated id for users

        $id = $_POST['idSalle'];
        
        $insertSalle = " insert into salle(idSalle,Nom,NbrPlaces) values(?,?,?)" ;
        $stmtInsert = $connexion->prepare($insertSalle) ;
        $result = $stmtInsert->execute([$id,$nom,$NbrPlaces]) ;

        if($result){
          $success = "Login successful! Redirecting...";
        }else{
          $error = "Nom d'utilisateur ou mot de passe est incorrect";
         }
    // $variable_affichage = $connexion ->query("select * from cour");
    // while($bd_util =  $variable_affichage->fetch())
    // {
    //   if(($id ==$bd_util['id']))
    //   {
    //         echo('The course already exit in Database');
    //     // header('location:home.php');
      
    //   }
    // }
    }
?>
    <!-- Table section -->
    <div class="table">
    <table>
            <tr>
              <th>id_personne</th>
              <th>Username</th>
              <th>Password</th>
              <th>Profil</th>
              <th>Fonction</th>
              <!-- <th>Actions</th> -->
            </tr>
            <?php

                include("../connexion.php");
                $sql = "SELECT * FROM utilisateur"; 
                $stmtSelect = $connexion->prepare($sql);
                $stmtSelect ->execute();
                $utilisateurs = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

                include '../idToNom.php';

                foreach($utilisateurs as $utilisateur): 
                $utilisateur['profil'] = idToNom($connexion,$utilisateur['profil'])

                ?>
            <tr>
                <td> <?php echo $utilisateur['id_personne'];?></td>
                <td> <?php echo $utilisateur['username'];?></td> 
                <td> <?php echo $utilisateur['password'];?></td> 
                <td> <?php echo $utilisateur['profil'];?></td> 
                <td> <?php echo $utilisateur['fonction'];?></td> 
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