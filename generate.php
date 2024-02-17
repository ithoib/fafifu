<?php
include 'header.php';
$db = new Db();
$q2 = $db->query("SELECT * FROM template");
$dt = array_combine(array_column($q2, 'template_id'), array_column($q2, 'template_content'));
$q3 = $db->query("SELECT * FROM constant");
$dc = array_combine(array_column($q3, 'constant_shortcode'), array_column($q3, 'constant_content'));
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
                                <h6 class="m-0 font-weight-bold text-primary">Advanced FaFiFu Generator</h6>
                                
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Data</label>
                                    <select name="data" class="form-control" id="data">
                                        <option value="1">From Data</option>
                                        <option value="2">From File</option>
                                    </select>
                                </div>
                                <div class="form-group" style="display: none;" id="file">
                                    <label>Import File</label>
                                    <input type="file" class="form-control customFile" name="excel" accept=".xls,.xlsx">
                                    <small>contoh file bisa diunduh di <a href="contoh-data.xlsx">sini</a>.</small>
                                </div>
                                <div class="form-group">
                                    <label>Template</label>
                                    <select name="template" class="form-control" id="data">
                                        <option value="1">Random Template</option>
                                        <?php 
                                            if(!empty($q2)){
                                                foreach($q2 as $item){
                                                    echo '<option value="'.$item['template_id'].'">'.$item['template_name'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="generate" class="btn btn-primary">Generate</button>
                                </div>
                            </form>
                            <?php 
                            if(isset($_POST['generate'])){
                                $data = $_POST['data'];
                                $template = $_POST['template'];
                                if($data==1){
                                    $dataArr = $db->query("SELECT * FROM data");
                                    // print_r($dataArr);
                                } else {
                                    if(isset($_FILES['excel'])){
                                         $excel = $_FILES['excel']['tmp_name'];
                                         $xlsx = new SimpleXLSX($excel);
                                         $dataArr = array();
                                         if ( $xlsx->success() ) {
                                            $dataA = $xlsx->rows();
                                            $i = 0;
                                            foreach($dataA as $row){
                                                $i++;
                                                if($i!=1){
                                                    $dataArr[] = array(
                                                        "nama" => $row[0],
                                                        "alamat" => $row[1],
                                                        "pekerjaan" => $row[2],
                                                        "posisi" => $row[3],
                                                        "lokasi" => $row[4],
                                                    );
                                                }
                                            }
                                            // print_r($dataArr);
                                         } else {
                                            // echo 'xlsx error: '.$xlsx->error();
                                         }
                                    }
                                }
                                if(!empty($dataArr)){
                                    if($template==1){
                                        shuffle($q2);
                                        $tmplt = $q2[0]['template_content'];
                                    } else {
                                        $tmplt = $dt[$template];
                                    }
                                    $x = 0;
                                    $txt = '';
                                    foreach($dataArr as $item){
                                        $x++;
                                        $txt .= $tmplt;
                                        $txt = str_ireplace(array('[nama]','[alamat]','[pekerjaan]','[posisi]','[lokasi]'), array($item['nama'],$item['alamat'],$item['pekerjaan'],$item['posisi'],$item['lokasi']), $txt);
                                        if($x<count($dataArr)){
                                            $txt .= " && ";
                                        }
                                        
                                    }
                                    $txt = replace_constant($txt);
                                    echo '<div class="form-group"><textarea class="form-control" rows="10" onclick="this.select()">'.$txt.'</textarea></div>';
                                }
                            }

                            ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
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
$footer_script .=
'<script>
$(document).ready(function() {
    $(`#data`).on(`change`, function() {
        if(this.value==2){
            $(`#file`).show(); 
        } else {
            $(`#file`).hide(); 
        }
    });
});
</script>';
include 'footer.php';?>
            