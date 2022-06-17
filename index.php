<?php
if (isset($_POST['SearchPokemon'])) {
    $input = $_POST['searchInput'];
    $input = strtolower($input);
    var_dump($input);
    $url = "https://pokeapi.co/api/v2/pokemon/$input";
    $pokemonFetch = file_get_contents($url);
    $pokemon = json_decode($pokemonFetch, true);

    $pokeName = $pokemon['name'];
    $frontSprite = $pokemon['sprites']['front_default'];
    $pokemonID = $pokemon['id'];

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
    var_dump($pokemon['species']['url']);

    $evoFetchChainUrl = $speciesData['evolution_chain']['url'];
    $evoFetchChain = file_get_contents($evoFetchChainUrl);
    $evoChainData = json_decode($evoFetchChain, true);

    $baseFormUrl = $evoChainData['chain']['species']['url'];
    $evoName = $evoChainData['chain']['evolves_to'][0]['species']['url'];
    $evoName2 = $evoChainData['chain']['evolves_to'][0]['evolves_to'][0]['species']['url'];

    $baseFormFetch = file_get_contents($baseFormUrl);
    $baseFormData = json_decode($baseFormFetch, true);

    $evoFetch = file_get_contents($evoName);
    $evoNameData = json_decode($evoFetch);

    $secondEvoFetch = file_get_contents($evoName2);
    $secondEvoData = json_decode($secondEvoFetch);



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
    //title
    <img src="Resources/Capture-removebg-preview.png" alt=""/>


    //Search Box
    <form method="post">
        <input id="SearchInput" type="text" name="searchInput">
        <input type="submit" value="Search Pokemon" name="SearchPokemon">
        <label for="searchInput"></label>
    </form>


    //Pokemon Card
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
                echo implode(" ",$moves);
            } ?></p>
        <img src="
                <?php
        if (isset($_POST['SearchPokemon'])) {
                echo $frontSprite;
            } ?>" alt="" id="frontSprite">

    </div>

    //Pokemon Evolutions
    <div class="pokemonEvos">
        <p>Base form: </p>
        <p>First evolution: </p>
        <p>Second Evolution: </p>
    </div>
</div>

</body>
</html>