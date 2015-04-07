<?php 
    $i=0;
    $col=0;
?>
<table width="600px" cellspacing="0" cellspadding="0">
    <tbody>
        <tr>
            <?php 
            foreach($products as $item) : 
                $i++;
                $col++;
            ?>
            <td width="33%" style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; vertical-align: top; text-transform: uppercase;">
                <a href="<?php echo $item->url ?>" target="_blank" title="Product" style="color: #000; text-decoration: none;">
                    <img src="<?php echo $item->image ?>" alt="Produkt" width="100%" />
                    <span style="font-weight:bold"><?php echo $item->attributes->attribute[0]->value; ?></span><br />
                    <?php echo $item->name; ?>
                </a>
            </td>
            <?php 
                if($col>=3) : 
                    $col = 0;
            ?>
        </tr>
        <tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>