
<?php
$TITLE = "Genescape Analysis";
include '../header.php';
include './GenescapeAnalysis_PHP/dataProcessor.php';
?>

<link rel="stylesheet" href="css/modal.css">

<?php
$gene = $_GET['gene'];

if (isset($gene) && !empty($gene)){
    $gene_arr = preg_split("/[;, \n]+/", $gene);
    for ($i=0; $i<count($gene_arr); $i++){
        $gene_arr[$i] = "'".trim($gene_arr[$i])."'";
    }
    echo "<br />";
    // $query_str = "SELECT * FROM soykb.Genescape_output WHERE (Gene IN (".implode(",", $gene_arr)."));";
    $query_str = "
        SELECT A.Count, B.NA_ANC, A.Category, A.Gene, A.Position, A.Genotype_with_Description
        FROM (SELECT COUNT(*) AS Count, Category, Gene, Position, Genotype_with_Description
        FROM soykb.Genescape_output
        WHERE (Gene IN (".implode(",", $gene_arr)."))
        GROUP BY Category, Gene, Position, Genotype_with_Description
        ORDER BY Gene, Position, Genotype_with_Description, Category) AS A
        LEFT JOIN (
        SELECT COUNT(*) AS NA_ANC, Category, Gene, Position, Genotype_with_Description FROM soykb.Genescape_output
        WHERE ((Gene IN (".implode(",", $gene_arr).")) AND (Ancestry_binary IS NOT NULL))
        GROUP BY Category, Gene, Position, Genotype_with_Description, Ancestry_binary
        ORDER BY Gene, Position, Genotype_with_Description, Category) AS B
        ON A.Category = B.Category AND A.Gene = B.Gene AND A.Position = B.Position AND A.Genotype_with_Description = B.Genotype_with_Description
        ORDER BY A.Gene, A.Position, A.Genotype_with_Description, A.Category;
    ";
    $result = mysql_query($query_str);
    $result_arr = array();
    if(mysql_num_rows($result) > 0){
        while ($row = mysql_fetch_assoc($result)) {
            array_push($result_arr, $row);
        }
    }

    $result_arr = dataProcessor($result_arr);
} else{
    echo "<p>Your query is empty. Please insert values into text box.</p>";
    echo "<button onclick=\"location.href='search.php';\"> Go Back to Last Page </button>";
}
?>


<div id="info-modal" class="info-modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="modal-close">&times;</span>
    <div id="modal-content-div" style='width:100%;height:100%; border:3px solid #000; overflow:scroll;max-height:1000px;'></div>
    <div id="modal-content-comment"></div>
  </div>
</div>


<?php
    $ref_color_code = "#D1D1D1";
    $missense_variant_color_code = "#7FC8F5";
    $frameshift_variant_color_code = "#F26A55";
    $exon_loss_variant_color_code = "#F26A55";
    $lost_color_code = "#F26A55";
    $gain_color_code = "#F26A55";

    for ($i=0; $i<count($result_arr); $i++){
        $segment_arr = $result_arr[$i];
        echo "<div style='width:100%;height:100%; border:3px solid #000; overflow:scroll;max-height:1000px;'>";
        echo "<table style='text-align:center;'>";
        echo "<tr>";
        foreach($segment_arr[0] as $key => $value){
            if ($key != "Position" && $key != "Genotype_with_Description"){
                echo "<th>".$key."</th>";
            }
        }
        echo "</tr>";

        for ($j=0; $j<count($segment_arr); $j++){
            if ($j % 2){
                $tr_bgcolor = "#FFFFFF";
            } else {
                $tr_bgcolor = "#DDFFDD";
            }

            echo "<tr bgcolor=\"".$tr_bgcolor."\">";
            foreach($segment_arr[$j] as $key => $value){
                if ($key != "Position" && $key != "Genotype_with_Description"){
                    if(!intval($key)){
                        if(preg_match("/soja/i", strval($key))){
                            if (intval($value)>0){
                                echo "<td style=\"min-width:80px\"><a href=\"javascript:void(0);\" onclick=\"getSamples('".strval($key)."', '".$segment_arr[$j]["Gene"]."', '".$segment_arr[$j]["Position"]."', '".$segment_arr[$j]["Genotype_with_Description"]."');\">".$value."</a></td>";
                            } else{
                                echo "<td style=\"min-width:80px\">".$value."</td>";
                            }
                        } else if(preg_match("/cultivar/i", strval($key))){
                            if (intval($value)>0){
                                echo "<td style=\"min-width:80px\"><a href=\"javascript:void(0);\" onclick=\"getSamples('".strval($key)."', '".$segment_arr[$j]["Gene"]."', '".$segment_arr[$j]["Position"]."', '".$segment_arr[$j]["Genotype_with_Description"]."');\">".$value."</a></td>";
                            } else{
                                echo "<td style=\"min-width:80px\">".$value."</td>";
                            }
                        } else if(preg_match("/landrace/i", strval($key))){
                            if (intval($value)>0){
                                echo "<td style=\"min-width:80px\"><a href=\"javascript:void(0);\" onclick=\"getSamples('".strval($key)."', '".$segment_arr[$j]["Gene"]."', '".$segment_arr[$j]["Position"]."', '".$segment_arr[$j]["Genotype_with_Description"]."');\">".$value."</a></td>";
                            } else{
                                echo "<td style=\"min-width:80px\">".$value."</td>";
                            }
                        } else if(preg_match("/total/i", strval($key))){
                            if (intval($value)>0){
                                echo "<td style=\"min-width:80px\"><a href=\"javascript:void(0);\" onclick=\"getSamples('".strval($key)."', '".$segment_arr[$j]["Gene"]."', '".$segment_arr[$j]["Position"]."', '".$segment_arr[$j]["Genotype_with_Description"]."');\">".$value."</a></td>";
                            } else{
                                echo "<td style=\"min-width:80px\">".$value."</td>";
                            }
                        } else if(preg_match("/na.anc/i", strval($key))){
                            if (intval($value)>0){
                                echo "<td style=\"min-width:80px\"><a href=\"javascript:void(0);\" onclick=\"getSamples('".strval($key)."', '".$segment_arr[$j]["Gene"]."', '".$segment_arr[$j]["Position"]."', '".$segment_arr[$j]["Genotype_with_Description"]."');\">".$value."</a></td>";
                            } else{
                                echo "<td style=\"min-width:80px\">".$value."</td>";
                            }
                        } else{
                            echo "<td style=\"min-width:80px\">".$value."</td>";
                        }
                    } else{
                        if (preg_match("/missense.variant/i", $value)){
                            $temp_value_arr = preg_split("/[;, |\n]+/", $value);
                            $temp_value = (count($temp_value_arr) > 2 ? $temp_value_arr[0]."|".$temp_value_arr[2] : $value);
                            echo "<td style=\"min-width:80px;background-color:".$missense_variant_color_code."\">".$temp_value."</td>";
                        } else if (preg_match("/frameshift/i", $value)){
                            echo "<td style=\"min-width:80px;background-color:".$frameshift_variant_color_code."\">".$value."</td>";
                        } else if (preg_match("/exon.loss/i", $value)){
                            echo "<td style=\"min-width:80px;background-color:".$exon_loss_variant_color_code."\">".$value."</td>";
                        } else if (preg_match("/lost/i", $value)){
                            $temp_value_arr = preg_split("/[;, |\n]+/", $value);
                            $temp_value = (count($temp_value_arr) > 2 ? $temp_value_arr[0]."|".$temp_value_arr[2] : $value);
                            echo "<td style=\"min-width:80px;background-color:".$lost_color_code."\">".$value."</td>";
                        } else if (preg_match("/gain/i", $value)){
                            $temp_value_arr = preg_split("/[;, |\n]+/", $value);
                            $temp_value = (count($temp_value_arr) > 2 ? $temp_value_arr[0]."|".$temp_value_arr[2] : $value);
                            echo "<td style=\"min-width:80px;background-color:".$gain_color_code."\">".$value."</td>";
                        } else if (preg_match("/ref/i", $value)){
                            echo "<td style=\"min-width:80px;background-color:".$ref_color_code."\">".$value."</td>";
                        } else{
                            echo "<td style=\"min-width:80px;background-color:#FFFFFF\">".$value."</td>";
                        }
                    }
                }
            }
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
        echo "<div style='margin-top:10px;' align='right'><button onclick=\"downloadAllByGene('".$result_arr[$i][0]["Gene"]."')\"> Download </button></div>";
        echo "<br/><br/>";
    }
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="./js/getSamples.js"></script>
<script type="text/javascript" src="./js/download.js"></script>
<script type="text/javascript" src="./js/modal.js"></script>

<?php include '../footer.php'; ?>
