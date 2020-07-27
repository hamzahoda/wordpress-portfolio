<?php
/**
 * Template for Contact Section
 *
 * @package RT_Portfolio
 */
$enable_contact = rt_portfolio_get_option( 'enable_contact' );

if ( false == $enable_contact ){
    return;
}
$contact_section_title 	= rt_portfolio_get_option( 'contact_section_title' );
$contact_page 	= rt_portfolio_get_option( 'contact_page' );
?>
<div class="section contact-section" id="contactsection">
	<div class="section contact-section">
		<div class="container">
			<div class="row">
				<?php if ( $contact_section_title ): ?>
					<div class="custom-col-4">
						<header class="entry-header heading">
							<h2 class="entry-title"><?php echo esc_html( $contact_section_title );?></h2>
						</header>
					</div>
				<?php endif;?>
				<div class="custom-col-8">
					<div class="contact-section-wrapper">
						<div class="contact-information">
                            <?php $args_intro = array (                         
                                'p'                 => absint( $contact_page ),
                                'post_status'       => 'publish',
                                'post_type'         => 'page',
                            );

                            $loop = new WP_Query( $args_intro ); 

                            if ( $loop->have_posts() ) : 
                                while ($loop->have_posts()) : $loop->the_post(); ?>							
									<article class="contact-form-wrap">
										<header class="screen-reader-text">
											<h2 class="entry-title"><?php the_title();?></h2>
										</header>
										<div class="entery-content">
											<?php the_content();?>
										</div>
									</article>
								<?php endwhile;
								wp_reset_postdata();
							endif; ?>
							<?php $contact_callback_html 	= rt_portfolio_get_option( 'contact_callback_html' ); 
							if ( ! empty( $contact_callback_html ) ): ?>	
								<div class="contact-info-section">								
									<div class="contact-detail">
										<div class="textwidget">
											<?php echo wp_kses_post( $contact_callback_html  );?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>