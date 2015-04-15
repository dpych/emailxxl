<html>
    <head>
        
    </head>
    <body>
        <div>
            <div class="">
                <?php echo isset($msg['msg'])? $msg['msg'] : "" ; ?>    
            </div>
            <form action="?c=desc&a=upload" method="POST" enctype="multipart/form-data">
                <div>
                    <input type="file" name="products" />
                </div>
                <div>
                    <select disabled="disabled">
                        <option value="1">sklep.sizeer.com</option>
                    </select>
                </div>
                <div>
                    <button class="btn btn-primary">Wyślij</button>
                </div>
            </form>
        </div>
    </body>
</html>
