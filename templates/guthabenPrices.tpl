{include file="documentHeader"}
<head>
	<title>{lang}wcf.guthaben.prices.title{/lang} - {lang}wcf.guthaben.pagetitle{/lang} - {PAGE_TITLE}</title>
	<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}style/guthaben.css" />
	{include file='headInclude' sandbox=false}
	<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/MultiPagesLinks.class.js"></script>
</head>
<body>
{include file='header' sandbox=false}

<div id="main">
	
	<ul class="breadCrumbs">
		<li><a href="index.php?page=Index{@SID_ARG_2ND}"><img src="icon/indexS.png" alt="" /> <span>{PAGE_TITLE}</span></a> &raquo;</li>
		<li><a href="index.php?page=guthabenMain&amp;action=shopPage{@SID_ARG_2ND}"><img src="icon/indexS.png" alt="" /> <span>{lang}wcf.guthaben.pagetitle{/lang}</span></a> &raquo;</li>
	</ul>
	
	<div class="mainHeadline">
		<img src="{@RELATIVE_WCF_DIR}icon/guthabenPricesL.png" alt="" />
		<div class="headlineContainer">
			<h2>{lang}wcf.guthaben.prices.title{/lang}</h2>
			<p>{lang}wcf.guthaben.prices.desc{/lang}</p>
		</div>
	</div>
	<div class="border">
		{if $prices|count > 0}
			<table class="tableList">
				<thead>
					<tr class="tableHead">
						<th class="columnPricesHeader"><div><strong>{lang}wcf.guthaben.prices.item{/lang}</strong></div></th>
						<th class="columnPricesHeader"><div><strong>{lang}wcf.guthaben.prices.itemdesc{/lang}</strong></div></th>
						<th class="columnPricesHeader"><div><strong>{lang}wcf.guthaben.prices.price{/lang}</strong></div></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$prices item=price}
						<tr class="container-{cycle values='1,2'}">
							<td class="columnPricesItem">{lang}{$price.priceItem}{/lang}</td>
							<td class="columnPricesDesc">{lang}{$price.priceDescription}{/lang}</td>
							<td class="columnPricesPrice"><span {if $price.priceConstant < 0 || $price.priceIsNegative} style="color:red"{else} style="color:green"{/if}>{$price.price}</span></td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		{/if}
	</div>
</div>

<p class="copyright">{lang}wcf.guthaben.copyright{/lang}</p>
{include file='footer' sandbox=false}
</body>
</html>