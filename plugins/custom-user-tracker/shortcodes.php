<?php

  add_shortcode('user_display_saved_posts', function($atts) {
    // [user_display_saved_posts]
    // On User Profile template pages, used to output all posts that user has 'saved' to their profile
    
    $userID = get_current_user_id();
    // Note this displays userID for the CURRENTLY LOGGED IN USER
    // not the ID for the user page currently being viewed
    // Are users only going to be able to view their own profile pages?

    $savedPosts = get_user_meta($userID,'_favorite_posts',false); //false because we want to return ALL matching values

    // If no saved posts, then save ourselves the trouble
    if(empty($savedPosts)){
      return;
    }

    // Template output:
    ob_start();
      get_template_part('template-parts/user/savedPosts', null, $savedPosts);
    return ob_get_clean();

  });



  add_shortcode('user_progress_update', function() {
    // [user_progress_update]
    // Displays a "section complete!" button that triggers a fetch() request to our API when scrolled into browser view

    ob_start();
      get_template_part('template-parts/section-progress-button');
    return ob_get_clean();

  });




  add_shortcode('user_display_section_progress', function() {
    // On user profile template pages, used to output progress for current userID
    
    $userID = get_current_user_id();
    $completedSections = get_user_meta($userID,'_section_progress',false); //false because we want to return ALL matching values

    // Template output:
    ob_start();
      get_template_part('template-parts/user/sectionProgress', null, $completedSections);
    return ob_get_clean();

  });

?>