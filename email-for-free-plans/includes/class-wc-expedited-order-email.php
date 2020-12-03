<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * A custom Expedited Order WooCommerce Email class
 *
 * @since 0.1
 * @extends \WC_Email
 */
class WC_Expedited_Order_Email extends WC_Email {

	/**
	 * Constructor
	 */
	function __construct() {

		$this->id 				= 'customer_food_plan';
		$this->title 			= __( 'Send food plan', 'woocommerce' );
		$this->description		= __( 'This is an order notification sent to the customer after payment containing the food plan.', 'woocommerce' );
		//$this->plan_content		= __( '<a href="http://wowtea.eu/wp-content/uploads/2020/emails/food-plan/food_plan_DE.pdf">➡ Sie können Ihre Diät HIER herunterladen</a>
		//<a href="http://wowtea.eu/wp-content/uploads/2020/emails/food-plan/shopping_list_DE.pdf">➡ Liste der erforderlichen Produkte</a>', 'woocommerce' );
//$this->additional_content = __( '<a href="http://wowtea.eu/wp-content/uploads/2020/emails/food-plan/food_plan_DE.pdf">➡ Sie können Ihre Diät HIER herunterladen</a>
		//<a href="http://wowtea.eu/wp-content/uploads/2020/emails/food-plan/shopping_list_DE.pdf">➡ Liste der erforderlichen Produkte</a>', 'woocommerce' );
		$this->heading 			= __( 'Your free food plan is here!', 'woocommerce' );
		$this->subject      	= __( 'Your free food plan for order {order_number} from {order_date}', 'woocommerce' );

		$this->template_html 	= 'emails/customer-food-plan.php';
		$this->template_plain 	= 'emails/plain/customer-food-plan.php';

		// Triggers for this email
		add_action( 'woocommerce_order_status_pending_to_processing_notification', array( $this, 'trigger' ) );
		add_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $this, 'trigger' ) );

		// Call parent constructor
		parent::__construct();
	}

	/**
	 * trigger function.
	 *
	 * @access public
	 * @return void
	 */
	function trigger( $order_id ) {
		global $woocommerce;

		if ( $order_id ) {
			$this->object 		= new WC_Order( $order_id );
			$this->recipient	= $this->object->billing_email;

			$this->find[] = '{order_date}';
			$this->replace[] = date_i18n( woocommerce_date_format(), strtotime( $this->object->order_date ) );

			$this->find[] = '{order_number}';
			$this->replace[] = $this->object->get_order_number();
		}

		if ( ! $this->is_enabled() || ! $this->get_recipient() )
			return;

		$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
	}

	/**
	 * get_content_html function.
	 *
	 * @access public
	 * @return string
	 */
	function get_content_html() {
		ob_start();
		woocommerce_get_template( $this->template_html, array(
			'order' 		=> $this->object,
			'email_heading' => $this->get_heading()
		) );
		return ob_get_clean();
	}

	/**
	 * get_content_plain function.
	 *
	 * @access public
	 * @return string
	 */
	function get_content_plain() {
		ob_start();
		woocommerce_get_template( $this->template_plain, array(
			'order' 		=> $this->object,
			'email_heading' => $this->get_heading()
		) );
		return ob_get_clean();
	}
}
