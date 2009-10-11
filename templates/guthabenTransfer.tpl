{include file="documentHeader"}
<head>
	<title>{lang}wcf.guthaben.transfer{/lang} - {lang}wcf.guthaben.pagetitle{/lang} - {PAGE_TITLE}</title>
	{include file='headInclude' sandbox=false}
	<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/AjaxRequest.class.js"></script>
	<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/Suggestion.class.js"></script>
</head>
<body>
{include file='header' sandbox=false}

<div id="main">
	
	<ul class="breadCrumbs">
		<li><a href="index.php?page=Index{@SID_ARG_2ND}"><img src="{icon}indexS.png{/icon}" alt="" /> <span>{PAGE_TITLE}</span></a> &raquo;</li>
		<li><a href="index.php?page=guthabenMain{@SID_ARG_2ND}"><img src="{icon}guthabenMainS.png{/icon}" alt="" /> <span>{lang}wcf.guthaben.pagetitle{/lang}</span></a> &raquo;</li>
	</ul>
	
	<div class="mainHeadline">
		<img src="{icon}guthabenTransferL.png{/icon}" alt="" />
		<div class="headlineContainer">
			<h2>{lang}wcf.guthaben.transfer.title{/lang}</h2>
			<p>{lang}wcf.guthaben.transfer.description{/lang}</p>
		</div>
	</div>
	
	{if $errorField}
		<p class="error">{lang}wcf.global.form.error{/lang}</p>
	{/if}
	
	<form enctype="multipart/form-data" method="post" action="index.php?form=guthabenTransfer">
		<div class="border content">
			<div class="container-1">
				<fieldset>
					<legend>{lang}wcf.guthaben.transfer{/lang}</legend>
					
					<div class="formElement{if $errorField == 'recipient'} formError{/if}">
						<div class="formFieldLabel">
							<label for="recipient">{lang}wcf.guthaben.transfer.recipient{/lang}</label>
						</div>
						<div class="formField">
							<input type="text" class="inputText" id="recipient" name="recipient" value="{$recipient}" />
							<script type="text/javascript">
								//<![CDATA[
								suggestion.setSource('index.php?page=PublicUserSuggest{@SID_ARG_2ND_NOT_ENCODED}');
								suggestion.init('recipient');
								//]]>
							</script>
							{if $errorField == 'recipient'}
								<p class="innerError">
									{if $errorType|is_array}
										{assign var="error" value=$errorType}
										{if $error.type == 'notFound'}{lang}wcf.pm.error.recipient.notFound{/lang}{/if}
										{if $error.type == 'ignoresYou'}{lang}wcf.pm.error.recipient.ignoresYou{/lang}{/if}
										{if $error.type == 'cannotReceive'}{lang}wcf.guthaben.transfer.cannotreceive{/lang}{/if}
									{else}
										{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
									{/if}
								</p>
							{/if}
						</div>
					</div>
		
					<div class="formElement{if $errorField == 'transfer'} formError{/if}">
						<div class="formFieldLabel">
							<label for="transfer">{lang}wcf.guthaben.transfer.value{/lang}</label>
						</div>
						<div class="formField">
							<input type="text" class="inputText" name="transfer" id="transfer" value="{$transfer}" /> {lang}wcf.guthaben.currency{/lang}
							{if $errorField == 'transfer'}
								<p class="innerError">
									{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
									{if $errorType == 'tomutch'}{lang}wcf.guthaben.transfer.tomutch{/lang}{/if}
								</p>
							{/if}
						</div>
					</div>
					
					<div class="formElement">
						<div class="formFieldLabel">
							<label for="text">{lang}wcf.guthaben.transfer.purpose{/lang}</label>
						</div>
						<div class="formField">
							<input type="text" class="inputText" name="text" id="text" value="{$text}" />
						</div>
					</div>
					
					{if $this->user->getPermission('guthaben.moderation.cantransfer')}
					<div class="formElement">
						<div class="formFieldLabel">
							<label for="moderativ">{lang}wcf.guthaben.transfer.moderativ{/lang}</label>
						</div>
						<div class="formField">
							<input type="checkbox" name="moderativ" id="moderativ" {if $moderativ}checked="checked" {/if}/>
						</div>
					</div>
					{/if}
					
				</fieldset>

			</div>
		</div>
		
		<div class="formSubmit">
			<input type="submit" name="send" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
			<input type="reset" name="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		</div>
		
		{@SID_INPUT_TAG}
	</form>
</div>

<p class="copyright">{lang}wcf.guthaben.copyright{/lang}</p>
{include file='footer' sandbox=false}
</body>
</html>