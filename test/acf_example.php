<?php

/*
 * Just a simple version of the 'Registering a block with callback' example
 * From: https://www.advancedcustomfields.com/resources/acf_register_block/
 */

add_action('acf/init', function () {
	if (!function_exists('acf_register_block')) {
		return;
	}

	$block = array(
		'name'            => 'testimonial',
		'title'           => __('Testimonial'),
		'description'     => __('A custom testimonial block.'),
		'category'        => 'formatting',
		'icon'            => [
			'foreground' => '#F60',
			'src'        => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0V0z" /><path d="M19 13H5v-2h14v2z" /></svg>',
		],
		'mode'            => 'preview',
		'keywords'        => array('testimonial', 'quote'),
		'render_callback' => 'testimonial_content',
	);

	acf_register_block($block);
});

/**
 *  This is the callback that displays the testimonial block.
 *
 * @param   array  $block      The block settings and attributes.
 * @param   string $content    The block content (empty string).
 * @param   bool   $is_preview True during AJAX preview.
 * @param   int    $post_id    Current Post ID.
 */
function testimonial_content ($block, $content = '', $is_preview = FALSE, $post_id = 0)
{
	// create id attribute for specific styling
	$id = 'testimonial-' . $block['id'];

	// create align class ("alignwide") from block setting ("wide")
	$align_class = $block['align'] ? 'align' . $block['align'] : '';

	?>
	<blockquote id="<?php echo $id; ?>" class="testimonial <?php echo $align_class; ?>">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
		<cite>
			<span>Author Name</span>
		</cite>
	</blockquote>
	<?php
}