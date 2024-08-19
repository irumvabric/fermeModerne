<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #c7c7c7;
    }

    header {
      background-color: #45aF50;
      color: #fff;
      text-align: center;
      padding: 1em;
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

    section {
      padding: 20px;
      margin-left: 20%;
      margin-right: 20%;
      margin-top: 3%;
      display: grid;
      /* grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      justify-content: center; */
    }

    .card {
      background-color: #fff;
      color: #333;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      text-align: center;
      transition: transform 0.3s;
    }

    .card a{
        text-decoration: none;
        color:#000;

    }

    .card:hover {
      transform: translateY(-5px);
    }


    .card1 {
      background-color: #45a569;
      
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      text-align: center;
      transition: transform 0.3s;
      border:1px solid #45a000;
    }

    .card1 a{
        
        text-decoration: none;
        color: #fff;

    }

    .card1:hover {
      transform: translateY(-5px);
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

.head{
  text-align :center;
}
.table {
  width: 65%; 
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  background-color: #fff;
  margin: 4% auto;
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
button,
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
  <title>Gestion Horaire</title>
</head>
<body>

  <header>
    <h1>Gestion Horaire</h1>
  </header>

  <?php
    include("../subMenu.php");
  ?>

  <section>

    <div class="card1">
      <form method="GET" action="search.php">
          <input type="text" name="search" placeholder="Search">
          <button type="submit">Search</button>
      </form>
    </div>


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


              // Get the search term
            $search = $_GET['search'];

            // Prepare and execute the SQL statement
            $sql = "SELECT * FROM utilisateur WHERE id_personne LIKE :search";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':search', '%' . $search . '%');
            $stmt->execute();

            // Fetch results and display
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display results (replace with your desired output format)
            foreach ($results as $row) {?>
              <tr>
              <td> <?php echo $utilisateur['id_personne'];?></td>
              <td> <?php echo $utilisateur['username'];?></td> 
              <td> <?php echo $utilisateur['password'];?></td> 
              <td> <?php echo $utilisateur['profil'];?></td> 
              <td> <?php echo $utilisateur['fonction'];?></td> 

                <?php } ?>
      </table>
      </div>
   
  </section>

</body>
</html>
