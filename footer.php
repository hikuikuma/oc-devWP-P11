<div class="modal">
    <?php get_template_part('templates_part/modal_contact'); ?>
    <?php get_template_part('templates_part/modal_lightbox'); ?>
</div>

<footer class="site-footer">
    <?php wp_nav_menu( array( 'container_class' => 'site-footer__menu', 'theme_location' => 'footer' ) ); ?>
</footer>

<?php wp_footer(); ?>

</body>
</html>