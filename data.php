<?php
include 'header.php';
$w  = isset($_GET['w']) ? $_GET['w'] : '';
$m  = isset($_GET['m']) ? $_GET['m'] : '';
$db = new Db();
if(isset($_POST['tambah'])){
    $tambah = $_POST['tambah'];
    $q1 = $db->insert('data',$tambah);
    if($q1>0){
        header('Location: data.php?w=tambah&m=ok');
    }
}

if(isset($_POST['ubah'])){
    $ubah = $_POST['ubah'];
    $q1 = $db->update('data',$ubah,"WHERE data_id='{$ubah['data_id']}'");
    if($q1>0){
        header('Location: data.php?w=ubah&m=ok');
    }
}

if(isset($_POST['hapus'])){
    $hapus = $_POST['hapus'];
    $q1 = $db->query("DELETE FROM data WHERE data_id = '{$hapus['data_id']}'");
    if($q1>0){
        header('Location: data.php?w=hapus&m=ok');
    }
}
$q2 = $db->query("SELECT * FROM data");
$modal = '';
?>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebar.php';?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- DataTales -->
                    <div class="card shadow mb-4 mt-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h6 class="m-0 font-weight-bold text-primary align-middle d-inline">Data</h6>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Data</button>
                                    <!-- <button class="btn btn-sm btn-success float-right mr-2" data-toggle="modal" data-target="#import"><i class="fas fa-file-excel"></i> Import Data</button> -->
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-body">
                        <!-- Warning -->
                          <?php if($w=='tambah' && $m=='ok') { ?>
                          <div class="alert alert-success alert-dismissible" role="alert">
                             Data berhasil ditambahkan!
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                             </button>
                          </div>
                          <?php } elseif($w=='tambah' && $m=='no') { ?>
                          <div class="alert alert-danger alert-dismissible" role="alert">
                          Data gagal ditambahkan!
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                             </button>
                          </div>
                          <?php } ?>
                          <?php if($w=='ubah' && $m=='ok') { ?>
                          <div class="alert alert-success alert-dismissible" role="alert">
                          Data berhasil diubah!
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                             </button>
                          </div>
                          <?php } elseif($w=='ubah' && $m=='no') { ?>
                          <div class="alert alert-danger alert-dismissible" role="alert">
                          Data gagal diubah!
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                             </button>
                          </div>
                          <?php } ?>
                          <?php if($w=='hapus' && $m=='ok') { ?>
                          <div class="alert alert-success alert-dismissible" role="alert">
                         Data berhasil dihapus!
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                             </button>
                          </div>
                          <?php } elseif($w=='hapus' && $m=='no') { ?>
                          <div class="alert alert-danger alert-dismissible" role="alert">
                          Data gagal dihapus!
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                             </button>
                          </div>
                          <?php } ?>
                          <!-- End of Warning -->
                        <?php if(empty($q2)){ ?>
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="fas fa-info"></i> &nbsp;Belum ada data. Silahkan tambahkan dulu!
                         </div>
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Pekerjaan</th>
                                            <th>Posisi</th>
                                            <th>Lokasi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=0; foreach($q2 as $item) { $i++;?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $item['nama'];?></td>
                                            <td><?php echo $item['alamat'];?></td>
                                            <td><?php echo $item['pekerjaan'];?></td>
                                            <td><?php echo $item['posisi'];?></td>
                                            <td><?php echo $item['lokasi'];?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit<?php echo $item['data_id'];?>"><i class="fas fa-pencil-alt"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapus<?php echo $item['data_id'];?>"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    <?php 
                                        $modal .=                     
'<!-- Modal Edit -->
<div class="modal fade" id="edit'.$item['data_id'].'" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="">
      <div class="modal-body">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" aria-describedby="nama" placeholder="Masukkan nama" name="ubah[nama]" value="'.$item['nama'].'">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input type="text" class="form-control" aria-describedby="alamat" placeholder="Masukkan alamat" name="ubah[alamat]" value="'.$item['alamat'].'">
          </div>
          <div class="form-group">
            <label>Pekerjaan</label>
            <input type="text" class="form-control" aria-describedby="pekerjaan" placeholder="Masukkan pekerjaan" name="ubah[pekerjaan]" value="'.$item['pekerjaan'].'">
          </div>
          <div class="form-group">
            <label>Posisi</label>
            <input type="text" class="form-control" aria-describedby="posisi" placeholder="Masukkan posisi" name="ubah[posisi]" value="'.$item['posisi'].'">
          </div>
          <div class="form-group">
            <label>Lokasi</label>
            <input type="text" class="form-control" aria-describedby="nama" placeholder="Masukkan lokasi" name="ubah[lokasi]" value="'.$item['lokasi'].'">
          </div>
          <input type="hidden" name="ubah[data_id]" value="'.$item['data_id'].'">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Hapus -->
<div class="modal fade" id="hapus'.$item['data_id'].'" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Yakin ingin menghapus?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="">
      <div class="modal-body">
          <p>Klik hapus untuk menghapus!</p>
          <input type="hidden" name="hapus[data_id]" value="'.$item['data_id'].'">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Hapus</button>
      </div>
      </form>
    </div>
  </div>
</div>
';

                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
<!-- Modal Tambah -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="">
      <div class="modal-body">
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" aria-describedby="nama" placeholder="Masukkan nama" name="tambah[nama]">
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" class="form-control" id="alamat" aria-describedby="alamat" placeholder="Masukkan alamat" name="tambah[alamat]">
          </div>
          <div class="form-group">
            <label for="pekerjaan">Pekerjaan</label>
            <input type="text" class="form-control" id="pekerjaan" aria-describedby="pekerjaan" placeholder="Masukkan pekerjaan" name="tambah[pekerjaan]">
          </div>
          <div class="form-group">
            <label for="posisi">Posisi</label>
            <input type="text" class="form-control" id="posisi" aria-describedby="posisi" placeholder="Masukkan posisi" name="tambah[posisi]">
          </div>
          <div class="form-group">
            <label for="lokasi">Lokasi</label>
            <input type="text" class="form-control" id="lokasi" aria-describedby="nama" placeholder="Masukkan lokasi" name="tambah[lokasi]">
          </div>
          <input type="hidden" name="tambah[data_id]" value="<?php echo getId();?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Tambah</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Import -->
<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Import Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="" enctype="multipart/form-data">
      <div class="modal-body">
          <p>Pastikan data yang akan Anda import sesuai dengan template excel ini.</p>
          <input type="file" class="form-control customFile" name="excel" accept=".xls,.xlsx" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
        <button type="submit" name="import" class="btn btn-success">Import</button>
      </div>
      </form>
    </div>
  </div>
</div>
<style type="text/css">
.customFile {
  padding: 0 !important;
  border: 1px solid #ced4da !important;
}
input[type=file]::file-selector-button {
  background: #DDE0E3;
  border: none;
  height: 100%;
  margin: ;
  color: #595959;
  font-size: 16px;
  padding: 0 10px;
}
</style>
<?php 
echo $modal;
include 'footer.php';?>
            