<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.4/tailwind.min.css">
    <link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
    <title>Overzicht Instructeurs</title>
</head>

<body class="bg-gray-100 p-6">

    <!-- make table voor  niet gebruikte voertuigen-->
    <!-- <?php var_dump($data) ?> -->
    <!-- table with 5 columns -->
    <h1 class="text-2xl font-bold mb-4">Vehicle Information</h1>
    <table>
        <tbody>
            <tr>
                <th>Naam:</th>
                <td><?= $data['naam']; ?></td>
            </tr>
            <tr>
                <th>Datum in Dienst:</th>
                <td><?= $data['datumInDienst']; ?></td>
            </tr>
            <tr>
                <th>Aantal Sterren</th>
                <td><?= $data['aantalSterren']; ?></td>
            </tr>
        </tbody>
    </table>
    <a href="<?= URLROOT; ?>/instructeur/overzichtVoertuigen/<?= $data['instructeaurId'] ?>" class="btn btn-primary mt-4">Back </a>
    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">License Plate</th>
                <th class="py-2 px-4 border-b">Type</th>
                <th class="py-2 px-4 border-b">Year</th>
                <th class="py-2 px-4 border-b">Fuel</th>
                <th class="py-2 px-4 border-b">Add</th>
                <th class="py-2 px-4 border-b">Edit</th>
            </tr>
        </thead>
        <tbody>
            <!-- check if $data['result'] contains 1 row -->
            <?php 
            // var_dump($data);
            if (count($data['result']) == 0) : ?>
                <tr>
                    <td class="py-2 px-4 border-b" colspan="6">No vehicles found</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($data['result'] as $voertuigInfo) : ?>
                <tr>
                    <td class="py-2 px-4 border-b"><?= $voertuigInfo->Kenteken ?></td>
                    <td class="py-2 px-4 border-b"><?= $voertuigInfo->Type ?></td>
                    <td class="py-2 px-4 border-b"><?= $voertuigInfo->Bouwjaar ?></td>
                    <td class="py-2 px-4 border-b"><?= $voertuigInfo->Brandstof ?></td>
                    <td class="py-2 px-4 border-b">
                        <!-- icon and a tag to add it -->
                        <a href="<?= URLROOT; ?>/instructeur/addNietGebruiktVoertuigen/<?= $voertuigInfo->Id ?>/<?= $data['instructeaurId'] ?>" class='m-4'>
                            <i class='bi bi-plus'></i>
                        </a>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <!-- icon and a tag to add it -->
                        <a href="<?= URLROOT; ?>/instructeur/overzichtvoertuigen_wijzig/<?= $voertuigInfo->Id ?>/<?= $data['instructeaurId'] ?>" class='m-4'>
                            <i class='bi bi-pencil-square'></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</body>

</html>