<?php

  // Called via [user_display_saved_posts] shortcode
  // Displays all 'saved posts' for a user on their profile page



  // $args currently defined in shortcodes.php, where this template-part is called
  // consists of an array of post IDs that the user has saved
  $user_saved_posts = $args;

  // Run a WP query, only match post IDs that the user has saved
  $saved_post_query = new WP_Query( array(
      'post__in' => $user_saved_posts
    )
  );

  if($saved_post_query->have_posts()):
    global $current_user;
    $username = $current_user->display_name;
?>

  <div>
    <h3>Saved Posts for <?php echo $username; ?>:</h3>
    <ul>

      <?php
        while($saved_post_query->have_posts()):
          $saved_post_query->the_post();
        ?>

          <li>
            <a href="<?php echo get_the_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </li>

      <?php
        endwhile;
      ?>

    </ul>
  </div>

<?php
  endif;
?>