function checkbox_highlights(event){

    gene_and_n = event.id.replace('no__', '').split('__');
    gene = gene_and_n[0];
    n = gene_and_n[1];

    if(document.getElementById(event.id).checked){
        var matches = $("td[id^='pos__".concat(gene,"__']"));

        for (let i = 0; i < matches.length; i++) {
            matches_id_str_arr = matches[i].id.split('__');
            if(parseInt(matches_id_str_arr[matches_id_str_arr.length - 1]) == parseInt(n)){
                matches[i].style.fontSize = "15px";
                // console.log(matches[i].style.fontSize);
            }
        }
    } else{
        var matches = $("td[id^='pos__".concat(gene,"__']"));

        for (let i = 0; i < matches.length; i++) {
            matches_id_str_arr = matches[i].id.split('__');
            if(parseInt(matches_id_str_arr[matches_id_str_arr.length - 1]) == parseInt(n)){
                matches[i].style.fontSize = "";
                // console.log(matches[i].style.fontSize);
            }
        }
    }

}