<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
  </head>
  <title>
    Data Mining
  </title>

<?php
define("Zero", 0);

if(!isset($_POST['submit'])){
    $text = $_POST['kalimat'];
    $jumlah_kata = 0;
    $tf_kata = array(array());
    $df_kata = array(0);
    $idf_kata = array();
    $tfIdf_kata = array(array());

    require_once("preproccess.php");
    require_once("connection.php");
    $con = new connection();
    $con = $con->conn();

    $process = new preproccess();
    $text = $process->preprocess($text);
    $teks = array_keys($text);

    $result = $con->query("SELECT * FROM dokumen");
    if($result->num_rows > 0){
            ?>
                <div id="tabel_container">
                    <table class = "tabel_1">
                    <tr>
                        <th>Dokumen</th>
                        <?php
                            $i =0;
                            foreach($teks as $kata){
                                $jumlah_kata ++;
                                $i++;
                                echo "<th>tf_".$kata."</th>";
                                $df_kata[$i]=0;
                            }
                            //echo "jumlah kata :".$jumlah_kata."<br>";
                        ?>
                    </tr>
                    <?php
                    $dok = 0;
                    $list_dokumen = array();
                    while($row_dokumen = $result->fetch_assoc()){
                        $dok++;
                        echo "<tr>
                                <td>".$row_dokumen["title"]."</td>";
                        $list_dokumen[$dok] = $row_dokumen["title"];
                        $j= 0;
                        foreach($teks as $kata){
                            $j++;
                            $index = $con->query("SELECT * FROM indexing WHERE dokumen_id = ".$row_dokumen["dokumen_id"]);
                            $allRows = $index->num_rows;
                            if( $allRows > 0){
                                $i = 1;
                                //echo "foreach : ".$kata."<br>";
                                $kata_masuk = 0;
                                while($row_index = $index->fetch_assoc()){
                                    // $term = $con->query("SELECT * FROM kata WHERE id = ".$row_index["kata_id"]);
                                    $i++;
                                    // if($term->num_rows >0){
                                    //     $row_term = $term->fetch_assoc();
                                    //     //echo "while : ".$row_term["kata"]."<br>";
                                        if($row_index["term"] == $kata){
                                            echo "<td>".$row_index["term_frequency"]."</td>";
                                            $kata_masuk = 1;
                                            $tf_kata[$j][$dok] = $row_index["term_frequency"];
                                            $df_kata[$j] +=1;
                                        }else{
                                            if($allRows == $i && !$kata_masuk){
                                                echo "<td>".Zero/*."masuk : ".$i*/."</td>";
                                                $tf_kata[$j][$dok] = Zero;
                                            }
                                        }
                                    // }
                                }
                            }
                            //echo "df_kata[".$dok."][".$kata."] = ".$tf_kata[$kat][$dok]."<br>";    //testing
                        }    
                        echo "</tr>";
                    }
                    ?>
                    </table>
                    <table class = "tabel_2">
                        <tr>
                            <th>Term</th>
                            <th>df</th> 
                        </tr>
        <?php
    }
    $i=0;
    foreach($teks as $kata){
        $i++;
        echo "
            <tr>
                <td>".$kata."</td>
                <td>".$df_kata[$i]."</td>
            </tr>
        ";
        //echo "idf_kata[".$kata."] = ".$df_kata[$i]."<br>";
    }
    ?>
        </table>
        <table class = "tabel_3">
            <tr>
                <th>Term</th>
                <th>idf</th>
            </tr>

    <?php
    $i=0;
    foreach($teks as $kata){
        $i++;
        $idf_kata[$i] = log(($dok)/($df_kata[$i]),);
        echo "<tr>
            <td>".$kata."</td>
            <td>".$idf_kata[$i]."</td>";
    }
    echo "</tr>
        </table>";
    ?>
        <table class="tabel_4">
            <tr>
                <th>Dokumen</th>
                <?php
                    foreach($teks as $kata){
                        echo "<th> tf-idf_".$kata."</th>";
                    }
                ?> 
            </tr>
    <?php
    $i=1;
    for($i=1; $i<=$dok;$i++){
        echo "<tr>
                <td>".$list_dokumen[$i]."</td>
            ";
        $j = 0;
        foreach($teks as $kata){
            $j++;
            //echo " tf_kata[$j][$i] = ".$tf_kata[$j][$i]."<br>";
           $tfIdf_kata[$j][$i] = ($tf_kata[$j][$i])*($idf_kata[$j]);
           echo "
                <td>".$tfIdf_kata[$j][$i]."</td>
           ";
        }
        echo "</tr>";
    }
    echo "</table>";

}
?>
        
    </div>
</html>