<h1>Module WEBDIGIT : {l s='Store Only'}</h1>
<fieldset>
	<legend>{l s='Products Store Only' mod='webdigitstoreonly'}</legend>
	<div class="control-group">
		<label class="control-label input-label" for="store_only">{l s='This product is only available in store :'}</label>
		<input type="checkbox" id="store_only" name="store_only">		
	</div>
</fieldset>
<!-- Footer enregistrement -->
<div class="panel-footer">
		<a href="{$link->getAdminLink('AdminProducts')|escape:'html':'UTF-8'}{if isset($smarty.request.page) && $smarty.request.page > 1}&amp;submitFilterproduct={$smarty.request.page|intval}{/if}" class="btn btn-default"><i class="process-icon-cancel"></i> {l s='Cancel'}</a>
		<button type="submit" name="submitAddproduct" class="btn btn-default pull-right" disabled="disabled"><i class="process-icon-loading"></i> {l s='Save'}</button>
		<button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right" disabled="disabled"><i class="process-icon-loading"></i> {l s='Save and stay'}</button>
</div>