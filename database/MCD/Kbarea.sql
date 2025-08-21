CREATE TABLE type_ressource(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   description TEXT,
   PRIMARY KEY(id)
);

CREATE TABLE role_utilisateur(
   id INT AUTO_INCREMENT,
   role VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE accessoires(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   nombre_disponible INT DEFAULT 0,
   PRIMARY KEY(id)
);

CREATE TABLE mode_paiement(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(nom)
);

CREATE TABLE type_paiement(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(nom)
);

CREATE TABLE unite_tarif(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(nom)
);

CREATE TABLE type_client(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(nom)
);

CREATE TABLE recu_occasionnel(
   id INT AUTO_INCREMENT,
   date_edition DATETIME,
   motif TEXT NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE ressources(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   caution DECIMAL(15,2)  ,
   capacite INT,
   id_type_ressource INT NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(nom),
   FOREIGN KEY(id_type_ressource) REFERENCES type_ressource(id)
);

CREATE TABLE clients(
   id INT AUTO_INCREMENT,
   reference VARCHAR(50) ,
   nom VARCHAR(50)  NOT NULL,
   representant VARCHAR(50)  NOT NULL,
   telephone VARCHAR(50)  NOT NULL,
   email VARCHAR(50) ,
   adresse VARCHAR(50) ,
   date_ajout DATETIME NOT NULL,
   id_type_client INT NOT NULL,
   PRIMARY KEY(id, reference),
   FOREIGN KEY(id_type_client) REFERENCES type_client(id)
);

CREATE TABLE utilisateur(
   id INT AUTO_INCREMENT,
   nom_utilisateur VARCHAR(50)  NOT NULL,
   password VARCHAR(255)  NOT NULL,
   token VARCHAR(50) ,
   id_role INT NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(nom_utilisateur),
   UNIQUE(token),
   FOREIGN KEY(id_role) REFERENCES role_utilisateur(id)
);

CREATE TABLE tarifs_ressources(
   id INT AUTO_INCREMENT,
   prix_unitaire DECIMAL(15,2)   NOT NULL,
   date_saisie DATETIME,
   id_unite_tarif INT NOT NULL,
   id_ressource INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_unite_tarif) REFERENCES unite_tarif(id),
   FOREIGN KEY(id_ressource) REFERENCES ressources(id)
);

CREATE TABLE tarifs_accessoires(
   id INT AUTO_INCREMENT,
   prix_unitaire DECIMAL(15,2)   NOT NULL,
   date_saisie DATETIME NOT NULL,
   id_unite_tarif INT NOT NULL,
   id_accessoire INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_unite_tarif) REFERENCES unite_tarif(id),
   FOREIGN KEY(id_accessoire) REFERENCES accessoires(id)
);

CREATE TABLE reservations(
   id INT AUTO_INCREMENT,
   reference VARCHAR(50) ,
   description TEXT NOT NULL,
   date_premier_jour DATE NOT NULL,
   date_dernier_jour DATE NOT NULL,
   date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
   cout_total DECIMAL(15,2)  ,
   id_creer_par INT NOT NULL,
   id_client INT NOT NULL,
   reference_client VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id, reference),
   FOREIGN KEY(id_creer_par) REFERENCES utilisateur(id),
   FOREIGN KEY(id_client, reference_client) REFERENCES clients(id, reference)
);

CREATE TABLE reductions(
   id INT AUTO_INCREMENT,
   motif VARCHAR(50) ,
   valeur DECIMAL(3,2)  ,
   id_reservation INT NOT NULL,
   reference_reservation VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_reservation, reference_reservation) REFERENCES reservations(id, reference)
);

CREATE TABLE facture(
   id INT AUTO_INCREMENT,
   reference VARCHAR(50) ,
   date_edition DATETIME NOT NULL,
   montant_paye DECIMAL(15,2)  ,
   reste_a_payer DECIMAL(15,2)  ,
   id_type_paiement INT NOT NULL,
   id_reservation INT NOT NULL,
   reference_reservation VARCHAR(50)  NOT NULL,
   id_creer_par INT NOT NULL,
   PRIMARY KEY(id, reference),
   FOREIGN KEY(id_type_paiement) REFERENCES type_paiement(id),
   FOREIGN KEY(id_reservation, reference_reservation) REFERENCES reservations(id, reference),
   FOREIGN KEY(id_creer_par) REFERENCES utilisateur(id)
);

CREATE TABLE recus(
   id INT AUTO_INCREMENT,
   reference VARCHAR(50) ,
   date_edition DATETIME NOT NULL,
   reference_paiement VARCHAR(100)  NOT NULL,
   id_mode_paiement INT NOT NULL,
   id_facture INT NOT NULL,
   reference_facture VARCHAR(50)  NOT NULL,
   creer_par INT NOT NULL,
   PRIMARY KEY(id, reference),
   UNIQUE(id_facture, reference_facture),
   FOREIGN KEY(id_mode_paiement) REFERENCES mode_paiement(id),
   FOREIGN KEY(id_facture, reference_facture) REFERENCES facture(id, reference),
   FOREIGN KEY(creer_par) REFERENCES utilisateur(id)
);

CREATE TABLE ressources_reservation(
   id_reservation INT,
   reference_reservation VARCHAR(50) ,
   id_tarif_ressource INT,
   id_ressource INT,
   quantite DECIMAL(15,2)   NOT NULL,
   debut_utilisation DATETIME,
   fin_utilisation DATETIME,
   PRIMARY KEY(id_reservation, reference_reservation, id_tarif_ressource, id_ressource),
   FOREIGN KEY(id_reservation, reference_reservation) REFERENCES reservations(id, reference),
   FOREIGN KEY(id_tarif_ressource) REFERENCES tarifs_ressources(id),
   FOREIGN KEY(id_ressource) REFERENCES ressources(id)
);

CREATE TABLE accessoires_reservation(
   id_reservation INT,
   reference_reservation VARCHAR(50) ,
   id_accessoire INT,
   id_tarif_accessoire INT,
   quantite INT NOT NULL,
   debut_utilisation DATETIME,
   fin_utilisation DATETIME,
   PRIMARY KEY(id_reservation, reference_reservation, id_accessoire, id_tarif_accessoire),
   FOREIGN KEY(id_reservation, reference_reservation) REFERENCES reservations(id, reference),
   FOREIGN KEY(id_accessoire) REFERENCES accessoires(id),
   FOREIGN KEY(id_tarif_accessoire) REFERENCES tarifs_accessoires(id)
);

CREATE TABLE ressources_recu_occasionnel(
   id INT,
   id_1 INT,
   id_2 INT,
   quantite VARCHAR(50) ,
   debut_utilisation VARCHAR(50) ,
   fin_utilisation VARCHAR(50) ,
   PRIMARY KEY(id, id_1, id_2),
   FOREIGN KEY(id) REFERENCES ressources(id),
   FOREIGN KEY(id_1) REFERENCES tarifs_ressources(id),
   FOREIGN KEY(id_2) REFERENCES recu_occasionnel(id)
);
