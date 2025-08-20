-- Types de ressources
INSERT INTO type_ressource (nom, description) VALUES
('Événement sur le parvis', 'Événements extérieurs sur le parvis'),
('Esplanade & Hall', 'Espaces Esplanade et Hall'),
('Infrastructures sportives', 'Terrains et installations sportives'),
('Locaux & Salles', 'Salles de réunion, conférence, bureaux'),
('Parking', 'Espaces de parking'),
('Jardin & Piste', 'Jardin ou piste de défilé');

-- Unités tarifaires
INSERT INTO unite_tarif (nom) VALUES
('heure'),
('demi-journee'),
('jour'),
('nuit'),
('mois'),
('par stand'),
('pers');

-- Ressources
INSERT INTO ressources (nom, caution, capacite, id_type_ressource) VALUES
('Salon <60 stands', NULL, NULL, 1),
('Salon 60-100 stands', NULL, NULL, 1),
('Salon >100 stands', NULL, NULL, 1),
('Sécurité', NULL, NULL, 1),
('Œuvres caritatives', NULL, NULL, 1),
('Expositions', NULL, NULL, 1),
('Événement payant (demi site)', NULL, NULL, 1),
('Événement payant (site complet)', NULL, NULL, 1),

('Salon Esplanade', NULL, NULL, 2),
('Food Court', NULL, NULL, 2),
('Concert/Spectacle Esplanade', NULL, NULL, 2),
('La Totale R+1', NULL, NULL, 2),
('Hall R+1 + 1 Esplanade', NULL, NULL, 2),
('Hall R+1', NULL, NULL, 2),
('Hall R+2', NULL, NULL, 2),
('Hall VIP R+1/R+2', NULL, NULL, 2),
('Hall côté pelouse', NULL, NULL, 2),
('Hall R+3', NULL, NULL, 2),

('Foot à 11', NULL, NULL, 3),
('Basket', NULL, NULL, 3),
('Boulodrome', NULL, NULL, 3),
('Footing', NULL, NULL, 3),

('Salle réunion Nord', NULL, NULL, 4),
('Salle média', NULL, NULL, 4),
('Bureau B5', NULL, NULL, 4),
('Bureau', NULL, NULL, 4),
('Salle conférence', NULL, NULL, 4),
('Salon VIP', NULL, NULL, 4),
('Loges', NULL, NULL, 4),
('Restaurant', NULL, NULL, 4),
('Food Court Salle', NULL, NULL, 4),
('Box', NULL, NULL, 4),

('Parking P2', NULL, NULL, 5),

('Jardin', NULL, NULL, 6),
('Piste de défilé', NULL, NULL, 6),
('11 bureaux', NULL, NULL, 6);

-- Tarifs ressources (avec unités)
INSERT INTO tarifs_ressources (prix_unitaire, date_saisie, id_unite_tarif, id_ressource) VALUES
(1650000, NOW(), 6, 1),
(30000, NOW(), 6, 2),
(20000, NOW(), 6, 3),
(0, NOW(), 3, 4),
(0, NOW(), 3, 5),
(1650000, NOW(), 3, 6),
(5800000, NOW(), 3, 7),
(8800000, NOW(), 3, 8),

(1050000, NOW(), 3, 9),
(1090000, NOW(), 3, 10),
(2000000, NOW(), 3, 11),
(6200000, NOW(), 3, 12),
(4100000, NOW(), 3, 13),
(4000000, NOW(), 3, 14),
(2080000, NOW(), 3, 15),
(500000, NOW(), 3, 16),
(350000, NOW(), 3, 17),
(1150000, NOW(), 3, 18),

(120000, NOW(), 3, 19),
(150000, NOW(), 3, 19),
(200000, NOW(), 4, 19),
(5000, NOW(), 1, 19),

(50000, NOW(), 3, 20),
(70000, NOW(), 4, 20),
(5000, NOW(), 1, 20),
(25000, NOW(), 3, 20),

(10000, NOW(), 3, 21),
(15000, NOW(), 4, 21),

(100000, NOW(), 5, 22),
(5000, NOW(), 1, 22),

(750000, NOW(), 3, 23),
(400000, NOW(), 2, 23),
(1000000, NOW(), 3, 24),
(150000, NOW(), 1, 24),

(500000, NOW(), 3, 25),
(50000, NOW(), 3, 26),
(1500000, NOW(), 3, 27),
(800000, NOW(), 2, 27),
(200000, NOW(), 1, 27),

(500000, NOW(), 3, 28),
(80000, NOW(), 1, 28),
(500000, NOW(), 3, 29),
(1000000, NOW(), 3, 30),
(2500000, NOW(), 3, 31),
(120000, NOW(), 3, 32),

(4000000, NOW(), 3, 33),

(2000000, NOW(), 3, 34),
(1500000, NOW(), 3, 34),
(2000000, NOW(), 3, 35),
(1000000, NOW(), 3, 36);

-- Insertion des rôles utilisateurs
INSERT INTO role_utilisateur (role) VALUES
('commercial'),
('dg'),
('admin'),
('caisse');

-- Insertion des accessoires
INSERT INTO accessoires (nom, nombre_disponible) VALUES
('Chaise pliante', 100),
('Table ronde', 30),
('Projecteur', 10),
('Microphone', 15),
('Tente 4x4m', 20),
('Sonorisation complète', 5),
('Podium', 8),
('Bouquets', 50),
('Jeux de boules', 25),
('Glacière', 15);

-- Insertion des modes de paiement
INSERT INTO mode_paiement (nom) VALUES
('virement'),
('carte'),
('especes'),
('cheque');

-- Insertion des types de paiement
INSERT INTO type_paiement (nom) VALUES
('totalite'),
('acompte'),
('reste');

-- Insertion des types de clients
INSERT INTO type_client (nom) VALUES
('entreprise'),
('association'),
('particulier'),
('administration');

-- Insertion des utilisateurs
INSERT INTO utilisateur (nom_utilisateur, password, token, id_role) VALUES
('admin', '$2y$10$/kzRM/xCgTvzcUI7O5nB0u/smBTTD5mmOT3JmoU1.GZvyjyxAbQy6', 'token_admin', 3), -- admin123
('dg', '$2y$10$TCVN.SPDEIacOorzFjGgje1UycoGKSBBGPkV0LAAu9n0TAY4j4EuS', 'token_dg', 2), -- dg123
('commercial', '$2y$10$k79jitHI0SUFgf6tAVpTdeYcPboVd9J4ZENfH/9kvxAQ9hIEMVz5.', 'token_com', 1), -- commercial123
('caisse', '$2y$10$nvkJyNshRAYikjUsbAIMOOAGvvPGPbjU7xFBNakpmnWkNo4Mf6fSK', 'token_caisse', 4), -- caisse123
('commercial2', '$2y$10$k79jitHI0SUFgf6tAVpTdeYcPboVd9J4ZENfH/9kvxAQ9hIEMVz5.', 'token_com2', 1); -- commercial123

-- Insertion des clients
INSERT INTO clients (reference, nom, representant, telephone, email, adresse, date_ajout, id_type_client) VALUES
('CLI001', 'Entreprise ABC', 'Jean Dupont', '0201234567', 'contact@abc.mg', 'Lot IIA 123', NOW(), 1),
('CLI002', 'Association Sportive', 'Marie Ranaivo', '0345678910', 'sport@asso.mg', 'Av. de l Indépendance', NOW(), 2),
('CLI003', 'SARL XYZ', 'Paul Randria', '0387654321', 'xyz@sarl.mg', 'Zone Galaxy 45', NOW(), 1),
('CLI004', 'Familie Rakoto', 'Jean Rakoto', '0321987654', NULL, 'Ivandry', NOW(), 3),
('CLI005', 'Hotel Panorama', 'Sophie Andria', '0209876543', 'reservation@panorama.mg', 'Route Digue', NOW(), 1),
('CLI006', 'Mairie Antananarivo', 'Pierre Rajaona', '0202345678', 'mairie@tana.mg', 'Place de l\'Indépendance', NOW(), 4),
('CLI007', 'Restaurant La Vanille', 'Emma Ravelo', '0341234567', 'contact@lavanille.mg', 'Route des Hydrocarbures', NOW(), 1),
('CLI008', 'Club de Pétanque', 'Henri Rakoto', '0323456789', 'petanque@club.mg', 'Alarobia', NOW(), 2);

-- Insertion des tarifs accessoires
INSERT INTO tarifs_accessoires (prix_unitaire, date_saisie, id_unite_tarif, id_accessoire) VALUES
(5000, NOW(), 3, 1),
(15000, NOW(), 3, 2),
(20000, NOW(), 1, 3),
(10000, NOW(), 1, 4),
(30000, NOW(), 3, 5),
(50000, NOW(), 3, 6),
(25000, NOW(), 3, 7),
(2000, NOW(), 1, 8),
(10000, NOW(), 3, 9),
(8000, NOW(), 3, 10);

INSERT INTO reservations (reference, description, date_creation, date_premier_jour, date_dernier_jour, id_creer_par, id_client, reference_client) VALUES
('RES001', 'Salon Professionnel Local', NOW(), CURDATE(), CURDATE(), 2, 1, 'CLI001'),
('RES002', 'Sécurité Festival Open Air', DATE_SUB(NOW(), INTERVAL 2 DAY), CURDATE(), CURDATE(), 3, 2, 'CLI002'),
('RES003', 'Grand Salon Entreprises', DATE_SUB(NOW(), INTERVAL 1 DAY), CURDATE(), CURDATE(), 2, 3, 'CLI003'),
('RES004', 'Marché Gastronomique', NOW(), CURDATE(), CURDATE(), 3, 4, 'CLI004'),
('RES005', 'Exposition Artistique', DATE_ADD(NOW(), INTERVAL 3 DAY), CURDATE(), CURDATE(), 2, 5, 'CLI005'),
('RES006', 'Match Amical Nocturne', DATE_SUB(NOW(), INTERVAL 5 DAY), CURDATE() + INTERVAL 1 DAY, CURDATE() + INTERVAL 1 DAY, 5, 6, 'CLI006'),
('RES007', 'Tournoi Basket Associations', DATE_SUB(NOW(), INTERVAL 3 DAY), CURDATE() - INTERVAL 1 DAY, CURDATE() - INTERVAL 1 DAY, 3, 7, 'CLI007'),
('RES008', 'Compétition Pétanque', DATE_ADD(NOW(), INTERVAL 2 DAY), CURDATE() + INTERVAL 2 DAY, CURDATE() + INTERVAL 2 DAY, 5, 8, 'CLI008');

-- Insertion des ressources réservées
INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation) VALUES
-- RES001 : Salon <60 stands → Salon <60 stands + Hall R+1 + Sécurité
(1, 'RES001', 1, 1, 1, CONCAT(CURDATE(), ' 08:00:00'), CONCAT(CURDATE(), ' 18:00:00')),
(1, 'RES001', 2, 14, 1, CONCAT(CURDATE(), ' 08:00:00'), CONCAT(CURDATE(), ' 18:00:00')),
(1, 'RES001', 3, 4, 1, CONCAT(CURDATE(), ' 08:00:00'), CONCAT(CURDATE(), ' 18:00:00')),

-- RES002 : Sécurité Festival → Sécurité + Food Court + Jardin
(2, 'RES002', 4, 4, 1, CONCAT(CURDATE(), ' 07:00:00'), CONCAT(CURDATE(), ' 22:00:00')),
(2, 'RES002', 5, 10, 1, CONCAT(CURDATE(), ' 07:00:00'), CONCAT(CURDATE(), ' 22:00:00')),
(2, 'RES002', 6, 34, 1, CONCAT(CURDATE(), ' 07:00:00'), CONCAT(CURDATE(), ' 22:00:00')),

-- RES003 : Grand Salon Entreprises → Salon >100 stands + Hall R+1 + Piste de défilé
(3, 'RES003', 7, 3, 1, CONCAT(CURDATE(), ' 08:45:00'), CONCAT(CURDATE(), ' 19:00:00')),
(3, 'RES003', 8, 14, 1, CONCAT(CURDATE(), ' 08:45:00'), CONCAT(CURDATE(), ' 19:00:00')),
(3, 'RES003', 9, 35, 1, CONCAT(CURDATE(), ' 08:45:00'), CONCAT(CURDATE(), ' 19:00:00')),

-- RES004 : Marché Gastronomique → Food Court + Jardin
(4, 'RES004', 10, 10, 1, CONCAT(CURDATE(), ' 14:00:00'), CONCAT(CURDATE(), ' 20:00:00')),
(4, 'RES004', 11, 34, 1, CONCAT(CURDATE(), ' 14:00:00'), CONCAT(CURDATE(), ' 20:00:00')),

-- RES005 : Exposition Artistique → Hall R+1 + Expositions + Sécurité
(5, 'RES005', 12, 14, 1, CONCAT(CURDATE(), ' 13:00:00'), CONCAT(CURDATE(), ' 19:30:00')),
(5, 'RES005', 13, 6, 1, CONCAT(CURDATE(), ' 13:00:00'), CONCAT(CURDATE(), ' 19:30:00')),
(5, 'RES005', 14, 4, 1, CONCAT(CURDATE(), ' 13:00:00'), CONCAT(CURDATE(), ' 19:30:00')),

-- RES006 : Match Amical Nocturne → Foot à 11 + Hall côté pelouse
(6, 'RES006', 15, 19, 1, CONCAT(CURDATE() + INTERVAL 1 DAY, ' 09:00:00'), CONCAT(CURDATE() + INTERVAL 1 DAY, ' 17:00:00')),
(6, 'RES006', 16, 17, 1, CONCAT(CURDATE() + INTERVAL 1 DAY, ' 09:00:00'), CONCAT(CURDATE() + INTERVAL 1 DAY, ' 17:00:00')),

-- RES007 : Tournoi Basket → Basket + Hall R+2 + Sécurité
(7, 'RES007', 17, 20, 1, CONCAT(CURDATE() - INTERVAL 1 DAY, ' 10:00:00'), CONCAT(CURDATE() - INTERVAL 1 DAY, ' 16:00:00')),
(7, 'RES007', 18, 15, 1, CONCAT(CURDATE() - INTERVAL 1 DAY, ' 10:00:00'), CONCAT(CURDATE() - INTERVAL 1 DAY, ' 16:00:00')),
(7, 'RES007', 19, 4, 1, CONCAT(CURDATE() - INTERVAL 1 DAY, ' 10:00:00'), CONCAT(CURDATE() - INTERVAL 1 DAY, ' 16:00:00')),

-- RES008 : Compétition Pétanque → Boulodrome + Loges
(8, 'RES008', 20, 21, 1, CONCAT(CURDATE() + INTERVAL 2 DAY, ' 14:00:00'), CONCAT(CURDATE() + INTERVAL 2 DAY, ' 18:00:00')),
(8, 'RES008', 21, 29, 1, CONCAT(CURDATE() + INTERVAL 2 DAY, ' 14:00:00'), CONCAT(CURDATE() + INTERVAL 2 DAY, ' 18:00:00'));

-- Insertion des accessoires réservés
INSERT INTO accessoires_reservation (id_reservation, reference_reservation, id_accessoire, id_tarif_accessoire, quantite, debut_utilisation, fin_utilisation) VALUES
(1, 'RES001', 1, 1, '20', CONCAT(CURDATE(), ' 08:00:00'), CONCAT(CURDATE(), ' 18:00:00')),
(1, 'RES001', 2, 2, '5', CONCAT(CURDATE(), ' 08:00:00'), CONCAT(CURDATE(), ' 18:00:00')),
(2, 'RES002', 5, 5, '3', CONCAT(CURDATE(), ' 07:00:00'), CONCAT(CURDATE(), ' 22:00:00')),
(2, 'RES002', 6, 6, '1', CONCAT(CURDATE(), ' 07:00:00'), CONCAT(CURDATE(), ' 22:00:00')),
(3, 'RES003', 9, 9, '2', CONCAT(CURDATE(), ' 08:45:00'), CONCAT(CURDATE(), ' 19:00:00')),
(4, 'RES004', 3, 3, '1', CONCAT(CURDATE(), ' 14:00:00'), CONCAT(CURDATE(), ' 20:00:00')),
(5, 'RES005', 4, 4, '4', CONCAT(CURDATE(), ' 13:00:00'), CONCAT(CURDATE(), ' 19:30:00')),
(6, 'RES006', 7, 7, '2', CONCAT(CURDATE() + INTERVAL 1 DAY, ' 09:00:00'), CONCAT(CURDATE() + INTERVAL 1 DAY, ' 17:00:00')),
(7, 'RES007', 10, 10, '5', CONCAT(CURDATE() - INTERVAL 1 DAY, ' 10:00:00'), CONCAT(CURDATE() - INTERVAL 1 DAY, ' 16:00:00')),
(8, 'RES008', 9, 9, '4', CONCAT(CURDATE() + INTERVAL 2 DAY, ' 14:00:00'), CONCAT(CURDATE() + INTERVAL 2 DAY, ' 18:00:00'));

-- Insertion des réductions
INSERT INTO reductions (motif, valeur, id_reservation, reference_reservation) VALUES
('Remise fidélité', 10, 2, 'RES002'),
('Remise spéciale', 5, 4, 'RES004'),
('Remise association', 15, 6, 'RES006'),
('Remise membre club', 20, 8, 'RES008');