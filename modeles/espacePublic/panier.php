<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/


$plxPlugin = $d["plxPlugin"];

?>


<link rel="stylesheet" type="text/css" href="<?php echo $this->plxMotor->racine . PLX_PLUGINS;?>plxMyShop/css/panier.css"/>


<a id="panier"></a>
<div align="center" class="panierbloc">
	<div align="center" id="listproducts">
		<section align="center" class="productsect">
			<header >
                <?php $plxPlugin->lang('L_PUBLIC_BASKET'); ?>&nbsp;&nbsp;&nbsp;&nbsp;<span id='totalCart'><?php $plxPlugin->lang('L_TOTAL_BASKET'); echo $plxPlugin->pos_devise('0.00'); ?></span><span id="spanshipping"></span>
			<?php if (isset($_SESSION['msgCommand']) && !empty($_SESSION['msgCommand']) && $_SESSION['msgCommand']!=""){
					echo $_SESSION['msgCommand'];
					unset($_SESSION['msgCommand']);
			 }?>
			</header>
			
			
			
			<form id="formcart" method="POST" action="#panier">
            <div id="shoppingCart" ><em><?php $plxPlugin->lang('L_PUBLIC_NOPRODUCT'); ?></em></div>
            <p ><strong id="labelFirstnameCart"><span class='startw'><?php $plxPlugin->lang('L_PUBLIC_MANDATORY_FIELD'); ?></span> <br>
            <br><?php $plxPlugin->lang('L_PUBLIC_FIRSTNAME'); ?><span class='star'>*</span> :</strong> <input  type="text" name="firstname" id="firstname" value=""><strong id="labelLastnameCart">&nbsp;&nbsp;<?php $plxPlugin->lang('L_PUBLIC_LASTNAME'); ?><span class='star'>*</span> :</strong> <input type="text" name="lastname"  id="lastname" value=""></p>
            <p ><strong id="labelMailCart"><?php $plxPlugin->lang('L_PUBLIC_EMAIL'); ?><span class='star'>*</span> :</strong> <input type="email" name="email"  id="email" value=""></p>
            <p ><strong id="labelTelCart"><?php $plxPlugin->lang('L_PUBLIC_TEL'); ?></strong> <input type="text" name="tel" id="tel" value=""></p>
            <p ><strong id="labelAddrCart"><?php $plxPlugin->lang('L_PUBLIC_ADDRESS'); ?><span class='star'>*</span> :</strong> <input type="text" name="adress" id="adress" value=""></p>
            <p ><strong id="labelPostcodeCart" ><?php $plxPlugin->lang('L_PUBLIC_ZIP'); ?><span class='star'>*</span> :</strong> <input  type="text" name="postcode" id="postcode" value="">
            <strong id="labelCityCart"><?php $plxPlugin->lang('L_PUBLIC_TOWN'); ?><span class='star'>*</span> :</strong> <input type="text" name="city" id="city" value=""></p>
            <p ><strong id="labelCountryCart"><?php $plxPlugin->lang('L_PUBLIC_COUNTRY'); ?><span class='star'>*</span> :</strong> <input type="text" name="country" id="country" value=""></p>
				<p>
					<label for="choixCadeau">
						<input type="checkbox" id="choixCadeau" name="choixCadeau"
							<?php echo (!isset($_POST["choixCadeau"])) ? "" : " checked=\"checked\"";?>
                        />
                        <?php $plxPlugin->lang('L_PUBLIC_GIFT'); ?>
					</label>
				</p>
				<p class="conteneurNomCadeau">
					<label for="nomCadeau">
                        <?php $plxPlugin->lang('L_PUBLIC_GIFTNAME'); ?>
						<input type="text" name="nomCadeau" id="nomCadeau" 
							 value="<?php echo (!isset($_POST["nomCadeau"])) ? "" : htmlspecialchars($_POST["nomCadeau"]);?>"
						/>
					</label>
				</p>
                <strong id="labelMsgCart"><?php $plxPlugin->lang('L_PUBLIC_COMMENT'); ?></strong><br><textarea name="msg" id="msgCart"  rows="3"></textarea><br>
				<textarea name="prods" id="prodsCart" rows="3"></textarea>
				<input type="hidden" name="total" id="totalcommand" value="0">
				<input type="hidden" name="shipping" id="shipping" value="0">
				<input type="hidden" name="shipping_kg" id="shipping_kg" value="0">
				<input type="hidden" name="idsuite" id="idsuite" value="0">
				<input type="hidden" name="numcart" id="numcart" value="0">
                <strong><?php $plxPlugin->lang('L_EMAIL_CUST_PAYMENT'); ?>&nbsp;:&nbsp;&nbsp;</strong><select onchange="changePaymentMethod(this.value);" name="methodpayment">
					<?php foreach ($d["tabChoixMethodespaiement"] as $codeM => $m) {?>
						<option value="<?php echo htmlspecialchars($codeM);?>">
							<?php echo htmlspecialchars($m["libelle"]);?>
						</option>
					<?php }?>
				</select><br>
                <input type="submit" id="btnCart" value="<?php $plxPlugin->lang('L_PUBLIC_VALIDATE_ORDER'); ?>"/><br>
			</form>
		</section>
	</div>
</div>
<div id="msgAddCart">&darr; <?php $plxPlugin->lang('L_PUBLIC_ADDBASKET'); ?> &darr;</div>

<script type="text/javascript">
var total=0;
var totalkg=0;
var shippingPrice=0;
var tmpship=0;
var nprod=0;
var realnprod=0;
var formCart=document.getElementById('formcart');
var shoppingCart=document.getElementById('shoppingCart');
var btnCart=document.getElementById('btnCart');
var msgCart=document.getElementById('msgCart');
var labelMsgCart=document.getElementById('labelMsgCart');
var PRODS=document.getElementById('prodsCart');
var msgAddCart=document.getElementById('msgAddCart');

var idSuite=document.getElementById('idsuite');
var numCart=document.getElementById('numcart');

var mailCart=document.getElementById('email');
var labelMailCart=document.getElementById('labelMailCart');
var firstnameCart=document.getElementById('firstname');
var labelFirstnameCart=document.getElementById('labelFirstnameCart');
var lastnameCart=document.getElementById('lastname');
var labelLastnameCart=document.getElementById('labelLastnameCart');

var adressCart=document.getElementById('adress');
var labelAddrCart=document.getElementById('labelAddrCart');
var postcodeCart=document.getElementById('postcode');
var labelPostcodeCart=document.getElementById('labelPostcodeCart');
var cityCart=document.getElementById('city');
var labelCityCart=document.getElementById('labelCityCart');
var countryCart=document.getElementById('country');
var labelCountryCart=document.getElementById('labelCountryCart');

var telCart=document.getElementById('tel');
var labelTelCart=document.getElementById('labelTelCart');

var totalCart=document.getElementById('totalCart');
var totalcommand=document.getElementById('totalcommand');
var shipping=document.getElementById('shipping');
var shipping_kg=document.getElementById('shipping_kg');
var spanshipping=document.getElementById('spanshipping');

<?php

if (isset($_SESSION['prods']) && is_array($_SESSION['prods'])) {
    $sessioncart="";
    $totalpricettc=0.00;
    $totalpoidg=0.00;
    $nprod=0;
    
    foreach ($_SESSION['prods'] as $k => $v) {
        if (isset($plxPlugin->aProds[$v])){
            $totalpricettc= ((float)$plxPlugin->aProds[$v]['pricettc']+(float)$totalpricettc);
            $totalpoidg= ((float)$plxPlugin->aProds[$v]['poidg']+(float)$totalpoidg);
            $productscart[$v]=array(
				'pricettc' => $plxPlugin->aProds[$v]['pricettc'],
				'poidg' => $plxPlugin->aProds[$v]['poidg'],
				'name' => $plxPlugin->aProds[$v]['name'],
			);
            $sessioncart.="<span id=\"p".$nprod."\"><br>-&nbsp;".preg_replace("/'/",'&apos;',$productscart[$v]['name'])."&nbsp;&nbsp;&nbsp;&nbsp;". $plxPlugin->pos_devise($productscart[$v]['pricettc']) . ((float)$productscart[$v]['poidg']>0?" ".$plxPlugin->getlang('L_FOR')." ".$productscart[$v]['poidg']."&nbsp;kg":"").'&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="return removeCart(\\\'p'.$nprod.'\\\', \\\''.$productscart[$v]['pricettc'].'\\\', '.$productscart[$v]['poidg'].', \\\''.$v.'\\\');" id="delp'.$nprod.'">'.$plxPlugin->getlang('L_DEL').'</button></span>';
            $nprod++;
        }
    }
    $totalpoidgshipping = $plxPlugin->shippingMethod($totalpoidg, 1);

	if (sizeof($_SESSION['prods']) > 0 ) echo "var error=true;\n";
	else echo "var error=false;\n";
?>
	
if (error) {
    shoppingCart.innerHTML='<?php echo $sessioncart; ?>';
    PRODS.value=shoppingCart.innerHTML;
	
    formcart.style.display='inline-block';
	
    btnCart.style.display='inline-block';
    msgCart.style.display='inline-block';
    labelMsgCart.style.display='inline-block';
    
    mailCart.style.display='inline-block';
    mailCart.value="<?php echo (isset($_POST['email'])?$_POST['email']:''); ?>";
    labelMailCart.style.display='inline-block';
    
    firstnameCart.style.display='inline-block';
    firstnameCart.value="<?php echo (isset($_POST['firstname'])?preg_replace('/\"/','\\\"',$_POST['firstname']):''); ?>";
    labelFirstnameCart.style.display='inline-block';
    
    lastnameCart.style.display='inline-block';
    lastnameCart.value="<?php echo (isset($_POST['lastname'])?preg_replace('/\"/','\\\"',$_POST['lastname']):''); ?>";
    labelLastnameCart.style.display='inline-block';
    
    adressCart.style.display='inline-block';
    adressCart.value="<?php echo (isset($_POST['adress'])?preg_replace('/\"/','\\\"',$_POST['adress']):''); ?>";
    labelAddrCart.style.display='inline-block';
    
    postcodeCart.style.display='inline-block';
    postcodeCart.value="<?php echo (isset($_POST['postcode'])?preg_replace('/\"/','\\\"',$_POST['postcode']):''); ?>";
    labelPostcodeCart.style.display='inline-block';
    
    cityCart.style.display='inline-block';
    cityCart.value="<?php echo (isset($_POST['city'])?preg_replace('/\"/','\\\"',$_POST['city']):''); ?>";
    labelCityCart.style.display='inline-block';
    
    countryCart.style.display='inline-block';
    countryCart.value="<?php echo (isset($_POST['country'])?preg_replace('/\"/','\\\"',$_POST['country']):''); ?>";
    labelCountryCart.style.display='inline-block';
    
    telCart.style.display='inline-block';
    telCart.value="<?php echo (isset($_POST['tel'])?preg_replace('/\"/','\\\"',$_POST['tel']):''); ?>";
    labelTelCart.style.display='inline-block';
    
    idSuite.value="<?php echo (isset($_SESSION['ncart'])?$_SESSION['ncart']:''); ?>";
    numCart.value="<?php echo (isset($_SESSION['ncart'])?$_SESSION['ncart']:''); ?>";
    nprod=<?php echo (isset($_SESSION['ncart'])?(int)$_SESSION['ncart']:0); ?>;
    realnprod=<?php echo (isset($_SESSION['ncart'])?(int)$_SESSION['ncart']:0); ?>;
    tmpship=<?php echo (isset($totalpoidgshipping)?$totalpoidgshipping:0.00); ?>;
    total=<?php echo (isset($totalpricettc)?$totalpricettc:0.00); ?>;
    if (total >0) displayTotal=(total+<?php echo (isset($totalpoidgshipping)?$totalpoidgshipping:0.00); ?>);
    else displayTotal=0;

    pos_devise= "<?php echo $plxPlugin->getParam("position_devise");?>";
    devise= "<?php echo $plxPlugin->getParam("devise");?>";
    if (pos_devise == "before") { price= devise+displayTotal.toFixed(2);}
    else { price= displayTotal.toFixed(2)+devise;}
    totalCart.innerHTML="<?php $plxPlugin->lang('L_TOTAL_BASKET'); ?>&nbsp;: "+price; 

    if (pos_devise == "before") { price= devise+"<?php echo (isset($totalpoidgshipping)?$totalpoidgshipping:0.00); ?>";}
    else { price= "<?php echo (isset($totalpoidgshipping)?$totalpoidgshipping:0.00); ?>"+devise;}
    spanshipping.innerHTML="<p class='spanshippingp'><?php $plxPlugin->lang('L_EMAIL_DELIVERY_COST'); ?>&nbsp;: " + price + " <?php $plxPlugin->lang('L_FOR'); ?> <?php echo $totalpoidg; ?>&nbsp;kg</p>";
    totalcommand.value=total;
}
<?php 
} else if (isset($_SESSION['prods']) && !is_array($_SESSION['prods'])) {
    unset($_SESSION['prods']);
}
?>
function changePaymentMethod(method) {
    if (method=="cheque")formCart.action="#panier";
    else if (method=="cash") formCart.action="#panier";
    else if (method=="paypal") formCart.action="#panier";
}

function shippingMethod(kg, op){
    if (op==1)totalkg=(parseFloat(totalkg.toFixed(3))+parseFloat(kg));
    if (op==0)totalkg=(parseFloat(totalkg.toFixed(3))-parseFloat(kg));
    accurecept=<?php echo (float)$plxPlugin->getParam('acurecept'); ?>;
    if (totalkg.toFixed(3)<=0.000) {
        shippingPrice=0.00;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p01'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv01'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p02'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv02'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p03'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv03'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p04'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv04'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p05'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv05'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p06'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv06'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p07'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv07'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p08'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv08'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p09'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv09'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p10'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv10'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p11'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv11'); ?>+accurecept;
    }
    return shippingPrice;
}

</script>
