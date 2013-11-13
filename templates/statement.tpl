{include file='documentHeader'}

<head>
	<title>{lang}wcf.credits.log.title{/lang} - {PAGE_TITLE|language}</title>
	{include file='headInclude'}

</head>

<body id="tpl{$templateName|ucfirst}">

{include file='userMenuSidebar'}

{include file='header' sidebarOrientation='left'}

<header class="boxHeadline">
	<h1>{lang}wcf.credits.log.title{/lang} <span class="badge">{#$items}</span></h1>
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

{if $objects|count}
	<div class="marginTop tabularBox tabularBoxTitle messageGroupList">
		<table class="table">
			<thead>
				<tr class="tableHead">
					<th class="columnText"><div><strong>{lang}wcf.credits.log.time{/lang}</strong></div></th>
					<th class="columnText"><div><strong>{lang}wcf.credits.log.desc{/lang}</strong></div></th>
					<th class="columnDigits"><div><strong>{lang}wcf.credits.log.change{/lang}</strong></div></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$objects item=log}
					<tr class="new {if $log->credits < 0}deleted{else}disabled{/if}">
						<td class="columnText">{@$log->time|date:"d.m.Y H:i"}</td>
						<td class="columnText">{lang}{$log->langvar}{/lang} {if $log->link}<a href="{$log->link}">{/if}{$log->text}{if $log->link}</a>{/if}</td>
						<td class="columnDigits"><span class="badge {if $log->credits < 0}red{else}green{/if}">{if $log->credits < 0}-{else}+{/if} {@$log->credits}</span></td>
					</tr>
				{/foreach}

			</tbody>
		</table>
	</div>

	<div class="contentNavigation">
		{@$pagesLinks}

		{hascontent}
			<nav>
				<ul>
					{content}
						{event name='contentNavigationButtonsBottom'}
					{/content}
				</ul>
			</nav>
		{/hascontent}
	</div>
{else}
	<p class="info">{lang}wcf.user.following.noUsers{/lang}</p>
{/if}

{include file='footer'}

</body>
</html>