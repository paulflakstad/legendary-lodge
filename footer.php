<?php
/**
 * The template for displaying the footer.
 */
?>
	</div>
</article>
<footer id="footer">
    <div class="mw">
        <div class="footer-about">
            <p>
                Legendary Lodge Senja AS<br />
                Botnhamnveien&nbsp;79<br />
                9373&nbsp;Botnhamn<?php if (the_lang() != 'no') { ?><br />NORWAY<?php } ?>
            </p>
            <dl>
            <?php if (the_lang() != 'no') { ?>
                <dt><i class="icon-phone" title="Phone number"></i></dt>
                    <dd>+47&nbsp;981&nbsp;32&nbsp;209</dd>
                <dt><i class="icon-envelope" title="In writing"></i></dt>
                    <dd><a href="/en/about/contact/">Contact us</a></dd>
            <?php } else { ?>
                <dt><i class="icon-phone" title="Telefonnummer"></i></dt>
                    <dd>981&nbsp;32&nbsp;209</dd>
                <dt><i class="icon-envelope" title="Skriftlig"></i></dt>
                    <dd><a href="/om-oss/kontakt-oss/">Kontakt oss</a></dd>
            <?php } ?>
            </dl>
        </div>
        <div class="footer-social-media">
            <ul>
                <li>
                    <a href="https://www.facebook.com/legendarylodge" class="facebook" title="Facebook" lang="en">
                        <i class="icon-facebook"></i>
                    </a>
                </li>
                <li>
                    <a href="https://plus.google.com/112181933130830722892/?hl=en" class="googleplus" title="Google plus" lang="en">
                        <i class="icon-googleplus"></i>
                    </a>
                </li>
                <li>
                    <a href="https://instagram.com/legendarylodge/" class="instagram" title="Instagram" lang="en">
                        <i class="icon-instagram"></i>
                    </a>
                </li>
            </ul>
        </div>
        <aside class="footer-partner-links" style="clear:both;">
        	<ul>
            	<li><a href="http://www.devold.com/"><img src="<?php echo get_template_directory_uri(); ?>/img/partners/devold.png" alt="" /></a></li>
            	<li><a href="http://www.dynafit.com/"><img src="<?php echo get_template_directory_uri(); ?>/img/partners/dynafit.png" alt="" /></a></li>
            	<li><a href="http://www.haglofs.com/"><img src="<?php echo get_template_directory_uri(); ?>/img/partners/haglofs.png" alt="" /></a></li>
            	<li><a href="http://www.backcountryaccess.com/"><img src="<?php echo get_template_directory_uri(); ?>/img/partners/bca.png" alt="" /></a></li>
            </ul>
        </aside>
    </div>
</footer>

<div id="fb-root"></div>

    </div></div>
<?php wp_footer(); ?>
</body>
</html>
