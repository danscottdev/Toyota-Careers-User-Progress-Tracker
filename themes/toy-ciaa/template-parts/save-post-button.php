<?php
  // Allow user to save current post to favorites
  // List of all favorited posts then displayed on user's profile page
  // Currently works for single posts... but in theory should also work for all CPTs or anything else that wordpress assigns a postID value
?>


<?php
  // $current_user_ID = get_current_user_id();
  global $current_user;
  // var_dump($current_user);
  $current_user_ID = $current_user->ID;
  $current_user_name = $current_user->display_name;

  // $temp = get_the_author_meta('user_url', $current_user_ID);
  // echo $temp;

  $user_url = "/user/" . $current_user_ID;
  echo $user_url;

  // If user isn't signed in, then don't bother
  if(!$current_user_ID > 0){
    echo '<h3>Sign in to save this post to your favorites</h3>';
  } else {
    
    // posts are saved in the 'wp_usermeta' table, under the '_favorite_posts' meta_key
    $saved_posts = get_user_meta($current_user_ID, '_favorite_posts', false);
    // var_dump($saved_posts);
    
    // Check to see if the user has already saved this post. Set the button text conditionally based on that
    $button_text = '';
    $button_text = in_array(get_the_ID(), $saved_posts) ? 'X UNSAVE' : 'SAVE';
?>


    <p>Currently Logged in as <strong><?php echo $current_user_name; ?></strong></p>
    <div id="like-button" class="like btn btn-default" type="button">
      <span id="like-button-text"><?php echo ($button_text . " THIS POST"); ?></span>
    </div>
    <a href="<?php echo $user_url; ?>">View all your saved posts</a>

    <input type="hidden" value="<?php the_ID(); ?>" id="current-post-id"/>
    <input type="hidden" value="<?php echo get_current_user_id(); ?>" id="current-user-id"/>



  <script>
    // Javascript for saving/unsaving current post to user's favorites

    const likeButton = document.getElementById('like-button');
    const likeButtonText = document.getElementById('like-button-text');

    likeButton.addEventListener('click', function(e){
      e.preventDefault();

      const postID = document.getElementById('current-post-id').value;
      const userID = document.getElementById('current-user-id').value;
      // console.log(postID);

      const data = {
        postID: postID,
        userID : userID
      }

      // Run fetch request to custom API endpoint
      // --> plugins/stilts-custom/rest-api-endpoints.php
      fetch('/wp-json/save-post/all', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
        .then(response => response.json())
        .then((data) => {
          console.log(data);

          if(data.status === 'error'){
            throw Error(data.message);
          }

          // If action was successful, update the save button text
          if(data.status === 'success'){
            if(data.action === 'add'){
              likeButtonText.innerHTML = 'X UNSAVE THIS POST';
            } else if (data.action === 'delete'){
              likeButtonText.innerHTML = 'SAVE THIS POST';
            }
          }


        })
        .catch((error) => {
          console.log(error);
        }); 
      

    }); //eventListener

  </script>

<?php
 } //if/else user logged in
?>