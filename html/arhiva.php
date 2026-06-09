<?php
session_start();
include '../connect.php';
define('UPLPATH', '../images/'); 
/** @var mysqli $dbc */

if (!isset($_SESSION['$level']) || $_SESSION['$level'] != 1) {
    header("Location: ../administrator.php");
    exit();
}

$poruka = "";

if (isset($_POST['izbrisi'])) {
    $id = intval($_POST['id']);
    
    $sql = "DELETE FROM vijesti WHERE id = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $poruka = "<p class='status-aktivno' style='background:#d4edda; color:#155724; padding:10px;'>Vijest je uspješno izbrisana!</p>";
    }
}

if (isset($_POST['azuriraj'])) {
    $id = intval($_POST['id']);
    $naslov = $_POST['naslov'] ?? '';
    $tekst = $_POST['tekst'] ?? '';
    $kategorija = $_POST['kategorija'] ?? '';
    
    // Checkbox: ako je označen, vrijednost je 1, inače je 0
    $arhiva = isset($_POST['arhiva']) ? 1 : 0;

    // Obrada slike: ako je prenesena nova slika
    if (isset($_FILES['pphoto']) && $_FILES['pphoto']['error'] == UPLOAD_ERR_OK) {
        $slika = $_FILES['pphoto']['name'];
        $target_dir = '../images/' . $slika;
        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
        
        // Upit s novom slikom
        $sql = "UPDATE vijesti SET naslov = ?, tekst = ?, kategorija = ?, slika = ?, arhiva = ? WHERE id = ?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssssii', $naslov, $tekst, $kategorija, $slika, $arhiva, $id);
            mysqli_stmt_execute($stmt);
        }
    } else {
        // Upit bez promjene slike
        $sql = "UPDATE vijesti SET naslov = ?, tekst = ?, kategorija = ?, arhiva = ? WHERE id = ?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'sssii', $naslov, $tekst, $kategorija, $arhiva, $id);
            mysqli_stmt_execute($stmt);
        }
    }
    $poruka = "<p class='status-aktivno' style='background:#d4edda; color:#155724; padding:10px;'>Vijest je uspješno ažurirana!</p>";
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Administracija - Uredi Arhivu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <style>

        .admin-forma-kartica {
            border: 1px solid #ccc;
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .admin-forma-kartica label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        .admin-input-text {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
        .admin-textarea {
            width: 100%;
            height: 100px;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            resize: vertical;
        }
        .admin-select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            background: #fff;
        }
        .gumb-container {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }
        .gumb-azuriraj {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-weight: bold;
        }
        .gumb-izbrisi {
            background: #d0021b;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>

  <header>
    <div class="header-inner">
      <a href="../index.php" class="logo"><div class="logo-star"></div><span class="logo-text">stern</span></a>
      <nav>
        <a href="../index.php">Početna</a>
        <a href="unos.php">Unos Vijesti</a>
        <a href="arhiva.php" class="active">Arhiva</a>
        <a href="../administrator.php">Administracija</a>
      </nav>
    </div>
  </header>

  <main style="padding: 20px; max-width: 800px; margin: 0 auto;">
    <h2>Administracija i uređivanje vijesti</h2>
    <p>Kao administrator ovdje možete izmijeniti sadržaj, upravljati prikazom (arhivom) ili potpuno obrisati vijesti.</p>
    
    <?php if(!empty($poruka)) echo $poruka; ?>

    <div style="margin-top: 30px;">
        <?php
        // Dohvati sve vijesti iz baze kako bi se za svaku generirala forma za izmjenu
        $query = "SELECT * FROM vijesti ORDER BY id DESC";
        $result = mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                ?>
                <div class="admin-forma-kartica">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                        <label>Naslov vijesti:</label>
                        <input type="text" name="naslov" class="admin-input-text" value="<?php echo htmlspecialchars($row['naslov']); ?>" required>

                        <label>Kratki tekst / Sadržaj:</label>
                        <textarea name="tekst" class="admin-textarea" required><?php echo htmlspecialchars($row['tekst']); ?></textarea>

                        <label>Kategorija:</label>
                        <select name="kategorija" class="admin-select">
                            <option value="politika" <?php if($row['kategorija'] == 'politika') echo 'selected'; ?>>Politika</option>
                            <option value="zdravlje" <?php if($row['kategorija'] == 'zdravlje') echo 'selected'; ?>>Zdravlje</option>
                        </select>

                        <label>Trenutna slika:</label>
                        <?php if(!empty($row['slika'])): ?>
                            <br><img src="<?php echo UPLPATH . $row['slika']; ?>" style="width: 150px; height: auto; display:block; margin: 5px 0 10px 0; border: 1px solid #ccc;">
                        <?php endif; ?>
                        <input type="file" name="pphoto">

                        <div style="margin-top: 15px;">
                            <label style="display: inline-block; cursor: pointer;">
                                <input type="checkbox" name="arhiva" value="1" <?php if($row['arhiva'] == 1) echo 'checked'; ?>> 
                                Arhiviraj ovu vijest (Sakrij s početne stranice)
                            </label>
                        </div>

                        <div class="gumb-container">
                            <button type="submit" name="azuriraj" class="gumb-azuriraj">Ažuriraj</button>
                            <button type="submit" name="izbrisi" class="gumb-izbrisi" onclick="return confirm('Jeste li sigurni da želite trajno izbrisati ovu vijest?');">Izbriši</button>
                        </div>
                    </form>
                </div>
                <?php
            }
        } else {
            echo '<p>Nema unesenih vijesti u bazi podataka.</p>';
        }
        ?>
    </div>
  </main>

  <footer>
    <div class="footer-inner">&copy; stern.de GmbH</div>
  </footer>

</body>
</html>
<?php mysqli_close($dbc); ?>