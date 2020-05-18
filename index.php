<?php
  $server = "localhost";
  $user = "root";
  $pass = "";
  $database = "dblatihan";

  $koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

  if (isset($_POST['bsimpan'])) {
    $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nama_kota, PDP, ODP, Positif, Zona)
                                      VALUES ('$_POST[tkota]', '$_POST[tpdp]', '$_POST[todp]', '$_POST[tpositif]', '$_POST[tzona]')
                          ");
    if ($simpan) {
      echo "<script>
                  alert('simpan data sukses!');
                  document.location='index.php';
            </script>";
    }
    else {
      echo "<script>
                  alert('simpan data GAGAL!');
                  document.location='index.php';
            </script>";    }
  }

  if (isset($_GET['hal'])) {
      if ($_GET['hal'] == "Edit") {
        $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_kota = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
          $vkota = $data['nama_kota'];
          $vpdp = $data['PDP'];
          $vodp = $data['ODP'];
          $vpositif = $data['Positif'];
          $vzona = $data['Zona'];
        }
      }
      else if ($_GET['hal'] == "Delete"){
          $delete = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_kota = '$_GET[id]'");
          if ($delete) {
            echo "<script>
                        alert('delete data sukses!');
                        document.location='index.php';
                  </script>";          }
      }
  }


 ?>




<!DOCTYPE html>
<html>
<head>
    <meta>
    <title> data positif corona </title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1 class="text-center"> Data Penyebaran CoronaVirus di Indonesia </h1>

    <div class="card mt-3">
      <div class="card-header bg-primary text-white" >
        Data tiap kota
      </div>
      <div class="card-body">
        <form  action="" method="post">
          <div class="form-group">
            <label> Nama Kota </label>
            <input type="text" name="tkota" value="<?=@$vkota ?>" class="form-control" placeholder="tulis nama kota" required>
          </div>
          <div class="form-group">
            <label> Data Pasien Dalam Pengawasan </label>
            <input type="text" name="tpdp" value="<?=@$vpdp ?>" class="form-control" placeholder="jumlah pasien" required>
          </div>
          <div class="form-group">
            <label> Data Orang Dalam Pemantauan </label>
            <input type="text" name="todp" value="<?=@$vodp ?>" class="form-control" placeholder="jumlah pasien" required>
          </div>
          <div class="form-group">
            <label> Data Positif CoronaVirus </label>
            <input type="text" name="tpositif" value="<?=@$vpositif ?>"class="form-control" placeholder="jumlah pasien" required>
          </div>
          <div class="form-group">
            <label> kawasan zona </label>
            <select class="form-control" name="tzona">
              <option value="<?=@$vzona ?>"></option>
              <option value="merah"> zona merah / bahaya </option>
              <option value="aman"> zona aman </option>
            </select>
          </div>
          <button type="submit" class="btn btn-success" name="bsimpan"> simpan </button>
          <button type="reset" class="btn btn-danger" name="breset"> reset </button>
        </form>
      </div>
    </div>



    <div class="card mt-3">
      <div class="card-header bg-warning " >
          Daftar Penyebaran CoronaVirus
      </div>
      <div class="card-body">
          <table class="table table-bordered table-striped">
            <tr>
              <th>No.</th>
              <th>Nama Kota</th>
              <th>Jumlah PDP</th>
              <th>Jumlah ODP</th>
              <th>Jumlah Positif</th>
              <th>Zona</th>
              <th>Aksi</th>
            </tr>
<?php
  $no = 1;
  $tampil = mysqli_query($koneksi, "SELECT*from tmhs order by id_kota desc");
  while ($data = mysqli_fetch_array($tampil)) :

 ?>

            <tr>
              <th><?=$no++; ?></th>
              <th><?=$data['nama_kota'] ?></th>
              <th><?=$data['PDP'] ?></th>
              <th><?=$data['ODP'] ?></th>
              <th><?=$data['Positif'] ?></th>
              <th><?=$data['Zona'] ?> </th>
              <th>
                  <a href="index.php?hal=Edit&id=<?=$data['id_kota'] ?>" class="btn btn-warning"> Edit </a>
                  <a href="index.php?hal=Delete&id=<?=$data['id_kota'] ?>" onclick="return confirm ('apakah anda ingin menghapus data ini? ')" class="btn btn-danger"> Delete </a>
              </th>
            </tr>

<?php
endwhile;
 ?>
          </table>
      </div>
    </div>

  </div>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
