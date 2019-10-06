<?php
    // $session = sess_data('in_cl');
    $session = $this->session->userdata('in');
    if ($session != TRUE) { redirect('auth'); }
?>