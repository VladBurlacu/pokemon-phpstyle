<?php
if (isset($_POST['SearchPokemon'])) {
    $input = $_POST['searchInput'];
    $input = strtolower($input);
    //var_dump($input);
    $url = "https://pokeapi.co/api/v2/pokemon/$input";
    $pokemonFetch = file_get_contents($url);
    $pokemon = json_decode($pokemonFetch, true);

    $pokeName = $pokemon['name'];
    $frontSprite = $pokemon['sprites']['front_default'];
    $pokemonID = $pokemon['id'];
    $pokemonAbilities = $pokemon['abilities']['0']['ability']['name'];

    if (count($pokemon['moves']) > 1) {
        $move1 = $pokemon['moves']['0']['move']['name'];
        $move2 = $pokemon['moves']['1']['move']['name'];
        $move3 = $pokemon['moves']['2']['move']['name'];
        $move4 = $pokemon['moves']['3']['move']['name'];
        $moves = array("$move1", "$move2", "$move3", "$move4");
    } else if (count($pokemon['moves']) === 1) {
        $moves = $pokemon['moves']['0']['move']['name'];
    }
    $speciesUrl = $pokemon['species']['url'];
    $fetchSpecies = file_get_contents($speciesUrl);
    $speciesData = json_decode($fetchSpecies, true);
    //var_dump($pokemon['species']['url']);

    $evoFetchChainUrl = $speciesData['evolution_chain']['url'];
    $evoFetchChain = file_get_contents($evoFetchChainUrl);
    $evoChainData = json_decode($evoFetchChain, true);

    $baseFormName = $evoChainData['chain']['species']['name'];
    if (count($evoChainData['chain']['evolves_to']) > 0) {
        $evoName = $evoChainData['chain']['evolves_to'][0]['species']['name'];
        if (count($evoChainData['chain']['evolves_to'][0]['evolves_to']) > 0) {
            $evoName2 = $evoChainData['chain']['evolves_to'][0]['evolves_to'][0]['species']['name'];
        } else $evoName2 = "";
    } else $evoName = "";

    $baseFormFetch = file_get_contents("https://pokeapi.co/api/v2/pokemon/$baseFormName");
    $baseFormData = json_decode($baseFormFetch, true);
    $baseFormSprite = $baseFormData['sprites']['other']['official-artwork']['front_default'];

    $evoFetch = file_get_contents("https://pokeapi.co/api/v2/pokemon/$evoName");
    $evoNameData = json_decode($evoFetch, true);
    if ($evoName) {
        $firstEvoSprite = $evoNameData['sprites']['other']['official-artwork']['front_default'];
        if ($evoName2) {
            $secondEvoFetch = file_get_contents("https://pokeapi.co/api/v2/pokemon/$evoName2");
            $secondEvoData = json_decode($secondEvoFetch, true);
            $secondEvoSprite = $secondEvoData['sprites']['other']['official-artwork']['front_default'];
        } else $secondEvoSprite = "";
    } else $firstEvoSprite = "";

    //var_dump($baseFormData);
    //var_dump($pokeName);
    //var_dump($frontSprite);
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pokedex</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="HandheldFriendly" content="true">
</head>
<body>

<div class="pokedexContainer">

    <img src="Resources/Capture-removebg-preview.png" alt=""/>


    <form method="post">
        <input id="SearchInput" type="text" name="searchInput">
        <input type="submit" value="Search Pokemon" name="SearchPokemon">
        <label for="searchInput"></label>
    </form>


    <div class="pokemonCard" id="pokemonInfo">
        <p>Name: <?php
            if (isset($_POST['SearchPokemon'])) {
                echo $pokeName;
            } ?> </p>
        <p>ID: <?php
            if (isset($_POST['SearchPokemon'])) {
                echo $pokemonID;
            } ?> </p>
        <p>Moves: <?php
            if (isset($_POST['SearchPokemon'])) {
                echo implode(", ", $moves);
            } ?></p>
        <p>Ability: <?php
            if (isset($_POST['SearchPokemon'])) {
            echo $pokemonAbilities;
            } ?></p>
        <img src="
                <?php
        if (isset($_POST['SearchPokemon'])) {
            echo $frontSprite;
        } ?>" alt="" id="frontSprite">

    </div>


    <div class="pokemonEvos">
        <p>Base form:
            <img src="
                <?php
            if (isset($_POST['SearchPokemon'])) {
                echo $baseFormSprite;
            } ?>" alt="">
        <p>First evolution:
            <img src="
                <?php
            if (isset($_POST['SearchPokemon'])) {
                if ($firstEvoSprite) {
                    echo $firstEvoSprite;
                } else echo "Resources/pokemon-ball-icon-9.jpg";
            } ?>" alt=""></p>
        <p>Second Evolution:
            <img src="
            <?php
            if (isset($_POST['SearchPokemon'])) {
                if ($firstEvoSprite) {
                    if ($secondEvoSprite) {
                        echo $secondEvoSprite;
                    } else echo "Resources/pokemon-ball-icon-9.jpg";
                } else echo "Resources/pokemon-ball-icon-9.jpg";
            } ?>" alt=""></p>
    </div>
</div>


</body>
</html>