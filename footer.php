<footer class="site-footer">
    <div class="footer-content">
        <!-- Socials and Links -->
        <div class="footer-layout">
            <!-- Réseaux Sociaux -->
            <div class="footer-socials">
                <a href="https://www.linkedin.com/in/votreprofil" target="_blank" aria-label="LinkedIn">
                    <img src="<?php echo get_template_directory_uri(); ?>/media/icons/linkedin.svg" alt="LinkedIn">
                    <span class="social-name">LinkedIn</span>
                </a>
                <a href="https://www.instagram.com/votreprofil" target="_blank" aria-label="Instagram">
                    <img src="<?php echo get_template_directory_uri(); ?>/media/icons/instagram.svg" alt="Instagram">
                    <span class="social-name">Instagram</span>
                </a>
            </div>

            <!-- Mentions légales et Contact -->
            <div class="footer-links">
                <a class="footer-link" href="<?php echo esc_url(home_url('/mentions-legales')); ?>">Mentions légales</a>
                <a class="footer-link" href="mailto:votremail@example.com">Contactez-moi</a>
            </div>
        </div>

        <!-- Copyright -->
        <p class="footer-copyright">
            &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Tous droits réservés.
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
