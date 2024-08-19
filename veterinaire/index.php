<!-- <!DOCTYPE html>
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
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      justify-content: center;
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

  </style>
  <title>Gestion ferme</title>
</head>
<body>

  <header>
    <h1>Gestion ferme</h1>
  </header>

 

</body>
</html> -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <style>
      body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
}

.sidebar {
    width: 250px;
    background-color: #33ff77;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    padding: 20px;
    box-sizing: border-box;
    display: grid;
    grid-template-rows: auto 1fr auto;
}

.sidebar-header {
    margin-bottom: 30px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin: 20px 0;
}

.sidebar ul li a {
    text-decoration: none;
    color: black;
    font-weight: bold;
    display: block;
}

.logout {
    margin-bottom: 20px;
}

.logout a {
    text-decoration: none;
    color: black;
    font-weight: bold;
}

.main-content {
    margin-left: 270px;
    padding: 20px;
    display: grid;
    grid-template-rows: auto 1fr auto;
    grid-template-columns: 1fr;
    gap: 20px;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.breadcrumb {
    font-size: 18px;
}

.user-profile img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.card {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.card span{
    font-weight:bold;
    font-size:20px;
    color : #2b4d63;
}
.charts {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

#production-chart,
#consumption-chart {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.worker-guard {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.worker-guard table {
    width: 100%;
    border-collapse: collapse;
}

.worker-guard th,
.worker-guard td {
    padding: 10px;
    text-align: left;
}

.upcoming-events {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.upcoming-events .events p {
    margin: 0 0 10px;
}


    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Tableau de Bord</h2>
        </div>
        <ul>
            <li><a href="#">Tableau de Bord</a></li>
            <li><a href="#">Animaux</a></li>
            <li><a href="#">Ouvrier</a></li>
            <li><a href="#">Stock</a></li>
            <li><a href="#">Boite de Dialogue</a></li>
            <li><a href="#">Admin Profile</a></li>
        </ul>
        <div class="logout">
            <a href="#">Se Deconnecter</a>
        </div>
    </div>

    <div class="main-content">
        <header>
            <div class="breadcrumb">Admin / Tableau de Bord</div>
            <div class="user-profile">
                <img src="user-profile.jpg" alt="User Profile">
            </div>
        </header>

<?php

include 'connexion.php';
        function anSaine($connexion) {
    $sqlcountPersonne = "SELECT count(*) as total FROM animaux WHERE EtatDesante = 'BienPortan' ";
    $stmtsqlcountPersonne = $connexion->prepare($sqlcountPersonne);
    $stmtsqlcountPersonne->execute();
    
    // Fetch the result as an associative array
    $result = $stmtsqlcountPersonne->fetch(PDO::FETCH_ASSOC);
    
    // Return the count value
    return $result['total'];
}

function anMalade($connexion) {
  $sqlcountPersonne = "SELECT count(*) as total FROM animaux WHERE EtatDesante = 'Malade' ";
  $stmtsqlcountPersonne = $connexion->prepare($sqlcountPersonne);
  $stmtsqlcountPersonne->execute();
  
  // Fetch the result as an associative array
  $result = $stmtsqlcountPersonne->fetch(PDO::FETCH_ASSOC);
  
  // Return the count value
  return $result['total'];
}

function anMort($connexion) {
  $sqlcountPersonne = "SELECT count(*) as total  FROM animaux WHERE EtatDesante = 'Mort' ";
  $stmtsqlcountPersonne = $connexion->prepare($sqlcountPersonne);
  $stmtsqlcountPersonne->execute();
  
  // Fetch the result as an associative array
  $result = $stmtsqlcountPersonne->fetch(PDO::FETCH_ASSOC);
  
  // Return the count value
  return $result['total'];
}
?>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Animaux</h3>
                <p>En bonne santé</p>
                <p>Nombre Total : <span><?php echo anSaine($connexion) ?> </span> </p>
            </div>
            <div class="card">
                <h3>Animaux</h3>
                <p>Malade</p>
                <p>Nombre Total : <span><?php echo anMalade($connexion) ?> </span></p>
            </div>
            <div class="card">
                <h3>Animaux</h3>
                <p>Decedé</p>
                <p>Nombre Total :<span><?php echo anMort($connexion) ?> </span></p>
            </div>
        </div>

        <div class="charts">
            <div id="production-chart"></div>
            <div id="consumption-chart"></div>
        </div>

        <div class="worker-guard">
            <h3>Ouvrier ayant fait la garde</h3>
            <table>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Role</th>
                    <th>Gender</th>
                </tr>
                <tr>
                    <td>Samuel Smith</td>
                    <td>ECS12-9087</td>
                    <td>Teacher</td>
                    <td>Male</td>
                </tr>
                <tr>
                    <td>Peter Greg Nienhuis</td>
                    <td>ECS12-9099</td>
                    <td>Teacher</td>
                    <td>Male</td>
                </tr>
            </table>
        </div>

        <div class="upcoming-events">
            <h3>Prochaines Evenement</h3>
            <div class="events">
                <p>Saturday - Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p>Saturday - Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>
    </div>

    <script>
      // Initialize the production chart
var productionOptions = {
    chart: {
        type: 'line',
        height: 200
    },
    series: [{
        name: 'Production Laitier',
        data: [50, 80, 30, 90, 100]
    }],
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
    },
    title: {
        text: 'Production Laitier'
    }
};

var productionChart = new ApexCharts(document.querySelector("#production-chart"), productionOptions);
productionChart.render();

// Initialize the consumption chart
var consumptionOptions = {
    chart: {
        type: 'bar',
        height: 200
    },
    series: [{
        name: 'Consommation',
        data: [100000, 200000, 150000, 300000, 250000]
    }],
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
    },
    title: {
        text: 'Consommation'
    }
};

var consumptionChart = new ApexCharts(document.querySelector("#consumption-chart"), consumptionOptions);
consumptionChart.render();

    </script>
</body>
</html>



