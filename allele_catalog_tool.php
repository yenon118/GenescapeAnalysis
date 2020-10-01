<?php
$TITLE = "Allele Catalog Tool";
include '../header.php';
?>


<style>
		body {
			background-color: darkseagreen;
			text-align: left;
			font-family: "Calibri", sans-serif;
		}
		button {
			background-color: #00802b; /* Green */
			border: none;
			color: white;
            margin: 5px 10px;
			padding: 8px 19px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 12px;
            border-radius: 5px;
		}

		h1 {
            width: 100%;
            text-align: left;
			font-size: 1.8em;
			color: lemonchiffon;
            text-shadow: 1px 1px black;
			font-family: serif;
		}
        #queryBox {
            margin: 0px;
            height: auto;
            width: 60%;
            text-align: left;
            background-color: lightyellow;
            color: black;
            border: 1px solid darkolivegreen;
            border-radius: 5px;
        }
        .queryOptions {
            text-algin: center;
        }

        #searchByPosOption {
            border: none;
        }
        #firstOptions {
            margin: 0px;
            text-align: left;
        }

        .searchElement{
            margin: 15px;
            float: left;
        }
        .clear:after{
            content: "";
            display: table;
            clear: both;
        }

        #secondOptions {
            margin: 0px;
            text-align: left;
        }

	</style>
	<script>            //Scripts to update the options page with appropriate options
		function geneIDSelected(val){
			console.log(val);
			if(val=='GenePossel'){
				console.log(val);
				document.getElementById('searchByGeneOption').style.visibility='hidden';
				document.getElementById('searchByPosOption').style.visibility='visible';
			}
			else if (val=='GeneIDsel'){
				document.getElementById('searchByPosOption').style.visibility='hidden';
				document.getElementById('searchByGeneOption').style.visibility='visible';
			}
		}
		function displayIDExample(val){
			if (val=='Wm82v1'){
				document.getElementById("idBox").value = "Ex: Glyma01g00410";
			}
			else if(val=='Wm82v2'){
				document.getElementById("idBox").value = "Ex: Glyma.01G001100";
			}
			else if(val=='Wm82v4'){
				document.getElementById("idBox").value = "Ex: Glyma.01G001100";
			}
			else if (val==`Soja`){
				document.getElementById("idBox").value = "Ex: GlysoPI483463.01G001000";
			}
			else if (val=='Lee'){
				document.getElementById("idBox").value = "Ex: GlymaLee.01G001100";
			}
		}
	</script>

<div>
    <table width="100%" cellspacing="14" cellpadding="14">
        <tr>
            <td width="50%" align="center" valign="top"
                style="border:1px solid #999999; padding:10px; background-color:#f8f8f8; text-align:left;">
                <form action= "allele_catalog_tool_results.php" method="get">

                    <label for="queryBy">Search By:</label>
                    <select id = "queryBy" class="queryOptions" name="queryBy" onchange="geneIDSelected(this.value)">
                        <option value ="GenePossel" selected>Gene Position</option>
                    </select>

                    <label for="genomeQueried">On Genome:</label>
                    <select id="genomeQueried" class="queryOptions" name="genomeQueried" onload = "displayIDExample(this.value)" onchange = "displayIDExample(this.value)">
                        <option value="Wm82v1" selected>Wm82v1</option>
                        <option value="Wm82v2">Wm82v2</option>
                        <option value="Wm82v4">Wm82v4</option>
                        <option value="Soja">Soja</option>
                        <option value="Lee">Lee</option>
                    </select>

                    <fieldset  id = "searchByPosOption" style = "visibility:visible">
                        <div class="searchElement">
                            <label for="chromoSelect">Chromosome Number:</label>
                            <select id="chromoSelect" name='Chromosome' >
                                <option value='1' selected='selected'>1</option>
                                <option value='2'>2</option>
                                <option value='3'>3</option>
                                <option value='4'>4</option>
                                <option value='5'>5</option>
                                <option value='6'>6</option>
                                <option value='7'>7</option>
                                <option value='8'>8</option>
                                <option value='9'>9</option>
                                <option value='10'>10</option>
                                <option value='11'>11</option>
                                <option value='12'>12</option>
                                <option value='13'>13</option>
                                <option value='14'>14</option>
                                <option value='15'>15</option>
                                <option value='16'>16</option>
                                <option value='17'>17</option>
                                <option value='18'>18</option>
                                <option value='19'>19</option>
                                <option value='20'>20</option>
                            </select>
                        </div>
                        <div class="searchElement">
                            <label for="spair">Start Range:</label>
                            <input id="spair" type="text" name="BottomRange">
                        </div>
                        <div class="searchElement">
                            <label for="epair">End Range:</label>
                            <input id="epair" type="text" name="TopRange">
                        </div>
                    </fieldset>

                    <button name = "returnOption" type = "submit" value = 0>Search</button>
                    <button name = "returnOption" type = "submit" value = 1>Return Full Gold Standard List</button>
                </form>
            </td><td></td>
        </tr>
        <tr>
        </tr>
    </table>
</div>

<?php include '../footer.php'; ?>
