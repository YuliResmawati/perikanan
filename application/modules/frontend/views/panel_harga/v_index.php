

<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Panel Harga</h1>
            </div>
        </div>
    </div>
</section>

<div class="product-tab-outer">
    <div class="container">
        <div class="row">
        <div class="right-sidebar">
            <div class="tab-container">
                <div class="responsive-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a id="tab-A" href="#pane-A" class="nav-link active" data-bs-toggle="tab" role="tab">
                                Grafik Panel Harga
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="tab-B" href="#pane-B" class="nav-link" data-bs-toggle="tab" role="tab">
                                Tabel Panel Harga
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="tab-C" href="#pane-C" class="nav-link" data-bs-toggle="tab" role="tab">
                                Requirement
                            </a>
                        </li>
                    </ul>
                    <div id="nav-tab-content" class="tab-content" role="tablist">
                        <div id="pane-A" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
                            <div class="card-header" role="tab" id="heading-A">
                                <h5 class="mb-0">
                                <a data-bs-toggle="collapse" href="#collapse-A" aria-expanded="true" aria-controls="collapse-A">
                                    Grafik Panel Harga
                                </a>
                                </h5>
                            </div>
                            <div id="collapse-A" class="collapse show" data-bs-parent="#nav-tab-content" role="tabpanel"
                                aria-labelledby="heading-A">
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
                        </div>
                        <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                            <div class="card-header" role="tab" id="heading-B">
                                <h5 class="mb-0">
                                <a class="collapsed" data-bs-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">
                                    Tabel Panel Harga
                                </a>
                                </h5>
                            </div>
                            <div id="collapse-B" class="collapse" data-bs-parent="#nav-tab-content" role="tabpanel"
                                aria-labelledby="heading-B">
                                <div class="card-body">
                                <table>
                                    <tr>
                                        <th>Weight</th>
                                        <td>4 kg</td>
                                    </tr>
                                    <tr>
                                        <th>Dimensions</th>
                                        <td>100 × 45 × 15 cm</td>
                                    </tr>
                                </table>
                                </div>
                            </div>
                        </div>
                        <div id="pane-C" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
                            <div class="card-header" role="tab" id="heading-C">
                                <h5 class="mb-0">
                                <a data-bs-toggle="collapse" href="#collapse-C" aria-expanded="true" aria-controls="collapse-C">
                                    Review
                                </a>
                                </h5>
                            </div>
                            <div id="collapse-C" class="collapse" data-bs-parent="#nav-tab-content" role="tabpanel"
                                aria-labelledby="heading-C">
                                <div class="card-body">
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            <div class="related-product">
            </div>
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