
<?php
$TITLE = "Soybean Allele Catalog";
include '../header.php';
?>

<script type="text/javascript">
</script>

<div>
    <table width="100%" cellspacing="14" cellpadding="14">
        <tr>
            <td width="50%" align="center" valign="top"
                style="border:1px solid #999999; padding:10px; background-color:#f8f8f8; text-align:left;">
                <form action="viewer.php" method="get">
                    <h2>Search By Gene Name</h2>
                    <br />
                    <b>Gene name</b><span>&nbsp;(eg Glyma.01g049100 Glyma.01g049200 Glyma.01g049300)</span>
                    <br />
                    <textarea id="gene" name="gene" rows="12" cols="50" placeholder="&#10;Please separate each gene into a new line. &#10;&#10;Example:&#10;Glyma.01g049100&#10;Glyma.01g049200&#10;Glyma.01g049300"></textarea>
                    <br /><br />
                    <input type="submit" value="Search">
                </form>
            </td>
            <td width="50%" align="center" valign="top"
                style="border:1px solid #999999; padding:10px; background-color:#f8f8f8; text-align:left;">
                <form action="viewAllByAccessionAndGene.php" method="get">
                    <h2>Search By Accession and Gene Name</h2>
                    <br />
                    <b>Accession</b><span>&nbsp;(eg HN052_PI424079 PI_479752)</span>
                    <br />
                    <textarea id="accession" name="accession" rows="9" cols="50" placeholder="&#10;Please separate each accession into a new line. &#10;&#10;Example:&#10;HN052_PI424079&#10;PI_479752"></textarea>
                    <br /><br />
                    <b>Gene name</b><span>&nbsp;(One gene name only; eg Glyma.01g049100)</span>
                    <br />
                    <input type="text" id="gene" name="gene" size="53"></input>
                    <br /><br />
                    <input type="submit" value="Search">
                </form>
            </td>
        </tr>
        <tr>
        </tr>
    </table>
</div>

<?php
// $response = file_get_contents('http://localhost:5000/');
// echo $response;
// echo "hello"
?>

<script type="text/javascript" language="javascript">
</script>

<?php include '../footer.php'; ?>
