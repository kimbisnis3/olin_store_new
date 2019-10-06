<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head.php'); ?>
  <style>
    .center-pos {
      max-width: 25%;
      margin: 35px auto;
    }
    .kotak {
      background-color: magenta !important;
    }
  </style>
  <body class="fadeIn animated">
    <?php $this->load->view('_partials/topbar.php'); ?>
    <div class="breadcrumbs">
      <div class="container">
        <div class="breadcrumbs-main">
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>">Home</a></li>
            <li class="active">Login</li>
          </ol>
        </div>
      </div>
    </div>
    <?php $this->load->view('_partials/foot.php'); ?>
  </body>
  
  <script>
    
	</script>
</html>