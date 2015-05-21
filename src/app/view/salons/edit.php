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
                    <li><a href="?c=shops">Strony</a></li>
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
            <form action="?c=salons&a=save" method="POST">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <button type="submit" class="btn btn-success btn-sm">Zapisz</button>
                        <a href="?c=salons<?php echo isset($_GET['shop_id']) && (int)$_GET['shop_id']>0 ? "&shop_id=".$_GET['shop_id'] : ""; ?>" class="btn btn-primary btn-sm">Wyjdź</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5">
                        <div class="form-group">
                            <label>Miasto</label>
                            <input type="text" name="miasto" value="<?php echo isset($shop['miasto']) ? $shop['miasto'] : ""; ?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Lokalizacja</label>
                            <input type="text" name="lokalizacja" value="<?php echo isset($shop['lokalizacja']) ? $shop['lokalizacja'] : ""; ?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Adres</label>
                            <textarea name="adres" class="form-control"><?php echo isset($shop['adres']) ? $shop['adres'] : ""; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Telefon</label>
                            <input type="text" name="telefon" value="<?php echo isset($shop['telefon']) ? $shop['telefon'] : ""; ?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Pon-Pt</label>
                            <input type="text" name="pon-pt" value="<?php echo isset($shop['pon-pt']) ? $shop['pon-pt'] : ""; ?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Sobota</label>
                            <input type="text" name="sob" value="<?php echo isset($shop['sob']) ? $shop['sob'] : ""; ?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Niedziela</label>
                            <input type="text" name="niedz" value="<?php echo isset($shop['niedz']) ? $shop['niedz'] : ""; ?>" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>Wybierz stronę</label>
                            <select name="shop_id" class="form-control">
                                <option value="0">Wybierz stronę</option>
                                <?php foreach ( $shops->getData() as $i ) : ?>
                                <?php 
                                    $select = "";
                                    
                                    if((int)$shop['shop_id']) {
                                        if((int)$i['id'] == (int) $shop['shop_id'] ) {
                                            $select = "selected=\"selected\"";
                                        }
                                    } else {
                                        if((int)$i['id'] == (int) $_GET['shop_id'] ) {
                                            $select = "selected=\"selected\"";
                                        }
                                    }
                                ?>
                                <option <?php echo $select; ?> value="<?php echo $i['id'] ?>"><?php echo $i['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Wyświetl</label>
                            <?php
                                if(!count($shop)) {
                                    $shop = array('published' => 1);
                                }
                            ?>
                            <select name="published" class="form-control">
                                <option <?php echo (int)$shop['published']==1 ? "selected=\"selected\"" : ""; ?> value="1">TAK</option>
                                <option <?php echo (int)$shop['published']==0 ? "selected=\"selected\"" : ""; ?> value="0">NIE</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo isset($shop['id']) ? $shop['id'] : ""; ?>" />
            </form>
        </div>
    </body>
</html>
