<?php 

/**
 *  Dokan Product category Walker Class
 *  @author weDevs
 */
class DokanCategoryWalker extends Walker_Category{

    public function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0 ) {

        $args = wp_parse_args(array(
            'name'    => 'product_cat',
        ), $args);

        extract($args);
        
        ob_start(); ?>   

        <li>
            <input type="checkbox" <?php echo checked( in_array( $category->term_id, $selected ), true ); ?> id="category-<?php print $category->term_id; ?>" name="<?php print $name; ?>[]" value="<?php print $category->term_id; ?>" />
            <label for="category-<?php print $category->term_id; ?>">
                <?php print esc_attr( $category->name ); ?>
            </label>       

        <?php // closing LI is added inside end_el

        $output .= ob_get_clean();
    }

}