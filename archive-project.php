<?php get_header(); ?>

<div class="content-area">
    <h2 class="title_projets">Mes Projets</h2>
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
                                <span class="project-type">
                                    <?php
                                        // Récupérer la première catégorie associée
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            echo esc_html($categories[0]->name); // Affiche le nom de la catégorie
                                        } else {
                                            echo "Non défini"; // Si aucun type n'est associé
                                        }
                                        ?>
                                </span>
                            </div>
                            <div class="card-description">
                                <?php echo wp_trim_words(get_the_excerpt(),50, '...'); ?>
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

        // Trouver l'index de la ligne active
        const activeLineIndex = Math.round(scrollPercentage * (lines.length - 1));

        // Supprime la classe active de toutes les lignes
        lines.forEach((line, index) => {
            line.classList.remove("active");

            // Ajuster les hauteurs en fonction de la distance
            const distance = Math.abs(index - activeLineIndex); // Distance par rapport à la ligne active
            if (distance === 0) {
                line.style.height = "45px"; // Hauteur de la ligne active
                line.style.width = "4px"; // Épaisseur de la ligne active
            } else if (distance === 1) {
                line.style.height = "40px"; // Lignes voisines
                line.style.width = "3.5px";
            } else if (distance === 2) {
                line.style.height = "37px"; // Lignes un peu éloignées
                line.style.width = "3px";
            } else {
                line.style.height = "35px"; // Hauteur par défaut
                line.style.width = "2.5px";
            }
        });

        // Appliquer la classe active à la ligne correspondante
        if (lines[activeLineIndex]) {
            lines[activeLineIndex].classList.add("active");
        }

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