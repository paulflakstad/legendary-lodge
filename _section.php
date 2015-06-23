<?php 
			// Repeater - Advanced Custom Fields
            //$rows = get_field('item_details');
                    $sections = get_field('section');
                    //var_dump($sections);
                    if($sections) {
                            //echo '<ul>';

                        foreach($sections as $section) {
                            echo '<section class="clearfix running-text">';
                                // Get image details
                                $images = $section['images'];
                                if ($images) {
                                    foreach ($images as $image) {
                                        $uri_large = $image['image']['sizes']['large'];
                                        $caption = $image['image']['caption'];
                                        //var_dump($image);
                                        ?>
                                <figure class="medium pull-right">
                                    <a href="<?php echo $uri_large ?>">
                                        <img class="" src="<?php echo $uri_large ?>" />
                                    </a>
                                    <?php if ($caption) { ?>
                                    <figcaption><?php echo $caption ?></figcaption>
                                    <?php } ?>
                                </figure>
                                <?php
                                            }
                                }
					
						// Get text
						$text = $section['text'];
						if ($text) {
							echo $text;
						}
						
					echo '</section>';
					
					//var_dump($image);
					
					/*
					$attachment = get_post( get_sub_field('image') ); 
					var_dump($attachment);
					$alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
					$image_title = $attachment->post_title;
					$caption = $attachment->post_excerpt;
					$description = $attachment->post_content;
					*/
					/*
					$attachment_id = $row['image'];
					$size = "medium"; // (thumbnail, medium, large, full or custom size)
					echo wp_get_attachment_image( $attachment_id, $size );
					//echo 'ID=' . $attachment_id;
					*/
					
					//	var_dump($row);
					
                                        /*
					echo '<section class="item-box">';
					if ($image) {
						echo '<span class="media alignright">'
								. '<a href="' . $image['sizes']['large'] . '" rel="slb">' 
									. '<img alt="' . $image['alt'] . '" src="' . $image['sizes']['large'] . '" />'
								. '</a>'
								. '<span class="wp-caption-text caption">' . $image['caption'] . '</span>'
							. '</span>';
					}
					echo '<h3 class="pull-top">';
					if ($row['link'])
						echo '<a href="' . $row['link'] . '">';
					echo $row['title'];
					if ($row['link'])
						echo '</a>';
					echo '</h3>';
					echo '' . $row['description'] . '';
					echo '<span class="item-price">' . $row['price'] . '</span>';
					echo '</section>';
                                        //*/
				}
			 
				//echo '</ul>';
			}
			?>