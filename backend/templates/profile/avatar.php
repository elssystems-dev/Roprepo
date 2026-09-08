<?php
    $avatar_url = $_SESSION['pfp_url'] ?? '/assets/img/system/default.png'
?>

<img id='pfp-preview' src="<?=$avatar_url?>" class='user-pfp modal-pfp' alt='Avatar Preview'>
<div>
    <label for='avatar-input' class='upload-label'>Select an image file</label>
    <input type='file' name='avatar' id='avatar-input' accept='image/*'>
</div>
<button class='btn'>Change Profile Picture</button>