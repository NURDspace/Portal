<?
include("../functions.php");
include("functions.php");
require("bootstrap.php");

$addressbook_id = get_addressbook_by_nick($_SERVER['Shib-uid']);
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
<tr><th>Date</th><th>Description</th><th>Amount</th><th>Pay date</th></tr>
<?
$invoices_paid = $entityManager->getRepository('Invoice')->findBy(array('paid'=>1,'addressbook'=>$addressbook_id));

foreach ($invoices_paid as $invoice) {
?>
<tr><td><?=$invoice->getDate()?></td><td><?=$invoice->getDescr()?></td><td><?=$invoice->getAmount()?></td><td><?=$invoice->getPaidDate()?></td></tr>
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
