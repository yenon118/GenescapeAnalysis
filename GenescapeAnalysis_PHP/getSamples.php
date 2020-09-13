<?php

include '../../config.php';

$key = $_GET['Key'];
$gene = $_GET['Gene'];
$position = $_GET['Position'];
$genotype_with_description = $_GET['Genotype_with_Description'];

$query_str = "";

if(preg_match("/soja/i", strval($key))){
    $query_str = "
        SELECT Type, Category, Number, Country, Location, Sample
        FROM soykb.Genescape_output
        WHERE (Gene IN ('".$gene."'))
        AND Position = '".$position."'
        AND Genotype_with_Description = '".$genotype_with_description."'
        AND Category LIKE '%soja%' ORDER BY Sample;
    ";
} else if(preg_match("/cultivar/i", strval($key))){
    $query_str = "
        SELECT Type, Category, Number, Country, Location, Sample
        FROM soykb.Genescape_output
        WHERE (Gene IN ('".$gene."'))
        AND Position = '".$position."'
        AND Genotype_with_Description = '".$genotype_with_description."'
        AND (Category LIKE '%cultivar%' OR Category LIKE '%elite%')
        ORDER BY Sample;
    ";
} else if(preg_match("/landrace/i", strval($key))){
    $query_str = "
        SELECT Type, Category, Number, Country, Location, Sample
        FROM soykb.Genescape_output
        WHERE (Gene IN ('".$gene."'))
        AND Position = '".$position."'
        AND Genotype_with_Description = '".$genotype_with_description."'
        AND Category LIKE '%landrace%'
        ORDER BY Sample;
    ";
} else if(preg_match("/total/i", strval($key))){
    $query_str = "
        SELECT Type, Category, Number, Country, Location, Sample
        FROM soykb.Genescape_output
        WHERE (Gene IN ('".$gene."'))
        AND Position = '".$position."'
        AND Genotype_with_Description = '".$genotype_with_description."'
        ORDER BY Sample;
    ";
} else if(preg_match("/na.anc/i", strval($key))){
    $query_str = "
        SELECT Type, Category, Number, Country, Location, Sample
        FROM soykb.Genescape_output
        WHERE (Gene IN ('".$gene."'))
        AND Position = '".$position."'
        AND Genotype_with_Description = '".$genotype_with_description."'
        AND Ancestry_binary IS NOT NULL
        ORDER BY Sample;
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
