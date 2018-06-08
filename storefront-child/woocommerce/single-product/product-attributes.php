<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<table class="shop_attributes">
	<?php if ( $display_dimensions && $product->has_weight() ) : ?>
		<tr>
			<th><?php _e( 'Weight', 'woocommerce' ) ?></th>
			<td class="product_weight"><?php echo esc_html( wc_format_weight( $product->get_weight() ) ); ?></td>
		</tr>
	<?php endif; ?>

	<?php if ( $display_dimensions && $product->has_dimensions() ) : ?>
		<tr>
			<th><?php _e( 'Dimensions', 'woocommerce' ) ?></th>
			<td class="product_dimensions"><?php echo esc_html( wc_format_dimensions( $product->get_dimensions( false ) ) ); ?></td>
		</tr>
	<?php endif; ?>

	<?php foreach ( $attributes as $attribute ) : ?>

			<?php
				$att_name = wc_attribute_label( $attribute->get_name() );
			if($att_name == "Video Disclaimer"){
				$tempvariable = "<tr class='video_disclaimer'><th >$att_name</th>";
			}
			else{
				$tempvariable ="<tr><th>$att_name</th>";
			}
			echo $tempvariable;
			?>

			<td><?php
				$values = array();

				if ( $attribute->is_taxonomy() ) {
					$attribute_taxonomy = $attribute->get_taxonomy_object();
					$attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

					foreach ( $attribute_values as $attribute_value ) {
						$value_name = esc_html( $attribute_value->name );

						if ( $attribute_taxonomy->attribute_public ) {
							$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
						} else {
							//translating attribute codes to full values
							if($att_name=="CDA Subject Areas"){
								switch ($value_name){
									case '1': $value_name = "1 - Planning a safe and healthy learning environment";
									break;

									case '2': $value_name = "2 - Advancing children’s physical and intellectual development";
									break;

									case '3': $value_name = "3 - Supporting children’s social and emotional development";
									break;

									case '4': $value_name = "4 - Building productive relationships with families";
									break;

									case '5': $value_name = "5 - Managing an effective program operation";
									break;

									case '6': $value_name = "6 - Maintaining a commitment to professionalism";
									break;

									case '7': $value_name = "7 - Observing and recording children’s behavior";
									break;

									case '8': $value_name = "8 - Understanding principles of child development and learning";
									break;

								}
							}

							else if($att_name=="Core Content"){
								switch ($value_name){
									case 'CGD': $value_name = "CGD - Child Growth and Development";
									break;

									case 'HSN': $value_name = "HSN - Health, Safety, and Nutrition";
									break;

									case 'PD': $value_name = "PD - Professional Development";
									break;

									case 'LEC': $value_name = "LEC - Learning Environments and Curriculum";
									break;

									case 'CA': $value_name = "CA - Child Assessment";
									break;

									case 'FCP': $value_name = "FCP - Family and Community Partnerships";
									break;

									case 'PME': $value_name = "PME - Program Management and Evaluation";
									break;
								}
							}
								$values[] = $value_name;
					}
				}



				} else {
					$values = $attribute->get_options();

					foreach ( $values as &$value ) {
						$value = make_clickable( esc_html( $value ) );
					}
				}
				echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
			?></td>
		</tr>
	<?php endforeach; ?>
</table>
