{include file="documentHeader"}
<head>
	<title>{lang}wcf.guthaben.log.title{/lang} - {lang}wcf.guthaben.pagetitle{/lang} - {PAGE_TITLE}</title>
	<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}style/guthaben.css" />
	{include file='headInclude' sandbox=false}
	<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/MultiPagesLinks.class.js"></script>
</head>
<body>
{include file='header' sandbox=false}

<div id="main">
	
	<ul class="breadCrumbs">
		<li><a href="index.php?page=Index{@SID_ARG_2ND}"><img src="icon/indexS.png" alt="" /> <span>{PAGE_TITLE}</span></a> &raquo;</li>
		<li><a href="index.php?page=guthabenMain{@SID_ARG_2ND}"><img src="icon/indexS.png" alt="" /> <span>{lang}wcf.guthaben.pagetitle{/lang}</span></a> &raquo;</li>
	</ul>
	
	<div class="mainHeadline">
		<img src="{@RELATIVE_WCF_DIR}icon/guthabenLogL.png" alt="" />
		<div class="headlineContainer">
			<h2>{lang}wcf.guthaben.log.title{/lang}</h2>
			<p>{lang}wcf.guthaben.log.description{/lang}</p>
		</div>
	</div>
	<div class="border">
		{if $logEntries|count > 0}
			<table class="tableList">
				<thead>
					<tr class="tableHead">
						<th class="columnGuthabenHeader"><div><strong>{lang}wcf.guthaben.log.id{/lang}</strong></div></th>
						<th class="columnGuthabenHeader"><div><strong>{lang}wcf.guthaben.log.time{/lang}</strong></div></th>
						<th class="columnGuthabenHeader"><div><strong>{lang}wcf.guthaben.log.desc{/lang}</strong></div></th>
						<th class="columnGuthabenHeader"><div><strong>{lang}wcf.guthaben.log.change{/lang}</strong></div></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$logEntries item=log}
						<tr class="container-{cycle values='1,2'}">
							<td class="columnGuthabenLogId">{$log.logID}</td>
							<td class="columnGuthabenTime">{@$log.time|time}</td>
							<td class="columnGuthabenDesc">{lang}{$log.langvar}{/lang} {if $log.link}<a href="{$log.link}">{/if}{$log.text}{if $log.link}</a>{/if}</td>
							<td class="columnGuthabenChange"><span {if $log.guthaben < 0} style="color:red"{else} style="color:green"{/if}>{@$log.guthaben}</span></td>
						</tr>
					{/foreach}
					<tr class="container-1">
						<td colspan="3" class="columnGuthabenPageSumDesc">{lang}wcf.guthaben.log.pagesum{/lang}</td>
						<td class="columnGuthabenPageSum"><span {if $pageSum < 0} style="color:red"{else} style="color:green"{/if}>{@$pageSum}</span></td>
					</tr>
					<tr class="container-2">
						<td colspan="3" class="columnGuthabenPageSumDesc">{lang}wcf.guthaben.log.allsum{/lang}</td>
						<td class="columnGuthabenPageSum"><strong>{@$allSum}</strong></td>
					</tr>
				</tbody>
			</table>
		{else}
			<div class="container-1">
				{lang}wcf.guthaben.log.nolog{/lang}
			</div>
		{/if}
	</div>
	{pages link="index.php?page=guthabenLog&pageNo=%d"|concat:SID_ARG_2ND_NOT_ENCODED}

	<a href="index.php?page=guthabenLog&amp;action=compress{@SID_ARG_2ND}">{lang}wcf.guthaben.log.compress{/lang}</a>
</div>

<p class="copyright">{lang}wcf.guthaben.copyright{/lang}</p>
{include file='footer' sandbox=false}
</body>
</html>