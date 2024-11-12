<?php
include(__DIR__ . '/../configevent.php');
include(__DIR__ . '/../Model/event.php');

class TravelOfferController {
    public function listevent() {
        $sql = "SELECT * FROM events";
        $db = configevent::getConnexion();

        try {
            $list = $db->query($sql);
            return $list;
        } catch(Exception $err) {
            echo $err->getMessage();
        }
    }

    public function addevent($event) {
        $sql = "INSERT INTO events VALUES (NULL, :NAME, :DATE, :Localisation, :DESCRIPTION)";
        $db = configevent::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'NAME' => $event->getNAME(),
                'DATE' => $event->getDATE(),
                'Localisation' =>$event->getLocalisation()->format('Y-m-d'),
                'DESCRIPTION' => $event->getDESCRIPTION()->format('Y-m-d'),
                
            ]);
        } catch(Exception $err) {
            echo $err->getMessage();
        }
    }

    public function deleteevent($id) {
        $sql = "DELETE FROM events WHERE ID = :id";
        $db = configevent::getConnexion();

        $query = $db->prepare($sql);
        $query->bindValue(':id', $id);

        try {
            $query->execute();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getevent($id) {
        $sql = "SELECT * FROM events WHERE ID = $id";
        $db = configevent::getConnexion();
        $query = $db->prepare($sql);

        try {
            $query->execute();
            $offer = $query->fetch();
            return $offer;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>
