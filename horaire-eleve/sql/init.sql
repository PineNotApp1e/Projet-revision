CREATE DATABASE IF NOT EXISTS horaire;
USE horaire;

CREATE TABLE cours (
    id INT AUTO_INCREMENT PRIMARY KEY,    
    code VARCHAR(20) NOT NULL,
    nom VARCHAR(120) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,    
    nom VARCHAR(50) UNIQUE NOT NULL,
    annee_scolaire VARCHAR(9) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE creneaux (
    id INT AUTO_INCREMENT PRIMARY KEY,    
    classe_id INT NOT NULL,
    cours_id INT NOT NULL,        
    jour VARCHAR(20),    
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    salle VARCHAR(20) NOT NULL,
    FOREIGN KEY (classe_id) REFERENCES classes(id),
    FOREIGN KEY (cours_id) REFERENCES cours(id)
) ENGINE=InnoDB;

