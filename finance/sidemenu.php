<div class="cleft">

<ul>
<li><a href="index.php">Home</a></li>
<?if (has_role("finance")) {?><li><a href="addressbook.php">Addressbook</a></li><?}?>
<?if (has_role("finance")) {?><li><a href="invoices.php">Invoices</a></li><?}?>
<?if (has_role("finance")) {?><li><a href="subscriptions.php">Subscriptions</a></li><?}?>
<?if (has_role("finance")) {?><li><a href="transactions.php">Transactions</a></li><?}?>
<?if (has_role("finance")) {?><li><a href="import.php">Bank import</a></li><?}?>
<li><a href="/Shibboleth.sso/Logout">Logout</a></li>
</ul>
</div>
