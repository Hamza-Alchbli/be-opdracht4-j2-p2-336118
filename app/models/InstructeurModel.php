<?php

class InstructeurModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getInstructeurs()
    {
        $sql = "SELECT Id
                      ,Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,Mobiel
                      ,DatumInDienst
                      ,AantalSterren
                      ,IsActief

                FROM  Instructeur
                ORDER BY AantalSterren DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getToegewezenVoertuigen($Id)
    {
        $sql = "SELECT      VOER.Id
                            ,VOER.Type
                            ,VOER.Kenteken
                            ,VOER.Bouwjaar
                            ,VOER.Brandstof
                            ,TypeVoertuigId
                            ,TYVO.TypeVoertuig
                            ,TYVO.RijbewijsCategorie

                FROM        Voertuig    AS  VOER
                
                INNER JOIN  TypeVoertuig AS TYVO

                ON          TYVO.Id = VOER.TypeVoertuigId
                
                INNER JOIN  VoertuigInstructeur AS VOIN
                
                ON          VOIN.VoertuigId = VOER.Id
                
                WHERE       VOIN.InstructeurId = $Id
                
                ORDER BY    TYVO.RijbewijsCategorie DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }
    function getToegewezenVoertuig($voertuigId, $InstructeurId)
    {
        $sql = "SELECT      VOER.Id
        ,VOER.Type
        ,VOER.Kenteken
        ,VOER.Bouwjaar
        ,VOER.Brandstof
        ,TypeVoertuigId
        ,TYVO.TypeVoertuig
        ,TYVO.Id
        ,TYVO.RijbewijsCategorie
        FROM        Voertuig    AS  VOER

        INNER JOIN  TypeVoertuig AS TYVO

        ON          TYVO.Id = VOER.TypeVoertuigId

        INNER JOIN  VoertuigInstructeur AS VOIN

        ON          VOIN.VoertuigId = VOER.Id

        WHERE       VOIN.InstructeurId = $InstructeurId AND VOER.Id = $voertuigId";

        $this->db->query($sql);
        return $this->db->resultSet();
    }
    function getToegewezenVoertuigNoInstructeur($voertuigId)
    {
        $sql = "SELECT      VOER.Id
        ,VOER.Type
        ,VOER.Kenteken
        ,VOER.Bouwjaar
        ,VOER.Brandstof
        ,TypeVoertuigId
        ,TYVO.TypeVoertuig
        ,TYVO.Id
        ,TYVO.RijbewijsCategorie
        FROM        Voertuig    AS  VOER

        INNER JOIN  TypeVoertuig AS TYVO

        ON          TYVO.Id = VOER.TypeVoertuigId

        WHERE       VOER.Id = $voertuigId";

        $this->db->query($sql);
        return $this->db->resultSet();
    }
    public function getInstructeurById($Id)
    {
        $sql = "SELECT Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,DatumInDienst
                      ,AantalSterren
                      ,IsActief
                FROM  Instructeur
                WHERE Id = $Id";

        $this->db->query($sql);

        return $this->db->single();
    }

    function typeVoertuigen()
    {
        $sql = "SELECT Id
                      ,TypeVoertuig
                      ,RijbewijsCategorie
                FROM  TypeVoertuig
                ORDER BY RijbewijsCategorie DESC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    function updateVoertuig($voertuigId)
    {
        try {
            $sql = "UPDATE Voertuig SET Type = :type, Brandstof = :brandstof, Kenteken = :kenteken, TypeVoertuigId = :TypeVoertuigId WHERE 
            Id = $voertuigId ";
            $this->db->query($sql);
            $this->db->bind(':type', $_POST['type']);
            $this->db->bind(':brandstof', $_POST['brandstof']);
            $this->db->bind(':kenteken', $_POST['kenteken']);
            $this->db->bind(':TypeVoertuigId', $_POST['typeVoertuig']);
            return $this->db->resultSet();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        // try {
        //     $sql = "UPDATE VoertuigInstructeur SET InstructeurId = :instructeur WHERE VoertuigId = $voertuigId";
        //     $this->db->query($sql);
        //     $this->db->bind(':instructeur', $_POST['instructeur']);
        //     return $this->db->resultSet();
        // } catch (Exception $e) {
        //     echo "Error: " . $e->getMessage();
        // }

    }

    function updateInstructeur($voertuigId)
    {
        try {
            $sql = "UPDATE VoertuigInstructeur SET InstructeurId = :instructeur WHERE VoertuigId = $voertuigId";
            $this->db->query($sql);
            $this->db->bind(':instructeur', $_POST['instructeur']);

            return $this->db->resultSet();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function deleteVoertuig($Id, $InstructeaurId)
    {
        $sqlVoeruit = "DELETE FROM Voertuig WHERE Id = $Id";
        $sqlVoerIn = "DELETE FROM VoertuigInstructeur WHERE VoertuigId = $Id AND InstructeurId = $InstructeaurId";
        $this->db->query($sqlVoeruit);
        $this->db->query($sqlVoerIn);
        return $this->db->resultSet();
    }

    function nietGebruiktVoertuig()
    {
        $sql = "SELECT * FROM Voertuig WHERE Id NOT IN (SELECT VoertuigId FROM VoertuigInstructeur where IsActief = 1);";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
    function addNietGebruiktVoertuigen($voertuigId, $InstructeaurId)
    {
        $sql = "INSERT INTO 
                VoertuigInstructeur (VoertuigId, InstructeurId, DatumToekenning, IsActief, Opmerkingen, DatumAangemaakt, DatumGewijzigd) 
                VALUES (:voertuigId, :instructeurId,SYSDATE(6), 1, Null, SYSDATE(6), SYSDATE(6))";
        $this->db->query($sql);
        $this->db->bind(':voertuigId', $voertuigId);
        $this->db->bind(':instructeurId', $InstructeaurId);
        return $this->db->resultSet();
    }
    function ziekverlof($id)
    {
        $sql = "UPDATE Instructeur SET IsActief = !IsActief WHERE Id = $id";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
    function removeAllVoertuigen($id)
    {
        $sql = "UPDATE VoertuigInstructeur SET IsActief = 0 WHERE InstructeurId = $id";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
    function returnAllVoertuigen($id)
    {
        $sql = "UPDATE VoertuigInstructeur SET IsActief = 1 WHERE InstructeurId = $id";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
    // a function to check if there is a voertuig assigned to two different instructeurs using sub query
    function checkIfVoertuigIsAssigned($id)
    {
        $sql = "SELECT
        VoertuigId,
        GROUP_CONCAT(InstructeurId) AS InstructeurIds
    FROM
        VoertuigInstructeur
    WHERE
        IsActief = 1
        AND VoertuigId IN (
            SELECT
                VoertuigId
            FROM
                VoertuigInstructeur
            WHERE
                IsActief = 1
                AND InstructeurId = $id
        )
    GROUP BY
        VoertuigId
    HAVING
        COUNT(DISTINCT InstructeurId) > 1;
    ";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    function deleteInstructeur($id)
    {
        $sql = "DELETE FROM Instructeur WHERE Id = $id";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
}
