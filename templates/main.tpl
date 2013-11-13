{include file="documentHeader"}

<head>
	<title>{lang}wcf.guthaben.pagetitle{/lang} - {PAGE_TITLE}</title>
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">

{include file='userMenuSidebar'}

{include file='header' sidebarOrientation='left'}

<header class="boxHeadline">
	<h1>{lang}wcf.credits.pagetitle{/lang} <span class="badge">{#$items}</span></h1>
</header>

{include file='userNotice'}

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller='Following' link="pageNo=%d"}

	{hascontent}
		<nav>
			<ul>
				{content}
					{event name='contentNavigationButtonsTop'}
				{/content}
			</ul>
		</nav>
	{/hascontent}
</div>

{if $items}
	<div class="container marginTop">
		<ol class="containerList doubleColumned creditsMainPage">
			{foreach from=$objects item=pageItem}
				<li data-object-id="{@$pageItem->menuItemID}">
					<div class="box48">
						<a href="{link controller='User' object=$user}{/link}" title="{$user->username}" class="framed">{@$user->getAvatar()->getImageTag(48)}</a>
						<a href="{link controller='User'}{/link}" title="{@$pageItem->menuItem}" class="framed">{@$pageItem->menuItem}</a>
						<div class="details userInformation">
							{@$pageItem->menuItemDescription}
						</div>
					</div>
				</li>
			{/foreach}
		</ol>
	</div>
{else}
	<p class="info">{lang}wcf.user.members.noMembers{/lang}</p>
{/if}

{include file='footer'}

</body>
</html>