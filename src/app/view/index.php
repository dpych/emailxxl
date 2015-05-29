<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
                <a href="index.php?c=main" class="navbar-brand">Wirtualna półka</a>
            </div>
        </header>
        <div class="container">
            <div class="row">
                <?php if(isset($msg['msg'])) : ?>
                <div class="alert alert-<?php echo $msg['type'] ? $msg['type'] : 'info'?>">
                    <?php echo isset($msg['msg'])? $msg['msg'] : "" ; ?>    
                </div>
                <?php endif; ?>
                <form action="?c=main&a=upload" method="POST" enctype="multipart/form-data" class="form-inline col-xs-4">
                    <div class="form-group-sm">
                        <label>Plik z produktami</label>
                        <input type="file" name="csv" class="form-control" />
                        <button type="submit" class="btn btn-primary btn-sm">Generuj</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
