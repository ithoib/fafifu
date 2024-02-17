<?php
include 'header.php';
$w  = isset($_GET['w']) ? $_GET['w'] : '';
$m  = isset($_GET['m']) ? $_GET['m'] : '';
$db = new Db();
if(isset($_POST['tambah'])){
    $tambah = $_POST['tambah'];
    $q1 = $db->insert('template',$tambah);
    if($q1>0){
        header('Location: template.php?w=tambah&m=ok');
    }
}

if(isset($_POST['ubah'])){
    $ubah = $_POST['ubah'];
    $q1 = $db->update('template',$ubah,"WHERE template_id='{$ubah['template_id']}'");
    if($q1>0){
        header('Location: template.php?w=ubah&m=ok');
    }
}

if(isset($_POST['hapus'])){
    $hapus = $_POST['hapus'];
    $q1 = $db->query("DELETE FROM template WHERE template_id = '{$hapus['template_id']}'");
    if($q1>0){
        header('Location: template.php?w=hapus&m=ok');
    }
}
$q2 = $db->query("SELECT * FROM template");
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
                                    <h6 class="m-0 font-weight-bold text-primary align-middle d-inline">Template</h6>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Template</button>
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
                                            <th>Nama Template</th>
                                            <th>Content</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=0; foreach($q2 as $item) { $i++;?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $item['template_name'];?></td>
                                            <td><?php echo $item['template_content'];?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit<?php echo $item['template_id'];?>"><i class="fas fa-pencil-alt"></i></button>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapus<?php echo $item['template_id'];?>"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    <?php 
                                        $modal .= 
                     
'<!-- Modal Edit -->
<div class="modal fade" id="edit'.$item['template_id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="">
      <div class="modal-body">
          <div class="form-group">
            <label>Nama Template</label>
            <input type="text" class="form-control"aria-describedby="template_shortcode" placeholder="Masukkan nama template" name="ubah[template_name]" value="'.$item['template_name'].'">
          </div>
          <div class="form-group">
            <label>Content</label>
            <textarea name="ubah[template_content]" class="form-control" rows="10" placeholder="Masukkan content dari template">'.$item['template_content'].'</textarea>
            <small>shortcode yang bisa digunakan: [nama], [alamat], [pekerjaan], [posisi], [lokasi] dan semua shortcode constant yang telah dibuat.</small>
          </div>
          <input type="hidden" name="ubah[template_id]" value="'.$item['template_id'].'">
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
<div class="modal fade" id="hapus'.$item['template_id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
          <input type="hidden" name="hapus[template_id]" value="'.$item['template_id'].'">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Hapus</button>
      </div>
      </form>
    </div>
  </div>
</div>';

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
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="">
      <div class="modal-body">
          <div class="form-group">
            <label>Nama Template</label>
            <input type="text" class="form-control" placeholder="Masukkan nama template" name="tambah[template_name]">
          </div>
          <div class="form-group">
            <label>Content</label>
            <textarea name="tambah[template_content]" rows="10" placeholder="Masukkan content dari template" class="form-control"></textarea>
            <small>shortcode yang bisa digunakan: [nama], [alamat], [pekerjaan], [posisi], [lokasi] dan semua shortcode constant yang telah dibuat.</small>
          </div>
          <input type="hidden" name="tambah[template_id]" value="<?php echo getId();?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Tambah</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php 
echo $modal;
include 'footer.php';?>
            