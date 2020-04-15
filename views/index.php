<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Accueil</title>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="/public/styles/styles.css">

  <base href="/">
</head>

<body>
  <nav class="white">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo black-text">Google Search Console App</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="/logout" class="black-text"><i class="material-icons right">exit_to_app</i>Se déconnecter</a></li>
      </ul>
    </div>
  </nav>

  <form action="/getCSV" method="POST" id="form">
    <div class="container" style="padding-top: 30px">
      <h4>Liste des domaines disponibles</h4>
      <?php
      $obj = getSites($_COOKIE['access_token']);

      $sites = $obj->siteEntry;
      if (isset($sites) && count($sites)) {
      ?>
        <ul class="collection">
          <li class="collection-item">
            <label>
              <input type="checkbox" class="filled-in" id="selectAll">
              <span class="bold black-text">TOUT SELECTIONNER</span>
            </label>
            <div class="right btn waves-effect teal" id="export">
              <i class="material-icons left">cloud_download</i>
              <span>Exporter en CSV</span>
            </div>
            <a class='dropdown-trigger btn btn-flat white right' href='#' data-target='settings' style="margin-right: 10px"><i class="material-icons">settings</i></a>

            <div id="settings" class="dropdown-content">
              <div class="input-field" style="margin-bottom: .5rem">
                <label for="startDate">Jour de début des requêtes</label>
                <input id="startDate" type="text" class="datepicker" name="startDate">
              </div>
            </div>
          </li>
          <?php
          foreach ($sites as $site) {
            if ($site->permissionLevel !== 'siteUnverifiedUser') {
          ?>
              <li class="collection-item">
                <label>
                  <input type="checkbox" class="filled-in" name="<?= urlencode($site->siteUrl) ?>" />
                  <span class="black-text"><?= $site->siteUrl ?></span>
                </label>
              </li>
            <?php
            } else {
            ?>
              <li class="collection-item unverified">
                <label>
                  <input type="checkbox" class="filled-in" name="<?= urlencode($site->siteUrl) ?>" disabled="disabled" />
                  <span class="black-text"><?= $site->siteUrl ?></span>
                  <span class="right bold black-text">Non vérifiée</span>
                </label>
              </li>
          <?php
            }
          }
          ?>
        </ul>
      <?php
      } else {
      ?>
        <h6>Aucune site disponible pour le compte Google associé</h6>
      <?php
      }
      ?>
    </div>
  </form>

  <div class="modal-container"></div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="/public/javascripts/index.js"></script>
</body>

</html>