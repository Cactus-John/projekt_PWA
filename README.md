Skini cijeli zip ovog projetka. 
Nakon toga otvori XAMPP i upali APACHE i MySQL i otvori bazu.
Zatim na MySQL napravi bazu nazivom pwa_projekt i zalijepi u nju kod koji se nalazi pod pwa_projekt.sql koji ce ti kreirat potrebne tablice i podatke da mozes testirati stranicu.
Na kraju zip folder extractaj i zalijepi u C:\xampp\htdocs (ili gdje god si spremio XAMPP folder).

VAŽNO:
  Ako ne možeš pokrenut u XAMPPU MySQL service; -> na Windowsu otiđi u Services i traži MySQL 80 i ugasi ga (STOP THE SERVICE) !
  Nakon što si ugasio MySQL pod Services, odi opet na XAMPP i upali na XAMPPu MySQL i otvori ga pod gumbom Admin !

  PRIJAVA ZA ADMINISTRATORA/ADMINA:
    - korisničko ime: admin67
    - lozinka: admin123
    - NAPOMENA: 
            Na stranici se prijavi preko ovih podataka i već imaš ulogu admina kako bi testirao funckionalnosti koje admin mora imati kako nebi trebao u bazi updateat tablicu korisnik i mijenjat ručno razinu.
            Naravno ovaj login će raditi samo ako si na MySQL bazi pokrenuo sql kod iz pwa_projekt.sql
