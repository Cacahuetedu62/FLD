-- Sélectionnez la base de données
USE u301331392_fld_agencement;

-- Création de la table projets
CREATE TABLE projets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    sous_titre VARCHAR(255),
    date VARCHAR(50),
    lieu VARCHAR(255),
    type_travaux VARCHAR(255),
    description TEXT
);


CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    projet_id INT,
    chemin VARCHAR(255),
    FOREIGN KEY (projet_id) REFERENCES projets(id)
);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role VARCHAR(20) NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE users ADD COLUMN locked_until DATETIME NULL;

INSERT INTO projets (titre, sous_titre, date, lieu, type_travaux, description)
VALUES 
('Isolation complète', 'Rénovation énergétique d''une maison à Arras', 'Janvier 2024', 'Arras', 'Isolation thermique des murs et combles', 'Ce projet consiste à améliorer l''efficacité énergétique d''une maison en isolant les murs extérieurs et les combles.'),
('Rénovation de salle de bain', 'Modernisation d''une salle de bain à Lille', 'Mars 2024', 'Lille', 'Rénovation complète de la salle de bain', 'Ce projet inclut le remplacement de la baignoire par une douche à l''italienne.'),
('Extension de maison', 'Agrandissement d''une maison familiale à Amiens', 'Juin 2024', 'Amiens', 'Construction d''une extension', 'Ce projet vise à ajouter une nouvelle pièce à vivre et une chambre supplémentaire.');

INSERT INTO images (projet_id, chemin) VALUES 
(1, 'images/color.jpg'),
(1, 'images/facade.jpg'),
(2, 'images/avant.png'),
(2, 'images/apres.png');