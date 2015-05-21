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
                <a class="navbar-brand" href="index.php?c=desc">Lista Salonów / Sklepów</a>
                <ul class="navbar-nav nav">
                    <li class="active"><a href="?c=shops">Strony</a></li>
                    <li><a href="?c=salons">Sklepy/Salony</a></li>
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
                    <a href="?c=shops&a=edit" class="btn btn-primary btn-sm">Dodaj nową stronę</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped table-hover table-condensed">
                        <thead>
                            <tr>
                                <th width="20">ID</th>
                                <th>Nazwa Sklepu</th>
                                <th width="20">Ilość Salonów/Sklepów</th>
                                <th width="50">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $shops as $shop ) : ?>
                            <?php
                                $c = $salons->getData()->querySingle('select count(*) from salons where shop_id='.$shop['id']);
                            ?>
                            <tr>
                                <td><?php echo $shop['id']; ?></td>
                                <td><a href="?c=shops&a=edit&id=<?php echo $shop['id']; ?>"><?php echo $shop['name']; ?></a></td>
                                <td><?php echo $c; ?></td>
                                <td width="150">
                                    <a href="?c=salons&a=edit&shop_id=<?php echo $shop['id']; ?>" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
                                    <a href="?c=salons&shop_id=<?php echo $shop['id']; ?>" class="btn btn-default"><i class="glyphicon glyphicon-list"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
