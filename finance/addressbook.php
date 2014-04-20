<?
include("../functions.php");
require("bootstrap.php");

if (!has_role("finance")) {
echo "Access Denied";
exit();
}

if (isset($_POST['name']) && isset($_POST['nick'])) {
    $addressbook = new Addressbook();
    $addressbook->setName($_POST['name']);
    $addressbook->setNick($_POST['nick']);
    $addressbook->setAddress(' ');
    $entityManager->persist($addressbook);
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
<form method="post">
name:<input type="text" name="name"><br>
nick:<input type="text" name="nick"><br>
<input type="submit">
</form>
<h2>Address book</h2>
<table id="hor-minimalist-b">
<tr><th>Name</th><th>Nick</th></tr>
<?
$addressbooks = $entityManager->getRepository('Addressbook')->findAll();
foreach ($addressbooks as $address) {
?>
<tr><td><?=$address->getName()?></td><td><?=$address->getNick()?></td></tr>
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
