<?php
include 'connect.php';
define('UPLPATH', 'images/');
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Početna - Stern Portal</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

  <header>
    <div class="header-inner">
      <a href="index.php" class="logo">
        <div class="logo-star"></div>
        <span class="logo-text">stern</span>
      </a>
      <nav>
        <a href="index.php" class="active">Početna</a>
        <a href="html/kategorija.php?id=politika">Politika</a>
        <a href="html/kategorija.php?id=zdravlje">Zdravlje</a>
        <a href="administrator.php">Administracija</a>
      </nav>
    </div>
  </header>

  <main>
    
    <section class="news-section">
      <h2 class="section-heading"><a href="html/kategorija.php?id=politika">POLITIKA</a></h2>
      <div class="cards-grid">
        <?php
        $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='politika' ORDER BY id DESC LIMIT 3";
        $result = mysqli_query($dbc, $query);
        
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                echo '<article class="card">';
                echo '  <div class="card-image">';
                echo '    <a href="html/clanak.php?id='.$row['id'].'">';
                
                if (strpos($row['slika'], 'http') === 0) {
                    echo '      <img src="'.$row['slika'].'" alt="'.htmlspecialchars($row['naslov']).'">';
                } else {
                    echo '      <img src="'.UPLPATH.$row['slika'].'" alt="'.htmlspecialchars($row['naslov']).'">';
                }
                
                echo '    </a>';
                echo '  </div>';
                echo '  <span class="card-category">'.$row['kategorija'].'</span>';
                echo '  <a href="html/clanak.php?id='.$row['id'].'" class="card-title">'.htmlspecialchars($row['naslov']).'</a>';
                echo '</article>';
            }
        } else {
            echo '<p class="article-lead">Trenutno nema vijesti u kategoriji Politika.</p>';
        }
        ?>
      </div>
    </section>

    <section class="news-section">
      <h2 class="section-heading"><a href="html/kategorija.php?id=zdravlje">ZDRAVLJE</a></h2>
      <div class="cards-grid">
        <?php
        $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='zdravlje' ORDER BY id DESC LIMIT 3";
        $result = mysqli_query($dbc, $query);
        
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                echo '<article class="card">';
                echo '  <div class="card-image">';
                echo '    <a href="html/clanak.php?id='.$row['id'].'">';
                
                if (strpos($row['slika'], 'http') === 0) {
                    echo '      <img src="'.$row['slika'].'" alt="'.htmlspecialchars($row['naslov']).'">';
                } else {
                    echo '      <img src="'.UPLPATH.$row['slika'].'" alt="'.htmlspecialchars($row['naslov']).'">';
                }
                
                echo '    </a>';
                echo '  </div>';
                echo '  <span class="card-category">'.$row['kategorija'].'</span>';
                echo '  <a href="html/clanak.php?id='.$row['id'].'" class="card-title">'.htmlspecialchars($row['naslov']).'</a>';
                echo '</article>';
            }
        } else {
            echo '<p class="article-lead">Trenutno nema vijesti u kategoriji Zdravlje.</p>';
        }
        ?>
      </div>
    </section>
    
  </main>

  <footer>
    <div class="footer-inner">
      &copy; stern.de GmbH | Početna
    </div>
  </footer>

</body>
</html>