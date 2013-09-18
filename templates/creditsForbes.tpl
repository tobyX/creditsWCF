{include file="documentHeader"}
<head>
	<title>{lang}wcf.guthaben.forbes.title{/lang} - {lang}{PAGE_TITLE}{/lang}</title>
	{include file='headInclude' sandbox=false}
	<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/MultiPagesLinks.class.js"></script>
</head>
<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>

{include file='header' sandbox=false}

<div id="main">
	
	<ul class="breadCrumbs">
		<li><a href="index.php?page=Index{@SID_ARG_2ND}"><img src="{icon}indexS.png{/icon}" alt="" /> <span>{lang}{PAGE_TITLE}{/lang}</span></a> &raquo;</li>
		<li><a href="index.php?page=guthabenMain{@SID_ARG_2ND}"><img src="{icon}guthabenMainS.png{/icon}" alt="" /> <span>{lang}wcf.guthaben.pagetitle{/lang}</span></a> &raquo;</li>
	</ul>
	
	<div class="mainHeadline">
		<img src="{icon}guthabenForbesL.png{/icon}" alt="" />
		<div class="headlineContainer">
			<h2>{lang}wcf.guthaben.mainpage.forbes{/lang}</h2>
			<p>{lang}wcf.guthaben.mainpage.forbes.description{/lang}</p>
			<p>{lang}wcf.guthaben.forbes.statistics{/lang}</p>
		</div>
	</div>
	
	{if $userMessages|isset}{@$userMessages}{/if}
		
	<div class="border">
		{if $members|count > 0}
			<table class="tableList membersList">
				<thead>
					<tr class="tableHead">
						<th class="columnUsername{if $sortField == 'username'} active{/if}"><div><a href="index.php?page=GuthabenForbes&amp;pageNo={@$pageNo}&amp;sortField=username&amp;sortOrder={if $sortField == 'username' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{@SID_ARG_2ND}">{lang}wcf.guthaben.forbes.name{/lang}{if $sortField == 'username'} <img src="{icon}sort{@$sortOrder}S.png{/icon}" alt="" />{/if}</a></div></th>
						<th class="columnGuthaben{if $sortField == 'guthaben'} active{/if}"><div><a href="index.php?page=GuthabenForbes&amp;pageNo={@$pageNo}&amp;sortField=guthaben&amp;sortOrder={if $sortField == 'guthaben' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{@SID_ARG_2ND}">{lang}wcf.guthaben.forbes.guthaben{/lang}{if $sortField == 'guthaben'} <img src="{icon}sort{@$sortOrder}S.png{/icon}" alt="" />{/if}</a></div></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$members item=member}
						<tr class="container-{cycle values='1,2'}">
							<td class="columnUsername">{@$member.username}</td>
							<td class="columnGuthaben">{@$member.guthaben}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		{else}
			<div class="container-1">
				{lang}wcf.user.membersList.error.noMembers{/lang}
			</div>
		{/if}
	</div>
	
	{pages link="index.php?page=GuthabenForbes&pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"|concat:SID_ARG_2ND_NOT_ENCODED}

</div>

{include file='footer' sandbox=false}
</body>
</html>