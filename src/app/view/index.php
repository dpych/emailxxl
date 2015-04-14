<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="?c=main&a=download" method="POST" enctype="multipart/form-data">
            <div>
                <label>Plik z produktami</label>
                <input type="file" name="csv" />
            </div>
            <div>
                <button type="submit">Generuj</button>
            </div>
        </form>
    </body>
</html>
