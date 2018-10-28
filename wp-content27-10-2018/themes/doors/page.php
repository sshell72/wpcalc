<?php

$post = get_post(get_the_ID());
get_header();
?>

<?php echo apply_filters('the_content', $post->post_content);

?>



<?php get_footer(); ?>
