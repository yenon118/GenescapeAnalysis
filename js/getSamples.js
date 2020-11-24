function constructInfoTable(arr) {
    var ref_color_code = "#D1D1D1";
    var missense_variant_color_code = "#7FC8F5";
    var frameshift_variant_color_code = "#F26A55";
    var exon_loss_variant_color_code = "#F26A55";
    var lost_color_code = "#F26A55";
    var gain_color_code = "#F26A55";
    var disruptive_color_code = "#F26A55";
    var splice_color_code = "#9EE85C";

    // Put data into modal
    document.getElementById('modal-content-div').innerHTML = "<table id='modal-content-table'><tr id='modal-content-table-head'></tr></table>";

    document.getElementById('modal-content-table-head').innerHTML += "<th style=\"min-width:80px;text-align:center\">Classification</th>";
    document.getElementById('modal-content-table-head').innerHTML += "<th style=\"min-width:80px;text-align:center\">Improvement Status</th>";
    document.getElementById('modal-content-table-head').innerHTML += "<th style=\"min-width:80px;text-align:center\">Maturity Group</th>";
    document.getElementById('modal-content-table-head').innerHTML += "<th style=\"min-width:80px;text-align:center\">Country</th>";
    document.getElementById('modal-content-table-head').innerHTML += "<th style=\"min-width:80px;text-align:center\">State</th>";
    document.getElementById('modal-content-table-head').innerHTML += "<th style=\"min-width:120px;text-align:center\">Accession</th>";
    document.getElementById('modal-content-table-head').innerHTML += "<th style=\"min-width:80px;text-align:center\">Gene</th>";

    keys = Object.keys(arr[0]);
    for (var i = 0; i < keys.length; i++) {
        if(keys[i] != "Sample" && keys[i] != "Gene" && keys[i] != "Type" && keys[i] != "Category" && keys[i] != "Number" && keys[i] != "Country" && keys[i] != "Location" && keys[i] != "Classification" && keys[i] != "Improvement_Status" && keys[i] != "Maturity_Group" && keys[i] != "State" && keys[i] != "Accession"){
            document.getElementById('modal-content-table-head').innerHTML += "<th style=\"min-width:80px;text-align:center\">"+keys[i]+"</th>";
        }
    }

    var tr_bgcolor = ""
    for (var i = 0; i < arr.length; i++) {
        if (i % 2 == 1){
            tr_bgcolor = "#FFFFFF";
        } else {
            tr_bgcolor = "#DDFFDD";
        }
        modal_content_table_data_id = "modal-content-table-data-"+i;
        document.getElementById('modal-content-table').innerHTML += "<tr id='"+modal_content_table_data_id+"' bgcolor='"+tr_bgcolor+"'></tr>"

        document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:left\">"+((arr[i]["Classification"] === null) ? '' : arr[i]["Classification"]) +"</td>";
        document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:left\">"+((arr[i]["Improvement_Status"] === null) ? '' : arr[i]["Improvement_Status"]) +"</td>";
        document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:left\">"+((arr[i]["Maturity_Group"] === null) ? '' : arr[i]["Maturity_Group"]) +"</td>";
        document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:left\">"+((arr[i]["Country"] === null) ? '' : arr[i]["Country"]) +"</td>";
        document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:left\">"+((arr[i]["State"] === null) ? '' : arr[i]["State"]) +"</td>";
        document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:120px;text-align:left\">"+((arr[i]["Accession"] === null) ? '' : arr[i]["Accession"]) +"</td>";
        document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:center\">"+((arr[i]["Gene"] === null) ? '' : arr[i]["Gene"]) +"</td>";

        for (var j = 0; j < keys.length; j++) {

            if(keys[j] != "Sample" && keys[j] != "Gene" && keys[j] != "Type" && keys[j] != "Category" && keys[j] != "Number" && keys[j] != "Country" && keys[j] != "Location" &&
                keys[j] != "Classification" && keys[j] != "Improvement_Status" && keys[j] != "Maturity_Group" && keys[j] != "State" && keys[j] != "Accession"){
                if(arr[i][keys[j]].search(/missense.variant/i) != -1 && arr[i][keys[j]].search(/missense.variant/i) != undefined){
                    var temp_value_arr = arr[i][keys[j]].split('|');
                    var temp_value = (temp_value_arr.length > 2) ? temp_value_arr[0]+"|"+temp_value_arr[2] : arr[i][keys[j]];
                    document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:center;background-color:"+missense_variant_color_code+"\">"+temp_value+"</td>";
                } else if(arr[i][keys[j]].search(/frameshift/i) != -1 && arr[i][keys[j]].search(/frameshift/i) != undefined){
                    document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:center;background-color:"+frameshift_variant_color_code+"\">"+arr[i][keys[j]]+"</td>";
                } else if(arr[i][keys[j]].search(/exon.loss/i) != -1 && arr[i][keys[j]].search(/exon.loss/i) != undefined){
                    document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:center;background-color:"+exon_loss_variant_color_code+"\">"+arr[i][keys[j]]+"</td>";
                } else if(arr[i][keys[j]].search(/lost/i) != -1 && arr[i][keys[j]].search(/lost/i) != undefined){
                    document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:center;background-color:"+lost_color_code+"\">"+arr[i][keys[j]]+"</td>";
                } else if(arr[i][keys[j]].search(/gain/i) != -1 && arr[i][keys[j]].search(/gain/i) != undefined){
                    document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:center;background-color:"+gain_color_code+"\">"+arr[i][keys[j]]+"</td>";
                } else if(arr[i][keys[j]].search(/disruptive/i) != -1 && arr[i][keys[j]].search(/gain/i) != undefined){
                    document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:center;background-color:"+disruptive_color_code+"\">"+arr[i][keys[j]]+"</td>";
                } else if(arr[i][keys[j]].search(/splice/i) != -1 && arr[i][keys[j]].search(/gain/i) != undefined){
                    document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:center;background-color:"+splice_color_code+"\">"+arr[i][keys[j]]+"</td>";
                } else if(arr[i][keys[j]].search(/ref/i) != -1 && arr[i][keys[j]].search(/ref/i) != undefined){
                    document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:center;background-color:"+ref_color_code+"\">"+arr[i][keys[j]]+"</td>";
                } else{
                    document.getElementById(modal_content_table_data_id).innerHTML += "<td style=\"min-width:80px;text-align:center;background-color:#FFFFFF\">"+arr[i][keys[j]]+"</td>";
                }
            }
        }
    }

    document.getElementById("modal-content-comment").innerHTML = "<p>Total number of samples: "+arr.length+"</p>";

}


function getSamples(key, gene, position, genotype_with_description) {

    $.ajax({
        url: 'GenescapeAnalysis_PHP/getSamples.php',
        type: 'GET',
        contentType: 'application/json',
        data: {
            Key: key,
            Gene: gene,
            Position: position,
            Genotype_with_Description: genotype_with_description,
        },
        success: function (response) {
            res = JSON.parse(response);
            res = res.data;
            // console.log(res);
            position_arr = position.toString().split(' ');
            genotype_with_description_arr = genotype_with_description.toString().split(' ');
            for (var i = 0; i < res.length; i++) {
                res[i]["Gene"] = gene
                for(var j = 0; j < position_arr.length; j++){
                    res[i][position_arr[j]] = genotype_with_description_arr[j]
                }
            }
            // console.log(res);

            // Open modal
            document.getElementById("info-modal").style.display = "block";

            constructInfoTable(res);

        },
        error: function(xhr, status, error){
            console.log('Error with code ' + xhr.status + ': ' + xhr.statusText);
        }
    });

}
