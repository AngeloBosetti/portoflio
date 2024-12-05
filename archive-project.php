<?php get_header(); ?>

<div class="content-area">
    <h1 class="title_projets">Mes Projets</h1>
    <div class="cards">
        <?php
        // Vérifie si des projets ont été trouvés
        if (have_posts()): ?>
            <?php
            // Boucle à travers chaque projet
            while (have_posts()):
                the_post(); ?>
                <article class="projet-card">
                    <div class="card-content">
                        <div class="card-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                        <div class="card-overlay">
                            <div class="card-header">
                                <h2 class="card-title"><?php the_title(); ?></h2>
                                <span class="project-type"><?php echo get_field('project_type'); ?></span>
                            </div>
                            <div class="card-description">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </div>
                            <a class="see-more-btn" href="<?php the_permalink(); ?>">En savoir plus</a>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Aucun projet trouvé.</p>
        <?php endif; ?>
    </div>
    <div class="scroll-bar">
        <span class="scroll-start">01</span>
        <div class="scroll-lines">
            <?php for ($i = 0; $i < 40; $i++): ?>
                <div class="line"></div>
            <?php endfor; ?>
        </div>
        <span class="scroll-end"><?php echo str_pad(wp_count_posts('project')->publish, 2, '0', STR_PAD_LEFT); ?></span>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".projet-card");
    const lines = document.querySelectorAll(".scroll-lines .line");
    const scrollStart = document.querySelector(".scroll-start");
    const scrollEnd = document.querySelector(".scroll-end");

    // Total de projets
    const totalProjects = cards.length;
    scrollEnd.textContent = totalProjects.toString().padStart(2, "0");

    // Largeur totale du défilement
    const scrollContainer = document.querySelector(".cards");
    const totalScrollWidth = scrollContainer.scrollWidth - scrollContainer.offsetWidth;

    // Fonction pour synchroniser les lignes avec le défilement
    const syncScrollBar = () => {
        const scrollLeft = scrollContainer.scrollLeft;
        const scrollPercentage = scrollLeft / totalScrollWidth;

        // Trouver l'index de la barre active
        const activeLineIndex = Math.round(scrollPercentage * (lines.length - 1));

        // Ajuster les hauteurs des barres en fonction de leur proximité avec la barre active
        lines.forEach((line, index) => {
            const distance = Math.abs(index - activeLineIndex); // Distance par rapport à la barre active

            if (distance === 0) {
                line.style.height = "45px"; // Barre active (hauteur maximale)
            } else if (distance === 1) {
                line.style.height = "40px"; // Barres voisines immédiates (semi-hauteur)
            } else if (distance === 2) {
                line.style.height = "37px"; // Barres un peu plus éloignées
            } else {
                line.style.height = "35px"; // Barres éloignées (taille par défaut)
            }
        });

        // Mettre à jour le numéro de projet
        const currentProject = Math.round(scrollPercentage * (totalProjects - 1)) + 1;
        scrollStart.textContent = currentProject.toString().padStart(2, "0");
    };

    // Initialisation dès le chargement
    syncScrollBar();

    // Synchronisation pendant le défilement
    scrollContainer.addEventListener("scroll", syncScrollBar);
    });

</script>
<?php get_footer(); ?>