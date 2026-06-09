<?php
include __DIR__ . '/../connect.php'; 
define('UPLPATH', '../images/');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT * FROM vijesti WHERE id = $id";
$result = mysqli_query($dbc, $query) or die("Greška u upitu: " . mysqli_error($dbc));
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $row ? $row['naslov'] : 'Članak nije pronađen'; ?></title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

  <header>
    <div class="header-inner">
      <a href="../index.php" class="logo"><div class="logo-star"></div><span class="logo-text">stern</span></a>
      <nav>
        <a href="../index.php">Početna</a>
        <a href="kategorija.php?id=politika">Politika</a>
        <a href="kategorija.php?id=zdravlje">Zdravlje</a>
        <a href="unos.php">Unos Vijesti</a>
        <a href="../administrator.php">Administracija</a>
      </nav>
    </div>
  </header>

  <main>
    <?php if ($row): ?>
    <article class="article-wrapper">
      <p class="article-date" style="text-align: left; font-weight: bold; color: #d0021b; text-transform: uppercase; margin-bottom: 5px;"><?php echo $row['kategorija']; ?></p>
      <p class="article-date"><?php echo $row['datum']; ?></p>
      <h1 class="article-title"><?php echo $row['naslov']; ?></h1>
      <p class="article-lead"><?php echo nl2br($row['sazetak']); ?></p>
      
      <figure class="article-image">
        <img src="<?php echo UPLPATH . $row['slika']; ?>" alt="<?php echo $row['naslov']; ?>">
      </figure>
      
      <div class="article-body">
        <p><?php echo nl2br($row['tekst']); ?></p>
      </div>
    </article>
    <?php else: ?>
    <article class="article-wrapper">
      <h1 class="article-title">Greška 404</h1>
      <p class="article-lead">Traženi članak ne postoji u bazi podataka ili je ID neispravan.</p>
    </article>
    <?php endif; ?>
  </main>

  <footer>
    <div class="footer-inner">&copy; stern.de GmbH</div>
  </footer>
</body>
</html>
<?php mysqli_close($dbc); ?>