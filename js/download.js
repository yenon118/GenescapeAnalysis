function convertJsonToCsv(json_obj){
    let csv_str = '';
    let keys = Object.keys(json_obj[0]);
    csv_str += keys.join(',')+'\n';
    for (let i=0; i<json_obj.length; i++){
        for (let j=0; j<keys.length; j++){

            if(j >= (keys.length-1)){
                csv_str += ((json_obj[i][keys[j]] === null) || (json_obj[i][keys[j]] === undefined)) ? '' : json_obj[i][keys[j]];
            } else {
                csv_str += ((json_obj[i][keys[j]] === null) || (json_obj[i][keys[j]] === undefined)) ? ',' : json_obj[i][keys[j]]+',';
            }

        }
        csv_str += '\n';
    }

    return csv_str;
}


function createAndDownloadCsvFile(csv_str, filename){
    var dataStr = "data:text/csv;charset=utf-8,"+csv_str;
    var downloadAnchorNode = document.createElement('a');
    downloadAnchorNode.setAttribute("href", dataStr);
    downloadAnchorNode.setAttribute("download", filename+".csv");
    document.body.appendChild(downloadAnchorNode); // required for firefox
    downloadAnchorNode.click();
    downloadAnchorNode.remove();
}


function createAndDownloadJsonFile(json_obj, filename){
    var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(json_obj));
    var downloadAnchorNode = document.createElement('a');
    downloadAnchorNode.setAttribute("href", dataStr);
    downloadAnchorNode.setAttribute("download", filename+".json");
    document.body.appendChild(downloadAnchorNode); // required for firefox
    downloadAnchorNode.click();
    downloadAnchorNode.remove();
}


function downloadAllByGene(gene) {

    $.ajax({
        url: 'GenescapeAnalysis_PHP/download.php',
        type: 'GET',
        contentType: 'application/json',
        data: {
            Gene: gene,
        },
        success: function (response) {
            var res = JSON.parse(response);
            res = res.data;
            // console.log(res);

            if (res.length > 0){
                var csv_str = convertJsonToCsv(res);
                createAndDownloadCsvFile(csv_str, gene+"_data");
            }

        },
        error: function(xhr, status, error){
            console.log('Error with code ' + xhr.status + ': ' + xhr.statusText);
        }
    });

}
