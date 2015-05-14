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
                <a class="navbar-brand" href="index.php?c=desc">Import opisów</a>
            </div>
        </header>
        <div class="container">
            <?php if(isset($msg['msg'])) : ?>
            <div class="alert alert-<?php echo $msg['type'] ? $msg['type'] : 'info'?>">
                <?php echo isset($msg['msg'])? $msg['msg'] : "" ; ?>    
            </div>
            <?php endif; ?>
            <div class="row">
                <form action="?c=desc&a=upload" method="POST" enctype="multipart/form-data" class="col-xs-5">
                    <div class="form-group">
                        <input type="file" name="products" class="form-control" accept=".xlsx" />
                    </div>
                    <div class="form-group">
                        <select disabled="disabled" class="form-control">
                            <option value="1">sklep.sizeer.com</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Wyślij</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
