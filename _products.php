<?php 
// Repeater - Advanced Custom Fields
$products_sections = get_field('products_section');
if ($products_sections) {
    echo '<section>';
    foreach ($products_sections as $products_section) {
        // Producs section title
        if (strlen(trim($products_section['title'])) > 0) {
            echo '<h2>' . $products_section['title'] . '</h2>';
        }
        // Products section text (before)
        if (strlen(trim($products_section['text_before'])) > 0) {
            echo $products_section['text_before'];
        }

        $products = $products_section['product'];

        if($products) {
            echo '<ul class="product-boxes">';

            foreach($products as $product) {
                $title = $product['title'];
                $price = $product['price'];
                $price_info = $product['price_info'];
                $timespan = $product['timespan'];

                echo '<li class="product-box">';
                echo '<h3 class="product-title">' . $title . '</h3>';
                echo '<span class="' . $timespan . '"></span>';
                echo '<p class="product-price">' . (the_lang() == 'no' ? '' : '<span class="currency" title="Norwegian Kroner">NOK</span>&nbsp;') . $price . (the_lang() == 'no' ? ',–' : '.00') . '</p>';
                echo '<p class="product-price-info">' . $price_info .'</p>';
                echo '<a class="product-cta-booking" href="' . (the_lang() == 'no' ? '/booking/' : '/en/booking-request/') . '"></a>';

                echo '</li>';
            }

            echo '</ul>';
        }
        // Products section text (before)
        if (strlen(trim($products_section['information'])) > 0) {
            echo '<div class="products-information">' 
                    . '<i class="icon-info big-icon"></i> '
                    . $products_section['information'] 
                . '</div>';
        }					

        // Products section text (before)
        if (strlen(trim($products_section['text_after'])) > 0) {
            echo $products_section['text_after'];
        }
    }
    echo '</section>';
}
?>