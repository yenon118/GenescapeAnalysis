<?php

include '../../config.php';
include './dataProcessor.php';

$gene = $_GET['Gene'];

$query_str = "";

if(!is_null($gene)){
    $query_str = "
        SELECT A.Count, B.NA_ANC, A.Improvement_Status, A.Gene, A.Position, A.Genotype_with_Description
        FROM (SELECT COUNT(*) AS Count, Improvement_Status, Gene, Position, Genotype_with_Description
        FROM soykb.Genescape_output2
        WHERE (Gene IN ('".$gene."'))
        GROUP BY Improvement_Status, Gene, Position, Genotype_with_Description
        ORDER BY Gene, Position, Genotype_with_Description, Improvement_Status) AS A
        LEFT JOIN (
        SELECT COUNT(*) AS NA_ANC, Improvement_Status, Gene, Position, Genotype_with_Description
        FROM soykb.Genescape_output2
        WHERE ((Gene IN ('".$gene."')) AND (Ancestry_Binary IS NOT NULL))
        GROUP BY Improvement_Status, Gene, Position, Genotype_with_Description, Ancestry_Binary
        ORDER BY Gene, Position, Genotype_with_Description, Improvement_Status) AS B
        ON A.Improvement_Status = B.Improvement_Status AND A.Gene = B.Gene AND A.Position = B.Position AND A.Genotype_with_Description = B.Genotype_with_Description
        ORDER BY A.Gene, A.Position, A.Genotype_with_Description, A.Improvement_Status;
    ";

    $result = mysql_query($query_str);
    $result_arr = array();
    if(mysql_num_rows($result) > 0){
        while ($row = mysql_fetch_assoc($result)) {
            array_push($result_arr, $row);
        }
    }

    $result_arr = dataProcessor($result_arr);

    echo json_encode(array("data" => $result_arr));
}

?>
