<?
include("../functions.php");
if (!has_role("finance")) {
    echo "Access Denied";
    exit();
}
include("functions.php");
require("bootstrap.php");

if (isset($_POST['transaction_id']) && isset($_POST['invoice_id'])) {
    foreach ($_POST['invoice_id'] as $key => $invoice_id){
        $transaction_id = $_POST['transaction_id'][$key];
        if ($invoice_id != 0 && $transaction_id != 0) {
            $invoice = $entityManager->getRepository('Invoice')->findOneBy(array('id'=>$invoice_id));
            $transaction = $entityManager->getRepository('Transaction')->findOneBy(array('id'=>$transaction_id));
            $transaction->getInvoices()->add($invoice);
            $entityManager->persist($transaction);
            $entityManager->flush();

            if (($transaction->getAmount() - $invoice->getAmount()) >= 0) {
                $invoice->setPaid(1);
                $invoice->setPaidDate($transaction->getDate());
                $entityManager->persist($invoice);
                $entityManager->flush();
            }
        }
    }
    foreach ($_POST['claim_id'] as $key => $claim_id){
        $transaction_id = $_POST['transaction_id'][$key];
        if ($claim_id != 0 && $transaction_id != 0) {
            $claim = $entityManager->getRepository('Claim')->findOneBy(array('id'=>$claim_id));
            $transaction = $entityManager->getRepository('Transaction')->findOneBy(array('id'=>$transaction_id));
            $transaction->getClaims()->add($claim);
            $entityManager->persist($transaction);
            $entityManager->flush();

            if (($transaction->getAmount() - $claim->getAmount()) >= 0) {
                $claim->setPaid(1);
                $claim->setPaidDate($transaction->getDate());
                $entityManager->persist($claim);
                $entityManager->flush();
            }
        }
    }
}
?>
<html>
<head>
<title>Nurdspace user system</title>
<link rel="stylesheet" type="text/css" href="../style.css" />
<link rel="stylesheet" type="text/css" href="../table-style.css" />
</head>
<body>
<div id="top">

<div id="header">
<H1>All hail <?=$_SERVER['Shib-givenName']?></H1>
</div>
<?include("menu.php");?>
<div class="clear"> </div>

</div>

<div id="contentwrap">

<div class="cright">
<a href="transactions.php?booked=0">Show only unbooked</a>
<h2>Transactions</h2>
<form method="POST">
<table id="hor-minimalist-b">
<?
$transactions = $entityManager->getRepository('Transaction')->findBy(array(),array('date'=>'desc'));

foreach ($transactions as $line) {
    $transaction_booked = ($line->getCdtDbt() == "CRDT")?transaction_crdt_booked($line->getId()):false;
    $transaction_dbit_booked = ($line->getCdtDbt() == "DBIT")?transaction_dbit_booked($line->getId()):false;
    if ((isset($_GET['booked']) && !$transaction_booked) or !isset($_GET['booked'])) {
?>
<tr>
    <td><?=$line->getSeq()?></td>
    <td><nobr><?=$line->getDate()?></nobr></td>
    <td><?=$line->getCdtDbt()?></td>
    <td><nobr><?=$line->getAccountNr()?></nobr></td>
    <td><nobr><?=$line->getName()?></nobr></td>
    <td><?=$line->getDescr()?></td>
    <td><?=$line->getAmount()?></td></tr>
<? if ($line->getCdtDbt() == "CRDT" && !$transaction_booked) {?>
<tr><td colspan="6">
<nobr>
<input type="hidden" name="transaction_id[]" value="<?=$line->getId()?>">
<input type="hidden" name="claim_id[]" value="0">
<select name="invoice_id[]">
<option value="0">Nothing selected</option>
<?=select_openinvoices()?>
</select>
<input type="submit">
</nobr>
</td></tr>
<?
}
if ($line->getCdtDbt() == "DBIT" && !$transaction_dbit_booked) {?>
<tr><td colspan="6">
<nobr>
<input type="hidden" name="transaction_id[]" value="<?=$line->getId()?>">
<input type="hidden" name="invoice_id[]" value="0">
<select name="claim_id[]">
<option value="0">Nothing selected</option>
<?=select_openclaims()?>
</select>
<input type="submit">
</nobr>
</td></tr>
<?
}
}
}
echo "</table>\n";
?>
</form>
</div>
<?include("sidemenu.php");?>
<div class="clear"> </div>

</div>

<div id="footer">

<div class="left">
</div>

<div class="right">
</div>

<div class="clear"> </div>

</div>

</body>
</html>
