<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>
        <article class="projet-single">
            <div class="projet-content-wrapper">
                <h1 class="projet-title"><?php the_title(); ?></h1>
                <div class="projet-content">
                    <?php the_content(); ?>
                    <span class="projet-type">
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
            </div>
        </article>
    <?php endwhile; endif; ?>
</main>
</div>
<?php get_footer(); ?>