<?php
/*************************************
 * @project:  Xenomorph
 * @file:     Error page
 * @author:   Mickaël POLLET
 *************************************/

echo '
<!DOCTYPE html>

    <html xmlns="http://www.w3.org/1999/xhtml" lang="fr">

    <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';

echo '<title>Critical Error</title>';

echo '
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--[if lt IE 10]>
        <div style="position:relative; color:#fff; top:0px; width:100%; height:40px; background-color:#A0152D; margin-top:0px; padding:5px; border-bottom:solid 5px #791022; text-align: center">
            <p>Cette application a été conçue pour fonctionner <b>à partir de la version 10 d\'Internet Explorer</b>. Mettez votre navigateur à jour ou utilisez un navigateur alternatif.</p>
        </div>
    <![endif]-->';

echo '  </head>

        <body>';

echo '<div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">';
          echo '<div class="inner cover">';

            echo '<h1 class="cover-heading"><span style="font-size:25px;padding:10px">Critical Error <span style="font-size:25px;padding:10px"></span></h1>
            <p class="lead">';
            echo $error_message;
            echo '</p>

          </div>

        </div>

      </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  </body>
</html>';

  ?>
