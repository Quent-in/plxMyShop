<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
if (!isset($_SESSION)) {
 session_start();
}
$messageProduitAjouter = FALSE;

if ( isset($_SESSION["plxMyShop"]["messageProduitAjouter"])
 && $_SESSION["plxMyShop"]["messageProduitAjouter"]
) {
 $messageProduitAjouter = TRUE;
 unset($_SESSION["plxMyShop"]["messageProduitAjouter"]);
}
?>
<div id="msgAddCart"><?php $this->lang('L_PUBLIC_MSG_BASKET_UP'); ?></div>
<script type="text/JavaScript">
 var msgAddCart = document.getElementById("msgAddCart");
 <?php if ($messageProduitAjouter) {?>
  msgAddCart.style.display = "block";
  setTimeout(function(){document.getElementById("msgAddCart").style.display = "none"; }, 3000);
 <?php }?>
 var shoppingCart = null;
</script>