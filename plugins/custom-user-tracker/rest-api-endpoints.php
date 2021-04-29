<?php
  // Register custom API endpoints for user-tracking and user-save-post features

  add_action('rest_api_init','create_endpoints');


  function create_endpoints() {

    // Update saved progress as user progresses through the site
    register_rest_route('update-user-progress', 'all', [
      'methods' => 'POST',
      'callback' => 'custom_api_UPDATE_USER_PROGRESS_callback',
      'permission_callback' => '__return_true'
    ]);

    // Reset saved progress for given user
    register_rest_route('update-user-progress', 'reset', [
      'methods' => 'POST',
      'callback' => 'custom_api_RESET_USER_PROGRESS_callback',
      'permission_callback' => '__return_true'
    ]);

    // Allow logged-in user to save posts to their account profile page
    register_rest_route('save-post', 'all', [
      'methods' => 'POST',
      'callback' => 'custom_api_SAVEPOST_callback',
      'permission_callback' => '__return_true'
    ]);
    
  }


  function custom_api_UPDATE_USER_PROGRESS_callback($request){
    // Track user progress as they progress through the site
    // When the user completes a given section, front-end sends an automated request via AJAX to this endpoint
    // Creates a custom '_section_progress' row in the WP 'user_metadata' database table

    // /wp-json/update-user-progress/all

    // inputs => userID, sectionID


    $body = $request->get_json_params();
    $data = array();

    // If either of our required inputs aren't set, abandon ship
    if(!isset($body['sectionID']) || !isset($body['userID'])){
      $data['status'] = 'error';
      $data['message'] = 'Missing Section ID or User ID';
      return $data;
    }

    // Extract relevant data
    $sectionID   = sanitize_text_field($body['sectionID']);
    $userID   = sanitize_text_field($body['userID']);

    // Get user's current saved progress
    $user_meta = get_user_meta($userID,'_section_progress',false);

    // If current section is already completed, do nothing. Otherwise add to progress
    if( in_array( $sectionID, $user_meta ) ){
        $data['status'] = 'success';
        $data['action'] = 'none';
        $data['message'] = 'SECTION ID ' . $sectionID . ' already completed for USER ID ' . $userID;
        return $data;
    } else {
        add_user_meta($userID,'_section_progress',$sectionID);
        $data['status'] = 'success';
        $data['action'] = 'add';
        $data['message'] = 'UPDATED: Section ID ' . $sectionID . ' saved as completed for UserID ' . $userID;
        return $data;
    }

  }





  function custom_api_RESET_USER_PROGRESS_callback($request){
    // Reset user's saved progress
    // clears out custom row in user_metadata database table

    // inputs: userID

    $body = $request->get_json_params();
    $userID   = sanitize_text_field($body['userID']);
    delete_user_meta($userID,'_section_progress');
    return "UPDATED: Section Progress reset for user " . $userID . "." ;

  }





  function custom_api_SAVEPOST_callback($request){
    // When logged-in user clicks 'save this post':
    // this function creates an entry in the wp_usermeta database table,
    // which consists of the User's ID, meta_key = '_favorite_posts', and meta_value = {#POSTID}

    
    // Relevant Data passed in via fetch() as JSON should include the current Post ID and the User's ID
    $body = $request->get_json_params();

    $data = array();

    // If either of our required inputs aren't set, abandon ship
    if(!isset($body['postID']) || !isset($body['userID'])){
      $data['status'] = 'error';
      $data['message'] = 'Missing Post ID or User ID';
      return $data;
    }

    // Extract relevant data
    $postID   = sanitize_text_field($body['postID']);
    $userID   = sanitize_text_field($body['userID']);

    // Get user's current 'saved posts'
    $user_meta = get_user_meta($userID,'_favorite_posts',false);

    // If current post is already 'saved', then un-save it. Otherwise save it
    if( in_array( $postID, $user_meta ) ){
        delete_user_meta($userID,'_favorite_posts',$postID);
        $data['status'] = 'success';
        $data['action'] = 'delete';
        $data['message'] = 'UNSAVED: Post ' . $postID . ' unsaved for UserID ' . $userID;
        return $data;
    } else {
        add_user_meta($userID,'_favorite_posts',$postID);
        $data['status'] = 'success';
        $data['action'] = 'add';
        $data['message'] = 'SAVED: Post ' . $postID . ' saved for UserID ' . $userID;
        return $data;
    }

  }

?>