<?php

include '../../config.php';

$gene = $_GET['Gene'];

$query_str = "";

if(!is_null($gene)){
    $query_str = "
        SELECT *
        FROM soykb.Genescape_output
        WHERE (Gene IN ('".$gene."'));
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
