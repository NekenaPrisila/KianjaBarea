-- Désactiver temporairement les contraintes de clés étrangères
SET FOREIGN_KEY_CHECKS = 0;

-- Août 2024 (6 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240722-0001', 'Festival culturel', '2024-08-05', '2024-08-07', '2024-07-22 09:45:00', 3, 5, 'CLI005'),
('RES-20240725-0002', 'Réunion de quartier', '2024-08-10', '2024-08-10', '2024-07-25 16:10:00', 5, 4, 'CLI004'),
('RES-20240801-0003', 'Séminaire management', '2024-08-15', '2024-08-16', '2024-08-01 10:30:00', 3, 1, 'CLI001'),
('RES-20240805-0004', 'Atelier formation', '2024-08-18', '2024-08-18', '2024-08-05 14:20:00', 5, 2, 'CLI002'),
('RES-20240810-0005', 'Événement corporate', '2024-08-22', '2024-08-22', '2024-08-10 11:15:00', 3, 3, 'CLI003'),
('RES-20240815-0006', 'Cérémonie officielle', '2024-08-28', '2024-08-28', '2024-08-15 16:45:00', 5, 6, 'CLI006');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(1, 'RES-20240722-0001', 12, 12, 1, '2024-08-05 09:00:00', '2024-08-07 22:00:00'),
(2, 'RES-20240725-0002', 23, 22, 1, '2024-08-10 14:00:00', '2024-08-10 18:00:00'),
(3, 'RES-20240801-0003', 27, 25, 2, '2024-08-15 09:00:00', '2024-08-16 17:00:00'),
(4, 'RES-20240805-0004', 25, 23, 1, '2024-08-18 14:00:00', '2024-08-18 18:00:00'),
(5, 'RES-20240810-0005', 27, 25, 1, '2024-08-22 10:00:00', '2024-08-22 16:00:00'),
(6, 'RES-20240815-0006', 35, 35, 1, '2024-08-28 10:00:00', '2024-08-28 16:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240728-0001', '2024-07-28 14:30:00', 6000000, 0, 1, 1, 'RES-20240722-0001', 4),
('FACT-20240802-0002', '2024-08-02 11:45:00', 400000, 0, 1, 2, 'RES-20240725-0002', 4),
('FACT-20240808-0003', '2024-08-08 16:20:00', 3200000, 0, 1, 3, 'RES-20240801-0003', 4),
('FACT-20240812-0004', '2024-08-12 10:15:00', 400000, 0, 1, 4, 'RES-20240805-0004', 4),
('FACT-20240815-0005', '2024-08-15 14:40:00', 800000, 0, 1, 5, 'RES-20240810-0005', 4),
('FACT-20240820-0006', '2024-08-20 09:30:00', 1800000, 0, 1, 6, 'RES-20240815-0006', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240728-0001', '2024-07-28 14:35:00', 'VIR01345678', 1, 1, 'FACT-20240728-0001', 4),
('RECU-20240802-0002', '2024-08-02 11:50:00', 'CARTE456123', 2, 2, 'FACT-20240802-0002', 4),
('RECU-20240808-0003', '2024-08-08 16:25:00', 'VIR01456789', 1, 3, 'FACT-20240808-0003', 4),
('RECU-20240812-0004', '2024-08-12 10:20:00', 'ESP0759863', 3, 4, 'FACT-20240812-0004', 4),
('RECU-20240815-0005', '2024-08-15 14:45:00', 'CHQ0055555', 4, 5, 'FACT-20240815-0005', 4),
('RECU-20240820-0006', '2024-08-20 09:35:00', 'CARTE789456', 2, 6, 'FACT-20240820-0006', 4);

-- Septembre 2024 (5 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240825-0007', 'Salon automobile', '2024-09-05', '2024-09-07', '2024-08-25 10:30:00', 3, 3, 'CLI003'),
('RES-20240901-0008', 'Tournoi football', '2024-09-12', '2024-09-12', '2024-09-01 14:50:00', 5, 2, 'CLI002'),
('RES-20240905-0009', 'Conférence tech', '2024-09-15', '2024-09-16', '2024-09-05 09:15:00', 3, 1, 'CLI001'),
('RES-20240910-0010', 'Atelier formation', '2024-09-20', '2024-09-20', '2024-09-10 16:30:00', 5, 5, 'CLI005'),
('RES-20240915-0011', 'Réunion annuelle', '2024-09-25', '2024-09-25', '2024-09-15 11:45:00', 3, 6, 'CLI006');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(7, 'RES-20240825-0007', 2, 2, 80, '2024-09-05 08:00:00', '2024-09-07 18:00:00'),
(8, 'RES-20240901-0008', 19, 19, 2, '2024-09-12 09:00:00', '2024-09-12 18:00:00'),
(9, 'RES-20240905-0009', 27, 25, 2, '2024-09-15 09:00:00', '2024-09-16 17:00:00'),
(10, 'RES-20240910-0010', 25, 23, 1, '2024-09-20 14:00:00', '2024-09-20 18:00:00'),
(11, 'RES-20240915-0011', 25, 23, 1, '2024-09-25 10:00:00', '2024-09-25 16:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240830-0007', '2024-08-30 16:20:00', 5500000, 0, 1, 7, 'RES-20240825-0007', 4),
('FACT-20240905-0008', '2024-09-05 11:45:00', 250000, 0, 1, 8, 'RES-20240901-0008', 4),
('FACT-20240910-0009', '2024-09-10 14:30:00', 2800000, 0, 1, 9, 'RES-20240905-0009', 4),
('FACT-20240915-0010', '2024-09-15 10:15:00', 400000, 0, 1, 10, 'RES-20240910-0010', 4),
('FACT-20240920-0011', '2024-09-20 13:40:00', 300000, 0, 1, 11, 'RES-20240915-0011', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240830-0007', '2024-08-30 16:25:00', 'VIR01567890', 1, 7, 'FACT-20240830-0007', 4),
('RECU-20240905-0008', '2024-09-05 11:50:00', 'CARTE852369', 2, 8, 'FACT-20240905-0008', 4),
('RECU-20240910-0009', '2024-09-10 14:35:00', 'VIR01678901', 1, 9, 'FACT-20240910-0009', 4),
('RECU-20240915-0010', '2024-09-15 10:20:00', 'ESP0869741', 3, 10, 'FACT-20240915-0010', 4),
('RECU-20240920-0011', '2024-09-20 13:45:00', 'CHQ0066666', 4, 11, 'FACT-20240920-0011', 4);

-- Octobre 2024 (4 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240920-0012', 'Congrès médical', '2024-10-05', '2024-10-07', '2024-09-20 09:15:00', 3, 6, 'CLI006'),
('RES-20240925-0013', 'Fête d\'anniversaire', '2024-10-12', '2024-10-12', '2024-09-25 14:30:00', 5, 4, 'CLI004'),
('RES-20241001-0014', 'Séminaire marketing', '2024-10-18', '2024-10-18', '2024-10-01 11:20:00', 3, 1, 'CLI001'),
('RES-20241005-0015', 'Atelier créatif', '2024-10-25', '2024-10-25', '2024-10-05 15:40:00', 5, 2, 'CLI002');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(12, 'RES-20240920-0012', 27, 25, 3, '2024-10-05 08:00:00', '2024-10-07 18:00:00'),
(13, 'RES-20240925-0013', 34, 34, 1, '2024-10-12 16:00:00', '2024-10-12 23:00:00'),
(14, 'RES-20241001-0014', 25, 23, 1, '2024-10-18 14:00:00', '2024-10-18 18:00:00'),
(15, 'RES-20241005-0015', 25, 23, 1, '2024-10-25 10:00:00', '2024-10-25 16:00:00');

INSERT INTO accessoires_reservation (id_reservation, reference_reservation, id_accessoire, id_tarif_accessoire, quantite, debut_utilisation, fin_utilisation)
VALUES
(13, 'RES-20240925-0013', 8, 8, 20, '2024-10-12 16:00:00', '2024-10-12 23:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240928-0012', '2024-09-28 10:40:00', 4200000, 0, 1, 12, 'RES-20240920-0012', 4),
('FACT-20241005-0013', '2024-10-05 15:20:00', 950000, 0, 1, 13, 'RES-20240925-0013', 4),
('FACT-20241010-0014', '2024-10-10 12:30:00', 400000, 0, 1, 14, 'RES-20241001-0014', 4),
('FACT-20241015-0015', '2024-10-15 14:15:00', 300000, 0, 1, 15, 'RES-20241005-0015', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240928-0012', '2024-09-28 10:45:00', 'VIR01789012', 1, 12, 'FACT-20240928-0012', 4),
('RECU-20241005-0013', '2024-10-05 15:25:00', 'CHQ0077777', 4, 13, 'FACT-20241005-0013', 4),
('RECU-20241010-0014', '2024-10-10 12:35:00', 'CARTE741852', 2, 14, 'FACT-20241010-0014', 4),
('RECU-20241015-0015', '2024-10-15 14:20:00', 'ESP0975361', 3, 15, 'FACT-20241015-0015', 4);

-- Novembre 2024 (3 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20241020-0016', 'Salon du livre', '2024-11-08', '2024-11-10', '2024-10-20 11:10:00', 3, 7, 'CLI007'),
('RES-20241025-0017', 'Réunion stratégique', '2024-11-15', '2024-11-15', '2024-10-25 16:45:00', 5, 1, 'CLI001'),
('RES-20241101-0018', 'Conférence annuelle', '2024-11-20', '2024-11-20', '2024-11-01 10:30:00', 3, 3, 'CLI003');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(16, 'RES-20241020-0016', 6, 6, 1, '2024-11-08 09:00:00', '2024-11-10 19:00:00'),
(17, 'RES-20241025-0017', 25, 23, 1, '2024-11-15 14:00:00', '2024-11-15 18:00:00'),
(18, 'RES-20241101-0018', 27, 25, 1, '2024-11-20 10:00:00', '2024-11-20 16:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20241028-0016', '2024-10-28 14:30:00', 3800000, 0, 1, 16, 'RES-20241020-0016', 4),
('FACT-20241105-0017', '2024-11-05 10:15:00', 600000, 0, 1, 17, 'RES-20241025-0017', 4),
('FACT-20241110-0018', '2024-11-10 16:40:00', 800000, 0, 1, 18, 'RES-20241101-0018', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20241028-0016', '2024-10-28 14:35:00', 'VIR01890123', 1, 16, 'FACT-20241028-0016', 4),
('RECU-20241105-0017', '2024-11-05 10:20:00', 'CARTE963258', 2, 17, 'FACT-20241105-0017', 4),
('RECU-20241110-0018', '2024-11-10 16:45:00', 'ESP1086429', 3, 18, 'FACT-20241110-0018', 4);

-- Décembre 2024 (7 réservations - fin d'année)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20241115-0019', 'Gala de fin d\'année', '2024-12-05', '2024-12-05', '2024-11-15 09:40:00', 3, 5, 'CLI005'),
('RES-20241120-0020', 'Fête de Noël entreprise', '2024-12-10', '2024-12-10', '2024-11-20 15:20:00', 5, 3, 'CLI003'),
('RES-20241125-0021', 'Réunion de clôture', '2024-12-15', '2024-12-15', '2024-11-25 11:15:00', 3, 1, 'CLI001'),
('RES-20241201-0022', 'Célébration équipe', '2024-12-18', '2024-12-18', '2024-12-01 14:30:00', 5, 2, 'CLI002'),
('RES-20241205-0023', 'Séminaire bilan', '2024-12-20', '2024-12-20', '2024-12-05 10:45:00', 3, 6, 'CLI006'),
('RES-20241210-0024', 'Atelier planning', '2024-12-22', '2024-12-22', '2024-12-10 16:20:00', 5, 4, 'CLI004'),
('RES-20241215-0025', 'Réveillon entreprise', '2024-12-28', '2024-12-28', '2024-12-15 12:30:00', 3, 7, 'CLI007');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(19, 'RES-20241115-0019', 31, 31, 1, '2024-12-05 18:00:00', '2024-12-05 23:00:00'),
(20, 'RES-20241120-0020', 13, 13, 1, '2024-12-10 17:00:00', '2024-12-10 23:00:00'),
(21, 'RES-20241125-0021', 25, 23, 1, '2024-12-15 10:00:00', '2024-12-15 16:00:00'),
(22, 'RES-20241201-0022', 25, 23, 1, '2024-12-18 15:00:00', '2024-12-18 19:00:00'),
(23, 'RES-20241205-0023', 25, 23, 1, '2024-12-20 14:00:00', '2024-12-20 18:00:00'),
(24, 'RES-20241210-0024', 25, 23, 1, '2024-12-22 09:00:00', '2024-12-22 17:00:00'),
(25, 'RES-20241215-0025', 11, 11, 1, '2024-12-28 19:00:00', '2024-12-28 23:00:00');

INSERT INTO accessoires_reservation (id_reservation, reference_reservation, id_accessoire, id_tarif_accessoire, quantite, debut_utilisation, fin_utilisation)
VALUES
(19, 'RES-20241115-0019', 7, 7, 1, '2024-12-05 18:00:00', '2024-12-05 23:00:00'),
(20, 'RES-20241120-0020', 1, 1, 150, '2024-12-10 17:00:00', '2024-12-10 23:00:00'),
(25, 'RES-20241215-0025', 8, 8, 50, '2024-12-28 19:00:00', '2024-12-28 23:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20241125-0019', '2024-11-25 14:20:00', 3200000, 0, 1, 19, 'RES-20241115-0019', 4),
('FACT-20241128-0020', '2024-11-28 16:45:00', 1800000, 0, 1, 20, 'RES-20241120-0020', 4),
('FACT-20241205-0021', '2024-12-05 11:30:00', 400000, 0, 1, 21, 'RES-20241125-0021', 4),
('FACT-20241210-0022', '2024-12-10 15:15:00', 300000, 0, 1, 22, 'RES-20241201-0022', 4),
('FACT-20241212-0023', '2024-12-12 10:40:00', 400000, 0, 1, 23, 'RES-20241205-0023', 4),
('FACT-20241215-0024', '2024-12-15 14:25:00', 300000, 0, 1, 24, 'RES-20241210-0024', 4),
('FACT-20241220-0025', '2024-12-20 16:50:00', 2500000, 0, 1, 25, 'RES-20241215-0025', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20241125-0019', '2024-11-25 14:25:00', 'VIR01901234', 1, 19, 'FACT-20241125-0019', 4),
('RECU-20241128-0020', '2024-11-28 16:50:00', 'CARTE852741', 2, 20, 'FACT-20241128-0020', 4),
('RECU-20241205-0021', '2024-12-05 11:35:00', 'ESP1197532', 3, 21, 'FACT-20241205-0021', 4),
('RECU-20241210-0022', '2024-12-10 15:20:00', 'CHQ0088888', 4, 22, 'FACT-20241210-0022', 4),
('RECU-20241212-0023', '2024-12-12 10:45:00', 'CARTE369258', 2, 23, 'FACT-20241212-0023', 4),
('RECU-20241215-0024', '2024-12-15 14:30:00', 'ESP1284639', 3, 24, 'FACT-20241215-0024', 4),
('RECU-20241220-0025', '2024-12-20 16:55:00', 'VIR02012345', 1, 25, 'FACT-20241220-0025', 4);

-- Réactiver les contraintes de clés étrangères
SET FOREIGN_KEY_CHECKS = 1;