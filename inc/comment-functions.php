<?php

/**
 * Comment functions and definitions
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.2
 */

/**
 * Enqueues comment scripts.
 */
function zan_comment_scripts()
{
	if (is_singular() && comments_open()) {

		add_action('wp_print_footer_scripts', 'zan_output_comment_help_html_in_script');

		if (get_theme_mod('rich_comment_editor', 1) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') === false) {

			wp_enqueue_style('editor-buttons');

			wp_enqueue_script('editor');

			wp_enqueue_script('wp-tinymce');

			add_action('wp_print_footer_scripts', 'zan_init_comment_tinymce', 50);
		}

		if (get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
}
add_action('wp_enqueue_scripts', 'zan_comment_scripts');

function zan_comment_form()
{
	$req = get_option('require_name_email');
	$html_req = ($req ? " required='required'" : '');
	$commenter     = wp_get_current_commenter();

	$fields = array(
		'author' => sprintf(
			'<div class="row"><div class="col-sm-4">%s<div class="comment-form-author input-group"><span class="input-group-addon"><i class="fas fa-user"></i></span>%s</div></div>',
			sprintf(
				'<label class="screen-reader-text" for="author">%s%s</label>',
				__('Name'),
				($req ? ' <span class="required">*</span>' : '')
			),
			sprintf(
				'<input class="form-control" id="author" name="author" type="text" placeholder="%s" value="%s" size="30" maxlength="245"%s />',
				__('Name') . ($req ? '*' : ''),
				esc_attr($commenter['comment_author']),
				$html_req
			)
		),
		'email'  => sprintf(
			'<div class="col-sm-4">%s<div class="comment-form-email input-group"><span class="input-group-addon"><i class="fas fa-envelope"></i></span>%s</div></div>',
			sprintf(
				'<label class="screen-reader-text" for="email">%s%s</label>',
				__('Email'),
				($req ? ' <span class="required">*</span>' : '')
			),
			sprintf(
				'<input class="form-control" id="email" name="email" type="email" placeholder="%s" value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />',
				__('Email') . ($req ? '*' : ''),
				esc_attr($commenter['comment_author_email']),
				$html_req
			)
		),
		'url'    => sprintf(
			'<div class="col-sm-4">%s<div class="comment-form-url input-group"><span class="input-group-addon"><i class="fas fa-link"></i></span>%s</div></div></div>',
			sprintf(
				'<label class="screen-reader-text" for="url">%s</label>',
				__('Website')
			),
			sprintf(
				'<input class="form-control" id="url" name="url" type="url" placeholder="%s" value="%s" size="30" maxlength="200" />',
				__('Website'),
				esc_attr($commenter['comment_author_url'])
			)
		),
	);

	ob_start(); ?>
	<div class="comment-form-comment">
		<label class="screen-reader-text" for="comment"><?php _ex('Comment', 'noun'); ?></label>
		<?php if (get_theme_mod('rich_comment_editor', 1) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') === false) : ?>
			<div class="comment-editor-wrap comment-tmce-active">
				<div class="comment-editor-tabs">
					<button type="button" class="btn comment-switch-html"><i class="fas fa-code"></i> <?php _ex('Text', 'Name for the Text editor tab (formerly HTML)'); ?></button><button type="button" class="btn comment-switch-tmce"><i class="fas fa-eye"></i> <?php _ex('Visual', 'Name for the Visual editor tab'); ?></button>
				</div>
				<div class="clearfix"></div>
				<div class="comment-editor-container">
					<textarea style="display: none;" class="comment-textarea" id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea>
					<div id="comment-tinymce" class="comment-tinymce"></div>
				</div>
			</div>
		<?php else : ?>
			<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea>
		<?php endif; ?>
	</div>
	<p class="comment-mail-notify">
		<input id="wp-comment-mail-notify" name="wp-comment-mail-notify" type="checkbox" value="yes">
		<label for="wp-comment-mail-notify"><?php _e('Notify me of follow-up comments via email.', 'zanblog-plus'); ?></label>
	</p>
<?php
	$comment_field = ob_get_clean();

	comment_form(
		array(
			'title_reply'          => '<i class="fas fa-pen"></i> ' . __('Leave a Reply'),
			'fields'               => $fields,
			'class_submit'         => 'submit btn btn-danger btn-block',
			'comment_field'        => $comment_field,
			'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title alert alert-info"><button class="comment-help-btn btn"><i class="fas fa-question-circle"></i> ' . __('Help') . '</button><span>',
			'title_reply_after'    => '</span></h3>',
		)
	);
}

function zan_output_comment_help_html_in_script()
{
	$tag_descriptions = array(
		'a'          => _x('Link to <a href="#comment-help-modal">another page</a> using the <code>href</code> attribute', 'tag-description', 'zanblog-plus'),
		'abbr'       => _x('Define <abbr title="Here is the value of the title attribute">an abbreviation or an acronym</abbr> using the <code>title</code> attribute', 'tag-description', 'zanblog-plus'),
		'blockquote' => _x('Define a section that is quoted from another source', 'tag-description', 'zanblog-plus'),
		'code'       => _x('Used to show <code>inline computer code</code>', 'tag-description', 'zanblog-plus'),
		'del'        => _x('<del>Strike a line</del> through text', 'tag-description', 'zanblog-plus'),
		'em'         => _x('Display the text in <em>italic</em>', 'tag-description', 'zanblog-plus'),
		'q'          => _x('Insert <q>quotation marks</q> around the text', 'tag-description', 'zanblog-plus'),
		'strong'     => _x('Display the text in <strong>bold</strong>', 'tag-description', 'zanblog-plus'),
	);

	ob_start();
?>
	<div class="modal fade comment-help-modal" id="comment-help-modal" tabindex="-1" role="dialog" aria-labelledby="comment-help-modal-title">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
					<h4 class="modal-title" id="comment-help-modal-title"><?php _e('Comment Help', 'zanblog-plus') ?></h4>
				</div>
				<div class="modal-body">
					<h4><?php _e('You can use following HTML Tags in your comment:', 'zanblog-plus') ?></h4>
					<table>
						<tbody>
							<?php
							echo '<tr><th>' . __('Tag', 'zanblog-plus') . '</th><th>' . __('Description', 'zanblog-plus') . '</th></tr>';
							global $allowedtags;
							if (is_array($allowedtags)) {
								foreach ($allowedtags as $tag => $attrs) {
									if (array_key_exists($tag, $tag_descriptions)) {
										echo '<tr><td><code>&lt;' . $tag . '&gt;</code></td><td>' . $tag_descriptions[$tag] . '</td></tr>';
									}
								}
							}
							echo '<tr><td><code>&lt;br&gt;</code></td><td>' . _x('Insert a line break (Only available in Visual mode. Wrap directly in Text mode to obtain the same effect.)', 'tag-description', 'zanblog-plus') . '</td></tr>';
							echo '<tr><td><code>&lt;p&gt;</code></td><td>' . _x('Define a paragraph (Only available in Visual mode. Wrap twice in Text mode to begin a new paragraph.)', 'tag-description', 'zanblog-plus') . '</td></tr>';
							?>
						</tbody>
					</table>
					<?php
					global $SyntaxHighlighter;
					if (isset($SyntaxHighlighter) && count($SyntaxHighlighter->brush_names) > 0) : ?>
						<h4><?php _e('You can use following shortcodes to format your source code, e.g. <code>[php]your code here[/php]</code>', 'zanblog-plus') ?></h4>
						<table>
							<tbody>
								<?php
								echo '<tr><th>' . __('Shortcode', 'zanblog-plus') . '</th><th>' . __('Language', 'zanblog-plus') . '</th></tr>';
								foreach ($SyntaxHighlighter->brush_names as $brush => $name) {
									echo '<tr><td><code>[' . $brush . ']</code></td><td>' . $name . '</td></tr>';
								}
								?>
							</tbody>
						</table>
					<?php
					endif;
					if (class_exists('\\SimpleMathJax')) {
						echo '<h4>' . __('You can use common LaTeX commands to enter math formulas, e.g. <code>$\LaTeX$</code> and <code>\begin{equation}E=mc^2\end{equation}</code>', 'zanblog-plus') . '</h4>';
					}
					?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><?php _e('Close'); ?></button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
<?php
	$help_html = ob_get_clean();
	echo '<script> window._comment_help_html = ' . wp_json_encode($help_html) . '; </script>';
}

function zan_init_comment_tinymce()
{
	$mce_locale = get_user_locale();
	$mce_locale = empty($mce_locale) ? 'en' : strtolower(substr($mce_locale, 0, 2)); // ISO 639-1.
?>
	<script>
		tinymce.addI18n('<?php echo $mce_locale; ?>',
			<?php
			echo wp_json_encode(array(
				'Bold'                                 => __('Bold'),
				'Italic'                               => __('Italic'),
				'Strikethrough'                        => __('Strikethrough'),
				'Insert/edit link'                     => __('Insert/edit link'),
				'Remove link'                          => __('Remove link'),
				'Code'                                 => __('Code'),
				'Blockquote'                           => __('Blockquote'),
				'Clear formatting'                     => __('Clear formatting'),
				'Emoticons'                            => __('Emoticons'),

				// Link plugin.
				'Link'                                 => __('Link'),
				'Insert link'                          => __('Insert link'),
				'Target'                               => __('Target'),
				'New window'                           => __('New window'),
				'Text to display'                      => __('Text to display'),
				'Url'                                  => __('URL'),
				'Title'                                => __('Title'),
				'None'                                 => __('None'),
				'Ok'                                   => __('OK'),
				'Cancel'                               => __('Cancel'),
				'The URL you entered seems to be an email address. Do you want to add the required mailto: prefix?' =>
				__('The URL you entered seems to be an email address. Do you want to add the required mailto: prefix?'),
				'The URL you entered seems to be an external link. Do you want to add the required http:// prefix?' =>
				__('The URL you entered seems to be an external link. Do you want to add the required http:// prefix?'),

			));
			?>
		);
		window.tinymce.init({
			selector: '#comment-tinymce',
			plugins: "link,paste,wordpress,wpemoji,emojipanel",
			toolbar1: "bold,italic,strikethrough,link,unlink,wp_code,blockquote,removeformat,emoticons",
			external_plugins: {
				'emojipanel': "<?php echo get_template_directory_uri() . '/assets/js/tinymce4-emojipanel.min.js' ?>"
			},
			content_css: "<?php echo get_template_directory_uri() . '/assets/css/emojipanel.min.css' ?>",
			inline: true,
			convert_urls: false,
			relative_urls: false,
			remove_script_host: false,
			menubar: false,
			language: "<?php echo $mce_locale; ?>",
			formats: {
				strikethrough: {
					inline: "del",
					deep: true,
					split: true
				}
			},
			setup: function(editor) {
				editor.on('postrender', function(e) {
					var emoticons = editor.buttons.emoticons;
					if (typeof emoticons !== 'undefined') {
						var originalOnpostrender = emoticons.onpostrender;
						emoticons.onpostrender = function(e) {
							typeof originalOnpostrender !== 'undefined' && originalOnpostrender(e);
							e.target.$el.find('i').css('padding-top', '2.5px');
						}
					}
				});
			},
			emojipanel_sprites_url: "<?php echo get_template_directory_uri() . '/assets/img/twemoji.c83f003a.png' ?>"
		})
	</script>
<?php
}

/**
 * Add an option "whether notify the comment's author of follow-up comments via email"
 * to the comment's metadata.
 *
 * @since ZanBlog Plus 1.1
 *
 * @param array   $commentdata     Comment Data.
 * @return array Processed Comment Data.
 */
function zan_preprocess_comment_mail_notify($commentdata)
{
	if (isset($_POST['wp-comment-mail-notify'])) {
		if (!isset($commentdata['comment_meta']) || !is_array($commentdata['comment_meta'])) {
			$commentdata['comment_meta'] = array();
		}
		$commentdata['comment_meta']['mail_notify'] = 1;
	}
	return $commentdata;
}
add_filter('preprocess_comment', 'zan_preprocess_comment_mail_notify');

/**
 * Notify the parental comment's author via wp_mail if a new comment replied.
 *
 * @since ZanBlog Plus 1.1
 *
 * @param WP_Comment $comment    Comment object.
 * @return bool Whether the mail is sent or not.
 */
function zan_comment_mail_notify($comment)
{
	if ($comment->comment_parent == 0) {
		return false;
	}

	$parent = get_comment($comment->comment_parent);

	if (empty($parent) || 1 != get_comment_meta($comment->comment_parent, 'mail_notify', true)) {
		return false;
	}

	if ('1' != $parent->comment_approved) {
		return false;
	}

	if ($comment->comment_author_email == $parent->comment_author_email) {
		return false;
	}

	$post   = get_post($comment->comment_post_ID);

	if (empty($post)) {
		return false;
	}

	$switched_locale = switch_to_locale(get_locale());

	// The blogname option is escaped with esc_html() on the way into the database in sanitize_option().
	// We want to reverse this for the plain text arena of emails.
	$blogname        = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	$reply_content   = wp_specialchars_decode($comment->comment_content);
	$comment_content = wp_specialchars_decode($parent->comment_content);

	/* translators: %s: Post title. */
	$notify_message = sprintf(__('Your comment on post "%s" has a new reply.', 'zanblog-plus'), $post->post_title);
	$notify_message .= __('(This email is sent automatically. Please don\'t reply.)', 'zanblog-plus');
	/* translators: %s: Comment text. */
	$notify_message .= str_replace("\n", "\n> ", "\r\n" . $comment_content) . "\r\n\r\n";

	/* translators: %s: Comment author's name*/
	$notify_message .= sprintf(__('Author: %s', 'zanblog-plus'), $comment->comment_author) . "\r\n";
	/* translators: %s: Comment text. */
	$notify_message .= sprintf(__('Reply: %s', 'zanblog-plus'), "\r\n" . $reply_content) . "\r\n\r\n";
	/* translators: %s: Comment URL. */
	$notify_message .= sprintf(__('Permalink: %s'), get_comment_link($comment)) . "\r\n";

	/* translators: Comment notification email subject. %s: Site title */
	$subject = sprintf(__('[%s] Your comment has a new reply', 'zanblog-plus'), $blogname);

	$wp_email = 'wordpress@' . preg_replace('#^www\.#', '', wp_parse_url(network_home_url(), PHP_URL_HOST));

	if ('' === $comment->comment_author) {
		$from = "From: \"$blogname\" <$wp_email>";
	} else {
		$from = "From: \"$comment->comment_author\" <$wp_email>";
	}

	$message_headers = "$from\n"
		. 'Content-Type: text/plain; charset="' . get_option('blog_charset') . "\"\n";

	wp_mail($parent->comment_author_email, wp_specialchars_decode($subject), $notify_message, $message_headers);

	if ($switched_locale) {
		restore_previous_locale();
	}

	return true;
}
add_action('comment_unapproved_to_approved', 'zan_comment_mail_notify');

function zan_comment_post_mail_notify($comment_ID, $comment_approved)
{
	if ('1' == $comment_approved) {
		$comment = get_comment($comment_ID);
		zan_comment_mail_notify($comment);
	}
}
add_action('comment_post', 'zan_comment_post_mail_notify', 10, 2);
