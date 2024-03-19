

<div id="collapse-A" class="collapse show" data-bs-parent="#nav-tab-content" role="tabpanel" aria-labelledby="heading-A" id="tab-A">
<div class="card-body">
    <div class="form-group">
        <input type="date" name="name" placeholder="Nama Lengkap">
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="contact-detail-container">
            <canvas id="myChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="contact-detail-container">
            <canvas id="myChart1"></canvas>
            </div>
        </div>
    </div>
</div>
</div>




<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2"></script>

<script type="text/javascript">
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
        <?php
            if (count($chart_harga_panel_bahan)>0) {
            foreach ($chart_harga_panel_bahan as $data) {
                echo "'" .$data->komoditas ."',";
            }
            }
        ?>
        ],
        datasets: [{
            label: 'Komoditi',
            backgroundColor: ['rgb(255, 99, 132)', 'rgba(56, 86, 255, 0.87)', 'rgb(60, 179, 113)', 'rgb(175, 238, 239)'],
            borderColor: ['rgb(255, 99, 132)'],
            data: [
            <?php
                if (count($chart_harga_panel_bahan)>0) {
                foreach ($chart_harga_panel_bahan as $data) {
                    echo $data->harga . ", ";
                }
                }
            ?>
            ]
        }]
    },
    });

    var ctx = document.getElementById('myChart1').getContext('2d');
    var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
        <?php
            if (count($chart_harga_panel_ikan)>0) {
            foreach ($chart_harga_panel_ikan as $data) {
                echo "'" .$data->komoditas ."',";
            }
            }
        ?>
        ],
        datasets: [{
            label: 'Komoditi',
            backgroundColor: ['rgb(255, 99, 132)', 'rgba(56, 86, 255, 0.87)', 'rgb(60, 179, 113)', 'rgb(175, 238, 239)'],
            borderColor: ['rgb(255, 99, 132)'],
            data: [
            <?php
                if (count($chart_harga_panel_ikan)>0) {
                foreach ($chart_harga_panel_ikan as $data) {
                    echo $data->harga . ", ";
                }
                }
            ?>
            ]
        }]
    },
    });
</script>