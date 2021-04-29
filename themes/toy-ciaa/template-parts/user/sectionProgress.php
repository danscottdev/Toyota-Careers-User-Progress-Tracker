<?php

  // Output to user profile template page
  // Display each 'site section' as well as User's progress

  $user_section_progress = $args;

    global $current_user;
    $username = $current_user->display_name;
    $userID = $current_user->ID;


    /*
      Relies on hardcoded page IDs since there's only 4.
      Look into making more scalable later
      
      Resume - 206
      Groom - 310
      LikeFollow - 320
      LinkedIn - 324
    */
?>

  <div>
    <h3>Current Progress for <?php echo $username; ?>:</h3>
    <ul>
      <li>Resume Refuel 
        <?php 
          if(in_array('206', $user_section_progress)){
            echo ' - Section Complete!';
          } else {
            echo '<a href="' . get_permalink(206) . '">View Section Now</a>';
          }
        ?>
        
      </li>
      <li>Groom & Zoom 
        <?php 
          if(in_array('310', $user_section_progress)){
            echo ' - Section Complete!';
            } else {
              echo '<a href="' . get_permalink(310) . '">View Section Now</a>';
            }
        ?>
      </li>
      <li>Like & Follow 
        <?php 
        if(in_array('320', $user_section_progress)){
          echo ' - Section Complete!';
        } else {
          echo '<a href="' . get_permalink(320) . '">View Section Now</a>';
        }
        ?>
      </li>



      <li>LinkedIn Loop 
        <?php 
        if(in_array('324', $user_section_progress)){
          echo ' - Section Complete!';
        } else {
          echo '<a href="' . get_permalink(324) . '">View Section Now</a>';
        }
        ?>
      </li>
     

      <button id="user-reset-progress" onclick='resetSectionProgress()' data-userid="<?php echo $userID; ?>">Reset Progress</button>
    </ul>

    <br/>
    
  </div>


<script>
  function resetSectionProgress(){

    const button = document.getElementById('user-reset-progress');
    const userID = +button.dataset.userid;

  const data = {
    userID: userID
  }

  console.log("sendData: ", data);


  fetch('/wp-json/update-user-progress/reset', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then((data) => {
    // console.log(data);
    location.reload();

  });
}
</script>