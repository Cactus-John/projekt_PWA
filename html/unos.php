<?php
session_start();

// Ako korisnik nije ulogiran ILI ako je ulogiran ali nije admin (razina != 1)
if (!isset($_SESSION['$level']) || $_SESSION['$level'] != 1) {
    // Preusmjeri ga na administrator.php gdje će dobiti poruku da nema prava
    header("Location: ../administrator.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dodaj novu vijest</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <header>
    <div class="header-inner">
      <a href="../index.php" class="logo">
        <div class="logo-star"></div>
        <span class="logo-text">stern</span>
      </a>
      <nav>
        <a href="../index.php">Početna</a>
        <a href="unos.php" class="active">Unos Vijesti</a>
        <a href="../administrator.php">Administracija</a>
      </nav>
    </div>
  </header>

  <main>
    <div class="article-wrapper">
      <h1 class="article-title">Unos nove vijesti</h1>
      
      <form action="../skripta.php" method="POST" enctype="multipart/form-data" name="dojmovnik" class="news-form">
        
        <div class="form-item">
          <label for="title" class="form-label">Naslov vijesti</label>
          <div class="form-field">
            <input type="text" name="title" id="title" class="form-field-textual" autofocus required>
          </div>
        </div>

        <div class="form-item">
          <label for="about" class="form-label">Kratki sadržaj vijesti (do 50 znakova)</label>
          <div class="form-field">
            <textarea name="about" id="about" cols="30" rows="4" class="form-field-textual" required></textarea>
          </div>
        </div>

        <div class="form-item">
          <label for="content" class="form-label">Sadržaj vijesti</label>
          <div class="form-field">
            <textarea name="content" id="content" cols="30" rows="10" class="form-field-textual" required></textarea>
          </div>
        </div>

        <div class="form-item">
          <label for="pphoto" class="form-label">Slika: </label>
          <div class="form-field">
            <input type="file" name="pphoto" id="pphoto" class="input-text" accept="image/*" required />
          </div>
        </div>

        <div class="form-item">
          <label for="category" class="form-label">Kategorija vijesti</label>
          <div class="form-field">
            <select name="category" id="category" class="form-field-textual">
              <option value="politika">Politika</option>
              <option value="zdravlje">Zdravlje</option>
            </select>
          </div>
        </div>

        <div class="form-item checkbox-item">
          <label class="form-label-checkbox">
            <input type="checkbox" name="archive" value="1"> Spremiti u arhivu
          </label>
        </div>

        <div class="form-buttons">
          <button type="reset" value="Poništi" class="btn-reset">Poništi</button>
          <button type="submit" value="Prihvati" class="btn-submit">Prihvati</button>
        </div>
      </form>
    </div>
  </main>

  <footer>
    <div class="footer-inner">
      &copy; stern.de GmbH | Administracija - Nova vijest
    </div>
  </footer>

</body>
</html>