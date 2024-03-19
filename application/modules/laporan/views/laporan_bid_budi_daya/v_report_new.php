<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    
    <style>
    @media print {
      body {
        font-size: 10pt;
      }
      .print-header {
        font-size: 12pt;
        text-align: center;
        margin-bottom: 10px;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
      }
      th, td {
        border: 0.1em solid #000;
        padding: 8px; /* Perubahan: Padding lebih besar */
        text-align: left; /* Perubahan: Teks rata kiri */
      }
      .no-border-bottom td {
        border-bottom: none !important;
      } 
    }

    /* Penambahan untuk responsivitas dan penempatan tabel ke tengah */
    @media (max-width: 767px) {
      .table-responsive {
        overflow-x: auto;
        max-width: 100%;
        margin-bottom: 15px;
      }
    }
    body {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .total-container {
    display: flex;
    /* justify-content: space-between; */
    align-items: center;
  }

  .total-text {
    margin-right: 35rem; /* Sesuaikan jarak sesuai kebutuhan */
  }

.floatedTable {
    float:left;
}
.inlineTable {
    display: inline-block;
}

  </style>

</head>
<body onload="print()">
<!-- <body> -->


<div class="container">
  <div class="row justify-content-center" style="padding-top:5%">
      <div class="col-md-12">
          <div class="d-flex align-items-center justify-content-center">
              <div class="ml-2 text-center">
                  <span class="font-weight-bold" style="font-size: 15px;">DINAS KELAUTAN DAN PERIKANAN PROVINSI SUMATERA BARAT</span><br>
                  <span class="font-weight-bold" style="font-size: 22px;">PAPAN DATA INFORMASI HARGA IKAN KABUPATEN AGAM</span><br>
                  <span style="font-size: 15px;">Jln. Piliang, Lubuk Basung 26415 (Komplek Kantor Bupati Agam)</span><br>
                  <span style="font-size: 15px;">Tlp./Fax. (0752) 66264</span>
              </div>
          </div>
      </div>
  </div>
</div>


  <hr>

  <center>
    <div class="row">
    <div class="table-responsive">
    <div style="overflow: hidden;">
      <table class="table" style="float: left; width: 50%; border-right: 1px solid #000;">
          <thead>
              <tr>
                  <th  width="5%">No</th>
                  <th  width="45%">Ikan Laut</th>
              </tr>
          </thead>
          <tbody>
              <tr>
              </tr>
             
              <!-- Isi tabel 1 berakhir -->
          </tbody>
      </table>
      <table class="table" style="float: right; width: 50%; border-left: 1px solid #000;">
          <thead>
              <tr>
                  <th width="15%">Ikan Tawar</th>
              </tr>
          </thead>
          <tbody>
              <!-- Isi tabel 2 -->
              <tr> 
              </tr>
              <!-- Isi tabel 2 berakhir -->
          </tbody>
      </table>
    </div>
    </div>
    </div>
  </center>



<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

</body>
</html>