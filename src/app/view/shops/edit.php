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
            <form action="?c=shops&a=save" method="POST">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <button type="submit" class="btn btn-success btn-sm">Zapisz</button>
                        <a href="?c=shops" class="btn btn-primary btn-sm">Wyjdź</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5">
                        <div class="form-group">
                            <label>Nazwa Sklepu</label>
                            <input type="text" name="sklep" value="<?php echo isset($shop['name']) ? $shop['name'] : ""; ?>" class="form-control"/>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo isset($shop['id']) ? $shop['id'] : ""; ?>" />
            </form>
        </div>
    </body>
</html>
