<div class="row">
    <div class="col-xl-3 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="font-13 text-muted text-uppercase">Menu</h6>
                <div class="list-group list-group-flush mt-2 font-15">
                    <a href="#" id="account" data-toggle="tab" class="tab-menu list-group-item list-group-item-action border-0 active"><i class='mdi mdi-account font-16 mr-1'></i> Akun</a>
                    <a href="#" id="device" data-toggle="tab" class="tab-menu list-group-item list-group-item-action border-0"><i class='mdi mdi-devices font-16 mr-1'></i> Perangkat Saya</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-8">
        <div id="load"></div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		load_account('account');
	});

	$('.tab-menu').click(function(){ 
		var id = $(this).attr('id');
		load_account(id);
	});

	function load_account(id) {
		$.ajax({
			url: "<?= site_url('profile/AjaxGet') ?>",
			data: {id: id},
			dataType :"html",
			error:function() {
				$('#load').unblock();
			},

			beforeSend:function(){
				load_page('#load');
			},

			success: function(res){
				$('#load').html(res);
			}
		});
	}
	
</script>

