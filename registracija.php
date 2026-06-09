<?php
include 'connect.php';

$msg = '';
$registriranKorisnik = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = $_POST['ime'] ?? '';
    $prezime = $_POST['prezime'] ?? '';
    $username = $_POST['username'] ?? '';
    $lozinka = $_POST['pass'] ?? '';
    $razina = 0;

    $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $msg = 'Korisničko ime već postoji!';
        } else {

            $hashed_password = password_hash($lozinka, PASSWORD_BCRYPT);
            
            $sql_insert = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = mysqli_stmt_init($dbc);
            
            if (mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
                mysqli_stmt_bind_param($stmt_insert, 'ssssi', $ime, $prezime, $username, $hashed_password, $razina);
                mysqli_stmt_execute($stmt_insert);
                $registriranKorisnik = true;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .form-wrapper { max-width: 400px; margin: 40px auto; padding: 20px; border: 1px solid #ccc; background: #fff; }
        .form-item { margin-bottom: 15px; }
        .form-item label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-field-textual { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; }
        .bojaPoruke { color: red; font-size: 14px; display: block; margin-top: 5px; }
        #slanje { background: #d0021b; color: white; border: none; padding: 10px 15px; cursor: pointer; width: 100%; }
        .success-msg { color: green; text-align: center; font-weight: bold; font-size: 18px; margin-top: 20px; }
    </style>
</head>
<body>

  <header>
    <div class="header-inner">
      <a href="index.php" class="logo"><div class="logo-star"></div><span class="logo-text">stern</span></a>
      <nav>
        <a href="index.php">Početna</a>
        <a href="html/kategorija.php?id=politika">Politika</a>
        <a href="html/kategorija.php?id=zdravlje">Zdravlje</a>
        <a href="html/unos.php">Unos Vijesti</a>
        <a href="administrator.php" class="active">Administracija</a>
      </nav>
    </div>
  </header>

  <main>
    <div class="form-wrapper">
      <?php if ($registriranKorisnik == true): ?>
          <p class="success-msg">Korisnik je uspješno registriran!</p>
          <p style="text-align:center;"><a href="administrator.php">Idi na prijavu</a></p>
      <?php else: ?>
          <h2>Registracija Korisnika</h2>
          <form action="" method="POST" id="regForm">
              <div class="form-item">
                  <label for="ime">Ime: </label>
                  <input type="text" name="ime" id="ime" class="form-field-textual">
                  <span id="porukaIme" class="bojaPoruke"></span>
              </div>
              <div class="form-item">
                  <label for="prezime">Prezime: </label>
                  <input type="text" name="prezime" id="prezime" class="form-field-textual">
                  <span id="porukaPrezime" class="bojaPoruke"></span>
              </div>
              <div class="form-item">
                  <label for="username">Korisničko ime:</label>
                  <input type="text" name="username" id="username" class="form-field-textual">
                  <span id="porukaUsername" class="bojaPoruke"><?php echo $msg; ?></span>
              </div>
              <div class="form-item">
                  <label for="pass">Lozinka: </label>
                  <input type="password" name="pass" id="pass" class="form-field-textual">
                  <span id="porukaPass" class="bojaPoruke"></span>
              </div>
              <div class="form-item">
                  <label for="passRep">Ponovite lozinku: </label>
                  <input type="password" name="passRep" id="passRep" class="form-field-textual">
                  <span id="porukaPassRep" class="bojaPoruke"></span>
              </div>
              <div class="form-item">
                  <button type="submit" id="slanje">Registriraj se</button>
              </div>
          </form>
      <?php endif; ?>
    </div>
  </main>

  <footer>
    <div class="footer-inner">&copy; stern.de GmbH</div>
  </footer>

  <script type="text/javascript">
  document.getElementById("slanje").onclick = function(event) {
      var slanjeForme = true;

      // Ime
      var poljeIme = document.getElementById("ime");
      var ime = poljeIme.value;
      if (ime.length == 0) {
          slanjeForme = false;
          poljeIme.style.border="1px dashed red";
          document.getElementById("porukaIme").innerHTML="Unesite ime!";
      } else {
          poljeIme.style.border="1px solid green";
          document.getElementById("porukaIme").innerHTML="";
      }

      // Prezime
      var poljePrezime = document.getElementById("prezime");
      var prezime = poljePrezime.value;
      if (prezime.length == 0) {
          slanjeForme = false;
          poljePrezime.style.border="1px dashed red";
          document.getElementById("porukaPrezime").innerHTML="Unesite prezime!";
      } else {
          poljePrezime.style.border="1px solid green";
          document.getElementById("porukaPrezime").innerHTML="";
      }

      // Korisničko ime
      var poljeUsername = document.getElementById("username");
      var username = poljeUsername.value;
      if (username.length == 0) {
          slanjeForme = false;
          poljeUsername.style.border="1px dashed red";
          document.getElementById("porukaUsername").innerHTML="Unesite korisničko ime!";
      } else {
          poljeUsername.style.border="1px solid green";
          document.getElementById("porukaUsername").innerHTML="";
      }

      // Lozinke
      var poljePass = document.getElementById("pass");
      var pass = poljePass.value;
      var poljePassRep = document.getElementById("passRep");
      var passRep = poljePassRep.value;
      if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
          slanjeForme = false;
          poljePass.style.border="1px dashed red";
          poljePassRep.style.border="1px dashed red";
          document.getElementById("porukaPass").innerHTML="Lozinke moraju biti unesene i identične!";
          document.getElementById("porukaPassRep").innerHTML="Lozinke moraju biti unesene i identične!";
      } else {
          poljePass.style.border="1px solid green";
          poljePassRep.style.border="1px solid green";
          document.getElementById("porukaPass").innerHTML="";
          document.getElementById("porukaPassRep").innerHTML="";
      }

      if (slanjeForme != true) {
          event.preventDefault();
      }
  };
  </script>
</body>
</html>