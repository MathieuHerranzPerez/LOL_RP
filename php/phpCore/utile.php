<?php


function displayMenu($pageActive)
{

}

/**
 * display the header with the right title
 * @param $title
 */
function displayHeader($title)
{
    echo '
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
              <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
              <!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
              <!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
          <head>
              <meta charset="utf-8">
              <title>Random Pick LOL</title>
              <meta name="description" content="">
              <meta name="viewport" content="width=device-width, initial-scale=1">
              <link rel="stylesheet" href="' . WEBROOT . 'css/main.css" id="css">
              <link rel="icon" type="image/png" href="" />

              <link href="' . WEBROOT . 'bootstrap/css/bootstrap.min.css" rel="stylesheet">
          </head>';
}

/**
 * display the footer
 */
function displayFooter()
{
    echo '<footer>
                  <div class="footer">
                      <span class="maj">&copy;</span> 2017-Tous droits réservés
                  </div>
              </footer>
              <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
              <script>window.jQuery || document.write(\'<script src="js/vendor/jquery-1.11.2.min.js"><\/script>\')</script>
              <script src="js/main.js"></script>';
}


function displayEntete($urlBackground)
{
    echo '<!doctype html>';
    displayHeader("Random Pick LOL");
    echo '<body style="background: url(\'' . $urlBackground . '\') no-repeat center fixed; background-size: cover;">
        <div class="container">
            <div id="contenu">';
}

function displayFin()
{
    echo '</div>
        </div>';
    displayFooter();
    echo '</body>
</html>';
}