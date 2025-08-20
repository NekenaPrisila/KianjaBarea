-- Vue des réservations avec au moins un reçu
CREATE OR REPLACE VIEW vue_reservations_statut_paiement AS
SELECT 
    r.id AS reservation_id,
    r.reference AS reservation_reference,
    CASE
        WHEN rc.id IS NOT NULL THEN 'confirmée'
        ELSE 'en attente'
    END AS statut_paiement,
    CASE 
        WHEN rc.id IS NOT NULL THEN rc.date_edition
        ELSE NULL
    END AS date_confirmation
FROM 
    reservations r
JOIN 
    clients c ON r.id_client = c.id AND r.reference_client = c.reference
LEFT JOIN 
    facture f ON f.id_reservation = r.id AND f.reference_reservation = r.reference
LEFT JOIN 
    recus rc ON rc.id_facture = f.id AND rc.reference_facture = f.reference
LEFT JOIN 
    type_paiement tp ON f.id_type_paiement = tp.id
LEFT JOIN 
    mode_paiement mp ON rc.id_mode_paiement = mp.id;


CREATE OR REPLACE VIEW vue_repartition_mensuelle_reservations AS
SELECT 
    YEAR(date_premier_jour) AS annee,
    LPAD(MONTH(date_premier_jour), 2, '0') AS mois,
    COUNT(*) AS nombre_reservations
FROM 
    reservations
GROUP BY 
    YEAR(date_premier_jour),
    LPAD(MONTH(date_premier_jour), 2, '0')
ORDER BY 
    annee, mois;

CREATE OR REPLACE VIEW vue_etat_paiement AS
SELECT
    r.id,
    r.reference,
    r.cout_total,
    f.total_paye,
    f.reste_a_payer,
    CASE
        WHEN f.nb_recu > 0 AND f.reste_a_payer = 0 THEN 'Payé'
        WHEN f.nb_recu > 0 AND f.reste_a_payer > 0 THEN 'Acompte'
        WHEN f.nb_recu = 0 OR f.nb_recu IS NULL THEN 'Non payé'
        ELSE 'Inconnu'
    END AS etat_paiement
FROM reservations r
LEFT JOIN (
    SELECT 
        fac.id_reservation,
        fac.reference_reservation,
        SUM(COALESCE(fac.montant_paye, 0)) AS total_paye,
        SUM(COALESCE(fac.reste_a_payer, 0)) AS reste_a_payer,
        COUNT(DISTINCT rec.id) AS nb_recu
    FROM facture fac
    LEFT JOIN recus rec 
        ON rec.id_facture = fac.id AND rec.reference_facture = fac.reference
    GROUP BY fac.id_reservation, fac.reference_reservation
) f ON r.id = f.id_reservation AND r.reference = f.reference_reservation;

CREATE OR REPLACE VIEW vue_chiffre_affaire_mensuel AS
SELECT 
    YEAR(r.date_edition) AS annee,
    MONTH(r.date_edition) AS mois,
    SUM(f.montant_paye) AS chiffre_affaire
FROM recus r
JOIN facture f ON f.id = r.id_facture AND f.reference = r.reference_facture
GROUP BY YEAR(r.date_edition), MONTH(r.date_edition)
ORDER BY annee, mois;
