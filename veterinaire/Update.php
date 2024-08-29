<?php
include("../admin/connexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve form data
        $personne = $_POST['personne'];
        $Quantite = $_POST['Quantite'];
        $id_Animal = $_POST['id_Animal'];
        $Date = $_POST['Date'];
        $Description = $_POST['Description'];

        // Prepare and execute the update statement
        $updateJournal = "UPDATE journal SET idPersonne = ?, Quantite = ?, idAnimal = ?, Date = ?, Description = ? WHERE id = ?";
        $stmtUpdate = $connexion->prepare($updateJournal);
        $result = $stmtUpdate->execute([$personne, $Quantite, $id_Animal, $Date, $Description, $id]);

        if ($result) {
            $success = "Journal updated successfully.";
        } else {
            $error = "Failed to update the journal.";
        }
    }

    // Fetch the existing record to display in the form
    $sql = "SELECT * FROM journal WHERE id = ?";
    $stmtSelect = $connexion->prepare($sql);
    $stmtSelect->execute([$id]);
    $journal = $stmtSelect->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Your existing head content -->
</head>
<body>

<?php include("subMenu.php"); ?>

<div class="wrapper">
    <!-- Form section -->
    <div class="form">
        <form method="POST">
            <h1>Ajout Sur Journal</h1>
            <table>
                <tr>
                    <td>Personne</td>
                    <td>
                        <select name="personne">
                            <?php include '../option/optionsPersonne.php'; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><input type="text" name="Description" value="<?php echo $journal['Description']; ?>" /></td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td><input type="date" name="Date" value="<?php echo $journal['Date']; ?>" /></td>
                </tr>
                <tr>
                    <td>IDAnimal</td>
                    <td>
                        <select name="id_Animal">
                            <?php include '../option/optionsAnimal.php'; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Produit (en litre)</td>
                    <td><input type="number" name="Quantite" value="<?php echo $journal['Quantite']; ?>" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update" />
                        <input type="reset" value="Cancel" />
                    </td>
                </tr>
            </table>
        </form>
    </div>

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
            </tr>
            <?php
            $sql = "SELECT * FROM journal";
            $stmtSelect = $connexion->prepare($sql);
            $stmtSelect->execute();
            $journals = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

            foreach ($journals as $journal) :
            ?>
                <tr>
                    <td><?php echo $journal['idUser']; ?></td>
                    <td><?php echo $journal['idPersonne']; ?></td>
                    <td><?php echo $journal['Description']; ?></td>
                    <td><?php echo $journal['idAnimal']; ?></td>
                    <td><?php echo $journal['Quantite']; ?></td>
                    <td><?php echo $journal['Date']; ?></td>
                </tr>
            <?php
            endforeach;
            ?>
        </table>
    </div>
</div>
</body>
</html>
