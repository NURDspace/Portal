<?
include("../functions.php");
include("functions.php");
require("bootstrap.php");

if (!has_role("finance")) {
echo "Access Denied";
exit();
}

if (isset($_POST['start_date']) && isset($_POST['amount'])) {
    $address = $entityManager->getRepository('Addressbook')->findOneBy(array('id'=>$_POST['addressboo
k_id']));
    $subscription = new Subscription();
    $subscription->setStartDate($_POST['start_date']);
    $subscription->setAmount($_POST['amount']);
    $subscription->setDescr($_POST['descr']);
    $subscription->setAddressbook($address);
    $entityManager->persist($subscription);
    $entityManager->flush();
}

if (isset($_GET['end_subscription'])) {
    $subscription = $entityManager->getRepository('Subscription')->findOneBy(array('id'=>$_GET['end_subscription']));
    $subscription->setEndDate(date("Y-m-d"));
    $entityManager->persist($subscription);
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
<form method="POST">
start date (2014-01-01)<input name="start_date">
amount:<input name="amount">
User: <select name="addressbook_id">
<?=select_addressbook()?>
</select>
omschrijving: <input name="descr" maxlength="255">
<input type="submit">
</form>
<h2>Subscriptions (active)</h2>
<table style="font-size: 11px;" width="100%" id="hor-minimalist-b">
<tr><th>Start date</th><th>Last invoice</th><th>Addressbook</th><th>amount</th><th>descr</th></tr>
<?
$subscriptionsRepo = $entityManager->getRepository('Subscription');
$qb = $subscriptionsRepo->createQueryBuilder('s');
$qb->where('s.endDate = \'0000-00-00\'');
$subscriptions = $qb->getQuery()->getResult();
foreach ($subscriptions as $line) {
?>
<tr>
    <td><?=$line->getStartDate()?></td>
    <td><?=$line->getLastInvoiceDate()?></td>
    <td><?=$line->getAddressbook()->getName()?> (<?=$line->getAddressbook()->getNick()?>)</td>
    <td><?=$line->getAmount()?></td>
    <td><?=$line->getDescr()?></td>
    <td><a href="subscriptions.php?end_subscription=<?=$line->getId()?>">End this</a></td>
</tr>
<?
}
?>
</table>
<h2>Subscriptions (inactive)</h2>
<table style="font-size: 11px;" width="100%" id="hor-minimalist-b">
<tr><th>Start date</th><th>Last invoice</th><th>End date</th><th>Addressbook</th><th>amount</th><th>descr</th></tr>
<?
$subscriptionsRepo = $entityManager->getRepository('Subscription');
$qb = $subscriptionsRepo->createQueryBuilder('s');
$qb->where('s.endDate != \'0000-00-00\'');
$subscriptions = $qb->getQuery()->getResult();
foreach ($subscriptions as $line) {
?>
<tr>
    <td><?=$line->startDate()?></td>
    <td><?=$line->getLastInvoiceDate()?></td>
    <td><?=$line->endDate()?></td>
    <td><?=$line->getAddressbook()->getName()?> (<?=$line->getAddressbook()->getNick()?>)</td>
    <td><?=$line->getAmount()?></td>
    <td><?=$line->getDescr()?></td>
</tr>
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
