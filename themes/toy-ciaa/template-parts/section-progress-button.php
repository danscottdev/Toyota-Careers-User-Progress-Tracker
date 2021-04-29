<?php
  global $current_user;
  global $post;

  $current_user_ID = $current_user->ID;
  $current_post_ID = $post->ID;

?>

<span 
  id="road-to-employment-section-completed"
  style="visibility: hidden; height: 1px; width: 1px" 
  data-userid="<?php echo $current_user_ID; ?>" 
  data-sectionid="<?php echo $current_post_ID; ?>">
</span>


<script>
  // Progress Toggle to update user progress through the site

  const progressToggle = document.getElementById('road-to-employment-section-completed');

  if(progressToggle){
    let options = {
      root: null, //default to browser viewport
      threshold: 1.0
    }
    
    let observer = new IntersectionObserver(updateUserProgress, options);
    observer.observe(progressToggle);

    function updateUserProgress(entries, observer){
      entries.forEach((entry) => {
        if(entry.isIntersecting){
          console.log("section complete!");

            const postID = progressToggle.dataset.sectionid;
            const userID = progressToggle.dataset.userid;

            const data = {
              sectionID: postID,
              userID : userID
            }

            console.log("send data: ", data);

            fetch('/wp-json/update-user-progress/all', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then((data) => {
                console.log("response data: ", data);

                if(data.status === 'error'){
                  throw Error(data.message);
                }

                // If action was successful, update the save button text
                if(data.status === 'success'){
                  if(data.action === 'add'){
                   
                  } else if (data.action === 'delete'){
                   
                  }
                }


              })
              .catch((error) => {
                console.log(error);
              }); 


        }
      });
    }
  }

</script>