<?php
function my_theme_enqueue_styles() {

    $parent_style = 'storefront-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
function woocommerce_order_again_button(){}
  //remove this button


//remove WC passwordpolicy

function wc_ninja_remove_password_strength() {
	if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
		wp_dequeue_script( 'wc-password-strength-meter' );
	}
}
add_action( 'wp_print_scripts', 'wc_ninja_remove_password_strength', 100 );

//modify checkout fields, specifically "company name"
add_filter( 'woocommerce_checkout_fields' , 'custom_change_woo_checkout_company' );

function custom_change_woo_checkout_company( $fields ) {
    // remove billing phone number
    $fields['billing']['billing_company']['label'] = "Organization";
    $fields['shipping']['shipping_company']['label'] = "Organization";

    // unset($fields['billing']['billing_company']);

    return $fields;
}


//turn some stuff off from parent theme, which is located in storefront-template-hooks.php
function sf_framework_remove_parent_theme_stuff() {
  remove_action( 'homepage', 'storefront_recent_products',       30 );
	remove_action( 'homepage', 'storefront_featured_products', 40 );
	remove_action( 'homepage', 'storefront_popular_products', 50 );
	remove_action( 'homepage', 'storefront_on_sale_products', 60 );
	remove_action( 'homepage', 'storefront_best_selling_products', 70 );
  remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
  remove_action( 'storefront_header', 'storefront_product_search', 40 );

  remove_action( 'storefront_header', 'storefront_header_cart',    60 );
}

add_action( 'init', 'sf_framework_remove_parent_theme_stuff', 0 );
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


add_action( 'storefront_before_col', 'storefront_header_banner', 10 );
// storefront_header
add_action( 'storefront_before_content', 'storefront_header_widget_region', 10 );
add_action( 'storefront_header', 'storefront_sidebar_cart',    40 );


function storefront_header_banner() {

  ?>
  <div id="top-banner" class="entry-header-banner">
    <!-- <div class="header-image-container" style="background:url(/wp-content/uploads/2017/11/working-together.jpg);background-size:cover;background-repeat:no-repeat;background-position: center 40%;"></div>
    <div class="banner-overlay " style="background-color: rgba(112,47,138,.6)">
<h2 class="banner-header">College & Career Ready</h2> -->
</div>

</div>
  <?php
  // <img src="/wp-content/uploads/2017/11/working-together.jpg">

}

// add_action( 'custom_sidebar_cart', 'storefront_sidebar_cart' );

function storefront_sidebar_cart() {
  if ( storefront_is_woocommerce_activated() ) {
    if ( is_cart() ) {
      $class = 'current-menu-item';
    } else {
      $class = '';
    }
  ?>
  <ul id="site-header-cart" class="site-header-cart menu">
    <li class="<?php echo esc_attr( $class ); ?>">
      <?php storefront_cart_link(); ?>
    </li>
    <li>
      <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
    </li>
  </ul>
  <?php
  }
}

function storefront_product_categories( $args ) {

  if ( storefront_is_woocommerce_activated() ) {

    $args = apply_filters( 'storefront_product_categories_args', array(
      'limit' 			=> 2,
      'columns' 			=> 2,
      'child_categories' 	=> 0,
      'orderby' 			=> 'name',
      'title'				=> __( 'Shop by Category', 'storefront' ),
    ) );

    echo '<section class="storefront-product-section storefront-product-categories" aria-label="Product Categories">';

    do_action( 'storefront_homepage_before_product_categories' );

    // echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

    do_action( 'storefront_homepage_after_product_categories_title' );

    echo storefront_do_shortcode( 'product_categories', array(
      'number'  => intval( $args['limit'] ),
      'columns' => intval( $args['columns'] ),
      'orderby' => esc_attr( $args['orderby'] ),
      'parent'  => esc_attr( $args['child_categories'] ),
    ) );

    do_action( 'storefront_homepage_after_product_categories' );

    echo '</section>';
  }
}

//footer info
function storefront_credit() {
  ?>
  <div class="site-info">
    <?php
	 $year = date('Y');
     $content = '<div id="lftboxwrap">
		<div id="lftbox">
			<div id="idblock">
				<img id="ketfooter" alt="KET Logo" src="/wp-content/uploads/2017/12/Logo_CompressedCMYK_KET.png" />
				<p id="footertext">&copy; '.$year.' KET - Kentucky Educational Television
				<br>600 Cooper Drive, Lexington, KY 40502
				<br>859.258.7278 &#8226; 859.258.7271
        <br><a href ="mailto:ChildDev@ket.org">ChildDev@ket.org</a> &#8226; <a href ="mailto:pd@ket.org">pd@ket.org</a>
				<br><a href="http://www.ket.org/privacy/terms-of-use.htm" target="_blank">Terms of Use</a> |
				<a href="http://www.ket.org/privacy/" target="_blank">Privacy Policy</a>

				</p>
			</div><!--/#idblock-->

		</div><!--/#lftbox-->
		</div><!--/#lftboxwrap-->

		';
      echo  apply_filters( 'storefront_copyright_text', $content ) ;
      //= '&copy; ' . get_bloginfo( 'name' ) . ' ' . date( 'Y' )
      //      echo esc_html( apply_filters( 'storefront_copyright_text', $content ) );

      if ( apply_filters( 'storefront_credit_link', true ) ) { }
     ?>
  </div><!-- .site-info -->
  <?php
}

// Hide Filter  Count
add_filter( 'woocommerce_layered_nav_count', 'hide_filter_count' );
function hide_filter_count() {
  /* empty - no count */
}

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
//remove product images from single product pages.

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
//remove 'categories' meta from product page

// add_filter('woocommerce_product_description_heading', '__return_null');
//turns off Tab heading on product description...clearly.


// Hide Product Category Count
add_filter( 'woocommerce_subcategory_count_html', 'prima_hide_subcategory_count' );
function prima_hide_subcategory_count() {
  /* empty - no count */
}

/*Add quantity to the shop page next to items*/
// add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );
// function quantity_inputs_for_woocommerce_loop_add_to_cart_link( $html, $product ) {
// 	if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
// 		$html = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" class="cart" method="post" enctype="multipart/form-data">';
// 		$html .= woocommerce_quantity_input( array(), $product, false );
// 		$html .= '<button type="submit" class="button">' . esc_html( $product->add_to_cart_text() ) . '</button>';
// 		$html .= '</form>';
// 	}
// 	return $html;
// }

//for edustore, we don't want to be able to add to cart from the list page, because they have to choose group enrollment on the individual product page
//so change the add to cart button to go to the product page, and change the buton to say "View Product";

add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );
function quantity_inputs_for_woocommerce_loop_add_to_cart_link( $html, $product ) {
	if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
    $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
    $html = '<form action="' . esc_url( $link ) . '" class="cart" method="post" enctype="multipart/form-data">';
		$html .= '<button type="submit" class="button">' . esc_html( "View Product" ) . '</button>';
		$html .= '</form>';
	}
	return $html;
}



// remove default sorting dropdown in StoreFront Theme
add_action('init','delay_remove');

function delay_remove() {
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
remove_action( 'woocommerce_after_shop_loop',        'woocommerce_result_count',                 20 );

// remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
}

//add short descriptions to category/archive pages
// add_action( 'woocommerce_after_shop_loop_item_title', 'lk_woocommerce_product_excerpt', 5, 2);
// if (!function_exists('lk_woocommerce_product_excerpt')) {
//   function lk_woocommerce_product_excerpt(){
//     echo '<span class="excerpt">';
//     the_excerpt();
//     echo '</span>';
//   }
// }


add_action( 'woocommerce_after_shop_loop_item_title', 'lk_woocommerce_product_excerpt', 12, 2);
if (!function_exists('lk_woocommerce_product_excerpt')) {
  function lk_woocommerce_product_excerpt() {
    $content_length = 25; //change length of except here.
    global $post;
    $content = $post->post_excerpt;
    $wordarray = explode(' ', $content, $content_length + 1);
    if(count($wordarray) > $content_length) : array_pop($wordarray);
    array_push($wordarray, '...');
    $content = implode(' ', $wordarray);
    $content = force_balance_tags($content);
    endif;
    echo "<span class='excerpt'><p>$content</p></span>";
}}

function storefront_primary_navigation() {
  //this empty funciton overwrites template and leaves the main nav menu empty.
}

//removes breadcrumbs.
//none of these filters or actions are actually working.  just overriding the funciton.
// add_filter( ‘woocommerce_get_breadcrumb’, ‘__return_false’ );
// remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
// remove_action( 'storefront_content_top', 'woocommerce_breadcrumb', 99 );
// function woocommerce_breadcrumb() {}

add_filter('widget_text','do_shortcode');
//allow short codes in widget area

//added functionality to show subcategory description and not just titles.
function woocommerce_template_loop_category_title( $category ) {
  ?>
  <h2 class="woocommerce-loop-category__title">
    <?php
      echo $category->name;
      if ( $category->count > 0 ) {
        echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
      }
    ?>
  </h2>
    <?php
    if($category->description){
      echo "<span class='excerpt'><p>" . $category->description . "</p></span>";

    }
    // $new_str = preg_replace('/Online$/', '', $category->name);
    //
    //  $page = get_page_by_title($new_str, OBJECT, 'post');
    //  if(!$page){
    //    echo "Needs post";
    //  }


}

//the following two loops allow for HTML code in the category descriptions.
// Disables Kses only for textarea saves
foreach (array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description') as $filter) {
	remove_filter($filter, 'wp_filter_kses');
}

// Disables Kses only for textarea admin displays
foreach (array('term_description', 'link_description', 'link_notes', 'user_description') as $filter) {
	remove_filter($filter, 'wp_kses_data');
}

//hide tool bar for all users except actual admins
/**
 * Prevent any user who cannot 'edit_posts' (subscribers, customers etc) from seeing the admin bar.
 *
 */
 function bbloomer_hide_admin_bar_if_non_admin( $show ) {
      if ( ! (current_user_can( 'administrator' ) ||  current_user_can('shop_manager')  || current_user_can('business'))) $show = false;
     return $show;
 }

 add_filter( 'show_admin_bar', 'bbloomer_hide_admin_bar_if_non_admin', 20, 1 );

    // echo &amp;quot;&amp;lt;span class='excerpt'&amp;gt;&amp;lt;p&amp;gt;$content&amp;lt;/p&amp;gt;&amp;lt;/span&amp;gt;&amp;quot;; } }

// add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
//
// function woo_remove_product_tabs( $tabs ) {
//
//     unset( $tabs['description'] );      	// Remove the description tab
//     unset( $tabs['reviews'] ); 			// Remove the reviews tab
//     unset( $tabs['additional_information'] );  	// Remove the additional information tab
//
//     return $tabs;
//
// }

/**		 * Remove existing tabs from single product pages.		 */
function remove_woocommerce_product_tabs( $tabs ) {
  unset( $tabs['description'] );
  unset( $tabs['reviews'] );
  unset( $tabs['additional_information'] );
  return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'remove_woocommerce_product_tabs', 98 );
/**		 * Hook in each tabs callback function after single content.		 */
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_product_description_tab', 13 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_product_additional_information_tab',12 );

//woocommerce_single_product_summary
//move grouped products location on product page
// remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
// add_action('woocommerce_after_single_product_summary', 'woocommerce_grouped_add_to_cart',30);


//rename the "Additional Information" tab
add_filter( 'woocommerce_product_additional_information_heading', 'wc_change_product_additional_tab_heading', 10, 1 );
function wc_change_product_additional_tab_heading( $title ) {
	global $post;
	return "COURSE INFO";
}

function remove_edwiser_grouped_courses_info() {
  remove_action('woocommerce_grouped_product_list_before_price',  'NmBridgeWoocommerce\BridgeWoocommercePublic->groupedProductDisplayAssociatedCourses',1,1);

}
add_action( 'woocommerce_grouped_product_list_before_price', 'remove_edwiser_grouped_courses_info', 2 );


//show only the top-level grouped products in searches and filters.
//this does not apply to p-k-12 products at the moment because they do not use grouped products.

add_action( 'woocommerce_product_query', 'only_grouped_products_query' );
function only_grouped_products_query( $q ) {
  if(isset($q->query['product_cat'])){
    $category_check = $q->query['product_cat'];


        if($category_check!='pd-k-12'){ //for all categories except pd-k-12
              //get current loop query
             $taxonomy_query = $q->get('tax_query') ;
             //appends the grouped products condition
             $taxonomy_query['relation'] = 'AND';
             $taxonomy_query[] = array(
                     'taxonomy' => 'product_type',
                     'field' => 'slug',
                     'terms' => 'grouped'
             );


             $q->set( 'tax_query', $taxonomy_query );
         }
     }
     else{};
}

//force display name to be first + last name instead of username
function force_pretty_displaynames($user_login, $user) {

    $outcome = trim(get_user_meta($user->ID, 'first_name', true) . " " . get_user_meta($user->ID, 'last_name', true));
    if (!empty($outcome) && ($user->data->display_name!=$outcome)) {
        wp_update_user( array ('ID' => $user->ID, 'display_name' => $outcome));
    }
}
add_action('wp_login','force_pretty_displaynames',10,2);


/**
 * Add Cynthia email recipient for admin New Order emails if SBDM is ordered
 *
 * @param string $recipient a comma-separated string of email recipients (will turn into an array after this filter!)
 * @param \WC_Order $order the order object for which the email is sent
 * @return string $recipient the updated list of email recipients
 */
// function sv_conditional_email_recipient( $recipient, $order ) {
// 	// Bail on WC settings pages since the order object isn't yet set yet
// 	$page = $_GET['page'] = isset( $_GET['page'] ) ? $_GET['page'] : '';
// 	if ( 'wc-settings' === $page ) {
// 		return $recipient;
// 	}
//
// 	// just in case
// 	if ( ! $order instanceof WC_Order ) {
// 		return $recipient;
// 	}
// 	// $items = $order->get_items();
//
// 	// check if a shipped product is in the order
// 	// foreach ( $items as $item ) {
// 		// $product = $order->get_product_from_item( $item );
// 	foreach ($order->get_items() as $item_key => $item_values){
//     $item_name = $item_values->get_name();
// 		if ( $product && strpos($item_name, 'SBDM') !== false) {
// 			$recipient .= ', bcvincent+sbdm@gmail.com';
// 			return $recipient;
// 		}
// 	}
//
// 	return $recipient;
// }
// add_filter( 'woocommerce_email_recipient_new_order', 'sv_conditional_email_recipient', 10, 2 );



?>
