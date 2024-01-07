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
    <!-- <?php var_dump($data) ?> -->
    
    <div class="max-w-md mx-auto bg-white rounded p-6">
        <h2 class="text-xl mb-4">Update Voertuig info</h2>
        <form action="<?= URLROOT; ?>/instructeur/overzichtvoertuigen_wijzig_save/<?= $data['voertuigId'] ?>/<?= $data['instructeaurId'] ?>" method="POST">
            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-bold mb-2">Type:</label>
                <input type="text" id="type" name="type" class="w-full p-2 border border-gray-300 rounded" value="<?= $data['voertuigInfo'][0]->Type ?>">
            </div>
            <label for="typeVoertuig" class="block text-gray-700 font-bold mb-2">TypeVoertuig:</label>
            <select name="typeVoertuig" id="typeVoertuig" class="w-full p-2 border border-gray-300 rounded mb-4">
                <?php foreach ($data['typeVoertuigen'] as $typeVoertuig) : ?>
                    <option value="<?= $typeVoertuig->Id ?>" <?= $typeVoertuig->Id == $data['voertuigInfo'][0]->TypeVoertuigId ? "selected" : "" ?>><?= $typeVoertuig->TypeVoertuig ?></option>
                <?php endforeach; ?>
            </select>

            <div class="mb-4">
                <label for="brandstof" class="block text-gray-700 font-bold mb-2">Brandstof:</label>
                <select name="brandstof" id="brandstof" class="w-full p-2 border border-gray-300 rounded">
                    <option value="Benzine" <?= $data['voertuigInfo'][0]->Brandstof == 'Benzine' ? 'selected' : '' ?>>Benzine</option>
                    <option value="Diesel" <?= $data['voertuigInfo'][0]->Brandstof == 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                    <option value="Elektrisch" <?= $data['voertuigInfo'][0]->Brandstof == 'Elektrisch' ? 'selected' : '' ?>>Elektrisch</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="kenteken" class="block text-gray-700 font-bold mb-2">Kenteken:</label>
                <input type="text" id="kenteken" name="kenteken" class="w-full p-2 border border-gray-300 rounded" value="<?= $data['voertuigInfo'][0]->Kenteken ?>">
            </div>
            <!-- make a date field that can not change -->
            <div class="mb-4">
                <label for="bouwjaar" class="block text-gray-700 font-bold mb-2">Bouwjaar:</label>
                <input type="date" id="bouwjaar" name="bouwjaar" class="w-full p-2 border border-gray-300 rounded" value="<?= $data['voertuigInfo'][0]->Bouwjaar ?>" disabled>
            </div>
            <div class="mb-4">
                <label for="instructeur" class="block text-gray-700 font-bold mb-2">Instructeur:</label>
                <select required name="instructeur" id="instructeur" class="w-full p-2 border border-gray-300 rounded mb-4">
                    <?php foreach ($data['instructeurs'] as $instructeur) : ?>
                        <option value="<?= $instructeur->Id ?>" <?= $instructeur->Id == $data['instructeaurId'] ? "selected" : "" ?>><?= $instructeur->Voornaam . ' ' . $instructeur->Tussenvoegsel . ' ' . $instructeur->Achternaam ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex justify-between">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
                <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded"><a href="<?= URLROOT; ?>/instructeur/overzichtvoertuigen/<?= $data['instructeaurId'] ?>">Cancel</a></button>
            </div>

        </form>
    </div>
    <!-- form with 3 text input, save and cancel button  and tailwind css-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>