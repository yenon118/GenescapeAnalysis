<?php
$TITLE = "Soybean Allele Catalog";
include '../header.php';
?>

<?php

$accession = $_GET['accession'];
$gene = $_GET['gene'];

if (isset($accession) && !empty($accession) && isset($gene) && !empty($gene)){
    $accession_arr = preg_split("/[;, \n]+/", $accession);
    for ($i=0; $i<count($accession_arr); $i++){
        $accession_arr[$i] = "'".trim($accession_arr[$i])."'";
    }
    echo "<br />";

    $query_str = "
        SELECT Classification, Improvement_Status, Maturity_Group, Country, State, Accession, Gene, Position, Genotype, Genotype_with_Description
        FROM soykb.Genescape_output2
        WHERE (Gene IN ('".$gene."')) AND (Accession IN (".implode(",", $accession_arr)."));
    ";

    $result = mysql_query($query_str);
    $result_arr = array();
    if(mysql_num_rows($result) > 0){
        while ($row = mysql_fetch_assoc($result)) {
            array_push($result_arr, $row);
        }
    }

    if (count($result_arr) > 0){
        for($i=0; $i<count($result_arr); $i++){
            $position_arr = preg_split("/[;, \n]+/", $result_arr[$i]["Position"]);
            $genotype_with_description_arr = preg_split("/[;, \n]+/", $result_arr[$i]["Genotype_with_Description"]);

            for($j=0; $j<count($position_arr); $j++){
                $result_arr[$i][$position_arr[$j]] = $genotype_with_description_arr[$j];
            }
        }
    }

//    echo json_encode(array("data" => $result_arr));

}  else{
    echo "<p>Your query is empty. Please insert values into text box.</p>";
    echo "<button onclick=\"location.href='search.php';\"> Go Back to Last Page </button>";
}
?>

<?php
    $ref_color_code = "#D1D1D1";
    $missense_variant_color_code = "#7FC8F5";
    $frameshift_variant_color_code = "#F26A55";
    $exon_loss_variant_color_code = "#F26A55";
    $lost_color_code = "#F26A55";
    $gain_color_code = "#F26A55";

    if(count($result_arr) > 0){
        echo "<div style='width:100%;height:100%; border:3px solid #000; overflow:scroll;max-height:1000px;'>";
        echo "<table style='text-align:center;'>";
        echo "<tr>";
        foreach($result_arr[0] as $key => $value){
            if ($key != "Position" && $key != "Genotype" && $key != "Genotype_with_Description"){
                echo "<th>".$key."</th>";
            }
        }
        echo "</tr>";
        for ($i=0; $i<count($result_arr); $i++){
            if ($i % 2){
                $tr_bgcolor = "#FFFFFF";
            } else {
                $tr_bgcolor = "#DDFFDD";
            }

            echo "<tr bgcolor=\"".$tr_bgcolor."\">";
            foreach($result_arr[$i] as $key => $value){
                if ($key != "Position" && $key != "Genotype" && $key != "Genotype_with_Description"){
                    if(!intval($key)){
                        echo "<td style=\"min-width:80px;\">".$value."</td>";
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
        echo "<div style='margin-top:10px;' align='right'>";

        $temp_accession_arr = preg_split("/[;, \n]+/", $accession);
        for ($i=0; $i<count($temp_accession_arr); $i++){
            $temp_accession_arr[$i] = trim($temp_accession_arr[$i]);
        }
        
        echo "<button onclick=\"downloadAllByAccessionAndGene('".strval(implode(";", $temp_accession_arr))."', '".$gene."')\"> Download</button>";
        echo "</div>";
        echo "<br/><br/>";
    }

    if(count($result_arr) > 0){
        echo "<br/><br/>";
        echo "<div style='margin-top:10px;' align='center'>";
        echo "<button type=\"submit\" onclick=\"window.open('https://de.cyverse.org/dl/d/761101E5-B0C7-461C-8FB9-BDFB11292A7A/Accession_info.csv')\">Download Accession Information</button>";
        // echo "&nbsp;&nbsp;";
        // echo "<button type=\"submit\" onclick=\"window.open('https://de.cyverse.org/dl/d/496DEACF-8067-45DC-9033-27F17FF2E960/genescape_output_v2.tar.gz')\">Download Full Dataset</button>";
        echo "</div>";
        echo "<br/><br/>";
    }
?>

<?php
//echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
echo '<script type="text/javascript" language="javascript" src="./js/download.js"></script>';
?>

<?php include '../footer.php'; ?>
