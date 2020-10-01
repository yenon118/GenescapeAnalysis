<?php
$TITLE = "Allele Catalog Tool";
include '../header.php';
?>

<style>
    table {
        border-collapse: collapse;
        border: 2px solid cornflowerblue;
        table-layout:auto;
        margin:auto;
    }
    th, td{
        text-align: center;
        border: 2px solid cornflowerblue;
    }

     button {
         background-color: #00802b; /* Green */
         border: none;
         color: whitesmoke;
         padding: 8px 19px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 12px;
     }

    thead {
        background:#a6edb2;
    }
</style>
<script>
    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV filet
        csvFile = new Blob([csv], {type: "text/csv"});

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
    }
    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("table tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++)
                row.push(cols[j].innerText);

            csv.push(row.join(","));
        }

        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
    }
</script>

<?php
//Connect to the Database
$servername="localhost";
$username="KBCommons";
$password="KsdbsaKNm55d3QtvtX44nSzS";
$db="kb_test";
$conn = mysqli_connect($servername,$username,$password,$db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$displayArray = array("Wm82v2 ID", "Wm82v2 Chromosome", "Wm82v2 Start Pair", "Wm82v2 End Pair", "Wm82v2 Description",
    "Wm82v1 ID","Wm82v1 Chromosome","Wm82v1 Start Pair","Wm82v1 End Pair", "Wm82v1 Description",
    "Wm82v4 ID","Wm82v4 Chromosome","Wm82v4 Start Pair","Wm82v4 End Pair", "Wm82v4 Description",
    "Glyma Lee ID", "Glyma Lee Chromosome", "Glyma Lee Start Pair", "Glyma Lee End Pair", "Glyma Lee Description",
    "Glycine Soja ID", "Glycine Soja Chromosome", "Glycine Soja Start Pair", "Glycine Soja End Pair", "Glycine Soja Description");


$qType = $_GET["queryBy"];
$returnOption = $_GET["returnOption"];

if ($qType == "GenePossel"){


    $genomeToQ = $_GET["genomeQueried"];            //ASSIGN APPROPRIATE VALUES TO REFERENCE IN SENDING QUEUES
    $chromosomeNum = $_GET["Chromosome"];
    $sPair = $_GET["BottomRange"];
    $ePair = $_GET["TopRange"];

    echo "You Searched For Genes In ".$genomeToQ."   On Chromosome ".$chromosomeNum."<br /><br />Starting At Base Pair: ".$sPair."   And Ending at Base Pair: ".$ePair;                                             //print the query you entered
?>

<br />
<br />
<br />

<button onclick = "exportTableToCSV('SequenceSearchResults.csv')">Export Results To CSV File</button>

<br />
<br />
<br />

<?php
              //Set the queried assembly to the first display column
$arr2 = new SplFixedArray(5);                   //array for holding the searcED info
    if ($genomeToQ == "Soja"){                      //UPDATE VERSION QUERY VALUE
        $chromosomeQ = 'Gs'.$chromosomeNum;
        $arr2 = array_splice($displayArray, 20, 5);      //PUT THE ONE YOU QUERY ON FAR LEFT OF DISPLAY TABLE
    }
    else if ($genomeToQ=="Wm82v1"){
        $chromosomeQ = 'Gm'.$chromosomeNum;
        $arr2 = array_splice($displayArray, 5, 5);
    }
    else {
        $chromosomeQ = 'Gm'.$chromosomeNum;
        if ($genomeToQ == "Wm82v2"){
            $arr2 = array_splice($displayArray, 0, 5);
        }
        else if( $genomeToQ=="Lee"){
            $arr2 = array_splice($displayArray, 15, 5);
        }
        else{
            $arr2 = array_splice($displayArray, 10, 5);
        }
    }

    array_unshift($displayArray, $arr2[0],$arr2[1],$arr2[2],$arr2[3],$arr2[4]);     //puts the searchED information on the left side

                        //WOULD LIKE TO INSERT THESE INTO AN HTML OR JS TABLE FOR BETTER VIEWING N BYOND TEXT
    if ($returnOption == 1){
        $sql = "CALL LoadGenome();";
    }
    else {
        $sql = "CALL ".$genomeToQ."PositionQuery('$sPair', '$ePair', '$chromosomeNum');";         //DISPLAYS THE COLUMN HEADERS
    }
        $result = mysqli_query($conn, $sql) or die("Query fail: " . mysqli_error($conn));}
        if ($result->num_rows > 0) {
            //echo "<table class='pure-table'><tr><th>$displayArray[0]</th><th>$displayArray[1]</th><th>$displayArray[2]</th><th>$displayArray[3]</th><th>$displayArray[4]</th><th>$displayArray[5]</th><th>$displayArray[6]</th><th>$displayArray[7]</th><th>$displayArray[8]</th><th>$displayArray[9]</th><th>$displayArray[10]</th></tr>";
            echo "<div style='width:100%;height:100%; border:3px solid #000; overflow:scroll;max-height:1000px;'><table class='pure-table' align = 'center'><tr>";
            echo "<th> Available Description </th>";
            for ($i = 0; $i < count($displayArray); $i++)
                echo "<th>$displayArray[$i]</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_array($result)) {
                $x = $row[4] ?? $row[9] ?? $row[14] ?? $row[19] ?? $row[24] ?? "N/A";
                echo "<tr><td>" . $x . "</td>";
                for ($i = 0; $i < 25; $i++)
                    echo "<td>" . $row[$i] . "</td>";
                echo "</tr>";
            }
            echo "</table></div>";
            $conn->close();
        }
else if ($qType == "GeneIDsel"){
    $geneID = $_GET["geneID"];
    echo $geneID;
}
else{
    echo "<br />";
    echo "OH NO IT DIDN'T WORK";
}
?>

<?php include '../footer.php'; ?>
