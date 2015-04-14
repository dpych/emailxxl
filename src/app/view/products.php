<?php foreach ($elements as $typ => $groups) : ?>
<table width="570px" border="0" cellpadding="0" cellspacing="0" style="width:570px; margin: 0 15px;">
    <thead>
        <tr>
            <th colspan="3" style="text-align: center">
                <?php if($typ === 0) : ?>
                <img src="<?php echo BASE_URL; ?>images/mailing_03.jpg" alt="Wszędzie" />
                <?php endif; ?>
                <?php if($typ === 1) : ?>
                <img src="<?php echo BASE_URL; ?>images/mailing_07.jpg" alt="Tylko wirtualny koszyk" />
                <?php endif; ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($groups as $key => $products ) : ?>
        <?php 
            $i=0;
            $col=0;
        ?>
        <?php if(count($products) > 0 ) : ?>
        <tr>
            <td colspan="3" style="text-align: center">
                <?php if($key=='meskie') : ?>
                <img src="<?php echo BASE_URL; ?>images/mailing_04.jpg" alt="Męskie" />
                <?php endif; ?>
                <?php if($key=='damskie') : ?>
                <img src="<?php echo BASE_URL; ?>images/mailing_05.jpg" alt="Damskie" />
                <?php endif; ?>
                <?php if($key=='dzieciece') : ?>
                <img src="<?php echo BASE_URL; ?>images/mailing_06.jpg" alt="Dziecięce" />
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <?php 
            foreach($products as $item) : 
                $i++;
                $col++;
            ?>
            <td style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; vertical-align: top; text-transform: uppercase; padding: 5px;">
                <a href="<?php echo $item->url ?>utm_content=produkt&amp;utm_campaign=M_<?php echo date('d_m_Y'); ?>_Wirtualny_Koszyk_U&amp;smclient=$$id_salesmanago$$" target="_blank" title="<?php echo $item->attributes->attribute[0]->value . $item->name ?>" style="color: #000; text-decoration: none;">
                    <img src="<?php echo $item->image ?>" alt="<?php echo $item->attributes->attribute[0]->value . $item->name ?>" width="180" />
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
            <?php if($col) : ?>
            <td colspan="<?php echo 3-$col ?>"></td>
            <?php endif; ?>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endforeach; ?>