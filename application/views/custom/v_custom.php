<!DOCTYPE html>
<html>
<?php $this->load->view('_partials/head.php'); ?>
<body class="fadeIn animated">
    <?php $this->load->view('_partials/topbar.php'); ?>
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumbs-main">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url() ?>">Home</a></li>
                    <li class="active">Custom</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="konten">
        <div class="container">
            <!-- <iframe src="<?php echo prep_url('http://demo.gongsoft.com/plugin/customdesign/editor.php?product=10') ?>" height="600px" width="100%" style="margin-top : 25px !important;"></iframe> -->
            <iframe id="iframe" src="<?php echo prep_url('http://localhost/lumise_custom/editor.php?product=3') ?>" height="600px" width="100%" style="margin-top : 25px !important;"></iframe>
        </div>
    </div>
    <?php $this->load->view('_partials/foot.php'); ?>
</body>
<script>
    $(function(){
			var f=$('#iframe')
			f.load(function(){ 
                f.contents().find(`
                    name,
                    price , 
                    desc,
                    #lumise-change-product,
                    #lumise-top-tools,
                    .how-calculate,
                    .lumise-prints,
                    [data-tab="bug"],
                    [data-type="quantity"]
                `).remove()
			})
		})
</script>
</html>