<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="lib/css/bootstrap.css" type="text/css" rel="stylesheet" />
        <style type="text/css">
            body {padding-top: 60px;}
        </style>
    </head>
    <body>
        <header class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a class="navbar-brand" href="index.php?c=desc">Lista Salonów / Sklepów - Lista</a>
                <ul class="navbar-nav nav">
                    <li><a href="?c=shops">Strony</a></li>
                    <li class="active"><a href="?c=salons">Sklepy/Salony</a></li>
                </ul>
            </div>
        </header>
        <div class="container">
            <?php if(isset($msg['msg'])) : ?>
            <div class="alert alert-<?php echo $msg['type'] ? $msg['type'] : 'info'?>">
                <?php echo isset($msg['msg'])? $msg['msg'] : "" ; ?>    
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <a href="?c=salons&a=edit<?php echo isset($_GET['shop_id']) ? '&shop_id='.$_GET['shop_id'] : ''; ?>" class="btn btn-primary btn-sm">Dodaj nową lokalizację</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped table-hover table-condensed">
                        <thead>
                            <tr>
                                <th width="20">ID</th>
                                <th width="50">Strona</th>
                                <th>Miasto</th>
                                <th>Lokalizacja</th>
                                <th>Adres</th>
                                <th>Telefon</th>
                                <th>Pon-Pt</th>
                                <th>Sobota</th>
                                <th>Niedziela</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $salons as $shop ) : ?>
                            <tr>
                                <td><?php echo $shop['id']; ?></td>
                                <td><?php echo isset($pages[$shop['shop_id']]) ? $pages[$shop['shop_id']] : ""; ?></td>
                                <td><a href="?c=salons&a=edit&id=<?php echo $shop['id']; ?>"><?php echo $shop['miasto']; ?></a></td>
                                <td><a href="?c=salons&a=edit&id=<?php echo $shop['id']; ?>"><?php echo $shop['lokalizacja']; ?></a></td>
                                <td><a href="?c=salons&a=edit&id=<?php echo $shop['id']; ?>"><?php echo $shop['adres']; ?></a></td>
                                <td><?php echo $shop['telefon']; ?></td>
                                <td><?php echo $shop['pon-pt']; ?></td>
                                <td><?php echo $shop['sob']; ?></td>
                                <td><?php echo $shop['niedz']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
