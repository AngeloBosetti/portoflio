<?php
get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <!-- Section avec la vidéo en fond -->
        <section class="hero-section">
         <div class="hero-video-container">
        <video autoplay muted loop playsinline class="background-video">
            <source src="<?php echo get_template_directory_uri(); ?>/media/videos/background-video.mp4" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture vidéo.
                </video>
            </div>
            <div class="hero-content">
                <h1 class="titre">Bienvenue</h1>
            </div>
        </section>

        <!-- Contenu principal -->
        <article class="section-presentation">
            <h1 class="presentation-titre">Je m’appelle <br> Angelo </h1>
            <div class="presentation-paragraphe">
                <p>
                    Je suis <span class="text-highlight">étudiant</span> en <span class="text-highlight">design</span> à
                    l'Univ­ersité de Techno­logie de
                    <span class="text-highlight">Montbé­liard</span>, passi­onné par l’<span
                        class="text-highlight">illustration digitale</span> et le
                    <span class="text-highlight">web Design</span>.
                </p>
            </div>
            <button class="btn-seemore" href="/projets">En savoir plus</button>
        </article>

        <!-- Dernier projet -->
        <article>
            <div class="last-project">
                <div class="last-project_title">
                    <h3 class="last-project_h3">Dernier Projet</h3>
                    <span class="last-project-span"></span>
                </div>
                <div class="last-projet-cards">
                    <?php
                    $args = array(
                        'post_type' => 'project',
                        'posts_per_page' => 1,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );

                    $last_project = new WP_Query($args);

                    if ($last_project->have_posts()):
                        while ($last_project->have_posts()):
                            $last_project->the_post(); ?>
                            <article class="last-projet-card">
                                <div class="last-projet-card-content">
                                    <!-- Image du projet -->
                                    <div class="last-projet-card-image">
                                        <?php the_post_thumbnail('large'); ?>
                                    </div>

                                    <!-- Overlay avec les détails -->
                                    <div class="last-projet-card-overlay">
                                        <!-- Titre et type de projet -->
                                        <div class="last-projet-card-header">
                                            <h2 class="last-projet-card-title"><?php the_title(); ?></h2>
                                            <span class="last-projet-type">
                                                <?php
                                                // Récupérer la première catégorie associée
                                                $categories = get_the_category();
                                                if (!empty($categories)) {
                                                    echo esc_html($categories[0]->name); // Affiche le nom de la catégorie
                                                } else {
                                                    echo "Non défini"; // Si aucune catégorie
                                                }
                                                ?>
                                            </span>
                                        </div>

                                        <!-- Description -->
                                        <div class="last-projet-card-description">
                                            <?php echo wp_trim_words(get_the_excerpt(), 40, '...'); ?>
                                        </div>

                                        <!-- Bouton pour voir le projet -->
                                        <a class="last-projet-see-more-btn" href="<?php the_permalink(); ?>">En savoir plus</a>
                                    </div>
                                </div>
                                
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else: ?>
                        <p>Aucun projet trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
            <button class="btn-seeprojects">Voir mes autres projets</button>
        </article>
        <h4 class="text-contact">N’hésitez pas à me contacter ou à me suivre sur les réseaux !</h4>
    </main>
</div>
<?php
get_footer();
?>