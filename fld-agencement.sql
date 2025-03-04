-- Sélectionnez la base de données
USE fld_agencement;

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

-- Insertion d'un exemple de données
INSERT INTO projets (titre, sous_titre, date, lieu, type_travaux, description)
VALUES (
    'Isolation complète',
    'Rénovation énergétique d''une maison à Arras',
    'Janvier 2024',
    'Arras',
    'Isolation thermique des murs et combles',
    'Ce projet consiste à améliorer l''efficacité énergétique d''une maison en isolant les murs extérieurs et les combles. Les travaux incluent également le remplacement des fenêtres par des modèles à double vitrage.'
);

INSERT INTO projets (titre, sous_titre, date, lieu, type_travaux, description)
VALUES
(
    'Isolation complète',
    'Rénovation énergétique d''une maison à Arras',
    'Janvier 2024',
    'Arras',
    'Isolation thermique des murs et combles',
    'Ce projet consiste à améliorer l''efficacité énergétique d''une maison en isolant les murs extérieurs et les combles. Les travaux incluent également le remplacement des fenêtres par des modèles à double vitrage.'
),
(
    'Rénovation de salle de bain',
    'Modernisation d''une salle de bain à Lille',
    'Mars 2024',
    'Lille',
    'Rénovation complète de la salle de bain',
    'Ce projet inclut le remplacement de la baignoire par une douche à l''italienne, l''installation de nouveaux carrelages et la mise à jour de la plomberie.'
),
(
    'Extension de maison',
    'Agrandissement d''une maison familiale à Amiens',
    'Juin 2024',
    'Amiens',
    'Construction d''une extension',
    'Ce projet vise à ajouter une nouvelle pièce à vivre et une chambre supplémentaire, avec des travaux d''isolation et de raccordement aux réseaux existants.'
);

describe projets;

CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    projet_id INT,
    chemin VARCHAR(255),
    FOREIGN KEY (projet_id) REFERENCES projets(id)
);

INSERT INTO images (projet_id, chemin) VALUES (1, 'images/color.jpg');
INSERT INTO images (projet_id, chemin) VALUES (1, 'images/color.jpg');
INSERT INTO images (projet_id, chemin) VALUES (1, 'images/facade.jpg');

INSERT INTO images (projet_id, chemin) VALUES (2, 'images/avant.png');
INSERT INTO images (projet_id, chemin) VALUES (2, 'images/apres.png');

describe projets
;

SHOW fld_agencement;

SHOW TABLES FROM fld_agencement;

describe images;


INSERT INTO images (projet_id, chemin) VALUES
(4, 'images/projet4test (1).jpg'),
(4, 'images/projet4test (2).jpg');

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role VARCHAR(20) NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE users ADD COLUMN locked_until DATETIME NULL;