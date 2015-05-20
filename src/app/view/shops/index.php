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
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="20">ID</th>
                                <th>Nazwa Sklepu</th>
                                <th width="20">Ilość Salonów/Sklepów</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $shops as $shop ) : ?>
                            <tr>
                                <td><?php echo $shop['id']; ?></td>
                                <td><a href="?c=shops&a=edit&id=<?php echo $shop['id']; ?>"><?php echo $shop['name']; ?></a></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
