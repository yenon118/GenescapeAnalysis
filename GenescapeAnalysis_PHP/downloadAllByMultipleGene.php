<?php

include '../../config.php';
include './dataProcessor.php';

$gene = $_GET['Gene'];

$query_str = "";

if(!is_null($gene)){
    $gene_arr = $gene;
    for ($i=0; $i<count($gene_arr); $i++){
        $gene_arr[$i] = "'".trim($gene_arr[$i])."'";
    }

    $query_str = "
        SELECT *
        FROM soykb.Genescape_output2
        WHERE (Gene IN (".implode(",", $gene_arr)."));
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
