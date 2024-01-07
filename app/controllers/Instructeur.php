<?php

class Instructeur extends BaseController
{
    private $instructeurModel;

    public function __construct()
    {
        $this->instructeurModel = $this->model('InstructeurModel');
    }

    public function overzichtInstructeur()
    {
        $result = $this->instructeurModel->getInstructeurs();

        //  var_dump($result);

        $data = [
            'title' => 'Instructeurs in dienst',
            'rows' => $result,
            'totalInstructeurs' => count($result),
        ];

        $this->view('Instructeur/overzichtinstructeur', $data);
    }

    public function overzichtVoertuigen($InstructeaurId, $message = '')
    {

        $instructeurInfo = $this->instructeurModel->getInstructeurById($InstructeaurId);
        $checkIfVoertuigIsAssigned = $this->instructeurModel->checkIfVoertuigIsAssigned($InstructeaurId);

        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        $datumInDienst = $instructeurInfo->DatumInDienst;
        $aantalSterren = $instructeurInfo->AantalSterren;

        /**
         * We laten de model alle gegevens ophalen uit de database
         */
        $result = $this->instructeurModel->getToegewezenVoertuigen($InstructeaurId);

        $tableRows = "";
        if ($instructeurInfo->IsActief == 0) {
            /**
             * Als er geen toegewezen voertuigen zijn komt de onderstaande tekst in de tabel
             */
            $tableRows = "<tr>
            <td colspan='6'>
                Deze instructeur is niet actief
            </td>
          </tr>";
        } else if (empty($result)) {
            $tableRows = "<tr>
            <td colspan='6'>
                Er zijn op dit moment nog geen voertuigen toegewezen aan deze instructeur
            </td>
          </tr>";
        } else {
            /**
             * Bouw de rows op in een foreach-loop en stop deze in de variabele
             * $tabelRows
             */
            foreach ($result as $voertuig) {

                /**
                 * Zet de datum in het juiste format
                 */
                $date_formatted = date_format(date_create($voertuig->Bouwjaar), 'd-m-Y');

                $tableRows .= "<tr>
                                    <td>$voertuig->Id</td>
                                    <td>$voertuig->TypeVoertuig</td>
                                    <td>$voertuig->Type</td>
                                    <td>$voertuig->Kenteken</td>
                                    <td>$date_formatted</td>
                                    <td>$voertuig->Brandstof</td>
                                    <td>$voertuig->RijbewijsCategorie</td>  
                                    <td class='d-flex justify-content-between gap-8'>
                                        <a href='" . URLROOT . "/instructeur/voertuigDelete/$voertuig->Id/$InstructeaurId' class='m-4'>
                                            <i class='bi bi-trash'></i>
                                        </a>
                                        <a href='" . URLROOT . "/instructeur/overzichtvoertuigen_wijzig/$voertuig->Id/$InstructeaurId' class='m-4'>
                                            <i class='bi bi-pencil-square'></i>
                                        </a>
                                    </td>
                                    <td>
                                    ";
                if (empty($checkIfVoertuigIsAssigned)) {
                    $tableRows .=
                        "<p>
                            ❌
                        </p>";
                } else {
                    foreach ($checkIfVoertuigIsAssigned as $checkVoertuig) {


                        if ($checkVoertuig->VoertuigId == $voertuig->Id) {
                            $instructeurIds = explode(',', $checkVoertuig->InstructeurIds);
                            foreach ($instructeurIds as $instructeur) {
                                if ($instructeur != $InstructeaurId) {
                                    $tableRows .=
                                        "<a href='" . URLROOT . "/instructeur/voertuigDelete/$checkVoertuig->VoertuigId/$instructeur'>
                                            ✅
                                        </a>";
                                }
                            }
                        }
                    }
                }
            }
        }


        $data = [
            'title'     => 'Door instructeur gebruikte voertuigen',
            'tableRows' => $tableRows,
            'naam'      => $naam,
            'datumInDienst' => $datumInDienst,
            'aantalSterren' => $aantalSterren,
            'instructeaurId' => $InstructeaurId,
            'message' => $message,
            'instucteurInfo' => $instructeurInfo,
        ];

        $this->view('Instructeur/overzichtVoertuigen', $data);
    }
    function overzichtvoertuigen_wijzig($voertuigId, $InstructeaurId)
    {
        $VoertuigInfo = $this->instructeurModel->getToegewezenVoertuig($voertuigId, $InstructeaurId);
        if (empty($VoertuigInfo)) {
            $VoertuigInfo =  $this->instructeurModel->getToegewezenVoertuigNoInstructeur($voertuigId);
        }
        $instructeurs = $this->instructeurModel->getInstructeurs();
        $typeVoertuigen = $this->instructeurModel->typeVoertuigen();
        $data = [
            'title' => 'Wijzig voertuig',
            'voertuigId' => $voertuigId,
            'instructeaurId' => $InstructeaurId,
            'voertuigInfo' => $VoertuigInfo,
            'instructeurs' => $instructeurs,
            'typeVoertuigen' => $typeVoertuigen
        ];
        $this->view('Instructeur/overzichtvoertuigen_wijzig', $data);
    }
    function overzichtvoertuigen_wijzig_save($voertuigId, $InstructeaurId)
    {
        $this->instructeurModel->updateVoertuig($voertuigId);
        $this->instructeurModel->updateInstructeur($voertuigId);
        $this->overzichtVoertuigen($InstructeaurId);
    }

    function voertuigDelete($Id, $InstructeaurId)
    {
        $instructeurInfo = $this->instructeurModel->getInstructeurById($InstructeaurId);
        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        $this->instructeurModel->deleteVoertuig($Id, $InstructeaurId);
        // show message and wait for 2 seconds
        echo "<div class='alert alert-success' role='alert'>
                Voertuig is verwijderd van $naam
              </div>";

        header("refresh:2;url=" . URLROOT . "/instructeur/overzichtvoertuigen/$InstructeaurId");
        // $this->overzichtVoertuigen($InstructeaurId, 'Het voertuig is verwijderd');
    }

    function nietGebruiktVoertuigen($InstructeaurId)
    {
        $nietGebruiktVoeruigen = $this->instructeurModel->nietGebruiktVoertuig();
        $instructeurInfo = $this->instructeurModel->getInstructeurById($InstructeaurId);

        // var_dump($instructeurInfo);
        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        $datumInDienst = $instructeurInfo->DatumInDienst;
        $aantalSterren = $instructeurInfo->AantalSterren;
        $data = [
            'title' => 'Niet gebruikte Voertuigen',
            'result' => $nietGebruiktVoeruigen,
            'instructeaurId' => $InstructeaurId,
            'naam'      => $naam,
            'datumInDienst' => $datumInDienst,
            'aantalSterren' => $aantalSterren,
        ];

        $this->view('Instructeur/overzichtNietGebruiktVoertuigen', $data);
    }
    function addNietGebruiktVoertuigen($Id, $InstructeaurId)
    {
        $this->instructeurModel->addNietGebruiktVoertuigen($Id, $InstructeaurId);
        // $this->overzichtVoertuigen($InstructeaurId);
        header("Location: " . URLROOT . "/Instructeur/overzichtVoertuigen/$InstructeaurId");
    }

    function ziekverlof($id)
    {
        $instructeurInfo = $this->instructeurModel->getInstructeurById($id);
        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        $this->instructeurModel->ziekverlof($id);
        $this->instructeurModel->removeAllVoertuigen($id);
        // wait for 2 seconds and say that the instructeur is ziek or verlof
        echo "<div class='alert alert-success' role='alert'>
                $naam is ziek/met verlof gemeld
              </div>";

        header("refresh:2;url=" . URLROOT . "/instructeur/overzichtinstructeur");
    }
    function terugZiekverlof($id)
    {
        $instructeurInfo = $this->instructeurModel->getInstructeurById($id);
        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        $this->instructeurModel->ziekverlof($id);
        $this->instructeurModel->returnAllVoertuigen($id);
        // wait for 2 seconds and say that the instructeur is ziek or verlof
        echo "<div class='alert alert-success' role='alert'>
                $naam is terug
              </div>";
        header("refresh:2;url=" . URLROOT . "/instructeur/overzichtinstructeur");
    }

    function instructeurDelete($id)
    {
        // check if instructeur is active
        $instructeurInfo = $this->instructeurModel->getInstructeurById($id);
        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        if ($instructeurInfo->IsActief != 1) {


            echo "<div class='alert alert-danger' role='alert'>
                Instructeur $naam kan niet definitief worden verwijderd, verander eerst de status ziekte/verlof
              </div>";
            header("refresh:3;url=" . URLROOT . "/instructeur/overzichtinstructeur");
        }

        $this->instructeurModel->removeAllVoertuigen($id);
       

        header("refresh:3;url=" . URLROOT . "/instructeur/overzichtinstructeur");
    }
}
