<?php

function dataProcessor($result_arr){
    $processed_arr = array();
    $segment_arr = array();

    $prev_state_landrace = 0;
    $prev_state_soja = 0;
    $prev_state_cultivar = 0;
    $prev_state_count = 0;
    $prev_state_improvement_status = "";
    $prev_state_gene = "";
    $prev_state_position = "";
    $prev_state_genotype_with_description = "";
    $prev_state_na_ancestor = 0;

    for ($i=0; $i<count($result_arr); $i++){

        if($result_arr[$i]['Gene'] != $prev_state_gene || $result_arr[$i]['Position'] != $prev_state_position || $result_arr[$i]['Genotype_with_Description'] != $prev_state_genotype_with_description){
            $prev_state_landrace = 0;
            $prev_state_soja = 0;
            $prev_state_cultivar = 0;
            $prev_state_count = intval($result_arr[$i]['Count']);
            $prev_state_improvement_status = $result_arr[$i]['Improvement_Status'];
            $prev_state_gene = $result_arr[$i]['Gene'];
            $prev_state_position = $result_arr[$i]['Position'];
            $prev_state_genotype_with_description = $result_arr[$i]['Genotype_with_Description'];
            $prev_state_na_ancestor = intval($result_arr[$i]['NA_ANC']);
            if(preg_match("/soja/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_soja=intval($result_arr[$i]['Count']);
            } else if(preg_match("/cultivar/i", strval($result_arr[$i]['Improvement_Status'])) || preg_match("/elite/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_cultivar=intval($result_arr[$i]['Count']);
            } else if(preg_match("/landrace/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_landrace=intval($result_arr[$i]['Count']);
            }




            if(($i+1)<count($result_arr)){
                if($result_arr[$i+1]['Gene'] != $result_arr[$i]['Gene'] || $result_arr[$i+1]['Position'] != $result_arr[$i]['Position'] || $result_arr[$i+1]['Genotype_with_Description'] != $result_arr[$i]['Genotype_with_Description']){
                    $temp = array(
                        "Soja" => $prev_state_soja,
                        "Cultivar" => $prev_state_cultivar,
                        "Landrace" => $prev_state_landrace,
                        "Total" => $prev_state_soja + $prev_state_cultivar + $prev_state_landrace,
                        "NA_ANC" => $prev_state_na_ancestor,
                        "Gene" => $prev_state_gene,
                        "Position" => $prev_state_position,
                        "Genotype_with_Description" => $prev_state_genotype_with_description
                    );
                    $prev_state_position_arr = preg_split("/[;, \n]+/", $prev_state_position);
                    $prev_state_genotype_with_description_arr = preg_split("/[;, \n]+/", $prev_state_genotype_with_description);

                    for ($j=0; $j<count($prev_state_position_arr); $j++){
                        $temp[$prev_state_position_arr[$j]] = $prev_state_genotype_with_description_arr[$j];
                    }

                    array_push($segment_arr, $temp);

                    if ($result_arr[$i+1]['Gene'] != $result_arr[$i]['Gene'] || $result_arr[$i+1]['Position'] != $result_arr[$i]['Position']){
                        array_push($processed_arr, $segment_arr);
                        $segment_arr=array();
                    }
                }
            } else if(($i+1)==count($result_arr)){
                $temp = array(
                    "Soja" => $prev_state_soja,
                    "Cultivar" => $prev_state_cultivar,
                    "Landrace" => $prev_state_landrace,
                    "Total" => $prev_state_soja + $prev_state_cultivar + $prev_state_landrace,
                    "NA_ANC" => $prev_state_na_ancestor,
                    "Gene" => $prev_state_gene,
                    "Position" => $prev_state_position,
                    "Genotype_with_Description" => $prev_state_genotype_with_description
                );
                $prev_state_position_arr = preg_split("/[;, \n]+/", $prev_state_position);
                $prev_state_genotype_with_description_arr = preg_split("/[;, \n]+/", $prev_state_genotype_with_description);

                for ($j=0; $j<count($prev_state_position_arr); $j++){
                    $temp[$prev_state_position_arr[$j]] = $prev_state_genotype_with_description_arr[$j];
                }

                array_push($segment_arr, $temp);
                array_push($processed_arr, $segment_arr);
                $segment_arr=array();
            }



        } else if($result_arr[$i]['Gene'] == $prev_state_gene && $result_arr[$i]['Position'] == $prev_state_position && $result_arr[$i]['Genotype_with_Description'] == $prev_state_genotype_with_description){
            if(preg_match("/soja/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_soja=$prev_state_soja + intval($result_arr[$i]['Count']);
            } else if(preg_match("/cultivar/i", strval($result_arr[$i]['Improvement_Status'])) || preg_match("/elite/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_cultivar=$prev_state_cultivar + intval($result_arr[$i]['Count']);
            } else if(preg_match("/landrace/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_landrace=$prev_state_landrace + intval($result_arr[$i]['Count']);
            }
            $prev_state_na_ancestor = $prev_state_na_ancestor + intval($result_arr[$i]['NA_ANC']);


            if(($i+1)<count($result_arr)){
                if($result_arr[$i+1]['Gene'] != $result_arr[$i]['Gene'] || $result_arr[$i+1]['Position'] != $result_arr[$i]['Position'] || $result_arr[$i+1]['Genotype_with_Description'] != $result_arr[$i]['Genotype_with_Description']){
                    $temp = array(
                        "Soja" => $prev_state_soja,
                        "Cultivar" => $prev_state_cultivar,
                        "Landrace" => $prev_state_landrace,
                        "Total" => $prev_state_soja + $prev_state_cultivar + $prev_state_landrace,
                        "NA_ANC" => $prev_state_na_ancestor,
                        "Gene" => $prev_state_gene,
                        "Position" => $prev_state_position,
                        "Genotype_with_Description" => $prev_state_genotype_with_description
                    );
                    $prev_state_position_arr = preg_split("/[;, \n]+/", $prev_state_position);
                    $prev_state_genotype_with_description_arr = preg_split("/[;, \n]+/", $prev_state_genotype_with_description);

                    for ($j=0; $j<count($prev_state_position_arr); $j++){
                        $temp[$prev_state_position_arr[$j]] = $prev_state_genotype_with_description_arr[$j];
                    }

                    array_push($segment_arr, $temp);

                    if ($result_arr[$i+1]['Gene'] != $result_arr[$i]['Gene'] || $result_arr[$i+1]['Position'] != $result_arr[$i]['Position']){
                        array_push($processed_arr, $segment_arr);
                        $segment_arr=array();
                    }
                }
            } else if(($i+1)==count($result_arr)){
                $temp = array(
                    "Soja" => $prev_state_soja,
                    "Cultivar" => $prev_state_cultivar,
                    "Landrace" => $prev_state_landrace,
                    "Total" => $prev_state_soja + $prev_state_cultivar + $prev_state_landrace,
                    "NA_ANC" => $prev_state_na_ancestor,
                    "Gene" => $prev_state_gene,
                    "Position" => $prev_state_position,
                    "Genotype_with_Description" => $prev_state_genotype_with_description
                );
                $prev_state_position_arr = preg_split("/[;, \n]+/", $prev_state_position);
                $prev_state_genotype_with_description_arr = preg_split("/[;, \n]+/", $prev_state_genotype_with_description);

                for ($j=0; $j<count($prev_state_position_arr); $j++){
                    $temp[$prev_state_position_arr[$j]] = $prev_state_genotype_with_description_arr[$j];
                }

                array_push($segment_arr, $temp);
                array_push($processed_arr, $segment_arr);
                $segment_arr=array();
            }



        }
    }

    // echo json_encode($processed_arr[0]);

    return $processed_arr;
}



function dataProcessor2($result_arr){
    $processed_arr = array();
    $segment_arr = array();

    $prev_state_landrace = 0;
    $prev_state_soja = 0;
    $prev_state_cultivar = 0;
    $prev_state_count = 0;
    $prev_state_improvement_status = "";
    $prev_state_gene = "";
    $prev_state_position = "";
    $prev_state_genotype = "";
    $prev_state_genotype_with_description = "";
    $prev_state_na_ancestor = 0;

    for ($i=0; $i<count($result_arr); $i++){

        if($result_arr[$i]['Gene'] != $prev_state_gene || $result_arr[$i]['Position'] != $prev_state_position || $result_arr[$i]['Genotype_with_Description'] != $prev_state_genotype_with_description){
            $prev_state_landrace = 0;
            $prev_state_soja = 0;
            $prev_state_cultivar = 0;
            $prev_state_count = intval($result_arr[$i]['Count']);
            $prev_state_improvement_status = $result_arr[$i]['Improvement_Status'];
            $prev_state_gene = $result_arr[$i]['Gene'];
            $prev_state_position = $result_arr[$i]['Position'];
            $prev_state_genotype = $result_arr[$i]['Genotype'];
            $prev_state_genotype_with_description = $result_arr[$i]['Genotype_with_Description'];
            $prev_state_na_ancestor = intval($result_arr[$i]['NA_ANC']);
            if(preg_match("/soja/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_soja=intval($result_arr[$i]['Count']);
            } else if(preg_match("/cultivar/i", strval($result_arr[$i]['Improvement_Status'])) || preg_match("/elite/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_cultivar=intval($result_arr[$i]['Count']);
            } else if(preg_match("/landrace/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_landrace=intval($result_arr[$i]['Count']);
            }




            if(($i+1)<count($result_arr)){
                if($result_arr[$i+1]['Gene'] != $result_arr[$i]['Gene'] || $result_arr[$i+1]['Position'] != $result_arr[$i]['Position'] || $result_arr[$i+1]['Genotype_with_Description'] != $result_arr[$i]['Genotype_with_Description']){
                    $temp = array(
                        "Soja" => $prev_state_soja,
                        "Cultivar" => $prev_state_cultivar,
                        "Landrace" => $prev_state_landrace,
                        "Total" => $prev_state_soja + $prev_state_cultivar + $prev_state_landrace,
                        "NA_ANC" => $prev_state_na_ancestor,
                        "Gene" => $prev_state_gene,
                        "Position" => $prev_state_position,
                        "Genotype" => $prev_state_genotype,
                        "Genotype_with_Description" => $prev_state_genotype_with_description
                    );
                    $prev_state_position_arr = preg_split("/[;, \n]+/", $prev_state_position);
                    $prev_state_genotype_arr = preg_split("/[;, \n]+/", $prev_state_genotype);
                    $prev_state_genotype_with_description_arr = preg_split("/[;, \n]+/", $prev_state_genotype_with_description);

                    for ($j=0; $j<count($prev_state_position_arr); $j++){
                        $temp[$prev_state_position_arr[$j]] = $prev_state_genotype_with_description_arr[$j];
                    }

                    array_push($segment_arr, $temp);

                    if ($result_arr[$i+1]['Gene'] != $result_arr[$i]['Gene'] || $result_arr[$i+1]['Position'] != $result_arr[$i]['Position']){
                        array_push($processed_arr, $segment_arr);
                        $segment_arr=array();
                    }
                }
            } else if(($i+1)==count($result_arr)){
                $temp = array(
                    "Soja" => $prev_state_soja,
                    "Cultivar" => $prev_state_cultivar,
                    "Landrace" => $prev_state_landrace,
                    "Total" => $prev_state_soja + $prev_state_cultivar + $prev_state_landrace,
                    "NA_ANC" => $prev_state_na_ancestor,
                    "Gene" => $prev_state_gene,
                    "Position" => $prev_state_position,
                    "Genotype" => $prev_state_genotype,
                    "Genotype_with_Description" => $prev_state_genotype_with_description
                );
                $prev_state_position_arr = preg_split("/[;, \n]+/", $prev_state_position);
                $prev_state_genotype_arr = preg_split("/[;, \n]+/", $prev_state_genotype);
                $prev_state_genotype_with_description_arr = preg_split("/[;, \n]+/", $prev_state_genotype_with_description);

                for ($j=0; $j<count($prev_state_position_arr); $j++){
                    $temp[$prev_state_position_arr[$j]] = $prev_state_genotype_with_description_arr[$j];
                }

                array_push($segment_arr, $temp);
                array_push($processed_arr, $segment_arr);
                $segment_arr=array();
            }



        } else if($result_arr[$i]['Gene'] == $prev_state_gene && $result_arr[$i]['Position'] == $prev_state_position && $result_arr[$i]['Genotype_with_Description'] == $prev_state_genotype_with_description){
            if(preg_match("/soja/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_soja=$prev_state_soja + intval($result_arr[$i]['Count']);
            } else if(preg_match("/cultivar/i", strval($result_arr[$i]['Improvement_Status'])) || preg_match("/elite/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_cultivar=$prev_state_cultivar + intval($result_arr[$i]['Count']);
            } else if(preg_match("/landrace/i", strval($result_arr[$i]['Improvement_Status']))){
                $prev_state_landrace=$prev_state_landrace + intval($result_arr[$i]['Count']);
            }
            $prev_state_na_ancestor = $prev_state_na_ancestor + intval($result_arr[$i]['NA_ANC']);


            if(($i+1)<count($result_arr)){
                if($result_arr[$i+1]['Gene'] != $result_arr[$i]['Gene'] || $result_arr[$i+1]['Position'] != $result_arr[$i]['Position'] || $result_arr[$i+1]['Genotype_with_Description'] != $result_arr[$i]['Genotype_with_Description']){
                    $temp = array(
                        "Soja" => $prev_state_soja,
                        "Cultivar" => $prev_state_cultivar,
                        "Landrace" => $prev_state_landrace,
                        "Total" => $prev_state_soja + $prev_state_cultivar + $prev_state_landrace,
                        "NA_ANC" => $prev_state_na_ancestor,
                        "Gene" => $prev_state_gene,
                        "Position" => $prev_state_position,
                        "Genotype" => $prev_state_genotype,
                        "Genotype_with_Description" => $prev_state_genotype_with_description
                    );
                    $prev_state_position_arr = preg_split("/[;, \n]+/", $prev_state_position);
                    $prev_state_genotype_arr = preg_split("/[;, \n]+/", $prev_state_genotype);
                    $prev_state_genotype_with_description_arr = preg_split("/[;, \n]+/", $prev_state_genotype_with_description);

                    for ($j=0; $j<count($prev_state_position_arr); $j++){
                        $temp[$prev_state_position_arr[$j]] = $prev_state_genotype_with_description_arr[$j];
                    }

                    array_push($segment_arr, $temp);

                    if ($result_arr[$i+1]['Gene'] != $result_arr[$i]['Gene'] || $result_arr[$i+1]['Position'] != $result_arr[$i]['Position']){
                        array_push($processed_arr, $segment_arr);
                        $segment_arr=array();
                    }
                }
            } else if(($i+1)==count($result_arr)){
                $temp = array(
                    "Soja" => $prev_state_soja,
                    "Cultivar" => $prev_state_cultivar,
                    "Landrace" => $prev_state_landrace,
                    "Total" => $prev_state_soja + $prev_state_cultivar + $prev_state_landrace,
                    "NA_ANC" => $prev_state_na_ancestor,
                    "Gene" => $prev_state_gene,
                    "Position" => $prev_state_position,
                    "Genotype" => $prev_state_genotype,
                    "Genotype_with_Description" => $prev_state_genotype_with_description
                );
                $prev_state_position_arr = preg_split("/[;, \n]+/", $prev_state_position);
                $prev_state_genotype_arr = preg_split("/[;, \n]+/", $prev_state_genotype);
                $prev_state_genotype_with_description_arr = preg_split("/[;, \n]+/", $prev_state_genotype_with_description);

                for ($j=0; $j<count($prev_state_position_arr); $j++){
                    $temp[$prev_state_position_arr[$j]] = $prev_state_genotype_with_description_arr[$j];
                }

                array_push($segment_arr, $temp);
                array_push($processed_arr, $segment_arr);
                $segment_arr=array();
            }



        }
    }

    // echo json_encode($processed_arr[0]);

    return $processed_arr;
}



?>
