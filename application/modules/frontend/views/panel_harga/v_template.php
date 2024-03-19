

<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Panel Harga</h1>
            </div>
        </div>
    </div>
</section>

<div class="product-outer-wrap product-wrap">
    <div class="product-tab-outer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 right-sidebar">
                    <div class="tab-container">
                        <div class="responsive-tabs">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active tab-account" id="grafik" aria-current="page" href="#">Grafik Panel Harga </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-account" id="tabel" href="#">Tabel Panel Harga</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-account" id="profile" href="#">Link</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="load"></div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		load_account('grafik');
	});

	$('.tab-account').click(function(){ 
		var id = $(this).attr('id');
		load_account(id);
	});

	function load_account(id) {
		$.ajax({
			url: "<?= site_url('panel_harga_chart/AjaxGet') ?>",
			data: {id: id},
			dataType :"html",
			// error:function() {
			// 	$('#load').unblock();
			// },

			// beforeSend:function(){
			// 	load_page('#load');
			// },

			// success: function(res){
			// 	$('#load').html(res);
			// }
		});
	}
	
</script>


