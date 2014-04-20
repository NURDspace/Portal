<?
include("../functions.php");
include("functions.php");
require("bootstrap.php");

$addressbook_id = get_addressbook_by_nick($_SERVER['Shib-uid']);

if ($addressbook_id == null) {
    $addressbook = new Addressbook();
    $addressbook->setNick($_SERVER['Shib-uid']);
    $addressbook->setName($_SERVER['Shib-cn']);
    $entityManager->persist($addressbook);
    $entityManager->flush();
    $addressbook_id = $addressbook->getId();
}

if (isset($_POST['add_claim'])) {
    $address = $entityManager->getRepository('Addressbook')->findOneBy(array('id'=>$addressbook_id));
    $claim = new Claim();
    $claim->setAddressbook($address);
    $claim->setPaid(false);
    $claim->setAccepted(false);
    $claim->setDate($_POST['date']);
    $claim->setDescr($_POST['descr']);
    $claim->setAmount($_POST['amount']);
    $entityManager->persist($claim);
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
<h2>Member info</h2>
Amount of debt: &euro; <?=get_user_dept($addressbook_id)?><br>
<h2>Claim</h2>
Here add a claim
<form method="POST">
<input type="hidden" name="add_claim" value="1">
Date (0000-00-00):<input type="text" name="date">
Amount (9.95):<input name="amount">
Description:<input name="descr">
</select>
<input type="submit">
</form>
<h2>Open Invoices</h2>
<table id="hor-minimalist-b" width="100%">
<tr><th>Date</th><th>Description</th><th>Amount</th></tr>
<?
$invoices_unpaid = $entityManager->getRepository('Invoice')->findBy(array('paid'=>0,'addressbook'=>$addressbook_id));

foreach ($invoices_unpaid as $invoice) {
?>
<tr><td><?=$invoice->getDate()?></td><td><?=$invoice->getDescr()?></td><td><?=$invoice->getAmount()?></td></tr>
<? 
}
?>
</table>

<h2>Paid Invoices</h2>
<table id="hor-minimalist-b" width="100%">
<tr><th>Date</th><th>Description</th><th>Amount</th><th>Paid date</th></tr>
<?
$invoices_paid = $entityManager->getRepository('Invoice')->findBy(array('paid'=>1,'addressbook'=>$addressbook_id));

foreach ($invoices_paid as $invoice) {
?>
<tr><td><?=$invoice->getDate()?></td><td><?=$invoice->getDescr()?></td><td><?=$invoice->getAmount()?></td><td><?=$invoice->getPaidDate()?></td></tr>
<?
}
?>
</table>

<h2>Open Claims</h2>
<table id="hor-minimalist-b" width="100%">
<tr><th>Date</th><th>Description</th><th>Amount</th></tr>
<?
$claims_unpaid = $entityManager->getRepository('Claim')->findBy(array('paid'=>0,'addressbook'=>$addressbook_id));

foreach ($claims_unpaid as $claim) {
?>
<tr><td><?=$claim->getDate()?></td><td><?=$claim->getDescr()?></td><td><?=$claim->getAmount()?></td><td><?=($claim->getAccepted())?'Accepted':'Not (yet) accepted'?></td></tr>
<? 
}
?>
</table>

<h2>Paid Claims</h2>
<table id="hor-minimalist-b" width="100%">
<tr><th>Date</th><th>Description</th><th>Amount</th><th>Paid date</th></tr>
<?
$claims_paid = $entityManager->getRepository('Claim')->findBy(array('paid'=>1,'addressbook'=>$addressbook_id));

foreach ($claims_paid as $claim) {
?>
<tr><td><?=$claim->getDate()?></td><td><?=$claim->getDescr()?></td><td><?=$claim->getAmount()?></td><td><?=$claim->getPaidDate()?></td></tr>
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
