<?php
session_start();
include 'connect.php';
define('UPLPATH', 'images/');

// 1. Inicijalizacija varijabli na samom vrhu kako bismo riješili Intelephense "Expected type string, found null" upozorenje
$uspjesnaPrijava = false;
$admin = false;
$errorMsg = '';
$imeKorisnika = '';
$lozinkaKorisnika = '';
$levelKorisnika = 0;

// 2. Logika za odjavu korisnika (izvršava se odmah ako je kliknut gumb/link za odjavu)
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: administrator.php");
    exit();
}

// 3. Provjera slanja forme za prijavu (Login)
if (isset($_POST['prijava'])) {
    $prijavaImeKorisnika = $_POST['username'] ?? '';
    $prijavaLozinkaKorisnika = $_POST['lozinka'] ?? '';

    // Prepared Statement za sigurno dohvaćanje korisnika iz baze podataka
    $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        // Ako korisnik postoji u bazi
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
            mysqli_stmt_fetch($stmt);
            
            // Provjera hashirane lozinke pomoću password_verify
            if (password_verify($prijavaLozinkaKorisnika, $lozinkaKorisnika)) {
                $uspjesnaPrijava = true;
                
                if ($levelKorisnika == 1) {
                    $admin = true;
                }
                
                // Postavljanje session varijabli za pamćenje prijave
                $_SESSION['$username'] = $imeKorisnika;
                $_SESSION['$level'] = $levelKorisnika;
            } else {
                $uspjesnaPrijava = false;
                $errorMsg = 'Pogrešna lozinka. Ako nemate račun, <a href="registracija.php">registrirajte se ovdje</a>.';
            }
        } else {
            $uspjesnaPrijava = false;
            $errorMsg = 'Korisnik ne postoji u bazi. Molimo da se prvo <a href="registracija.php">registrirate ovdje</a>.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracija</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .login-wrapper { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; background: #fff; }
        .login-wrapper h2 { margin-top: 0; }
        .form-item { margin-bottom: 15px; }
        .form-item label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-field-textual { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; }
        .btn-submit { background: #d0021b; color: white; border: none; padding: 10px 15px; cursor: pointer; width: 100%; font-weight: bold; }
        .error-box { background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-left: 5px solid #f5c6cb; font-size: 14px; }
        .info-box { max-width: 600px; margin: 40px auto; background: #e2e3e5; color: #383d41; padding: 20px; border-left: 5px solid #ffeeba; text-align: center; }
        .logout-btn { display: inline-block; background: #333; color: #fff; padding: 6px 15px; text-decoration: none; margin-top: 10px; font-size: 14px; font-weight: bold; border-radius: 3px; }
        .logout-btn:hover { background: #555; }
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .admin-table th, .admin-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .admin-table th { background-color: #f2f2f2; }
    </style>
</head>
<body>

  <header>
    <div class="header-inner">
      <a href="index.php" class="logo"><div class="logo-star"></div><span class="logo-text">stern</span></a>
      <nav>
        <a href="index.php">Početna</a>
        <a href="html/unos.php">Unos Vijesti</a>
        <a href="administrator.php" class="active">Administracija</a>
        <a href="html/arhiva.php">Arhiva</a>
      </nav>
    </div>
  </header>

  <main style="padding: 20px; max-width: 1000px; margin: 0 auto;">
    <?php
    // SLUČAJ 1: Korisnik je uspješno prijavljen upravo sada ILI već ima aktivnu sesiju kao Administrator (razina == 1)
    if (($uspjesnaPrijava == true && $admin == true) || (isset($_SESSION['$username']) && $_SESSION['$level'] == 1)) {
        $prikazIme = $_SESSION['$username'] ?? $imeKorisnika;
        echo '<h2>Dobrodošli natrag u CMS, administrator ' . htmlspecialchars($prikazIme) . '!</h2>';
        
        // Link za odjavu koji šalje ?action=logout natrag PHP-u na vrhu datoteke
        echo '<a href="administrator.php?action=logout" class="logout-btn">Odjavi se</a>';
        
        echo '<h3 style="margin-top: 30px;">Upravljanje vijestima u bazi podataka:</h3>';
        
        // Dohvat i prikaz tablice s vijestima (iz tvojih ranijih faza za izmjenu i brisanje)
        $query = "SELECT id, naslov, kategorija, arhiva FROM vijesti ORDER BY id DESC";
        $result = mysqli_query($dbc, $query);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="admin-table">';
            echo '<tr><th>ID</th><th>Naslov</th><th>Kategorija</th><th>Arhiva</th></tr>';
            while($row = mysqli_fetch_array($result)) {
                echo '<tr>';
                echo '<td>'.$row['id'].'</td>';
                echo '<td>'.htmlspecialchars($row['naslov']).'</td>';
                echo '<td>'.htmlspecialchars($row['kategorija']).'</td>';
                echo '<td>'.($row['arhiva'] == 1 ? 'Da (Skriveno)' : 'Ne (Aktivno)').'</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>Nema unesenih vijesti u bazi.</p>';
        }

    // SLUČAJ 2: Korisnik je prijavljen, ali NEMA prava administratora (razina == 0)
    } else if (($uspjesnaPrijava == true && $admin == false) || (isset($_SESSION['$username']) && $_SESSION['$level'] == 0)) {
        $prikazIme = $_SESSION['$username'] ?? $imeKorisnika;
        echo '<div class="info-box">';
        echo '  <p style="font-size: 16px;">Bok ' . htmlspecialchars($prikazIme) . '! Uspješno ste prijavljeni, ali nemate dovoljna prava za pristup administraciji.</p>';
        
        // Link za odjavu običnog korisnika
        echo '  <a href="administrator.php?action=logout" class="logout-btn" style="background: #d0021b;">Odjavi se</a>';
        echo '</div>';

    // SLUČAJ 3: Korisnik uopće nije prijavljen ili je unio pogrešne podatke -> Prikaz forme za Login
    } else {
        ?>
        <div class="login-wrapper">
            <h2>Prijava u administraciju</h2>
            <?php if (!empty($errorMsg)) echo '<div class="error-box">'.$errorMsg.'</div>'; ?>
            
            <form action="" method="POST">
                <div class="form-item">
                    <label for="username">Korisničko ime:</label>
                    <input type="text" name="username" id="username" class="form-field-textual" required>
                </div>
                <div class="form-item">
                    <label for="lozinka">Lozinka:</label>
                    <input type="password" name="lozinka" id="lozinka" class="form-field-textual" required>
                </div>
                <div class="form-item">
                    <button type="submit" name="prijava" class="btn-submit">Prijavi se</button>
                </div>
            </form>
            <p style="text-align: center; font-size: 14px; margin-top: 15px;">
                Nemate korisnički račun? <a href="registracija.php">Registrirajte se ovdje</a>.
            </p>
        </div>
        <?php
    }
    ?>
  </main>

  <footer>
    <div class="footer-inner">&copy; stern.de GmbH</div>
  </footer>
</body>
</html>
<?php mysqli_close($dbc); ?>