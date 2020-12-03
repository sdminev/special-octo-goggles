//this goes in functions.php

add_filter('woocommerce_get_price_html', 'fstr_display_striked_out_price_for_variable', 200, 2);
function fstr_display_striked_out_price_for_variable($price='', $product)
{
$reg_price = '';

//update code below if to be used
//if(!$product->is_on_sale()){
//return $price;
//}
//$varproducts = array();
//if($product->is_type( 'variable' ) & $product->get_id()!=4608 & $product->get_id()!=29959 & $product->get_id()!=6788 & $product->get_id()!=42 & $product->get_id()!=2761 & $product->get_id()!=6094 & //$product->get_id()!=3680  & $product->get_id()!=55347  & $product->get_id()!=53733   & $product->get_id()!=54076 & $product->get_id()!=57300 & $product->get_id()!=53716 & $product->get_id()!=53864 & //$product->get_id()!=53339 & $product->get_id()!=53457 & $product->get_id()!=52520 & $product->get_id()!=56843 & $product->get_id()!=54856 & $product->get_id()!=56239 & $product->get_id()!=55488 & //$product->get_id()!=53532 & $product->get_id()!=57116  & $product->get_id()!=54972  & $product->get_id()!=53763  & $product->get_id()!=53980  & $product->get_id()!=53890  & $product->get_id()!=53420  //& $product->get_id()!=52576 & $product->get_id()!=52685  & $product->get_id()!=52986)
	if($product->is_type( 'variable' )){
$variations = $product->get_children();
$reg_prices = array();
$sale_prices = array();
foreach ($variations as $value) {
$single_variation=new WC_Product_Variation($value);
array_push($reg_prices, $single_variation->get_regular_price());
array_push($sale_prices, $single_variation->get_price());
}
sort($reg_prices);
sort($sale_prices);
$min_price_reg = $reg_prices[0];
$max_price_reg = $reg_prices[count($reg_prices)-1];
if($min_price_reg == $max_price_reg)
{
$reg_price = wc_price($min_price_reg);
}
else
{
$reg_price = wc_format_price_range($min_price_reg, $max_price_reg);
}
$min_price_sale = $sale_prices[0];
$max_price_sale = $sale_prices[count($sale_prices)-1];
if($min_price_sale == $max_price_sale)
{
$sale_price = wc_price($min_price_sale);
}
else
{
$sale_price = wc_format_price_range($min_price_sale, $max_price_sale);
}
$suffix = $product->get_price_suffix($price);
if($min_price_reg == $min_price_sale) {return wc_price($min_price_sale);}
else {return wc_format_sale_price($min_price_reg, $min_price_sale);}
	}
	return $price;
}

//this function is to be added in separate snippet
function fstr_get_percentage($product){
$reg_price = '';
if($product->is_type( 'variable' )){
$variations = $product->get_children();
$reg_prices = array();
$sale_prices = array();
foreach ($variations as $value) {
$single_variation=new WC_Product_Variation($value);
array_push($reg_prices, $single_variation->get_regular_price());
array_push($sale_prices, $single_variation->get_price());
}
sort($reg_prices);
sort($sale_prices);
$min_price_reg = $reg_prices[0];
$max_price_reg = $reg_prices[count($reg_prices)-1];
if($min_price_reg == $max_price_reg)
{
$reg_price = wc_price($min_price_reg);

}
else
{
$reg_price = wc_format_price_range($min_price_reg, $max_price_reg);
}
$min_price_sale = $sale_prices[0];
$max_price_sale = $sale_prices[count($sale_prices)-1];
if($min_price_sale == $max_price_sale)
{
$sale_price = wc_price($min_price_sale);
}
else
{
$sale_price = wc_format_price_range($min_price_sale, $max_price_sale);
}
$suffix = $product->get_price_suffix($price);
if($min_price_reg == $min_price_sale) {$salespercent=0;}
else {$salepercent = 100 - ($min_price_sale*100)/$min_price_reg;
}return $salepercent;
	} $regprice=$product->get_regular_price();
	$saleprice = $product->get_price();
	if($regprice==$saleprice){$salepercent=0;}else{$salepercent = 100 - ($saleprice*100)/$regprice;}
	return $salepercent;
}
