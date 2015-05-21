<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="lib/css/bootstrap.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container-fluid">
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
                            <?php foreach( $salons->data as $shop ) : ?>
                            <tr>
                                <td><?php echo $shop['id']; ?></td>
                                <td><?php echo isset($pages[$shop['shop_id']]) ? $pages[$shop['shop_id']] : ""; ?></td>
                                <td><?php echo $shop['miasto']; ?></td>
                                <td><?php echo $shop['lokalizacja']; ?></td>
                                <td><?php echo $shop['adres']; ?></td>
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
