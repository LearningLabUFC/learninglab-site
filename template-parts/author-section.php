<?php

$author_id = get_the_author_meta('ID');
$author_name = get_the_author();
$author_bio = get_the_author_meta('description');
$author_avatar = get_avatar_url($author_id, array('size' => 120));
$author_posts_url = get_author_posts_url($author_id);

$author_title = get_the_author_meta('user_title');
$author_facebook = get_the_author_meta('facebook');
$author_twitter = get_the_author_meta('twitter');
$author_instagram = get_the_author_meta('instagram');
$author_linkedin = get_the_author_meta('linkedin');
$author_website = get_the_author_meta('url');

if ($author_bio) : ?>
    <div class="author-section">
        <div class="author-info">
            <div class="author-avatar">
                <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
            </div>
            <div class="author-details">
                <h3><?php echo esc_html($author_name); ?></h3>
                
                <?php if ($author_title) : ?>
                    <div class="author-title"><?php echo esc_html($author_title); ?></div>
                <?php endif; ?>
                

                
                <?php if ($author_facebook || $author_twitter || $author_instagram || $author_linkedin || $author_website) : ?>
                    <div class="author-social">
                        <?php if ($author_website) : ?>
                            <a href="<?php echo esc_url($author_website); ?>" target="_blank" title="Website">
                                <i class="fas fa-globe"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($author_facebook) : ?>
                            <a href="<?php echo esc_url($author_facebook); ?>" target="_blank" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($author_twitter) : ?>
                            <a href="<?php echo esc_url($author_twitter); ?>" target="_blank" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($author_instagram) : ?>
                            <a href="<?php echo esc_url($author_instagram); ?>" target="_blank" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($author_linkedin) : ?>
                            <a href="<?php echo esc_url($author_linkedin); ?>" target="_blank" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="author-bio">
                    <?php echo wp_kses_post($author_bio); ?>
                </div>
                
                <a href="<?php echo esc_url($author_posts_url); ?>" class="author-posts-link">
                    Ver todos os posts de <?php echo esc_html($author_name); ?>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>