<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.4/tailwind.min.css">
    <link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
</head>

<body>

    <div class="container mx-auto p-4">

        <h3><u><?= $data['title']; ?></u></h3>
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
        <!-- button with cool styling and top margin-->
        <a href="<?= URLROOT; ?>/instructeur/overzichtinstructeur" class="btn btn-primary mt-4">Back </a>
        <?php if ($data['instucteurInfo']->IsActief == 1) : ?>
            <a href="<?= URLROOT; ?>/instructeur/ziekverlof/<?= $data['instructeaurId'] ?>" class="btn btn-primary mt-4">Ziekverlof </a>
            <a href="<?= URLROOT; ?>/instructeur/nietGebruiktVoertuigen/<?= $data['instructeaurId'] ?>" class="btn btn-primary mt-4">Add </a>
        <?php endif; ?>
        <table>
            <thead>
                <th>Id</th>
                <th>TypeVoertuig</th>
                <th>Type</th>
                <th>Kenteken</th>
                <th>Bouwjaar</th>
                <th>Brandstof</th>
                <th>RijbewijsCategorie</th>
                <th>Settings</th>
                <th>Toegewezen</th>
            </thead>
            <tbody>
                <?= $data['tableRows']; ?>
            </tbody>
        </table>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>