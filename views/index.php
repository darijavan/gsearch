<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Accueil</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

  <base href="/">

  <style>
    .nav-wrapper {
      padding-left: 20px;
    }
  </style>
</head>

<body>
  <nav class="white">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo black-text">Google Search Console App</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="/logout" class="black-text">Se déconnecter</a></li>
      </ul>
    </div>
  </nav>

  <div class="container" style="padding-top: 30px">
    <h4>Liste des sites disponibles</h4>
    <?php
    $obj = getSites($_COOKIE['access_token']);

    echo $obj;
    ?>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>