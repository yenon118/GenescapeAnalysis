<?php

include '../../config.php';

$key = $_GET['Key'];
$gene = $_GET['Gene'];
$position = $_GET['Position'];
$genotype_with_description = $_GET['Genotype_with_Description'];

$query_str = "";

if(preg_match("/soja/i", strval($key))){
    $query_str = "
        SELECT Classification, Improvement_Status, Maturity_Group, Country, State, Accession
        FROM soykb.Genescape_output2
        WHERE (Gene IN ('".$gene."'))
        AND Position = '".$position."'
        AND Genotype_with_Description = '".$genotype_with_description."'
        AND Improvement_Status LIKE '%soja%' ORDER BY Accession;
    ";
} else if(preg_match("/cultivar/i", strval($key))){
    $query_str = "
        SELECT Classification, Improvement_Status, Maturity_Group, Country, State, Accession
        FROM soykb.Genescape_output2
        WHERE (Gene IN ('".$gene."'))
        AND Position = '".$position."'
        AND Genotype_with_Description = '".$genotype_with_description."'
        AND (Improvement_Status LIKE '%cultivar%' OR Improvement_Status LIKE '%elite%')
        ORDER BY Accession;
    ";
} else if(preg_match("/landrace/i", strval($key))){
    $query_str = "
        SELECT Classification, Improvement_Status, Maturity_Group, Country, State, Accession
        FROM soykb.Genescape_output2
        WHERE (Gene IN ('".$gene."'))
        AND Position = '".$position."'
        AND Genotype_with_Description = '".$genotype_with_description."'
        AND Improvement_Status LIKE '%landrace%'
        ORDER BY Accession;
    ";
} else if(preg_match("/total/i", strval($key))){
    $query_str = "
        SELECT Classification, Improvement_Status, Maturity_Group, Country, State, Accession
        FROM soykb.Genescape_output2
        WHERE (Gene IN ('".$gene."'))
        AND Position = '".$position."'
        AND Genotype_with_Description = '".$genotype_with_description."'
        ORDER BY Accession;
    ";
} else if(preg_match("/na.anc/i", strval($key))){
    $query_str = "
        SELECT Classification, Improvement_Status, Maturity_Group, Country, State, Accession
        FROM soykb.Genescape_output2
        WHERE (Gene IN ('".$gene."'))
        AND Position = '".$position."'
        AND Genotype_with_Description = '".$genotype_with_description."'
        AND Ancestry_Binary IS NOT NULL
        ORDER BY Accession;
    ";
}

$result = mysql_query($query_str);
$result_arr = array();
if(mysql_num_rows($result) > 0){
    while ($row = mysql_fetch_assoc($result)) {
        array_push($result_arr, $row);
    }
}

echo json_encode(array("data" => $result_arr));

?>
