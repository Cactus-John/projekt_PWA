<?php
include __DIR__ . '/../connect.php'; 

define('UPLPATH', '../images/');

$kategorija_id = isset($_GET['id']) ? mysqli_real_escape_string($dbc, $_GET['id']) : '';
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo ucfirst($kategorija_id); ?> - Kategorija</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

  <header>
    <div class="header-inner">
      <a href="../index.php" class="logo"><div class="logo-star"></div><span class="logo-text">stern</span></a>
      <nav>
        <a href="../index.php">Početna</a>
        <a href="kategorija.php?id=politika" class="<?php if($kategorija_id == 'politika') echo 'active'; ?>">Politika</a>
        <a href="kategorija.php?id=zdravlje" class="<?php if($kategorija_id == 'zdravlje') echo 'active'; ?>">Zdravlje</a>
        <a href="../administrator.php">Administracija</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="news-section">
      <h2 class="section-heading"><a href="kategorija.php?id=<?php echo $kategorija_id; ?>"><?php echo strtoupper($kategorija_id); ?></a></h2>
      <div class="cards-grid">
        <?php
        if (!empty($kategorija_id)) {
            $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='$kategorija_id' ORDER BY id DESC";
            $result = mysqli_query($dbc, $query) or die("Greška u upitu: " . mysqli_error($dbc));
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    echo '<article class="card">';
                    echo '  <div class="card-image">';
                    echo '    <a href="clanak.php?id='.$row['id'].'">';
                    echo '      <img src="'.UPLPATH.$row['slika'].'" alt="'.$row['naslov'].'">';
                    echo '    </a>';
                    echo '  </div>';
                    echo '  <span class="card-category">'.$row['kategorija'].'</span>';
                    echo '  <a href="clanak.php?id='.$row['id'].'" class="card-title">'.$row['naslov'].'</a>';
                    echo '</article>';
                }
            } else {
                echo '<p class="article-lead">Trenutno nema objavljenih vijesti u ovoj kategoriji.</p>';
            }
        } else {
            echo '<p class="article-lead">Kategorija nije ispravno odabrana.</p>';
        }
        ?>
      </div>
    </section>
  </main>

  <footer>
    <div class="footer-inner">&copy; stern.de GmbH</div>
  </footer>
</body>
</html>
<?php mysqli_close($dbc); ?>