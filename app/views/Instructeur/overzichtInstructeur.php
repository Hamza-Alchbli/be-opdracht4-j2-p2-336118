<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
    <title>Overzicht Instructeurs</title>
</head>

<body>

    <div class="container mx-auto p-4">
        <u><?= $data['title']; ?></u><br>
        <!-- button to take me home  -->
        <a href="<?= URLROOT; ?>" class="btn btn-primary">Home</a>
        <!-- aantal instructeurs -->
        <p>Er zijn <?= $data['totalInstructeurs']; ?> instructeurs</p>
        <!-- Your content goes here -->
        <table>
            <thead>
                <th>Voornaam</th>
                <th>Tussenvoegsel</th>
                <th>Achternaam</th>
                <th>Mobiel</th>
                <th>Datum in dienst</th>
                <th>Aantal sterren</th>
                <th>Voertuigen</th>
                <th>Ziek/Verlof</th>
            </thead>
            <tbody>
                <?php foreach ($data['rows'] as $instructeur) :
                    $date = date_create($instructeur->DatumInDienst);
                    $formatted_date = date_format($date, 'd-m-Y');
                ?>
                    <tr>
                        <td><?= $instructeur->Voornaam ?></td>
                        <td><?= $instructeur->Tussenvoegsel ?></td>
                        <td><?= $instructeur->Achternaam ?></td>
                        <td><?= $instructeur->Mobiel ?></td>
                        <td><?= $formatted_date ?></td>
                        <td><?= $instructeur->AantalSterren ?></td>
                        <td>
                            <a href='<?= URLROOT ?>/instructeur/overzichtvoertuigen/<?= $instructeur->Id ?>'>
                                <i class='bi bi-car-front'></i>
                            </a>
                        </td>
                        <td>
                            <!-- check if instructeatr is actief -->
                            <?php if ($instructeur->IsActief == 1) { ?>
                                <a href='<?= URLROOT ?>/instructeur/ziekverlof/<?= $instructeur->Id ?>'>
                                    <i class="bi bi-hand-thumbs-up"></i>
                                </a>
                            <?php } else { ?>
                                <a href='<?= URLROOT ?>/instructeur/terugZiekverlof/<?= $instructeur->Id ?>'>
                                    <i class="bi bi-bandaid"></i>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach;
                ?>
            </tbody>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>