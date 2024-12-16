<?php get_header(); ?>

<div class="content-area">
    <!-- Conteneur Titre + Menu Déroulant -->
    <div class="title-container">
        <h2 class="title_projets">Mes Projets</h2>
        <div class="filter-container">
            <label for="project-category">Filtrer par :</label>
            <select id="project-category">
                <option value="all">Tous</option>
                <?php
                // Récupérer toutes les catégories associées aux projets
                $categories = get_categories(array(
                    'taxonomy' => 'category',
                    'orderby' => 'name',
                    'order' => 'ASC',
                ));
                foreach ($categories as $category): ?>
                    <option value="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Liste des projets -->
    <div class="cards">
        <?php
        if (have_posts()): ?>
            <?php
            while (have_posts()):
                the_post(); ?>
                <article class="projet-card" data-category="<?php
                $categories = get_the_category();
                echo !empty($categories) ? esc_attr($categories[0]->slug) : 'uncategorized';
                ?>">
                    <div class="card-content">
                        <div class="card-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                        <div class="card-overlay">
                            <div class="card-header">
                                <h2 class="card-title"><?php the_title(); ?></h2>
                                <span class="project-type">
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo esc_html($categories[0]->name);
                                    } else {
                                        echo "Non défini";
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="card-description">
                                <?php echo wp_trim_words(get_the_excerpt(), 50, '...'); ?>
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

    <!-- Barre de défilement -->
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

<!-- Script de tri par catégories et synchronisation de la barre -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const categoryFilter = document.getElementById("project-category");
        const projectCards = document.querySelectorAll(".projet-card");

        // Filtrage des projets
        categoryFilter.addEventListener("change", function () {
            const selectedCategory = this.value;

            projectCards.forEach(card => {
                const cardCategory = card.getAttribute("data-category");

                // Afficher/Masquer les projets selon la catégorie sélectionnée
                if (selectedCategory === "all" || cardCategory === selectedCategory) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });

            // Réinitialiser le scroll si filtrage est activé
            document.querySelector(".cards").scrollLeft = 0;
            updateScrollMetrics();
        });

        // Synchronisation de la barre de défilement
        const scrollContainer = document.querySelector(".cards");
        const lines = document.querySelectorAll(".scroll-lines .line");
        const scrollStart = document.querySelector(".scroll-start");
        const scrollEnd = document.querySelector(".scroll-end");
        const scrollBar = document.querySelector(".scroll-lines");

        let isDragging = false;
        let startX, startScroll;

        const totalProjects = projectCards.length;
        scrollEnd.textContent = totalProjects.toString().padStart(2, "0");

        const updateScrollMetrics = () => {
            const totalScrollWidth = scrollContainer.scrollWidth - scrollContainer.offsetWidth;
            const scrollPercentage = scrollContainer.scrollLeft / totalScrollWidth;
            const activeLineIndex = Math.round(scrollPercentage * (lines.length - 1));

            // Mettre à jour la barre de défilement
            lines.forEach((line, index) => {
                line.classList.remove("active");
                const distance = Math.abs(index - activeLineIndex);
                if (distance === 0) {
                    line.style.height = "45px";
                    line.style.width = "4px";
                } else if (distance === 1) {
                    line.style.height = "40px";
                    line.style.width = "3.5px";
                } else if (distance === 2) {
                    line.style.height = "37px";
                    line.style.width = "3px";
                } else {
                    line.style.height = "35px";
                    line.style.width = "2.5px";
                }
            });

            if (lines[activeLineIndex]) {
                lines[activeLineIndex].classList.add("active");
            }

            // Mise à jour des indices
            const currentProject = Math.round(scrollPercentage * (totalProjects - 1)) + 1;
            scrollStart.textContent = currentProject.toString().padStart(2, "0");
        };

        scrollContainer.addEventListener("scroll", updateScrollMetrics);

        const handleDragStart = (e) => {
            isDragging = true;
            startX = e.clientX || e.touches[0].clientX;
            startScroll = scrollContainer.scrollLeft;
        };

        const handleDragging = (e) => {
            if (!isDragging) return;
            const currentX = e.clientX || e.touches[0].clientX;
            const delta = currentX - startX;

            const totalScrollWidth = scrollContainer.scrollWidth - scrollContainer.offsetWidth;
            const scrollBarWidth = scrollBar.offsetWidth;
            const scrollRatio = totalScrollWidth / scrollBarWidth;

            scrollContainer.scrollLeft = startScroll + delta * scrollRatio;
        };

        const handleDragEnd = () => {
            isDragging = false;
        };

        scrollBar.addEventListener("mousedown", handleDragStart);
        scrollBar.addEventListener("mousemove", handleDragging);
        document.addEventListener("mouseup", handleDragEnd);
        scrollBar.addEventListener("touchstart", handleDragStart);
        scrollBar.addEventListener("touchmove", handleDragging);
        document.addEventListener("touchend", handleDragEnd);

        updateScrollMetrics();
    });
</script>

<?php get_footer(); ?>