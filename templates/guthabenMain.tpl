{include file="documentHeader"}
<head>
	<title>{lang}wcf.guthaben.pagetitle{/lang} - {PAGE_TITLE}</title>
	<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}style/guthaben.css" />
	{include file='headInclude' sandbox=false}
</head>
<body>
{include file='header' sandbox=false}

<div id="main">
	<ul class="breadCrumbs">
		<li><a href="index.php?page=Index{@SID_ARG_2ND}"><img src="icon/indexS.png" alt="" /> <span>{PAGE_TITLE}</span></a> &raquo;</li>
	</ul>
	
	<div class="mainHeadline">
		<img src="{@RELATIVE_WCF_DIR}icon/guthabenL.png" alt="" />
		<div class="headlineContainer">
			<h2> {lang}wcf.guthaben.pagetitle{/lang}</h2>
		</div>
	</div>

	{if $userMessages|isset}{@$userMessages}{/if}
	
	<div class="tabMenu">
		<ul>
			{foreach from=$parentItems item=item}
				<li{if $item.menuItemLink == $activeParent} class="activeTabMenu"{/if}><a href="index.php?page=guthabenMain&amp;action={$item.menuItemLink}{@SID_ARG_2ND}">{if $item.menuItemIcon}<img src="{$item.menuItemIcon}" alt="" /> {/if}<span>{lang}{@$item.menuItem}{/lang}</span></a></li>
			{/foreach}
		</ul>
	</div>
		
	<div class="subTabMenu">
		<div class="containerHead">
			<div> </div>
		</div>
	</div>
	
	{cycle values='container-1,container-2' print=false advance=false}
	<div class="container-1">
		<div class="message content">
		{foreach from=$childItems item=link}
			<div class="messageInner {cycle}">
				<a href="index.php?{$link.menuItemLink}{@SID_ARG_2ND}">
					{if !$link.menuItemIcon|empty}<img src="{@RELATIVE_WCF_DIR}{$link.menuItemIcon}" alt="" />{/if}
				</a>
				<a href="index.php?{$link.menuItemLink}{@SID_ARG_2ND}">
					{lang}{$link.menuItem}{/lang}
				</a>

				<h3><a href="index.php?{$link.menuItemLink}{@SID_ARG_2ND}"></a></h3>
				<div class="messageBody">
					{if !$link.menuItemDescription|empty}{lang}{$link.menuItemDescription}{/lang}{/if}
				</div>
			</div>
		{/foreach}
		</div>
	</div>
	
</div>

<p class="copyright">{lang}wcf.guthaben.copyright{/lang}</p>
{include file='footer' sandbox=false}
</body>
</html>