<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $post;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<!-- BCV - this is an updated template from woo, needs updating to match what we need -->
<!-- <form class="cart" action="<?php echo esc_url( get_permalink() ); ?>" method="post" enctype='multipart/form-data'> -->
	<table cellspacing="0" class="woocommerce-grouped-product-list group_table">
		<tbody>
			<?php
			$quantites_required      = false;
			$previous_post           = $post;
			$grouped_product_columns = apply_filters( 'woocommerce_grouped_product_columns', array(
				'label',
				'price',
				'moreinfo',
			), $product );

			foreach ( $grouped_products as $grouped_product ) {
				$post_object        = get_post( $grouped_product->get_id() );
				$quantites_required = $quantites_required || ( $grouped_product->is_purchasable() && ! $grouped_product->has_options() );
				$post               = $post_object; // WPCS: override ok.
				setup_postdata( $post );

				echo '<tr id="product-' . esc_attr( get_the_ID() ) . '" class="woocommerce-grouped-product-list-item ' . esc_attr( implode( ' ', get_post_class() ) ) . '">';

				// Output columns for each product.
				foreach ( $grouped_product_columns as $column_id ) {
					do_action( 'woocommerce_grouped_product_list_before_' . $column_id, $grouped_product );

					switch ( $column_id ) {

						case 'label':
							$value  = '<label for="product-' . esc_attr( $grouped_product->get_id() ) . '">';
							$value .= $grouped_product->is_visible() ? '<a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', get_permalink( $grouped_product->get_id() ), $grouped_product->get_id() ) ) . '">' . $grouped_product->get_name() . '</a>' : $grouped_product->get_name();
							$value .= '</label>';
							break;
						case 'price':
							$value = $grouped_product->get_price_html() . wc_get_stock_html( $grouped_product );
							break;


							case 'moreinfo':

								$value = $grouped_product->is_visible() ? '<a href ="'.esc_url( apply_filters( 'woocommerce_grouped_product_list_link', get_permalink( $grouped_product->get_id() ), $grouped_product->get_id() ) ).'" class="button">More Info</a>' : 'More Info';

								break;


								default:
									$value = '';
									break;
					}

					echo '<td class="woocommerce-grouped-product-list-item__' . esc_attr( $column_id ) . '">' . apply_filters( 'woocommerce_grouped_product_list_column_' . $column_id, $value, $grouped_product ) . '</td>'; // WPCS: XSS ok.

					do_action( 'woocommerce_grouped_product_list_after_' . $column_id, $grouped_product );
				}

				echo '</tr>';
			}
			$post = $previous_post; // WPCS: override ok.
			setup_postdata( $post );
			?>
		</tbody>
	</table>


<!-- </form> -->

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
