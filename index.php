<?php 
include("functions.php");
include("config.php");

$bar_account_query = 'select * from "public"."user_balance" WHERE "public"."user_balance".nick = \'%s\';';
$bar_history_query = 'WITH t AS (SELECT transactiondatetime,transaction_price,description,volume,sell_price FROM user_transactions 
WHERE "public"."user_transactions".nick = \'%s\' ORDER BY "transactiondatetime" DESC, nick LIMIT 10)
SELECT * FROM t ORDER BY "transactiondatetime" ASC;';

$query = sprintf($bar_account_query,$_SERVER['Shib-uid']);
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$num_rows = pg_num_rows($result);
if ($num_rows == 0) {
    $bar_balance = "No bar account found";
}else{
    $row = pg_fetch_row($result);
    $bar_balance = number_format($row[0],2);
}

$query = sprintf($bar_history_query,$_SERVER['Shib-uid']);
$bar_history = pg_query($query) or die('Query failed: ' . pg_last_error());
?>
<html>
<head>
<title>Nurdspace user system</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="top">

<div id="header">
<H1><?=greeting();?> <?=$_SERVER['Shib-givenName']?>, and welcome to the Nurdspace user system.</H1>
</div>
<?include("menu.php");?>
<div class="clear"> </div>

</div>

<div id="contentwrap">

<div class="cright">
<h2>Nurdbar</h2>
<? if (is_numeric($bar_balance)) { ?>
<p>Your bar balance is: &euro; <?=$bar_balance?></p>
<h3>Bar history</h3>
<table>
<TR><TH>Date/Time</TH><TH>+/-</TH><TH>Amount</TH><TH>Price</TH><TH>Description</TH><TH>Volume</TH></TR>
<?
while ($line = pg_fetch_array($bar_history)) {
?>
<tr>
<td><?=date("j F, Y, H:i", strtotime($line[0]))?></td>
<td><?=($line[1] < 0)?"-":"+"?></td>
<td><?if($line[1] < 0) {?><?=(abs($line[1])/$line[4])?><?}?></td>
<td>&euro; <?=number_format(abs($line[1]),2)?></td>
<td><?=$line[2]?></td>
<td><?=$line[3]?></td>
</td>
<?}?>
</table>
<? } else { echo "No bar account found"; } ?>
<h2>Rights</h2>
<UL>
<?
$roles = explode(';',$_SERVER['Shib-roles']);
foreach ($roles as $role){
print "<LI>{$role}</LI>";
};
?>
</UL>
</div>

<div class="cleft">

<ul>
<li><a href="https://nurdspace.nl">Wiki</a></li>
<li><a href="https://parts.nurdspace.lan/">Partkeepr</a></li>
<li><a href="https://ldap.nurdspace.nl/">FusionDirectory</a></li>
<li><a href="/Shibboleth.sso/Logout">Logout</a></li>
</ul>
</div>

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
