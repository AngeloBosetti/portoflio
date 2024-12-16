<?php
/*
Template name: About
*/
get_header();
?>

<div id="primary" class="content-area about-page">
    <main id="main" class="site-main">
        <div class="background-circles">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
        </div>
        <div class="content-about">
            <!-- Titre principal -->
            <h1 class="about-title">À propos de moi</h1>

            <!-- Introduction -->
            <section class="about-intro">
                <p>
                    Je m’appelle <span class="text-hover">Angelo Bosetti</span>, j’ai <span class="text-hover">20 ans</span>. 
                    Actuellement, je suis <span class="text-hover">étudiant en design</span> à l'<span class="text-hover">Université de Technologie de Montbéliard</span>.
                </p>
                <p>
                    Je suis passi­onné par l’<span class="text-hover">illustration digitale</span>, le <span class="text-hover">web design</span>, 
                    ainsi que par tout ce qui touche à l'<span class="text-hover">informatique</span>, à l'<span class="text-hover">électronique</span>, 
                    aux <span class="text-hover">jeux vidéo</span> et à la <span class="text-hover">musique</span>.
                </p>
            </section>

            <!-- Compétences logiciels -->
            <section class="about-skills">
                <h2 class="skills-title">Logiciels maîtrisés</h2>
                <ul class="skills-list">
                    <li class="skill-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/media/icons/logiciels/photoshop.svg" alt="Photoshop" class="skill-icon">
                        <span class="text-hover">Photoshop</span>
                    </li>
                    <li class="skill-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/media/icons/logiciels/illustrator.svg" alt="Illustrator" class="skill-icon">
                        <span class="text-hover">Illustrator</span>
                    </li>
                    <li class="skill-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/media/icons/logiciels/figma.svg" alt="Figma" class="skill-icon">
                        <span class="text-hover">Figma</span>
                    </li>
                    <li class="skill-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/media/icons/logiciels/wordpress.svg" alt="WordPress" class="skill-icon">
                        <span class="text-hover">WordPress</span>
                    </li>
                    <li class="skill-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/media/icons/logiciels/html5.svg" alt="HTML" class="skill-icon">
                        <span class="text-hover">HTML</span>
                    </li>
                    <li class="skill-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/media/icons/logiciels/css3.svg" alt="CSS" class="skill-icon">
                        <span class="text-hover">CSS</span>
                    </li>
                    <li class="skill-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/media/icons/logiciels/notion.svg" alt="Notion" class="skill-icon">
                        <span class="text-hover">Notion</span>
                    </li>
                </ul>
            </section>

            <!-- Appel à l'action -->
            <section class="about-contact">
                <p>
                    N’hésitez pas à me <a href="#" class="text-hover">contacter</a> ou à me suivre sur les <span class="text-hover">réseaux sociaux</span> pour découvrir mon travail !
                </p>
            </section>
        </div>
    </main>
</div>

<?php
get_footer();
?>


