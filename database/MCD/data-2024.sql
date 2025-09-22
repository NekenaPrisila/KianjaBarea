-- Désactiver temporairement les contraintes de clés étrangères
SET FOREIGN_KEY_CHECKS = 0;

-- Janvier 2024 (3 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240105-0001', 'Séminaire d\'entreprise - Janvier', '2024-01-15', '2024-01-16', '2024-01-05 09:30:00', 3, 1, 'CLI001'),
('RES-20240110-0002', 'Tournoi de basket', '2024-01-20', '2024-01-20', '2024-01-10 14:15:00', 3, 2, 'CLI002'),
('RES-20240118-0003', 'Réunion de planning', '2024-01-25', '2024-01-25', '2024-01-18 11:20:00', 5, 3, 'CLI003');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(1, 'RES-20240105-0001', 25, 23, 2, '2024-01-15 08:00:00', '2024-01-16 18:00:00'),
(1, 'RES-20240105-0001', 32, 27, 1, '2024-01-15 08:00:00', '2024-01-16 18:00:00'),
(2, 'RES-20240110-0002', 20, 19, 1, '2024-01-20 14:00:00', '2024-01-20 18:00:00'),
(3, 'RES-20240118-0003', 25, 23, 1, '2024-01-25 09:00:00', '2024-01-25 12:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240108-0001', '2024-01-08 11:20:00', 2500000, 0, 1, 1, 'RES-20240105-0001', 4),
('FACT-20240115-0002', '2024-01-15 16:45:00', 150000, 0, 1, 2, 'RES-20240110-0002', 4),
('FACT-20240120-0003', '2024-01-20 10:30:00', 300000, 0, 1, 3, 'RES-20240118-0003', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240108-0001', '2024-01-08 11:25:00', 'VIR00124578', 1, 1, 'FACT-20240108-0001', 4),
('RECU-20240115-0002', '2024-01-15 16:50:00', 'CARTE789456', 2, 2, 'FACT-20240115-0002', 4),
('RECU-20240120-0003', '2024-01-20 10:35:00', 'ESP0012345', 3, 3, 'FACT-20240120-0003', 4);

-- Février 2024 (4 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240128-0004', 'Conférence annuelle', '2024-02-10', '2024-02-11', '2024-01-28 10:00:00', 3, 3, 'CLI003'),
('RES-20240201-0005', 'Mariage - Cérémonie', '2024-02-14', '2024-02-14', '2024-02-01 15:30:00', 5, 4, 'CLI004'),
('RES-20240208-0006', 'Atelier formation', '2024-02-20', '2024-02-20', '2024-02-08 09:15:00', 3, 5, 'CLI005'),
('RES-20240215-0007', 'Réunion équipe', '2024-02-25', '2024-02-25', '2024-02-15 14:20:00', 5, 6, 'CLI006');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(4, 'RES-20240128-0004', 27, 25, 1, '2024-02-10 09:00:00', '2024-02-11 17:00:00'),
(4, 'RES-20240128-0004', 33, 28, 2, '2024-02-10 09:00:00', '2024-02-11 17:00:00'),
(5, 'RES-20240201-0005', 34, 34, 1, '2024-02-14 15:00:00', '2024-02-14 22:00:00'),
(6, 'RES-20240208-0006', 25, 23, 1, '2024-02-20 09:00:00', '2024-02-20 17:00:00'),
(7, 'RES-20240215-0007', 25, 23, 1, '2024-02-25 14:00:00', '2024-02-25 16:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240205-0004', '2024-02-05 14:20:00', 2000000, 1500000, 2, 4, 'RES-20240128-0004', 4),
('FACT-20240208-0005', '2024-02-08 09:15:00', 2000000, 0, 1, 5, 'RES-20240201-0005', 4),
('FACT-20240212-0006', '2024-02-12 11:30:00', 400000, 0, 1, 6, 'RES-20240208-0006', 4),
('FACT-20240218-0007', '2024-02-18 16:45:00', 250000, 0, 1, 7, 'RES-20240215-0007', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240205-0004', '2024-02-05 14:25:00', 'VIR00234567', 1, 4, 'FACT-20240205-0004', 4),
('RECU-20240208-0005', '2024-02-08 09:20:00', 'ESP0145789', 3, 5, 'FACT-20240208-0005', 4),
('RECU-20240212-0006', '2024-02-12 11:35:00', 'CARTE123456', 2, 6, 'FACT-20240212-0006', 4),
('RECU-20240218-0007', '2024-02-18 16:50:00', 'CHQ0007890', 4, 7, 'FACT-20240218-0007', 4);

-- Mars 2024 (6 réservations - haute saison)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240220-0008', 'Salon professionnel', '2024-03-05', '2024-03-07', '2024-02-20 11:45:00', 3, 5, 'CLI005'),
('RES-20240225-0009', 'Tournoi de pétanque', '2024-03-10', '2024-03-10', '2024-02-25 16:20:00', 5, 8, 'CLI008'),
('RES-20240301-0010', 'Séminaire corporate', '2024-03-12', '2024-03-13', '2024-03-01 09:30:00', 3, 1, 'CLI001'),
('RES-20240305-0011', 'Formation technique', '2024-03-15', '2024-03-15', '2024-03-05 14:15:00', 5, 2, 'CLI002'),
('RES-20240310-0012', 'Événement caritatif', '2024-03-18', '2024-03-18', '2024-03-10 10:45:00', 3, 7, 'CLI007'),
('RES-20240315-0013', 'Réunion annuelle', '2024-03-22', '2024-03-22', '2024-03-15 16:30:00', 5, 3, 'CLI003');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(8, 'RES-20240220-0008', 1, 1, 50, '2024-03-05 08:00:00', '2024-03-07 18:00:00'),
(8, 'RES-20240220-0008', 9, 9, 1, '2024-03-05 08:00:00', '2024-03-07 18:00:00'),
(9, 'RES-20240225-0009', 22, 21, 2, '2024-03-10 09:00:00', '2024-03-10 17:00:00'),
(10, 'RES-20240301-0010', 27, 25, 2, '2024-03-12 09:00:00', '2024-03-13 17:00:00'),
(11, 'RES-20240305-0011', 25, 23, 1, '2024-03-15 14:00:00', '2024-03-15 18:00:00'),
(12, 'RES-20240310-0012', 34, 34, 1, '2024-03-18 15:00:00', '2024-03-18 22:00:00'),
(13, 'RES-20240315-0013', 25, 23, 1, '2024-03-22 10:00:00', '2024-03-22 16:00:00');

INSERT INTO accessoires_reservation (id_reservation, reference_reservation, id_accessoire, id_tarif_accessoire, quantite, debut_utilisation, fin_utilisation)
VALUES
(9, 'RES-20240225-0009', 9, 9, 10, '2024-03-10 09:00:00', '2024-03-10 17:00:00'),
(12, 'RES-20240310-0012', 8, 8, 20, '2024-03-18 15:00:00', '2024-03-18 22:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240228-0008', '2024-02-28 14:30:00', 5000000, 0, 1, 8, 'RES-20240220-0008', 4),
('FACT-20240305-0009', '2024-03-05 11:45:00', 100000, 0, 1, 9, 'RES-20240225-0009', 4),
('FACT-20240308-0010', '2024-03-08 16:20:00', 1800000, 0, 1, 10, 'RES-20240301-0010', 4),
('FACT-20240312-0011', '2024-03-12 10:15:00', 400000, 0, 1, 11, 'RES-20240305-0011', 4),
('FACT-20240314-0012', '2024-03-14 14:40:00', 1200000, 0, 1, 12, 'RES-20240310-0012', 4),
('FACT-20240318-0013', '2024-03-18 09:30:00', 300000, 0, 1, 13, 'RES-20240315-0013', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240228-0008', '2024-02-28 14:35:00', 'VIR00345678', 1, 8, 'FACT-20240228-0008', 4),
('RECU-20240305-0009', '2024-03-05 11:50:00', 'CHQ0012345', 4, 9, 'FACT-20240305-0009', 4),
('RECU-20240308-0010', '2024-03-08 16:25:00', 'CARTE456789', 2, 10, 'FACT-20240308-0010', 4),
('RECU-20240312-0011', '2024-03-12 10:20:00', 'ESP0023456', 3, 11, 'FACT-20240312-0011', 4),
('RECU-20240314-0012', '2024-03-14 14:45:00', 'VIR00456789', 1, 12, 'FACT-20240314-0012', 4),
('RECU-20240318-0013', '2024-03-18 09:35:00', 'CARTE567890', 2, 13, 'FACT-20240318-0013', 4);

-- Avril 2024 (5 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240325-0014', 'Concert public', '2024-04-05', '2024-04-05', '2024-03-25 09:15:00', 3, 7, 'CLI007'),
('RES-20240401-0015', 'Réunion administrative', '2024-04-12', '2024-04-12', '2024-04-01 14:45:00', 5, 6, 'CLI006'),
('RES-20240405-0016', 'Atelier créatif', '2024-04-15', '2024-04-15', '2024-04-05 11:20:00', 3, 4, 'CLI004'),
('RES-20240410-0017', 'Séminaire marketing', '2024-04-18', '2024-04-19', '2024-04-10 15:30:00', 5, 1, 'CLI001'),
('RES-20240415-0018', 'Cérémonie officielle', '2024-04-25', '2024-04-25', '2024-04-15 10:10:00', 3, 6, 'CLI006');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(14, 'RES-20240325-0014', 11, 11, 1, '2024-04-05 18:00:00', '2024-04-05 23:00:00'),
(15, 'RES-20240401-0015', 25, 23, 1, '2024-04-12 14:00:00', '2024-04-12 17:00:00'),
(16, 'RES-20240405-0016', 25, 23, 1, '2024-04-15 09:00:00', '2024-04-15 12:00:00'),
(17, 'RES-20240410-0017', 27, 25, 2, '2024-04-18 09:00:00', '2024-04-19 17:00:00'),
(18, 'RES-20240415-0018', 35, 35, 1, '2024-04-25 10:00:00', '2024-04-25 16:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240328-0014', '2024-03-28 16:45:00', 3000000, 0, 1, 14, 'RES-20240325-0014', 4),
('FACT-20240405-0015', '2024-04-05 10:30:00', 500000, 0, 1, 15, 'RES-20240401-0015', 4),
('FACT-20240408-0016', '2024-04-08 14:20:00', 300000, 0, 1, 16, 'RES-20240405-0016', 4),
('FACT-20240412-0017', '2024-04-12 11:15:00', 2800000, 0, 1, 17, 'RES-20240410-0017', 4),
('FACT-20240418-0018', '2024-04-18 15:40:00', 1800000, 0, 1, 18, 'RES-20240415-0018', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240328-0014', '2024-03-28 16:50:00', 'VIR00567890', 1, 14, 'FACT-20240328-0014', 4),
('RECU-20240405-0015', '2024-04-05 10:35:00', 'CARTE678901', 2, 15, 'FACT-20240405-0015', 4),
('RECU-20240408-0016', '2024-04-08 14:25:00', 'ESP0034567', 3, 16, 'FACT-20240408-0016', 4),
('RECU-20240412-0017', '2024-04-12 11:20:00', 'VIR00678901', 1, 17, 'FACT-20240412-0017', 4),
('RECU-20240418-0018', '2024-04-18 15:45:00', 'CHQ0011111', 4, 18, 'FACT-20240418-0018', 4);

-- Mai 2024 (7 réservations - très haute saison)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240420-0019', 'Festival gastronomique', '2024-05-03', '2024-05-05', '2024-04-20 10:20:00', 3, 7, 'CLI007'),
('RES-20240425-0020', 'Séance de sport entreprise', '2024-05-08', '2024-05-08', '2024-04-25 15:40:00', 5, 1, 'CLI001'),
('RES-20240428-0021', 'Mariage printemps', '2024-05-11', '2024-05-11', '2024-04-28 14:15:00', 3, 4, 'CLI004'),
('RES-20240502-0022', 'Conférence tech', '2024-05-15', '2024-05-16', '2024-05-02 09:45:00', 5, 3, 'CLI003'),
('RES-20240505-0023', 'Tournoi sportif', '2024-05-18', '2024-05-18', '2024-05-05 16:20:00', 3, 2, 'CLI002'),
('RES-20240510-0024', 'Atelier formation', '2024-05-22', '2024-05-22', '2024-05-10 11:30:00', 5, 5, 'CLI005'),
('RES-20240515-0025', 'Réunion stratégique', '2024-05-28', '2024-05-28', '2024-05-15 14:50:00', 3, 1, 'CLI001');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(19, 'RES-20240420-0019', 10, 10, 1, '2024-05-03 10:00:00', '2024-05-05 20:00:00'),
(20, 'RES-20240425-0020', 19, 19, 1, '2024-05-08 16:00:00', '2024-05-08 19:00:00'),
(21, 'RES-20240428-0021', 34, 34, 1, '2024-05-11 15:00:00', '2024-05-11 23:00:00'),
(22, 'RES-20240502-0022', 27, 25, 2, '2024-05-15 09:00:00', '2024-05-16 17:00:00'),
(23, 'RES-20240505-0023', 19, 19, 2, '2024-05-18 14:00:00', '2024-05-18 18:00:00'),
(24, 'RES-20240510-0024', 25, 23, 1, '2024-05-22 09:00:00', '2024-05-22 17:00:00'),
(25, 'RES-20240515-0025', 25, 23, 1, '2024-05-28 14:00:00', '2024-05-28 18:00:00');

INSERT INTO accessoires_reservation (id_reservation, reference_reservation, id_accessoire, id_tarif_accessoire, quantite, debut_utilisation, fin_utilisation)
VALUES
(19, 'RES-20240420-0019', 2, 2, 20, '2024-05-03 10:00:00', '2024-05-05 20:00:00'),
(19, 'RES-20240420-0019', 1, 1, 100, '2024-05-03 10:00:00', '2024-05-05 20:00:00'),
(21, 'RES-20240428-0021', 8, 8, 30, '2024-05-11 15:00:00', '2024-05-11 23:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240425-0019', '2024-04-25 14:15:00', 4500000, 0, 1, 19, 'RES-20240420-0019', 4),
('FACT-20240503-0020', '2024-05-03 11:30:00', 200000, 0, 1, 20, 'RES-20240425-0020', 4),
('FACT-20240505-0021', '2024-05-05 16:45:00', 2000000, 0, 1, 21, 'RES-20240428-0021', 4),
('FACT-20240508-0022', '2024-05-08 10:20:00', 2800000, 0, 1, 22, 'RES-20240502-0022', 4),
('FACT-20240512-0023', '2024-05-12 14:30:00', 300000, 0, 1, 23, 'RES-20240505-0023', 4),
('FACT-20240515-0024', '2024-05-15 12:45:00', 400000, 0, 1, 24, 'RES-20240510-0024', 4),
('FACT-20240520-0025', '2024-05-20 16:10:00', 300000, 0, 1, 25, 'RES-20240515-0025', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240425-0019', '2024-04-25 14:20:00', 'VIR00789012', 1, 19, 'FACT-20240425-0019', 4),
('RECU-20240503-0020', '2024-05-03 11:35:00', 'ESP0256897', 3, 20, 'FACT-20240503-0020', 4),
('RECU-20240505-0021', '2024-05-05 16:50:00', 'CARTE741852', 2, 21, 'FACT-20240505-0021', 4),
('RECU-20240508-0022', '2024-05-08 10:25:00', 'VIR00890123', 1, 22, 'FACT-20240508-0022', 4),
('RECU-20240512-0023', '2024-05-12 14:35:00', 'CHQ0022222', 4, 23, 'FACT-20240512-0023', 4),
('RECU-20240515-0024', '2024-05-15 12:50:00', 'CARTE852963', 2, 24, 'FACT-20240515-0024', 4),
('RECU-20240520-0025', '2024-05-20 16:15:00', 'ESP0369852', 3, 25, 'FACT-20240520-0025', 4);

-- Juin 2024 (4 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240525-0026', 'Cérémonie officielle', '2024-06-05', '2024-06-05', '2024-05-25 09:00:00', 3, 6, 'CLI006'),
('RES-20240601-0027', 'Anniversaire entreprise', '2024-06-12', '2024-06-12', '2024-06-01 16:20:00', 5, 3, 'CLI003'),
('RES-20240605-0028', 'Séminaire d\'été', '2024-06-18', '2024-06-19', '2024-06-05 11:45:00', 3, 1, 'CLI001'),
('RES-20240610-0029', 'Atelier team building', '2024-06-25', '2024-06-25', '2024-06-10 15:30:00', 5, 2, 'CLI002');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(26, 'RES-20240525-0026', 35, 35, 1, '2024-06-05 10:00:00', '2024-06-05 16:00:00'),
(27, 'RES-20240601-0027', 16, 16, 1, '2024-06-12 19:00:00', '2024-06-12 23:00:00'),
(28, 'RES-20240605-0028', 27, 25, 2, '2024-06-18 09:00:00', '2024-06-19 17:00:00'),
(29, 'RES-20240610-0029', 25, 23, 1, '2024-06-25 14:00:00', '2024-06-25 18:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240530-0026', '2024-05-30 14:20:00', 1800000, 0, 1, 26, 'RES-20240525-0026', 4),
('FACT-20240605-0027', '2024-06-05 10:45:00', 1200000, 0, 1, 27, 'RES-20240601-0027', 4),
('FACT-20240610-0028', '2024-06-10 16:30:00', 2800000, 0, 1, 28, 'RES-20240605-0028', 4),
('FACT-20240615-0029', '2024-06-15 11:15:00', 400000, 0, 1, 29, 'RES-20240610-0029', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240530-0026', '2024-05-30 14:25:00', 'VIR00901234', 1, 26, 'FACT-20240530-0026', 4),
('RECU-20240605-0027', '2024-06-05 10:50:00', 'CARTE963258', 2, 27, 'FACT-20240605-0027', 4),
('RECU-20240610-0028', '2024-06-10 16:35:00', 'VIR01012345', 1, 28, 'FACT-20240610-0028', 4),
('RECU-20240615-0029', '2024-06-15 11:20:00', 'ESP0478963', 3, 29, 'FACT-20240615-0029', 4);

-- Juillet 2024 (8 réservations - pic saisonnier)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240620-0030', 'Camp sportif été', '2024-07-05', '2024-07-07', '2024-06-20 11:30:00', 3, 2, 'CLI002'),
('RES-20240625-0031', 'Séminaire de formation', '2024-07-10', '2024-07-11', '2024-06-25 15:15:00', 5, 1, 'CLI001'),
('RES-20240628-0032', 'Festival musical', '2024-07-15', '2024-07-15', '2024-06-28 10:45:00', 3, 7, 'CLI007'),
('RES-20240701-0033', 'Mariage été', '2024-07-18', '2024-07-18', '2024-07-01 14:20:00', 5, 4, 'CLI004'),
('RES-20240705-0034', 'Conférence annuelle', '2024-07-20', '2024-07-21', '2024-07-05 09:30:00', 3, 3, 'CLI003'),
('RES-20240710-0035', 'Tournoi beach volley', '2024-07-25', '2024-07-25', '2024-07-10 16:10:00', 5, 2, 'CLI002'),
('RES-20240715-0036', 'Atelier créatif', '2024-07-28', '2024-07-28', '2024-07-15 11:25:00', 3, 5, 'CLI005'),
('RES-20240718-0037', 'Réunion stratégique', '2024-07-30', '2024-07-30', '2024-07-18 15:40:00', 5, 1, 'CLI001');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(30, 'RES-20240620-0030', 19, 19, 3, '2024-07-05 08:00:00', '2024-07-07 18:00:00'),
(31, 'RES-20240625-0031', 27, 25, 2, '2024-07-10 09:00:00', '2024-07-11 17:00:00'),
(32, 'RES-20240628-0032', 11, 11, 1, '2024-07-15 18:00:00', '2024-07-15 23:00:00'),
(33, 'RES-20240701-0033', 34, 34, 1, '2024-07-18 15:00:00', '2024-07-18 22:00:00'),
(34, 'RES-20240705-0034', 27, 25, 2, '2024-07-20 09:00:00', '2024-07-21 17:00:00'),
(35, 'RES-20240710-0035', 19, 19, 2, '2024-07-25 14:00:00', '2024-07-25 18:00:00'),
(36, 'RES-20240715-0036', 25, 23, 1, '2024-07-28 10:00:00', '2024-07-28 16:00:00'),
(37, 'RES-20240718-0037', 25, 23, 1, '2024-07-30 14:00:00', '2024-07-30 17:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240625-0030', '2024-06-25 16:45:00', 900000, 0, 1, 30, 'RES-20240620-0030', 4),
('FACT-20240701-0031', '2024-07-01 11:30:00', 2800000, 0, 1, 31, 'RES-20240625-0031', 4),
('FACT-20240705-0032', '2024-07-05 14:20:00', 2000000, 0, 1, 32, 'RES-20240628-0032', 4),
('FACT-20240710-0033', '2024-07-10 10:15:00', 1800000, 0, 1, 33, 'RES-20240701-0033', 4),
('FACT-20240712-0034', '2024-07-12 15:40:00', 3200000, 0, 1, 34, 'RES-20240705-0034', 4),
('FACT-20240718-0035', '2024-07-18 09:25:00', 300000, 0, 1, 35, 'RES-20240710-0035', 4),
('FACT-20240720-0036', '2024-07-20 13:15:00', 400000, 0, 1, 36, 'RES-20240715-0036', 4),
('FACT-20240722-0037', '2024-07-22 16:50:00', 300000, 0, 1, 37, 'RES-20240718-0037', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240625-0030', '2024-06-25 16:50:00', 'CHQ0033333', 4, 30, 'FACT-20240625-0030', 4),
('RECU-20240701-0031', '2024-07-01 11:35:00', 'VIR01123456', 1, 31, 'FACT-20240701-0031', 4),
('RECU-20240705-0032', '2024-07-05 14:25:00', 'CARTE159753', 2, 32, 'FACT-20240705-0032', 4),
('RECU-20240710-0033', '2024-07-10 10:20:00', 'ESP0589632', 3, 33, 'FACT-20240710-0033', 4),
('RECU-20240712-0034', '2024-07-12 15:45:00', 'VIR01234567', 1, 34, 'FACT-20240712-0034', 4),
('RECU-20240718-0035', '2024-07-18 09:30:00', 'CARTE357159', 2, 35, 'FACT-20240718-0035', 4),
('RECU-20240720-0036', '2024-07-20 13:20:00', 'CHQ0044444', 4, 36, 'FACT-20240720-0036', 4),
('RECU-20240722-0037', '2024-07-22 16:55:00', 'ESP0698741', 3, 37, 'FACT-20240722-0037', 4);

-- Août 2024 (6 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240722-0038', 'Festival culturel', '2024-08-05', '2024-08-07', '2024-07-22 09:45:00', 3, 5, 'CLI005'),
('RES-20240725-0039', 'Réunion de quartier', '2024-08-10', '2024-08-10', '2024-07-25 16:10:00', 5, 4, 'CLI004'),
('RES-20240801-0040', 'Séminaire management', '2024-08-15', '2024-08-16', '2024-08-01 10:30:00', 3, 1, 'CLI001'),
('RES-20240805-0041', 'Atelier formation', '2024-08-18', '2024-08-18', '2024-08-05 14:20:00', 5, 2, 'CLI002'),
('RES-20240810-0042', 'Événement corporate', '2024-08-22', '2024-08-22', '2024-08-10 11:15:00', 3, 3, 'CLI003'),
('RES-20240815-0043', 'Cérémonie officielle', '2024-08-28', '2024-08-28', '2024-08-15 16:45:00', 5, 6, 'CLI006');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(38, 'RES-20240722-0038', 12, 12, 1, '2024-08-05 09:00:00', '2024-08-07 22:00:00'),
(39, 'RES-20240725-0039', 23, 22, 1, '2024-08-10 14:00:00', '2024-08-10 18:00:00'),
(40, 'RES-20240801-0040', 27, 25, 2, '2024-08-15 09:00:00', '2024-08-16 17:00:00'),
(41, 'RES-20240805-0041', 25, 23, 1, '2024-08-18 14:00:00', '2024-08-18 18:00:00'),
(42, 'RES-20240810-0042', 27, 25, 1, '2024-08-22 10:00:00', '2024-08-22 16:00:00'),
(43, 'RES-20240815-0043', 35, 35, 1, '2024-08-28 10:00:00', '2024-08-28 16:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240728-0038', '2024-07-28 14:30:00', 6000000, 0, 1, 38, 'RES-20240722-0038', 4),
('FACT-20240802-0039', '2024-08-02 11:45:00', 400000, 0, 1, 39, 'RES-20240725-0039', 4),
('FACT-20240808-0040', '2024-08-08 16:20:00', 3200000, 0, 1, 40, 'RES-20240801-0040', 4),
('FACT-20240812-0041', '2024-08-12 10:15:00', 400000, 0, 1, 41, 'RES-20240805-0041', 4),
('FACT-20240815-0042', '2024-08-15 14:40:00', 800000, 0, 1, 42, 'RES-20240810-0042', 4),
('FACT-20240820-0043', '2024-08-20 09:30:00', 1800000, 0, 1, 43, 'RES-20240815-0043', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240728-0038', '2024-07-28 14:35:00', 'VIR01345678', 1, 38, 'FACT-20240728-0038', 4),
('RECU-20240802-0039', '2024-08-02 11:50:00', 'CARTE456123', 2, 39, 'FACT-20240802-0039', 4),
('RECU-20240808-0040', '2024-08-08 16:25:00', 'VIR01456789', 1, 40, 'FACT-20240808-0040', 4),
('RECU-20240812-0041', '2024-08-12 10:20:00', 'ESP0759863', 3, 41, 'FACT-20240812-0041', 4),
('RECU-20240815-0042', '2024-08-15 14:45:00', 'CHQ0055555', 4, 42, 'FACT-20240815-0042', 4),
('RECU-20240820-0043', '2024-08-20 09:35:00', 'CARTE789456', 2, 43, 'FACT-20240820-0043', 4);

-- Septembre 2024 (5 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240825-0044', 'Salon automobile', '2024-09-05', '2024-09-07', '2024-08-25 10:30:00', 3, 3, 'CLI003'),
('RES-20240901-0045', 'Tournoi football', '2024-09-12', '2024-09-12', '2024-09-01 14:50:00', 5, 2, 'CLI002'),
('RES-20240905-0046', 'Conférence tech', '2024-09-15', '2024-09-16', '2024-09-05 09:15:00', 3, 1, 'CLI001'),
('RES-20240910-0047', 'Atelier formation', '2024-09-20', '2024-09-20', '2024-09-10 16:30:00', 5, 5, 'CLI005'),
('RES-20240915-0048', 'Réunion annuelle', '2024-09-25', '2024-09-25', '2024-09-15 11:45:00', 3, 6, 'CLI006');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(44, 'RES-20240825-0044', 2, 2, 80, '2024-09-05 08:00:00', '2024-09-07 18:00:00'),
(45, 'RES-20240901-0045', 19, 19, 2, '2024-09-12 09:00:00', '2024-09-12 18:00:00'),
(46, 'RES-20240905-0046', 27, 25, 2, '2024-09-15 09:00:00', '2024-09-16 17:00:00'),
(47, 'RES-20240910-0047', 25, 23, 1, '2024-09-20 14:00:00', '2024-09-20 18:00:00'),
(48, 'RES-20240915-0048', 25, 23, 1, '2024-09-25 10:00:00', '2024-09-25 16:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240830-0044', '2024-08-30 16:20:00', 5500000, 0, 1, 44, 'RES-20240825-0044', 4),
('FACT-20240905-0045', '2024-09-05 11:45:00', 250000, 0, 1, 45, 'RES-20240901-0045', 4),
('FACT-20240910-0046', '2024-09-10 14:30:00', 2800000, 0, 1, 46, 'RES-20240905-0046', 4),
('FACT-20240915-0047', '2024-09-15 10:15:00', 400000, 0, 1, 47, 'RES-20240910-0047', 4),
('FACT-20240920-0048', '2024-09-20 13:40:00', 300000, 0, 1, 48, 'RES-20240915-0048', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240830-0044', '2024-08-30 16:25:00', 'VIR01567890', 1, 44, 'FACT-20240830-0044', 4),
('RECU-20240905-0045', '2024-09-05 11:50:00', 'CARTE852369', 2, 45, 'FACT-20240905-0045', 4),
('RECU-20240910-0046', '2024-09-10 14:35:00', 'VIR01678901', 1, 46, 'FACT-20240910-0046', 4),
('RECU-20240915-0047', '2024-09-15 10:20:00', 'ESP0869741', 3, 47, 'FACT-20240915-0047', 4),
('RECU-20240920-0048', '2024-09-20-13:45:00', 'CHQ0066666', 4, 48, 'FACT-20240920-0048', 4);

-- Octobre 2024 (4 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20240920-0049', 'Congrès médical', '2024-10-05', '2024-10-07', '2024-09-20 09:15:00', 3, 6, 'CLI006'),
('RES-20240925-0050', 'Fête d\'anniversaire', '2024-10-12', '2024-10-12', '2024-09-25 14:30:00', 5, 4, 'CLI004'),
('RES-20241001-0051', 'Séminaire marketing', '2024-10-18', '2024-10-18', '2024-10-01 11:20:00', 3, 1, 'CLI001'),
('RES-20241005-0052', 'Atelier créatif', '2024-10-25', '2024-10-25', '2024-10-05 15:40:00', 5, 2, 'CLI002');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(49, 'RES-20240920-0049', 27, 25, 3, '2024-10-05 08:00:00', '2024-10-07 18:00:00'),
(50, 'RES-20240925-0050', 34, 34, 1, '2024-10-12 16:00:00', '2024-10-12 23:00:00'),
(51, 'RES-20241001-0051', 25, 23, 1, '2024-10-18 14:00:00', '2024-10-18 18:00:00'),
(52, 'RES-20241005-0052', 25, 23, 1, '2024-10-25 10:00:00', '2024-10-25 16:00:00');

INSERT INTO accessoires_reservation (id_reservation, reference_reservation, id_accessoire, id_tarif_accessoire, quantite, debut_utilisation, fin_utilisation)
VALUES
(50, 'RES-20240925-0050', 8, 8, 20, '2024-10-12 16:00:00', '2024-10-12 23:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20240928-0049', '2024-09-28 10:40:00', 4200000, 0, 1, 49, 'RES-20240920-0049', 4),
('FACT-20241005-0050', '2024-10-05 15:20:00', 950000, 0, 1, 50, 'RES-20240925-0050', 4),
('FACT-20241010-0051', '2024-10-10 12:30:00', 400000, 0, 1, 51, 'RES-20241001-0051', 4),
('FACT-20241015-0052', '2024-10-15 14:15:00', 300000, 0, 1, 52, 'RES-20241005-0052', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20240928-0049', '2024-09-28 10:45:00', 'VIR01789012', 1, 49, 'FACT-20240928-0049', 4),
('RECU-20241005-0050', '2024-10-05 15:25:00', 'CHQ0077777', 4, 50, 'FACT-20241005-0050', 4),
('RECU-20241010-0051', '2024-10-10 12:35:00', 'CARTE741852', 2, 51, 'FACT-20241010-0051', 4),
('RECU-20241015-0052', '2024-10-15 14:20:00', 'ESP0975361', 3, 52, 'FACT-20241015-0052', 4);

-- Novembre 2024 (3 réservations)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20241020-0053', 'Salon du livre', '2024-11-08', '2024-11-10', '2024-10-20 11:10:00', 3, 7, 'CLI007'),
('RES-20241025-0054', 'Réunion stratégique', '2024-11-15', '2024-11-15', '2024-10-25 16:45:00', 5, 1, 'CLI001'),
('RES-20241101-0055', 'Conférence annuelle', '2024-11-20', '2024-11-20', '2024-11-01 10:30:00', 3, 3, 'CLI003');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(53, 'RES-20241020-0053', 6, 6, 1, '2024-11-08 09:00:00', '2024-11-10 19:00:00'),
(54, 'RES-20241025-0054', 25, 23, 1, '2024-11-15 14:00:00', '2024-11-15 18:00:00'),
(55, 'RES-20241101-0055', 27, 25, 1, '2024-11-20 10:00:00', '2024-11-20 16:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20241028-0053', '2024-10-28 14:30:00', 3800000, 0, 1, 53, 'RES-20241020-0053', 4),
('FACT-20241105-0054', '2024-11-05 10:15:00', 600000, 0, 1, 54, 'RES-20241025-0054', 4),
('FACT-20241110-0055', '2024-11-10 16:40:00', 800000, 0, 1, 55, 'RES-20241101-0055', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20241028-0053', '2024-10-28 14:35:00', 'VIR01890123', 1, 53, 'FACT-20241028-0053', 4),
('RECU-20241105-0054', '2024-11-05 10:20:00', 'CARTE963258', 2, 54, 'FACT-20241105-0054', 4),
('RECU-20241110-0055', '2024-11-10 16:45:00', 'ESP1086429', 3, 55, 'FACT-20241110-0055', 4);

-- Décembre 2024 (7 réservations - fin d'année)
INSERT INTO reservations (reference, description, date_premier_jour, date_dernier_jour, date_creation, id_creer_par, id_client, reference_client)
VALUES 
('RES-20241115-0056', 'Gala de fin d\'année', '2024-12-05', '2024-12-05', '2024-11-15 09:40:00', 3, 5, 'CLI005'),
('RES-20241120-0057', 'Fête de Noël entreprise', '2024-12-10', '2024-12-10', '2024-11-20 15:20:00', 5, 3, 'CLI003'),
('RES-20241125-0058', 'Réunion de clôture', '2024-12-15', '2024-12-15', '2024-11-25 11:15:00', 3, 1, 'CLI001'),
('RES-20241201-0059', 'Célébration équipe', '2024-12-18', '2024-12-18', '2024-12-01 14:30:00', 5, 2, 'CLI002'),
('RES-20241205-0060', 'Séminaire bilan', '2024-12-20', '2024-12-20', '2024-12-05 10:45:00', 3, 6, 'CLI006'),
('RES-20241210-0061', 'Atelier planning', '2024-12-22', '2024-12-22', '2024-12-10 16:20:00', 5, 4, 'CLI004'),
('RES-20241215-0062', 'Réveillon entreprise', '2024-12-28', '2024-12-28', '2024-12-15 12:30:00', 3, 7, 'CLI007');

INSERT INTO ressources_reservation (id_reservation, reference_reservation, id_tarif_ressource, id_ressource, quantite, debut_utilisation, fin_utilisation)
VALUES
(56, 'RES-20241115-0056', 31, 31, 1, '2024-12-05 18:00:00', '2024-12-05 23:00:00'),
(57, 'RES-20241120-0057', 13, 13, 1, '2024-12-10 17:00:00', '2024-12-10 23:00:00'),
(58, 'RES-20241125-0058', 25, 23, 1, '2024-12-15 10:00:00', '2024-12-15 16:00:00'),
(59, 'RES-20241201-0059', 25, 23, 1, '2024-12-18 15:00:00', '2024-12-18 19:00:00'),
(60, 'RES-20241205-0060', 25, 23, 1, '2024-12-20 14:00:00', '2024-12-20 18:00:00'),
(61, 'RES-20241210-0061', 25, 23, 1, '2024-12-22 09:00:00', '2024-12-22 17:00:00'),
(62, 'RES-20241215-0062', 11, 11, 1, '2024-12-28 19:00:00', '2024-12-28 23:00:00');

INSERT INTO accessoires_reservation (id_reservation, reference_reservation, id_accessoire, id_tarif_accessoire, quantite, debut_utilisation, fin_utilisation)
VALUES
(56, 'RES-20241115-0056', 7, 7, 1, '2024-12-05 18:00:00', '2024-12-05-23:00:00'),
(57, 'RES-20241120-0057', 1, 1, 150, '2024-12-10 17:00:00', '2024-12-10 23:00:00'),
(62, 'RES-20241215-0062', 8, 8, 50, '2024-12-28 19:00:00', '2024-12-28 23:00:00');

INSERT INTO facture (reference, date_edition, montant_paye, reste_a_payer, id_type_paiement, id_reservation, reference_reservation, id_creer_par)
VALUES
('FACT-20241125-0056', '2024-11-25 14:20:00', 3200000, 0, 1, 56, 'RES-20241115-0056', 4),
('FACT-20241128-0057', '2024-11-28 16:45:00', 1800000, 0, 1, 57, 'RES-20241120-0057', 4),
('FACT-20241205-0058', '2024-12-05 11:30:00', 400000, 0, 1, 58, 'RES-20241125-0058', 4),
('FACT-20241210-0059', '2024-12-10 15:15:00', 300000, 0, 1, 59, 'RES-20241201-0059', 4),
('FACT-20241212-0060', '2024-12-12 10:40:00', 400000, 0, 1, 60, 'RES-20241205-0060', 4),
('FACT-20241215-0061', '2024-12-15 14:25:00', 300000, 0, 1, 61, 'RES-20241210-0061', 4),
('FACT-20241220-0062', '2024-12-20 16:50:00', 2500000, 0, 1, 62, 'RES-20241215-0062', 4);

INSERT INTO recus (reference, date_edition, reference_paiement, id_mode_paiement, id_facture, reference_facture, creer_par)
VALUES
('RECU-20241125-0056', '2024-11-25 14:25:00', 'VIR01901234', 1, 56, 'FACT-20241125-0056', 4),
('RECU-20241128-0057', '2024-11-28 16:50:00', 'CARTE852741', 2, 57, 'FACT-20241128-0057', 4),
('RECU-20241205-0058', '2024-12-05 11:35:00', 'ESP1197532', 3, 58, 'FACT-20241205-0058', 4),
('RECU-20241210-0059', '2024-12-10 15:20:00', 'CHQ0088888', 4, 59, 'FACT-20241210-0059', 4),
('RECU-20241212-0060', '2024-12-12 10:45:00', 'CARTE369258', 2, 60, 'FACT-20241212-0060', 4),
('RECU-20241215-0061', '2024-12-15 14:30:00', 'ESP1284639', 3, 61, 'FACT-20241215-0061', 4),
('RECU-20241220-0062', '2024-12-20 16:55:00', 'VIR02012345', 1, 62, 'FACT-20241220-0062', 4);

-- Réactiver les contraintes de clés étrangères
SET FOREIGN_KEY_CHECKS = 1;