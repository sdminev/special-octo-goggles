<?php
/**
 * Customer food plan email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
<?php /* translators: %s: Order number */ ?>
<p><?php echo'👍'; printf( esc_html__( 'Please find below your free plans for your order #%s!', 'woocommerce' ), esc_html( $order->get_order_number() ) ); ?></p>

<?php
	$hasfreegym=0;
	$hasfreefood=0;
    $hasfreeyoga=0;
    $hasfreeshoppinglist=0;
    $has25recipes=0;

    $freegym_sku                   = get_option('fstr_homegym', '');
    $freefood_sku                  = get_option('fstr_food', '');
    $freeyoga_sku                  = get_option('fstr_yoga', '');
    

    $linktoyoga                    = get_option('yoga_plan', '');
    $linktohomegym                 = get_option('homegym', '');
    $linktoshoppinglist            = get_option('shopping_list', '');
    $linktofoodplan                = get_option('panam_food_plan', '');

    $fstr_product_cart_id_gym  = WC()->cart->generate_cart_id($freegym_sku);
    $fstr_product_cart_id_food = WC()->cart->generate_cart_id($freefood_sku);
    $fstr_product_cart_id_yoga = WC()->cart->generate_cart_id($freeyoga_sku);

    if (WC()->cart->find_product_in_cart($fstr_product_cart_id_gym)) {$hasfreegym=1;}
    if (WC()->cart->find_product_in_cart($fstr_product_cart_id_food)) {$hasfreefood=1;}
    if (WC()->cart->find_product_in_cart($fstr_product_cart_id_yoga)) {$hasfreeyoga=1;}
    

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
//do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
//do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
//do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */

if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}
//$foodplan = __( '<a href="http://wowtea.eu/wp-content/uploads/2020/emails/food-plan/food_plan_DE.pdf">➡ Sie können Ihre Diät HIER herunterladen</a>
//		<br /><a href="http://wowtea.eu/wp-content/uploads/2020/emails/food-plan/shopping_list_DE.pdf">➡ Liste der erforderlichen Produkte</a>', 'woocommerce' );

echo $foodplan;
$gymplantext = __(' Get your free home gym workout here', 'woocommerce');
$foodplantext = __(' Get your free food plan here', 'woocommerce');
$yogaplantext = __(' Get your free yoga plan here', 'woocommerce');
$shoppinglisttext = __(' Get your free shopping list here', 'woocommerce');

if($hasfreegym){echo '<div><a href="' . $linktohomegym .'"><img src="https://wowtea.eu/de/wp-content/uploads/sites/30/2020/09/workout.png" style="width:279px; height:209px; margin-bottom:5px;margin-right:30%; margin-left:30%;"></a><br /><a href="' . $linktohomegym .'" style="font-size:1.19em; font-weight: bold;">'; printf(  esc_html__('Get your free home gym workout here', 'woocommerce')); echo '</a></div><br />';}
if($hasfreefood){echo '<div><a href="' . $linktofoodplan .'"><img src="https://wowtea.eu/de/wp-content/uploads/sites/30/2020/09/foodplan.png" style="width:279px; height:209px; margin-bottom:5px;margin-right:30%; margin-left:30%;"></a><br /><a href="' . $linktofoodplan .'" style="margin-left: 12%;; font-size:1.19em; font-weight: bold;">'; printf( esc_html__('Get your free food plan here', 'woocommerce')); echo '</a></div><br />';
                echo '<div><a href="' . $linktoshoppinglist .'"><img src="https://wowtea.eu/wp-content/uploads/2020/10/shopping-list-1.png" style="width:279px; height:209px;argin-right:30%; margin-left:30%;"></a><br /><a href="' . $linktoshoppinglist .'" style="margin: 10%; font-size:1.19em; font-weight: bold;">'; printf( esc_html__('Get your free shopping list here', 'woocommerce')); echo '</a></div><br />';}
if($hasfreeyoga){echo '<div><a href="' . $linktoyoga .'"><img src="https://wowtea.eu/de/wp-content/uploads/sites/30/2020/09/yoga.png" style="width:279px; height:209px;argin-right:30%; margin-left:30%;"></a><br /><a href="' . $linktoyoga .'" style="margin: 10%; font-size:1.19em; font-weight: bold;">'; printf( esc_html__('Get your free yoga plan here', 'woocommerce')); echo '</a></div><br />';}


/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
