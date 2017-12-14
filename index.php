<?php
ob_start();
if (PROD === false) {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
}
require_once './DBOperations.php';
$dbOperationObj = new DBOperations();
$condition['date_from'] = (isset($_POST['date_from'])) ? (string) trim($_POST['date_from']) : date('Y-m-d');
$condition['date_to'] = (isset($_POST['date_to'])) ? (string) trim($_POST['date_to']) : date('Y-m-d');
$salesTotalReportByDate = $dbOperationObj->getSalesSummery($condition);
$productReportByInvoice = $dbOperationObj->getInvoiceByProductBetweenDates($condition);
?>

<html>
    <title>Sales Report</title>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <form name="search_frm" id="search_frm"  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  >
            <input type="text" name="date_from" id="date_from"  value="<?= $condition['date_from'] ?>"/>
            <input type="text" name="date_to" id="date_to" value="<?= $condition['date_to'] ?>"/>
            <input type="submit" name="submit_frm" value="SEARCH"/>
        </form>

        <table width='100%'>
            <tr>
                <th>SL</th>
                <th>Product</th>
                <th>Sales Total</th>
            </tr>
            <?php
            if (!empty($salesTotalReportByDate)) {
                foreach ($salesTotalReportByDate as $key => $value) {
                    ?>
                    <tr style="height: 25px;">
                        <td style="width: 5%;"><?= $key + 1; ?></td>
                        <td style="width: 25%;cursor: pointer;"><lable  data-toggle="collapse" data-target='#<?= "product_$key"; ?>'><?= $value['type']; ?></lable></td>
                <td style="width: 25%"><?= $value['total']; ?></td>
            </tr>
            <tr id="product_<?= $key; ?>" class="collapse">
                <td colspan="3">
                    <table width='100%'>
                        <tbody>
                            <tr>
                                <th>SL No</th>
                                <th>Invoice No</th>
                                <th>Product Name</th>
                                <th>Amount</th>
                            </tr>
                            <?php
                            if (!empty($productReportByInvoice)) {
                                $invoice_count = 0;
                                foreach ($productReportByInvoice as $keyIndex => $data) {
                                    if (trim($value['type']) == trim($data['type'])) {
                                        unset($productReportByInvoice[$keyIndex]);
                                        ?>
                                        <tr>
                                            <td> <?= $invoice_count + 1; ?> </td>
                                            <td><?= $data['id']; ?></td>
                                            <td><?= $data['type']; ?></td>
                                            <td><?= $data['amount']; ?></td>
                                        </tr>
                                        <?php
                                        $invoice_count++;
                                        if ($value['invoice_count'] <= $invoice_count)
                                            break;
                                    }
                                }
                            } else {
                                echo '<tr><td colspan="3">No data Found !</td></tr>';
                            }
                            ?>
                        </tbody> <!--inner -->
                    </table>
                </td>
            </tr>
            <?php
        }
    } else {
        echo '<tr><td colspan="3">No data Found !</td></tr>';
    }
    ?>

</table>

</body>

</html>