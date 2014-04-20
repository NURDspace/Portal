<?
include("../functions.php");
include("functions.php");

if (!has_role("finance")) {
    echo "Access Denied";
    exit();
}

if (isset($_GET['generate'])){
    $datenow = new DateTime('now');
    $subscriptionsRepo = $entityManager->getRepository('Subscription');
    $qb = $subscriptionsRepo->createQueryBuilder('s');
    $qb->where('s.endDate = \'0000-00-00\' and s.startDate < :startDate');
    $qb->setParameter('startDate',$datenow->format('Y-m-d'));
    $subscriptions = $qb->getQuery()->getResult();
    foreach ($subscriptions as $line) { 
        if ($line->getLastInvoiceDate() == '0000-00-00') {
            $line_5 = explode('-',$line->startDate());
            $last_subs_date = $line_5[0]."-".($line_5[1]-1)."-".$line_5[2];
        } else
            $last_subs_date = $line->getLastInvoiceDate(); 
        $diff = abs(strtotime("now") - strtotime($last_subs_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $difference_months = ($years*12)+$months;
        if ($difference_months > 0) {
            for ($i = 1; $i <= $difference_months; $i++) {
                $last_invoice_date = explode("-",$last_subs_date);
                $invoice_month = mktime(0, 0, 0, $last_invoice_date[1]+$i, $last_invoice_date[2],  $last_invoice_date[0]);
                $invoice = new Invoice();
                $invoice->setDate(date("Y-m-d"));
                $invoice->setAddressbook();
                $invoice->setDescr('Subscription invoice '.date("F Y",$invoice_month)." {$line->getDescr()}");
                $invoice->setAmount($line->getAmount);
                $invoice->setSubscription($line);
                $entityManager->persist($invoice);
                $entityManager->flush();
                $line->setLastInvoiceDate(date("Y-m-d"));
                $entityManager->persist($line);
                $entityManager->flush();
            }
        }
    }
}
if (isset($_GET['set_paid'])) {
    $invoice = $entityManager->getRepository('Invoice')->findOneBy(array('id'=>$_GET['set_paid']));
    $invoice->setPaidDate(date("Y-m-d"));
    $invoice->setPaid(1);
    $entityManager->persist($invoice);
    $entityManager->flush();
}
if (isset($_POST['date']) && isset($_POST['addressbook_id'])) {
    $address = $entityManager->getRepository('Addressbook')->findOneBy(array('id'=>$_POST['addressbook_id']));
    $invoice = new Invoice();
    $invoice->setAddressbook($address);
    $invoice->setPaid(false);
    $invoice->setDate($_POST['date']);
    $invoice->setDescr($_POST['descr']);
    $invoice->setAmount($_POST['amount']);
    $entityManager->persist($invoice);
    $entityManager->flush();
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
<H1><?=greeting();?> <?=$_SERVER['Shib-givenName']?></H1>
</div>
<?include("menu.php");?>
<div class="clear"> </div>

</div>

<div id="contentwrap">

<div class="cright">
<a href="invoices.php?generate=1">Generate subscription invoices</a>
<form method="POST">
Date (0000-00-00)<input type="text" name="date">
Description<input name="descr">
Amount<input name="amount">
AddressBook<select name="addressbook_id">
<?=select_addressbook()?>
</select>
<input type="submit">
</form>
<h2>Open Invoices</h2>
<table id="hor-minimalist-b">
<?
$invoices = $entityManager->getRepository('Invoice')->findBy(array('paid'=>0),array('date'=>'desc'));
foreach ($invoices as $invoice) {
?>
<tr>
    <td><?=$invoice->getDate()?></td>
    <td><?=$invoice->getDescr()?></td>
    <td><?=$invoice->getAmount()?></td>
    <td><?=$invoice->getAddressbook()->getName()?></td>
    <td><?=$invoice->getAddressbook()->getNick()?></td>
    <td><a href="invoices.php?set_paid=<?=$invoice->getId()?>">Set Paid</a></td></tr>
<?
}
?>
</table>

<h2>Closed Invoices</h2>
<table id="hor-minimalist-b">
<?
$invoices = $entityManager->getRepository('Invoice')->findBy(array('paid'=>1),array('paidDate'=>'desc'));
foreach ($invoices as $invoice) {
?>
<tr>
    <td><?=$invoice->getDate()?></td>
    <td><?=$invoice->getDescr()?></td>
    <td><?=$invoice->getAmount()?></td>
    <td><?=$invoice->getAddressbook()->getName()?></td>
    <td><?=$invoice->getAddressbook()->getNick()?></td>
    <td><?=$invoice->getPaidDate()?></td>
<?
}
?>
</table>
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
