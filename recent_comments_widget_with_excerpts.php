<?php
defined( 'ABSPATH' ) or exit;

/**
 * Plugin Name: Recent Comments Widget with Excerpts
 * Plugin URI: https://github.com/csalzano/recent-comments-widget-with-comment-excerpts/
 * Description: Modifies the built-in recent comments widget to show excerpts instead of post titles
 * Author: Corey Salzano
 * Author URI: https://breakfastco.xyz
 * Version: 1.0.0
 * Text Domain: recent-comments-widget
 */

class WP_Widget_Recent_Comments_Excerpts extends WP_Widget {

	function __construct()
	{
		parent::__construct(
			'recent_comments_widget',
			__( 'Recent Comments', 'recent-comments-widget' ),
			array( 
				'description' => __( 'The most recent comments with excerpts', 'recent-comments-widget' ), 
			)
		);

		add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array(&$this, 'flush_widget_cache') );
	}


	function flush_widget_cache() {
		wp_cache_delete('recent_comments', 'widget');
	}

	function widget( $args, $instance ) {
		global $wpdb, $comments, $comment;

		extract($args, EXTR_SKIP);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Comments') : $instance['title']);
		if ( empty( $instance['number'] ) || ! $number = (int) $instance['number'] )
			$number = 5;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 150 )
			$number = 150;

		if ( !$comments = wp_cache_get( 'recent_comments', 'widget' ) ) {
			$comments = $wpdb->get_results("SELECT $wpdb->comments.* FROM $wpdb->comments JOIN $wpdb->posts ON $wpdb->posts.ID = $wpdb->comments.comment_post_ID WHERE comment_approved = '1' AND post_status = 'publish' ORDER BY comment_date_gmt DESC LIMIT 150");
			wp_cache_add( 'recent_comments', $comments, 'widget' );
		}

		$comments = array_slice( (array) $comments, 0, $number );

		//how many characters in length should the comment excerpts be?
		$excerptLen = empty( $instance['length'] ) ? 50 : absint( $instance['length'] );
		
		echo $before_widget;
		
		if ( $title )
		{
			echo $before_title . $title . $after_title;
		}
		echo '<ul id="recentcomments">';
		if ( $comments )
		{
			foreach ( (array) $comments as $comment)
			{
				$aRecentComment = get_comment($comment->comment_ID);
				$aRecentCommentTxt = trim( mb_substr( strip_tags( apply_filters( 'comment_text', $aRecentComment->comment_content ?? '' )), 0, $excerptLen ));
				if(strlen($aRecentComment->comment_content ?? '')>$excerptLen)
				{
					$aRecentCommentTxt .= "...";
				}
		
				printf( 
					'<li class="recentcomments"><span class="recentcommentsauthor">%s</span> %s <a href="%s">%s</a></li>',
					get_comment_author_link(),
					__( 'said', 'recent-comments-widget' ),
					esc_url( get_comment_link($comment->comment_ID) ),
					$aRecentCommentTxt
				);
			}
		}
		echo '</ul>' . $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_comments']) )
			delete_option('widget_recent_comments');

		return $instance;
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = empty( $instance['number'] ) ? 5 : absint($instance['number'] );
		$length = empty( $instance['length'] ) ? 50 : absint( $instance['length'] );
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'recent-comments-widget' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of comments to show (at most 150):', 'recent-comments-widget' ); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e( 'Comment excerpt character count:', 'recent-comments-widget' ); ?></label>
			<input id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" value="<?php echo $length; ?>" />
		</p>
<?php
	}
}

function WP_Widget_Recent_Comments_Excerpts_Init() {
	register_widget('WP_Widget_Recent_Comments_Excerpts');
}
add_action('widgets_init', 'WP_Widget_Recent_Comments_Excerpts_Init');
