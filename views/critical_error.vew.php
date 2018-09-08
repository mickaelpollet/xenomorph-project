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
    <meta name="viewport" content="width=device-width, initial-scale=1">';

echo '<title>Critical Error</title>';

echo '
    <!-- Bootstrap -->
    <!-- <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet"> -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- GlyphIcons Pro -->
    <link href="css/glyphicons-filetypes.css" rel="stylesheet">
    <link href="css/glyphicons-halflings.css" rel="stylesheet">
    <link href="css/glyphicons-social.css" rel="stylesheet">
    <link href="css/glyphicons.css" rel="stylesheet">
    <!-- Toastr -->
    <!-- <link href="css/toastr.css" rel="stylesheet" /> -->
    <link href="css/toastr.min.css" rel="stylesheet" />
    <!-- Application -->
    <link href="css/error.css" rel="stylesheet">

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

        //echo '<div class="back-circle">'.showGlyph('hazard').'</div>';


          echo '<div class="inner cover">';


            echo '<h1 class="cover-heading"><span style="font-size:25px;padding:10px">Critical Error <span style="font-size:25px;padding:10px"></span></h1>
            <p class="lead">';
            echo $error_message;
            echo '</p>

          </div>

        </div>

      </div>

    </div>

  </body>
</html>';

  ?>
