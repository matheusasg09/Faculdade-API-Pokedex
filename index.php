<?php
$url = "https://pokeapi.co/api/v2/pokemon/";

if (isset($_GET['pokemon'])) {
  $url .=  $_GET['pokemon'];
}

$resultadoApiString = file_get_contents($url);
$resultado = json_decode($resultadoApiString);

function getPokemonId($url) {
  return preg_replace('/[^0-9]/', '', preg_replace('/v2/', '', $url));
}

function getPokemonImage($id) {
  return "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/$id.png";
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Pokemóns</title>

  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  <section class="row">
    <div class="col bg-primary">
      <div class="text-white text-center">
        <p class="display-4">
          Listagem de Pokémons
        </p>
        <p>
          Consumo de API com PHP
        </p>
      </div>
    </div>
  </section>
  <div class="box cta">
    <form method="get">
      <input type="text" placeholder="Digite" name="pokemon">
      <button type="submit">Pesquisar</button>
    </form>
  </div>
  <section class="container">
    <?php if(is_null($resultado)) { ?>
      <h1 class="display-1">NENHUM POKEMON ENCONTRADO =(</h1>
    <?php } else if (isset($resultado->results)) { ?>
      <?php foreach ($resultado->results as $pokemon){ ?>
        <div class="card">
          <div class="card-image has-text-centered">
            <figure class="image is-128x128">
              <img src="<?= getPokemonImage(getPokemonId($pokemon->url))?>" alt="<?= $pokemon->url ?>" class="" data-target="modal-image2">
            </figure>
          </div>
          <div class="card-content has-text-centered">
            <div class="content">
              <h4> <?= $pokemon->name ?></h4>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } else { ?>
      <div class="card">
        <div class="card-image has-text-centered">
          <figure class="image is-128x128">
            <img src="<?php echo $resultado->sprites->front_default ?>" alt="<?php echo $resultado->sprites->front_default ?>" class="" data-target="modal-image2">
          </figure>
        </div>
        <div class="card-content has-text-centered">
          <div class="content">
            <h4> <?= $resultado->name ?></h4>
          </div>
        </div>
      </div>
    <?php } ?>
  </section>
</body>

</html>
