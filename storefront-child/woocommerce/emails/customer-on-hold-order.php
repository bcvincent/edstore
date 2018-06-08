<?php
/**
 * Customer on-hold order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-on-hold-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

	<p><?php

$method_title = $order->get_payment_method_title();
if($method_title="Purchase Order"){
	_e( "Thank you for placing your order with KET. After your payment method is confirmed, your order will be processed. Forward the below invoice to accounts payable to remit payment within 30 days.
	Make payment payable to KET then mail along with this invoice to:<br><br>
	KET<br>
Business Office<br>
600 Cooper Drive<br>
Lexington KY 40502<br><br>
Your order details are shown below for your reference.", 'woocommerce' );

}

else{ //if credit card, only other option right now
	_e( "Thank you for placing your order with KET. After your payment method is confirmed, your order will be processed. At that time, you will receive a notification email.
<br>Your order details are shown below for your reference.<br>", 'woocommerce' );
}


?></p>

<?php

/**
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );


/**
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

_e("Customer Service Contact Information<br><br>

For billing and technical support for <strong>Early Childhood PD courses</strong> contact:<br>
Ph: 800-432-0951, ext. 7278<br>
Email: ecpd@ket.org<br><br>

For billing and technical support for <strong>K-12 PD courses</strong> contact:<br>
Ph: 800-432-0951, ext. 7271<br>
Email: pd@ket.org");
/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
