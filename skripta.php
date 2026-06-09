<?php
include 'connect.php';

$naslov = '';
$sazetak = '';
$tekst = '';
$kategorija = '';
$slika = '';
$datum = date("d.m.Y.");
$poruka_baze = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $naslov = isset($_POST['title']) ? mysqli_real_escape_string($dbc, $_POST['title']) : '';
    $sazetak = isset($_POST['about']) ? mysqli_real_escape_string($dbc, $_POST['about']) : '';
    $tekst = isset($_POST['content']) ? mysqli_real_escape_string($dbc, $_POST['content']) : '';
    $kategorija = isset($_POST['category']) ? mysqli_real_escape_string($dbc, $_POST['category']) : '';
    
    // Provjera arhive
    if (isset($_POST['archive'])) {
        $archive = 1;
    } else {
        $archive = 0;
    }
    
    if (isset($_FILES['pphoto']['name'])) {
        $slika = $_FILES['pphoto']['name'];
    }
    
    if (!empty($slika)) {
        $target_dir = 'images/' . $slika;
        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
    }

    $query = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) 
              VALUES ('$datum', '$naslov', '$sazetak', '$tekst', '$slika', '$kategorija', '$archive')";
              
    $result = mysqli_query($dbc, $query);
    
    if ($result) {
        $poruka_baze = "Uspješno spremljeno u bazu podataka!";
    } else {
        $poruka_baze = "Greška pri upisu u bazu: " . mysqli_error($dbc);
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($naslov); ?></title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
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
        <a href="administrator.php">Administracija</a>
      </nav>
    </div>
  </header>

  <main>
    <article class="article-wrapper">
      <div style="background: #eee; padding: 10px; margin-bottom: 20px; border-left: 5px solid #d0021b;">
        <strong>Status baze:</strong> <?php echo $poruka_baze; ?>
      </div>

      <p class="article-date" style="text-align: left; font-weight: bold; color: #d0021b; text-transform: uppercase; margin-bottom: 5px;"><?php echo htmlspecialchars($kategorija); ?></p>
      <p class="article-date"><?php echo $datum; ?></p>
      <h1 class="article-title"><?php echo htmlspecialchars($naslov); ?></h1>
      <p class="article-lead"><?php echo nl2br(htmlspecialchars($sazetak)); ?></p>
      
      <?php if (!empty($slika)): ?>
      <figure class="article-image">
        <img src="images/<?php echo htmlspecialchars($slika); ?>" alt="<?php echo htmlspecialchars($naslov); ?>">
      </figure>
      <?php endif; ?>
      
      <div class="article-body">
        <p><?php echo nl2br(htmlspecialchars($tekst)); ?></p>
      </div>
    </article>
  </main>

  <footer>
    <div class="footer-inner">&copy; stern.de GmbH</div>
  </footer>
</body>
</html>
<?php mysqli_close($dbc); ?>