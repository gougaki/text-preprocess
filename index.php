<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
  </head>
  <title>
    Data Mining
  </title>
  <body>
    <div id = "content">
    
      <?php 
        require_once("preproccess.php");
        require_once("connection.php");
        $con = new connection();
        $con = $con->conn();
        $dir = "artikel/";


        if (is_dir($dir)){
          if ($dh = opendir($dir)){
            while (($file = readdir($dh))){
              if ($file != '.' && $file != '..'){
                //input file ke database
                $result = $con->query("SELECT * FROM dokumen WHERE title = '$file'");
                if($result->num_rows == 0) {
                  $con->query("INSERT INTO dokumen (title) VALUES ('$file')");
                  $dokumen_id = $con->insert_id;

                  //text preprocess
                  $teks = file_get_contents($dir.$file, FILE_USE_INCLUDE_PATH);
                  explode("\n", $teks);
                  $process = new preproccess();
                  $teks = $process->preprocess($teks);
                  $key = array_keys($teks);

                  //input tiap term ke database
                  foreach($key as $index){
                    //echo "$index = $teks[$index] <br>";
                    $result = $con->query("SELECT * FROM term WHERE kata = '$index'");
                    if($result->num_rows == 0) {
                      $con->query("INSERT INTO term (kata) VALUES ('$index')");
                    }
                    $con->query("INSERT INTO indexing (term,dokumen_id,term_frequency)
                                  VALUES ($index,$dokumen_id,$teks[$index])");
                  }
                }
              }        
            }
            closedir($dh);
          }
        }                  
      ?>
      <h1>
        Sistem Temu Kembali Berbasis Komputasi Cerdas
      </h1>
      <div>
        <form action="tf-idf.php" method="post">
          <input type = "text" placeholder ="cari" name ="kalimat"/>
          <input type = "submit"/>
        </form>
      </div>
        <!-- <div id="tabel_container">
          <table class = "tabel_1">
            <tr>
              <th>Company</th>
              <th>Contact</th>
              <th>Country</th>
            </tr>
            <?php
            // $hai = "hai";
            // $hellow = "hello";
            // $world = "world";
            // echo "<tr>
            //   <td>".$hai."</td>
            //   <td>".$hellow."</td>
            //   <td>".$world."</td>
            // </tr>" ; 
            ?>
          </table>
        </div> -->
    </div>
  </body>
</html>