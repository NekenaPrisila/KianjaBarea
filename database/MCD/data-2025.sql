SET FOREIGN_KEY_CHECKS = 0;

-- Janvier 2025 (3 réservations) - Suite à partir de l'ID 26
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20250105-0026', 'Séminaire d\'entreprise - Janvier', '2025-01-15', '2025-01-16', '2025-01-05 09:30:00', 3, 1, 'CLI001'),
('RES-20250110-0027', 'Tournoi de basket', '2025-01-20', '2025-01-20', '2025-01-10 14:15:00', 3, 2, 'CLI002'),
('RES-20250118-0028', 'Réunion de planning', '2025-01-25', '2025-01-25', '2025-01-18 11:20:00', 5, 3, 'CLI003');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(26, 'RES-20250105-0026', 25, 23, 2, '2025-01-15 08:00:00', '2025-01-16 18:00:00'),
(26, 'RES-20250105-0026', 32, 27, 1, '2025-01-15 08:00:00', '2025-01-16 18:00:00'),
(27, 'RES-20250110-0027', 20, 19, 1, '2025-01-20 14:00:00', '2025-01-20 18:00:00'),
(28, 'RES-20250118-0028', 25, 23, 1, '2025-01-25 09:00:00', '2025-01-25 12:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20250108-0026', '2025-01-08 11:20:00', 2500000, 0, 1, 26, 'RES-20250105-0026', 4),
('FACT-20250115-0027', '2025-01-15 16:45:00', 150000, 0, 1, 27, 'RES-20250110-0027', 4),
('FACT-20250120-0028', '2025-01-20 10:30:00', 300000, 0, 1, 28, 'RES-20250118-0028', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20250108-0026', '2025-01-08 11:25:00', 'VIR00124578', 1, 26, 'FACT-20250108-0026', 4),
('RECU-20250115-0027', '2025-01-15 16:50:00', 'CARTE789456', 2, 27, 'FACT-20250115-0027', 4),
('RECU-20250120-0028', '2025-01-20 10:35:00', 'ESP0012345', 3, 28, 'FACT-20250120-0028', 4);

-- Février 2025 (4 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20250128-0029', 'Conférence annuelle', '2025-02-10', '2025-02-11', '2025-01-28 10:00:00', 3, 3, 'CLI003'),
('RES-20250201-0030', 'Mariage - Cérémonie', '2025-02-14', '2025-02-14', '2025-02-01 15:30:00', 5, 4, 'CLI004'),
('RES-20250208-0031', 'Atelier formation', '2025-02-20', '2025-02-20', '2025-02-08 09:15:00', 3, 5, 'CLI005'),
('RES-20250215-0032', 'Réunion équipe', '2025-02-25', '2025-02-25', '2025-02-15 14:20:00', 5, 6, 'CLI006');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(29, 'RES-20250128-0029', 27, 25, 1, '2025-02-10 09:00:00', '2025-02-11 17:00:00'),
(29, 'RES-20250128-0029', 33, 28, 2, '2025-02-10 09:00:00', '2025-02-11 17:00:00'),
(30, 'RES-20250201-0030', 34, 34, 1, '2025-02-14 15:00:00', '2025-02-14 22:00:00'),
(31, 'RES-20250208-0031', 25, 23, 1, '2025-02-20 09:00:00', '2025-02-20 17:00:00'),
(32, 'RES-20250215-0032', 25, 23, 1, '2025-02-25 14:00:00', '2025-02-25 16:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20250205-0029', '2025-02-05 14:20:00', 2000000, 1500000, 2, 29, 'RES-20250128-0029', 4),
('FACT-20250208-0030', '2025-02-08 09:15:00', 2000000, 0, 1, 30, 'RES-20250201-0030', 4),
('FACT-20250212-0031', '2025-02-12 11:30:00', 400000, 0, 1, 31, 'RES-20250208-0031', 4),
('FACT-20250218-0032', '2025-02-18 16:45:00', 250000, 0, 1, 32, 'RES-20250215-0032', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20250205-0029', '2025-02-05 14:25:00', 'VIR00234567', 1, 29, 'FACT-20250205-0029', 4),
('RECU-20250208-0030', '2025-02-08 09:20:00', 'ESP0145789', 3, 30, 'FACT-20250208-0030', 4),
('RECU-20250212-0031', '2025-02-12 11:35:00', 'CARTE123456', 2, 31, 'FACT-20250212-0031', 4),
('RECU-20250218-0032', '2025-02-18 16:50:00', 'CHQ0007890', 4, 32, 'FACT-20250218-0032', 4);

-- Mars 2025 (6 réservations - haute saison)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20250220-0033', 'Salon professionnel', '2025-03-05', '2025-03-07', '2025-02-20 11:45:00', 3, 5, 'CLI005'),
('RES-20250225-0034', 'Tournoi de pétanque', '2025-03-10', '2025-03-10', '2025-02-25 16:20:00', 5, 8, 'CLI008'),
('RES-20250301-0035', 'Séminaire corporate', '2025-03-12', '2025-03-13', '2025-03-01 09:30:00', 3, 1, 'CLI001'),
('RES-20250305-0036', 'Formation technique', '2025-03-15', '2025-03-15', '2025-03-05 14:15:00', 5, 2, 'CLI002'),
('RES-20250310-0037', 'Événement caritatif', '2025-03-18', '2025-03-18', '2025-03-10 10:45:00', 3, 7, 'CLI007'),
('RES-20250315-0038', 'Réunion annuelle', '2025-03-22', '2025-03-22', '2025-03-15 16:30:00', 5, 3, 'CLI003');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(33, 'RES-20250220-0033', 1, 1, 50, '2025-03-05 08:00:00', '2025-03-07 18:00:00'),
(33, 'RES-20250220-0033', 9, 9, 1, '2025-03-05 08:00:00', '2025-03-07 18:00:00'),
(34, 'RES-20250225-0034', 22, 21, 2, '2025-03-10 09:00:00', '2025-03-10 17:00:00'),
(35, 'RES-20250301-0035', 27, 25, 2, '2025-03-12 09:00:00', '2025-03-13 17:00:00'),
(36, 'RES-20250305-0036', 25, 23, 1, '2025-03-15 14:00:00', '2025-03-15 18:00:00'),
(37, 'RES-20250310-0037', 34, 34, 1, '2025-03-18 15:00:00', '2025-03-18 22:00:00'),
(38, 'RES-20250315-0038', 25, 23, 1, '2025-03-22 10:00:00', '2025-03-22 16:00:00');

INSERT INTO accessoires_reservation (id_reservation, reference_reservation, id_accessoire, id_tarif_accessoire, quantite, debut_utilisation, fin_utilisation)
VALUES
(34, 'RES-20250225-0034', 9, 9, 10, '2025-03-10 09:00:00', '2025-03-10 17:00:00'),
(37, 'RES-20250310-0037', 8, 8, 20, '2025-03-18 15:00:00', '2025-03-18 22:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20250228-0033', '2025-02-28 14:30:00', 5000000, 0, 1, 33, 'RES-20250220-0033', 4),
('FACT-20250305-0034', '2025-03-05 11:45:00', 100000, 0, 1, 34, 'RES-20250225-0034', 4),
('FACT-20250308-0035', '2025-03-08 16:20:00', 1800000, 0, 1, 35, 'RES-20250301-0035', 4),
('FACT-20250312-0036', '2025-03-12 10:15:00', 400000, 0, 1, 36, 'RES-20250305-0036', 4),
('FACT-20250314-0037', '2025-03-14 14:40:00', 1200000, 0, 1, 37, 'RES-20250310-0037', 4),
('FACT-20250318-0038', '2025-03-18 09:30:00', 300000, 0, 1, 38, 'RES-20250315-0038', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20250228-0033', '2025-02-28 14:35:00', 'VIR00345678', 1, 33, 'FACT-20250228-0033', 4),
('RECU-20250305-0034', '2025-03-05 11:50:00', 'CHQ0012345', 4, 34, 'FACT-20250305-0034', 4),
('RECU-20250308-0035', '2025-03-08 16:25:00', 'CARTE456789', 2, 35, 'FACT-20250308-0035', 4),
('RECU-20250312-0036', '2025-03-12 10:20:00', 'ESP0023456', 3, 36, 'FACT-20250312-0036', 4),
('RECU-20250314-0037', '2025-03-14 14:45:00', 'VIR00456789', 1, 37, 'FACT-20250314-0037', 4),
('RECU-20250318-0038', '2025-03-18 09:35:00', 'CARTE567890', 2, 38, 'FACT-20250318-0038', 4);

-- Avril 2025 (5 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20250325-0039', 'Concert public', '2025-04-05', '2025-04-05', '2025-03-25 09:15:00', 3, 7, 'CLI007'),
('RES-20250401-0040', 'Réunion administrative', '2025-04-12', '2025-04-12', '2025-04-01 14:45:00', 5, 6, 'CLI006'),
('RES-20250405-0041', 'Atelier créatif', '2025-04-15', '2025-04-15', '2025-04-05 11:20:00', 3, 4, 'CLI004'),
('RES-20250410-0042', 'Séminaire marketing', '2025-04-18', '2025-04-19', '2025-04-10 15:30:00', 5, 1, 'CLI001'),
('RES-20250415-0043', 'Cérémonie officielle', '2025-04-25', '2025-04-25', '2025-04-15 10:10:00', 3, 6, 'CLI006');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(39, 'RES-20250325-0039', 11, 11, 1, '2025-04-05 18:00:00', '2025-04-05 23:00:00'),
(40, 'RES-20250401-0040', 25, 23, 1, '2025-04-12 14:00:00', '2025-04-12 17:00:00'),
(41, 'RES-20250405-0041', 25, 23, 1, '2025-04-15 09:00:00', '2025-04-15 12:00:00'),
(42, 'RES-20250410-0042', 27, 25, 2, '2025-04-18 09:00:00', '2025-04-19 17:00:00'),
(43, 'RES-20250415-0043', 35, 35, 1, '2025-04-25 10:00:00', '2025-04-25 16:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20250328-0039', '2025-03-28 16:45:00', 3000000, 0, 1, 39, 'RES-20250325-0039', 4),
('FACT-20250405-0040', '2025-04-05 10:30:00', 500000, 0, 1, 40, 'RES-20250401-0040', 4),
('FACT-20250408-0041', '2025-04-08 14:20:00', 300000, 0, 1, 41, 'RES-20250405-0041', 4),
('FACT-20250412-0042', '2025-04-12 11:15:00', 2800000, 0, 1, 42, 'RES-20250410-0042', 4),
('FACT-20250418-0043', '2025-04-18 15:40:00', 1800000, 0, 1, 43, 'RES-20250415-0043', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20250328-0039', '2025-03-28 16:50:00', 'VIR00567890', 1, 39, 'FACT-20250328-0039', 4),
('RECU-20250405-0040', '2025-04-05 10:35:00', 'CARTE678901', 2, 40, 'FACT-20250405-0040', 4),
('RECU-20250408-0041', '2025-04-08 14:25:00', 'ESP0034567', 3, 41, 'FACT-20250408-0041', 4),
('RECU-20250412-0042', '2025-04-12 11:20:00', 'VIR00678901', 1, 42, 'FACT-20250412-0042', 4),
('RECU-20250418-0043', '2025-04-18 15:45:00', 'CHQ0011111', 4, 43, 'FACT-20250418-0043', 4);

-- Mai 2025 (7 réservations - très haute saison)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20250420-0044', 'Festival gastronomique', '2025-05-03', '2025-05-05', '2025-04-20 10:20:00', 3, 7, 'CLI007'),
('RES-20250425-0045', 'Séance de sport entreprise', '2025-05-08', '2025-05-08', '2025-04-25 15:40:00', 5, 1, 'CLI001'),
('RES-20250428-0046', 'Mariage printemps', '2025-05-11', '2025-05-11', '2025-04-28 14:15:00', 3, 4, 'CLI004'),
('RES-20250502-0047', 'Conférence tech', '2025-05-15', '2025-05-16', '2025-05-02 09:45:00', 5, 3, 'CLI003'),
('RES-20250505-0048', 'Tournoi sportif', '2025-05-18', '2025-05-18', '2025-05-05 16:20:00', 3, 2, 'CLI002'),
('RES-20250510-0049', 'Atelier formation', '2025-05-22', '2025-05-22', '2025-05-10 11:30:00', 5, 5, 'CLI005'),
('RES-20250515-0050', 'Réunion stratégique', '2025-05-28', '2025-05-28', '2025-05-15 14:50:00', 3, 1, 'CLI001');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(44, 'RES-20250420-0044', 10, 10, 1, '2025-05-03 10:00:00', '2025-05-05 20:00:00'),
(45, 'RES-20250425-0045', 19, 19, 1, '2025-05-08 16:00:00', '2025-05-08 19:00:00'),
(46, 'RES-20250428-0046', 34, 34, 1, '2025-05-11 15:00:00', '2025-05-11 23:00:00'),
(47, 'RES-20250502-0047', 27, 25, 2, '2025-05-15 09:00:00', '2025-05-16 17:00:00'),
(48, 'RES-20250505-0048', 19, 19, 2, '2025-05-18 14:00:00', '2025-05-18 18:00:00'),
(49, 'RES-20250510-0049', 25, 23, 1, '2025-05-22 09:00:00', '2025-05-22 17:00:00'),
(50, 'RES-20250515-0050', 25, 23, 1, '2025-05-28 14:00:00', '2025-05-28 18:00:00');

INSERT INTO accessoires_reservation (id_reservation, reference_reservation, id_accessoire, id_tarif_accessoire, quantite, debut_utilisation, fin_utilisation)
VALUES
(44, 'RES-20250420-0044', 2, 2, 20, '2025-05-03 10:00:00', '2025-05-05 20:00:00'),
(44, 'RES-20250420-0044', 1, 1, 100, '2025-05-03 10:00:00', '2025-05-05 20:00:00'),
(46, 'RES-20250428-0046', 8, 8, 30, '2025-05-11 15:00:00', '2025-05-11 23:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20250425-0044', '2025-04-25 14:15:00', 4500000, 0, 1, 44, 'RES-20250420-0044', 4),
('FACT-20250503-0045', '2025-05-03 11:30:00', 200000, 0, 1, 45, 'RES-20250425-0045', 4),
('FACT-20250505-0046', '2025-05-05 16:45:00', 2000000, 0, 1, 46, 'RES-20250428-0046', 4),
('FACT-20250508-0047', '2025-05-08 10:20:00', 2800000, 0, 1, 47, 'RES-20250502-0047', 4),
('FACT-20250512-0048', '2025-05-12 14:30:00', 300000, 0, 1, 48, 'RES-20250505-0048', 4),
('FACT-20250515-0049', '2025-05-15 12:45:00', 400000, 0, 1, 49, 'RES-20250510-0049', 4),
('FACT-20250520-0050', '2025-05-20 16:10:00', 300000, 0, 1, 50, 'RES-20250515-0050', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20250425-0044', '2025-04-25 14:20:00', 'VIR00789012', 1, 44, 'FACT-20250425-0044', 4),
('RECU-20250503-0045', '2025-05-03 11:35:00', 'ESP0256897', 3, 45, 'FACT-20250503-0045', 4),
('RECU-20250505-0046', '2025-05-05 16:50:00', 'CARTE741852', 2, 46, 'FACT-20250505-0046', 4),
('RECU-20250508-0047', '2025-05-08 10:25:00', 'VIR00890123', 1, 47, 'FACT-20250508-0047', 4),
('RECU-20250512-0048', '2025-05-12 14:35:00', 'CHQ0022222', 4, 48, 'FACT-20250512-0048', 4),
('RECU-20250515-0049', '2025-05-15 12:50:00', 'CARTE852963', 2, 49, 'FACT-20250515-0049', 4),
('RECU-20250520-0050', '2025-05-20 16:15:00', 'ESP0369852', 3, 50, 'FACT-20250520-0050', 4);

-- Juin 2025 (4 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20250525-0051', 'Cérémonie officielle', '2025-06-05', '2025-06-05', '2025-05-25 09:00:00', 3, 6, 'CLI006'),
('RES-20250601-0052', 'Anniversaire entreprise', '2025-06-12', '2025-06-12', '2025-06-01 16:20:00', 5, 3, 'CLI003'),
('RES-20250605-0053', 'Séminaire d\'été', '2025-06-18', '2025-06-19', '2025-06-05 11:45:00', 3, 1, 'CLI001'),
('RES-20250610-0054', 'Atelier team building', '2025-06-25', '2025-06-25', '2025-06-10 15:30:00', 5, 2, 'CLI002');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(51, 'RES-20250525-0051', 35, 35, 1, '2025-06-05 10:00:00', '2025-06-05 16:00:00'),
(52, 'RES-20250601-0052', 16, 16, 1, '2025-06-12 19:00:00', '2025-06-12 23:00:00'),
(53, 'RES-20250605-0053', 27, 25, 2, '2025-06-18 09:00:00', '2025-06-19 17:00:00'),
(54, 'RES-20250610-0054', 25, 23, 1, '2025-06-25 14:00:00', '2025-06-25 18:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20250530-0051', '2025-05-30 14:20:00', 1800000, 0, 1, 51, 'RES-20250525-0051', 4),
('FACT-20250605-0052', '2025-06-05 10:45:00', 1200000, 0, 1, 52, 'RES-20250601-0052', 4),
('FACT-20250610-0053', '2025-06-10 16:30:00', 2800000, 0, 1, 53, 'RES-20250605-0053', 4),
('FACT-20250615-0054', '2025-06-15 11:15:00', 400000, 0, 1, 54, 'RES-20250610-0054', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20250530-0051', '2025-05-30 14:25:00', 'VIR00901234', 1, 51, 'FACT-20250530-0051', 4),
('RECU-20250605-0052', '2025-06-05 10:50:00', 'CARTE963258', 2, 52, 'FACT-20250605-0052', 4),
('RECU-20250610-0053', '2025-06-10 16:35:00', 'VIR01012345', 1, 53, 'FACT-20250610-0053', 4),
('RECU-20250615-0054', '2025-06-15 11:20:00', 'ESP0478963', 3, 54, 'FACT-20250615-0054', 4);

-- Juillet 2025 (8 réservations - pic saisonnier)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20250620-0055', 'Camp sportif été', '2025-07-05', '2025-07-07', '2025-06-20 11:30:00', 3, 2, 'CLI002'),
('RES-20250625-0056', 'Séminaire de formation', '2025-07-10', '2025-07-11', '2025-06-25 15:15:00', 5, 1, 'CLI001'),
('RES-20250628-0057', 'Festival musical', '2025-07-15', '2025-07-15', '2025-06-28 10:45:00', 3, 7, 'CLI007'),
('RES-20250701-0058', 'Mariage été', '2025-07-18', '2025-07-18', '2025-07-01 14:20:00', 5, 4, 'CLI004'),
('RES-20250705-0059', 'Conférence annuelle', '2025-07-20', '2025-07-21', '2025-07-05 09:30:00', 3, 3, 'CLI003'),
('RES-20250710-0060', 'Tournoi beach volley', '2025-07-25', '2025-07-25', '2025-07-10 16:10:00', 5, 2, 'CLI002'),
('RES-20250715-0061', 'Atelier créatif', '2025-07-28', '2025-07-28', '2025-07-15 11:25:00', 3, 5, 'CLI005'),
('RES-20250718-0062', 'Réunion stratégique', '2025-07-30', '2025-07-30', '2025-07-18 15:40:00', 5, 1, 'CLI001');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(55, 'RES-20250620-0055', 19, 19, 3, '2025-07-05 08:00:00', '2025-07-07 18:00:00'),
(56, 'RES-20250625-0056', 27, 25, 2, '2025-07-10 09:00:00', '2025-07-11 17:00:00'),
(57, 'RES-20250628-0057', 11, 11, 1, '2025-07-15 18:00:00', '2025-07-15 23:00:00'),
(58, 'RES-20250701-0058', 34, 34, 1, '2025-07-18 15:00:00', '2025-07-18 22:00:00'),
(59, 'RES-20250705-0059', 27, 25, 2, '2025-07-20 09:00:00', '2025-07-21 17:00:00'),
(60, 'RES-20250710-0060', 19, 19, 2, '2025-07-25 14:00:00', '2025-07-25 18:00:00'),
(61, 'RES-20250715-0061', 25, 23, 1, '2025-07-28 10:00:00', '2025-07-28 16:00:00'),
(62, 'RES-20250718-0062', 25, 23, 1, '2025-07-30 14:00:00', '2025-07-30 17:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20250625-0055', '2025-06-25 16:45:00', 900000, 0, 1, 55, 'RES-20250620-0055', 4),
('FACT-20250701-0056', '2025-07-01 11:30:00', 2800000, 0, 1, 56, 'RES-20250625-0056', 4),
('FACT-20250705-0057', '2025-07-05 14:20:00', 2000000, 0, 1, 57, 'RES-20250628-0057', 4),
('FACT-20250710-0058', '2025-07-10 10:15:00', 1800000, 0, 1, 58, 'RES-20250701-0058', 4),
('FACT-20250712-0059', '2025-07-12 15:40:00', 3200000, 0, 1, 59, 'RES-20250705-0059', 4),
('FACT-20250718-0060', '2025-07-18 09:25:00', 300000, 0, 1, 60, 'RES-20250710-0060', 4),
('FACT-20250720-0061', '2025-07-20 13:15:00', 400000, 0, 1, 61, 'RES-20250715-0061', 4),
('FACT-20250722-0062', '2025-07-22 16:50:00', 300000, 0, 1, 62, 'RES-20250718-0062', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20250625-0055', '2025-06-25 16:50:00', 'CHQ0033333', 4, 55, 'FACT-20250625-0055', 4),
('RECU-20250701-0056', '2025-07-01 11:35:00', 'VIR01123456', 1, 56, 'FACT-20250701-0056', 4),
('RECU-20250705-0057', '2025-07-05 14:25:00', 'CARTE159753', 2, 57, 'FACT-20250705-0057', 4),
('RECU-20250710-0058', '2025-07-10 10:20:00', 'ESP0589632', 3, 58, 'FACT-20250710-0058', 4),
('RECU-20250712-0059', '2025-07-12 15:45:00', 'VIR01234567', 1, 59, 'FACT-20250712-0059', 4),
('RECU-20250718-0060', '2025-07-18 09:30:00', 'CARTE357159', 2, 60, 'FACT-20250718-0060', 4),
('RECU-20250720-0061', '2025-07-20 13:20:00', 'CHQ0044444', 4, 61, 'FACT-20250720-0061', 4),
('RECU-20250722-0062', '2025-07-22 16:55:00', 'ESP0698741', 3, 62, 'FACT-20250722-0062', 4);

SET FOREIGN_KEY_CHECKS = 0;

-- Août 2025 (6 réservations - haute saison)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20250725-0063', 'Festival d\'été', '2025-08-05', '2025-08-07', '2025-07-25 10:30:00', 3, 7, 'CLI007'),
('RES-20250728-0064', 'Séminaire management', '2025-08-12', '2025-08-13', '2025-07-28 14:45:00', 5, 1, 'CLI001'),
('RES-20250801-0065', 'Mariage été', '2025-08-15', '2025-08-15', '2025-08-01 09:20:00', 3, 4, 'CLI004'),
('RES-20250805-0066', 'Tournoi sportif', '2025-08-18', '2025-08-18', '2025-08-05 16:10:00', 5, 2, 'CLI002'),
('RES-20250810-0067', 'Conférence annuelle', '2025-08-22', '2025-08-22', '2025-08-10 11:35:00', 3, 3, 'CLI003'),
('RES-20250815-0068', 'Atelier formation', '2025-08-28', '2025-08-28', '2025-08-15 15:50:00', 5, 5, 'CLI005');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(63, 'RES-20250725-0063', 11, 11, 1, '2025-08-05 18:00:00', '2025-08-07 23:00:00'),
(64, 'RES-20250728-0064', 27, 25, 2, '2025-08-12 09:00:00', '2025-08-13 17:00:00'),
(65, 'RES-20250801-0065', 34, 34, 1, '2025-08-15 15:00:00', '2025-08-15 22:00:00'),
(66, 'RES-20250805-0066', 19, 19, 2, '2025-08-18 14:00:00', '2025-08-18 18:00:00'),
(67, 'RES-20250810-0067', 25, 23, 1, '2025-08-22 10:00:00', '2025-08-22 16:00:00'),
(68, 'RES-20250815-0068', 25, 23, 1, '2025-08-28 14:00:00', '2025-08-28 18:00:00');

INSERT INTO accessoires_reservation (id_reservation, reference_reservation, id_accessoire, id_tarif_accessoire, quantite, debut_utilisation, fin_utilisation)
VALUES
(63, 'RES-20250725-0063', 8, 8, 25, '2025-08-05 18:00:00', '2025-08-07 23:00:00'),
(65, 'RES-20250801-0065', 1, 1, 80, '2025-08-15 15:00:00', '2025-08-15 22:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20250730-0063', '2025-07-30 14:20:00', 2000000, 1500000, 2, 63, 'RES-20250725-0063', 4),
('FACT-20250803-0064', '2025-08-03 11:45:00', 1400000, 1400000, 2, 64, 'RES-20250728-0064', 4),
('FACT-20250805-0065', '2025-08-05 10:30:00', 1000000, 1000000, 2, 65, 'RES-20250801-0065', 4),
('FACT-20250808-0066', '2025-08-08 16:15:00', 150000, 150000, 2, 66, 'RES-20250805-0066', 4),
('FACT-20250812-0067', '2025-08-12 13:40:00', 200000, 200000, 2, 67, 'RES-20250810-0067', 4),
('FACT-20250818-0068', '2025-08-18 09:25:00', 200000, 200000, 2, 68, 'RES-20250815-0068', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20250730-0063', '2025-07-30 14:25:00', 'VIR01345678', 1, 63, 'FACT-20250730-0063', 4),
('RECU-20250803-0064', '2025-08-03 11:50:00', 'CARTE456789', 2, 64, 'FACT-20250803-0064', 4),
('RECU-20250805-0065', '2025-08-05 10:35:00', 'ESP0741963', 3, 65, 'FACT-20250805-0065', 4),
('RECU-20250808-0066', '2025-08-08 16:20:00', 'CHQ0054321', 4, 66, 'FACT-20250808-0066', 4),
('RECU-20250812-0067', '2025-08-12 13:45:00', 'VIR01456789', 1, 67, 'FACT-20250812-0067', 4),
('RECU-20250818-0068', '2025-08-18 09:30:00', 'CARTE789123', 2, 68, 'FACT-20250818-0068', 4);

-- Septembre 2025 (5 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20250820-0069', 'Salon professionnel', '2025-09-05', '2025-09-07', '2025-08-20 11:15:00', 3, 3, 'CLI003'),
('RES-20250825-0070', 'Réunion de rentrée', '2025-09-10', '2025-09-10', '2025-08-25 15:40:00', 5, 6, 'CLI006'),
('RES-20250901-0071', 'Formation technique', '2025-09-15', '2025-09-15', '2025-09-01 09:30:00', 3, 2, 'CLI002'),
('RES-20250905-0072', 'Événement corporate', '2025-09-18', '2025-09-18', '2025-09-05 14:20:00', 5, 1, 'CLI001'),
('RES-20250910-0073', 'Atelier créatif', '2025-09-25', '2025-09-25', '2025-09-10 16:45:00', 3, 5, 'CLI005');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(69, 'RES-20250820-0069', 2, 2, 60, '2025-09-05 08:00:00', '2025-09-07 18:00:00'),
(70, 'RES-20250825-0070', 25, 23, 1, '2025-09-10 14:00:00', '2025-09-10 17:00:00'),
(71, 'RES-20250901-0071', 25, 23, 1, '2025-09-15 09:00:00', '2025-09-15 17:00:00'),
(72, 'RES-20250905-0072', 27, 25, 1, '2025-09-18 10:00:00', '2025-09-18 16:00:00'),
(73, 'RES-20250910-0073', 25, 23, 1, '2025-09-25 14:00:00', '2025-09-25 18:00:00');

-- Octobre 2025 (4 réservations - certaines déjà passées, d'autres futures)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20250915-0074', 'Congrès médical', '2025-10-05', '2025-10-07', '2025-09-15 09:20:00', 3, 6, 'CLI006'),
('RES-20250920-0075', 'Fête d\'anniversaire', '2025-10-12', '2025-10-12', '2025-09-20 14:35:00', 5, 4, 'CLI004'),
('RES-20251001-0076', 'Séminaire marketing', '2025-10-18', '2025-10-18', '2025-10-01 11:10:00', 3, 1, 'CLI001'),
('RES-20251005-0077', 'Atelier team building', '2025-10-25', '2025-10-25', '2025-10-05 15:45:00', 5, 2, 'CLI002');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(74, 'RES-20250915-0074', 27, 25, 2, '2025-10-05 08:00:00', '2025-10-07 18:00:00'),
(75, 'RES-20250920-0075', 34, 34, 1, '2025-10-12 16:00:00', '2025-10-12 23:00:00'),
(76, 'RES-20251001-0076', 25, 23, 1, '2025-10-18 14:00:00', '2025-10-18 18:00:00'),
(77, 'RES-20251005-0077', 25, 23, 1, '2025-10-25 10:00:00', '2025-10-25 16:00:00');

-- Novembre 2025 (3 réservations - futures)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20251015-0078', 'Salon du livre', '2025-11-08', '2025-11-10', '2025-10-15 11:25:00', 3, 7, 'CLI007'),
('RES-20251020-0079', 'Réunion stratégique', '2025-11-15', '2025-11-15', '2025-10-20 16:40:00', 5, 1, 'CLI001'),
('RES-20251101-0080', 'Conférence annuelle', '2025-11-20', '2025-11-20', '2025-11-01 10:15:00', 3, 3, 'CLI003');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(78, 'RES-20251015-0078', 6, 6, 1, '2025-11-08 09:00:00', '2025-11-10 19:00:00'),
(79, 'RES-20251020-0079', 25, 23, 1, '2025-11-15 14:00:00', '2025-11-15 18:00:00'),
(80, 'RES-20251101-0080', 27, 25, 1, '2025-11-20 10:00:00', '2025-11-20 16:00:00');

-- Réactiver les contraintes de clés étrangères
SET FOREIGN_KEY_CHECKS = 1;