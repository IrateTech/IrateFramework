<?=self::template('base/header');?>

<?=$error;?>. Please <a
    href="<?php if (isset($cta_link)): ?><?=$cta_link;?><?php else: ?>#<?php endif;?>"><?php if (isset($cta_copy)): ?><?=$cta_copy;?><?php else: ?>contact
    support<?php endif;?></a> for more information.


<?=self::template('base/footer');?>