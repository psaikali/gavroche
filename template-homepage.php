<?php
/**
 * The template for displaying the homepage
 *
 * @package Gavroche
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */
?>

<?php 
/*
Template Name: Homepage
*/
__('Homepage', 'gavroche'); ?>

<?php if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

if (have_posts()) :

	while (have_posts()) :

		the_post();

		$sections = gavroche_option('home_sections');
		$sections_amount = count($sections);
		$sections_displayed = $sections_amount;
		$section_current_index = 0;

		foreach ($sections as $section => $display) {
			if (!$display) {
				$sections_displayed--;
				continue;
			} else {
				$section_current_index++;
			}

			/****************************************
			 * General stuff
			 */
			$section_classes = array('home-section', "home-section-$section_current_index");

			switch ($section) {

				/****************************************
				 * Page content (introductory text)
				 */
				case 'content':

					$section_classes[] = 'page-content';

					?>

					<section class="<?php echo join(' ', $section_classes); ?>">
						<?php the_content(); ?>
					</section>

					<?php

					break;

				/****************************************
				 * Portfolio featured projects
				 */
				case 'portfolio':

					$section_classes[] = 'portfolio';
					$portfolio_projects_ids = (!array_key_exists('gavroche_portfolio_items', $post->custom_fields)) ? array() : unserialize($post->custom_fields['gavroche_portfolio_items'][0]);

					?>

					<section class="<?php echo join(' ', $section_classes); ?>">
						<?php if (array_key_exists('gavroche_portfolio_title', $post->custom_fields)) { ?>
						<h2><?php echo apply_filters('gavroche_title', $post->custom_fields['gavroche_portfolio_title'][0]); ?></h2>
						<?php } ?>

						<?php if (!empty($portfolio_projects_ids)) { ?>
						<div class="portfolio-projects grid row" data-columns>
							<?php $projects = get_posts(
								array(
									'posts_per_page' => -1,
									'post__in' => $portfolio_projects_ids,
									'post_type' => 'portfolio',
									'orderby' => 'menu_order',
									'order' => 'ASC'
								)
							);

							foreach ($projects as $project) {
								gavroche_display_project_box($project);
							} ?>
						</div>
						<?php } ?>

						<p class="button-portfolio">
							<?php gavroche_button(
								get_post_type_archive_link('portfolio'),
								apply_filters('gavroche_portfolio_button_txt', __('See more projects', 'gavroche'))
							); ?>
						</p>
					</section>

					<?php

					break;

				/****************************************
				 * Skills / services
				 */
				case 'skills':

					$section_classes[] = 'skills';
					$skills_pages_ids = (!array_key_exists('gavroche_skills_items', $post->custom_fields)) ? array() : unserialize($post->custom_fields['gavroche_skills_items'][0]);

					$skills_classes = array(
						'skills-content unit half',
						'skills-boxes unit half',
						'skills-content unit whole'
					); ?>

					<section class="<?php echo join(' ', $section_classes); ?>">
						<?php if (array_key_exists('gavroche_skills_title', $post->custom_fields)) { ?>
						<h2><?php echo apply_filters('gavroche_title', $post->custom_fields['gavroche_skills_title'][0]); ?></h2>
						<?php } ?>

						<div class="skills-content-boxes row no-gutters">
							<?php if (array_key_exists('gavroche_skills_content', $post->custom_fields)) { ?>
							<div class="<?php echo (!empty($skills_pages_ids)) ? esc_attr($skills_classes[0]) : esc_attr($skills_classes[2]); ?>">
								<?php echo wpautop(do_shortcode($post->custom_fields['gavroche_skills_content'][0])); ?>
							</div>
							<?php } ?>

							<?php if (!empty($skills_pages_ids)) { ?>
							<div class="<?php echo (array_key_exists('gavroche_skills_content', $post->custom_fields)) ? esc_attr($skills_classes[1]) : esc_attr($skills_classes[2]); ?>">
								<?php $skills_pages = get_posts(
									array(
										'posts_per_page' => -1,
										'post__in' => $skills_pages_ids,
										'post_type' => 'page',
										'orderby' => 'menu_order',
										'order' => 'ASC'
									)
								);

								foreach ($skills_pages as $skill_page) {
									gavroche_display_page_box($skill_page);
								} ?>
							</div>
							<?php } ?>
						</div>
					</section>

					<?php

					break;

				/****************************************
				 * References
				 */
				case 'references':

					$section_classes[] = 'references';

					?>

					<section class="<?php echo join(' ', $section_classes); ?>">
						<?php if (array_key_exists('gavroche_references_title', $post->custom_fields)) { ?>
						<h2><?php echo apply_filters('gavroche_title', $post->custom_fields['gavroche_references_title'][0]); ?></h2>
						<?php } ?>

						<?php if (array_key_exists('gavroche_references_content', $post->custom_fields)) { ?>
						<?php echo wpautop(do_shortcode($post->custom_fields['gavroche_references_content'][0])); ?>
						<?php } ?>
					</section>

					<?php

					break;

				/****************************************
				 * Blog posts
				 */
				case 'posts':

					$section_classes[] = 'posts';

					?>

					<section class="<?php echo join(' ', $section_classes); ?>">
						<h2><?php echo apply_filters('gavroche_title', apply_filters('gavroche_title_blog_homepage', __('Latest blog posts', 'gavroche'))); ?></h2>

						<?php

						$posts_count = gavroche_option('home_posts');

						$featured_post = get_posts(
							array(
								'posts_per_page' => 1,
								'post__in'  => get_option( 'sticky_posts' ),
								'ignore_sticky_posts' => 1
							)
						);

						$posts = get_posts(
							array(
								'posts_per_page' => $posts_count-1,
								'orderby' => 'date',
								'post__not_in' => array($featured_post[0]->ID)
							)
						);

						?>

						<div class="posts-list row no-gutters">
							<div class="featured-post unit golden-small">
								<article class="post" itemscope="itemscope" itemtype="http://schema.org/Article">
									<div class="post-inner">
										<?php $url = get_permalink($featured_post[0]->ID); ?>

										<?php if (has_post_thumbnail($featured_post[0]->ID)) { ?>
										<figure class="post-thumbnail">
											<a href="<?php echo $url;  ?>" title="<?php echo esc_attr($featured_post[0]->post_title); ?>">
												<?php echo get_the_post_thumbnail($featured_post[0]->ID, 'post-thumbnail'); ?>
											</a>
										</figure>
										<?php } ?>

										<div class="post-info">
											<h4 class="entry-title"><a rel="bookmark" itemprop="url" href="<?php echo $url;  ?>" title="<?php echo esc_attr($featured_post[0]->post_title); ?>"><?php echo apply_filters('gavroche_title', $featured_post[0]->post_title); ?></a></h4>

											<aside class="meta"><?php echo sprintf(__('Published %s ago', 'gavroche'), human_time_diff( get_the_time('U', $featured_post[0]), current_time('timestamp'))); ?></aside>

											<?php echo gavroche_excerpt(25, $featured_post[0]->ID); ?>

											<?php gavroche_button($url, apply_filters('gavroche_skill_button_txt', __('Read full article', 'gavroche')), '', array('small')); ?>
										</div>
									</div>
								</article>
							</div>

							<div class="other-posts unit golden-large">
								<?php foreach ($posts as $item) { ?>
									<article class="post" itemscope="itemscope" itemtype="http://schema.org/Article">
										<h4 class="entry-title"><a rel="bookmark" itemprop="url" href="<?php echo get_permalink($item->ID);  ?>" title="<?php echo esc_attr($item->post_title); ?>"><?php echo apply_filters('gavroche_title', $item->post_title); ?></a></h4>
										<aside class="meta"><?php echo sprintf(__('Published %s ago', 'gavroche'), human_time_diff( get_the_time('U', $item), current_time('timestamp'))); ?></aside>

										<?php echo wpautop(do_shortcode($item->post_excerpt)); ?>
									</article>
								<?php } ?>
							</div>
						</div>
						<?php  ?>
					</section>

					<?php

					break;
			}

			do_action("gavroche_after_home_section_{$section}", $section);
		}

		if ($sections_displayed == 0)
			printf(__("Your custom home page isn't fully set up, you have to choose the elements to display on <a href='%s'>Gavroche's settings page</a>.", 'gavroche'), admin_url('themes.php?page=gavroche_options#general'));

	endwhile;

else:

	get_template_part('content', 'none');

endif;

get_footer(); ?>