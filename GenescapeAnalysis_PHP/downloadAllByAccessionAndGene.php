<?php

include '../../config.php';

$gene = $_GET['Gene'];
$accession = $_GET['Accession'];

$query_str = "";

if(!is_null($accession) && isset($accession) && !empty($accession) && !is_null($gene) && isset($gene) && !empty($gene)){
    $accession_arr = $accession;
    for ($i=0; $i<count($accession_arr); $i++){
        $accession_arr[$i] = "'".trim($accession_arr[$i])."'";
    }
    
    $query_str = "
        SELECT *
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

    echo json_encode(array("data" => $result_arr));
}

?>
