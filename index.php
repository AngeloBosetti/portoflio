<?php
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <!-- Section avec la vidéo en fond -->
        <section class="hero-section">
            <div class="hero-video-container">
                <video autoplay muted loop playsinline class="background-video">
                    <source src="<?php echo wp_get_attachment_url(get_theme_mod('background_video')); ?>"
                        type="video/mp4">
                    Votre navigateur ne supporte pas la lecture vidéo.
                </video>
            </div>
            <div class="hero-content">
                <h1 class="titre">Bienvenue</h1>
            </div>
        </section>

        <!-- Contenu principal -->
        <article class="page">
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
            <button class="btn-seemore">En savoir plus</button>
        </article>

        <!-- Dernier projet -->
        <article>
            <div class="last-project">
                <div class="last-project_title">
                    <h3 class="last-project_h3">Dernier Projet</h3>
                    <span class="last-project-span"></span>
                </div>
                <div class="project-card">
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
                            <div class="project-card-content">
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="project-cover">
                                        <?php the_post_thumbnail('large'); ?>
                                    </div>
                                <?php endif; ?>
                                <h4 class="project-title"><?php the_title(); ?></h4>
                                <p class="project-excerpt"><?php echo wp_trim_words(get_the_content(), 20, '...'); ?></p>
                                <a href="<?php the_permalink(); ?>" class="project-link">Voir le projet</a>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else: ?>
                        <p>Aucun projet trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    </main>
</div>

<?php
get_footer();
?>