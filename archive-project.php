<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
            <div class="background-circles">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
            </div>
            <div class="content">
                <!-- Conteneur Titre + Menu Déroulant -->
                <div class="title-container">
                    <h2 class="title_projets">Mes Projets</h2>
                    <div class="filter-container">
                        <label for="filter-categories" class="filter-label">Filtrer par catégorie :</label>
                        <select id="filter-categories" class="filter-select">
                            <option value="all">Toutes les catégories</option>
                            <?php
                            // Récupérer toutes les catégories
                            $categories = get_categories(array(
                                'hide_empty' => true, // Ne pas inclure les catégories vides
                            ));

                            // Boucle pour ajouter les catégories au menu déroulant
                            foreach ($categories as $category):
                                // Exclure la catégorie par son slug
                                if ($category->slug === 'non-classe') continue; // Remplacer par 'uncategorized' si le site est en anglais
                            ?>
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
        </main>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const categoryFilter = document.getElementById("filter-categories");
        const projectCards = document.querySelectorAll(".projet-card");
        const scrollContainer = document.querySelector(".cards");
        const lines = document.querySelectorAll(".scroll-lines .line");
        const scrollStart = document.querySelector(".scroll-start");
        const scrollEnd = document.querySelector(".scroll-end");
        const scrollBar = document.querySelector(".scroll-lines");

        let isDragging = false;
        let startX, startScroll;

        // Fonction pour mettre à jour les métriques de la barre de défilement
        const updateScrollMetrics = () => {
            // Récupérer uniquement les projets visibles
            const visibleProjects = Array.from(projectCards).filter(card => card.style.display !== "none");

            const totalVisibleProjects = visibleProjects.length;
            const totalScrollWidth = scrollContainer.scrollWidth - scrollContainer.offsetWidth;
            const scrollPercentage = scrollContainer.scrollLeft / totalScrollWidth;

            // Calcul de l'index actif
            const activeLineIndex = Math.round(scrollPercentage * (lines.length - 1));

            // Mettre à jour la barre de défilement
            lines.forEach((line, index) => {
                line.classList.remove("active");
                const distance = Math.abs(index - activeLineIndex);

                // Ajuster la taille des lignes en fonction de leur distance à l'élément actif
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

            // Ajouter la classe active à la ligne principale
            if (lines[activeLineIndex]) {
                lines[activeLineIndex].classList.add("active");
            }

            // Mettre à jour les indices de projet
            const currentProjectIndex = Math.round(scrollPercentage * (totalVisibleProjects - 1)) + 1;
            scrollStart.textContent = currentProjectIndex.toString().padStart(2, "0");
            scrollEnd.textContent = totalVisibleProjects.toString().padStart(2, "0");
        };

        // Fonction pour filtrer les projets
        const filterProjects = () => {
            const selectedCategory = categoryFilter.value;

            projectCards.forEach(card => {
                const cardCategory = card.getAttribute("data-category");

                // Afficher/Masquer les projets selon la catégorie sélectionnée
                if (selectedCategory === "all" || cardCategory === selectedCategory) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });

            // Réinitialiser le scroll et mettre à jour la barre après filtrage
            scrollContainer.scrollLeft = 0;
            updateScrollMetrics();
        };

        // Écouteur pour le menu déroulant
        categoryFilter.addEventListener("change", filterProjects);

        // Synchronisation de la barre de défilement
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

        // Initialisation dès le chargement
        scrollContainer.addEventListener("scroll", updateScrollMetrics);
        updateScrollMetrics();
    });
</script>


<?php get_footer(); ?>