DELIMITER $$

CREATE TRIGGER trig_maj_cout_total_ressource
AFTER INSERT ON ressources_reservation
FOR EACH ROW
BEGIN
   DECLARE prix DECIMAL(15,2);
   DECLARE montant DECIMAL(15,2);

   -- Récupérer le prix unitaire
   SELECT prix_unitaire INTO prix
   FROM tarifs_ressources
   WHERE id = NEW.id_tarif_ressource;

   SET montant = NEW.quantite * prix;

   -- Mettre à jour le cout_total de la réservation
   UPDATE reservations
   SET cout_total = IFNULL(cout_total, 0) + montant
   WHERE id = NEW.id_reservation AND reference = NEW.reference_reservation;
END$$

DELIMITER ;


DELIMITER $$

CREATE TRIGGER trig_maj_cout_total_accessoire
AFTER INSERT ON accessoires_reservation
FOR EACH ROW
BEGIN
   DECLARE prix DECIMAL(15,2);
   DECLARE montant DECIMAL(15,2);

   -- Récupérer le prix unitaire
   SELECT prix_unitaire INTO prix
   FROM tarifs_accessoires
   WHERE id = NEW.id_tarif_accessoire;

   SET montant = NEW.quantite * prix;

   -- Mettre à jour le cout_total de la réservation
   UPDATE reservations
   SET cout_total = IFNULL(cout_total, 0) + montant
   WHERE id = NEW.id_reservation AND reference = NEW.reference_reservation;
END$$

DELIMITER ;
