<?
include("../functions.php");
include("functions.php");

if (!has_role("finance")) {
    echo "Access Denied";
    exit();
}

if (isset($_GET['set_accepted'])) {
    $claim = $entityManager->getRepository('Claim')->findOneBy(array('id'=>$_GET['set_accepted']));
    $claim->setAccepted(true);
    $entityManager->persist($claim);
    $entityManager->flush();
}

if (isset($_GET['unset_accepted'])) {
    $claim = $entityManager->getRepository('Claim')->findOneBy(array('id'=>$_GET['unset_accepted']));
    $claim->setAccepted(false);
    $entityManager->persist($claim);
    $entityManager->flush();
}


if (isset($_GET['set_paid'])) {
    $claim = $entityManager->getRepository('Claim')->findOneBy(array('id'=>$_GET['set_paid']));
    $claim->setPaidDate(date("Y-m-d"));
    $claim->setPaid(1);
    $entityManager->persist($claim);
    $entityManager->flush();
}
if (isset($_POST['date']) && isset($_POST['addressbook_id'])) {
    $address = $entityManager->getRepository('Addressbook')->findOneBy(array('id'=>$_POST['addressbook_id']));
    $claim = new Claim();
    $claim->setAddressbook($address);
    $claim->setPaid(false);
    $claim->setAccepted(true);
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
<form method="POST">
Date (0000-00-00)<input type="text" name="date">
Description<input name="descr">
Amount<input name="amount">
AddressBook<select name="addressbook_id">
<?=select_addressbook()?>
</select>
<input type="submit">
</form>
<h2>Open claims</h2>
<table id="hor-minimalist-b">
<tr>
    <th>Date</th>
    <th>Descr</th>
    <th>Amount</th>
    <th>Name</th>
    <th>Nick</th>
</tr>
<?
$claims = $entityManager->getRepository('Claim')->findBy(array('paid'=>0),array('date'=>'desc'));
foreach ($claims as $claim) {
?>
<tr>
    <td><?=$claim->getDate()?></td>
    <td><?=$claim->getDescr()?></td>
    <td><?=$claim->getAmount()?></td>
    <td><?=$claim->getAddressbook()->getName()?></td>
    <td><?=$claim->getAddressbook()->getNick()?></td>
    <td><?
if ($claim->getAccepted()) {?>
<a href="claims.php?unset_accepted=<?=$claim->getId()?>">Unaccept</a></td>
<?}else{?>
<a href="claims.php?set_accepted=<?=$claim->getId()?>">Accept</a></td>
<?}?>
    <td><a href="claims.php?set_paid=<?=$claim->getId()?>">Set Paid</a></td></tr>
<?
}
?>
</table>

<h2>Closed claims</h2>
<table id="hor-minimalist-b">
<?
$claims = $entityManager->getRepository('Claim')->findBy(array('paid'=>1),array('paidDate'=>'desc'));
foreach ($claims as $claim) {
?>
<tr>
    <td><?=$claim->getDate()?></td>
    <td><?=$claim->getDescr()?></td>
    <td><?=$claim->getAmount()?></td>
    <td><?=$claim->getAddressbook()->getName()?></td>
    <td><?=$claim->getAddressbook()->getNick()?></td>
    <td><?=$claim->getPaidDate()?></td>
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
