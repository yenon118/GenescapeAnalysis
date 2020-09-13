
<?php
$TITLE = "Genescape Analysis";
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
                    <textarea id="gene" name="gene" rows="10" cols="50" placeholder="&#10;Please separate each gene into a new line. &#10;&#10;Example:&#10;Glyma.01g049100&#10;Glyma.01g049200&#10;Glyma.01g049300"></textarea>
                    <br /><br />
                    <input type="submit" value="Search">
                </form>
            </td><td></td>
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

<script type="text/javascript">
</script>

<?php include '../footer.php'; ?>
