{extends file="layout.tpl"}
{block name='head:title'}Google Translate{/block}
{block name='body:id'}gtranslate{/block}
{block name='article:header'}
    <h1 class="h2">Google Translate</h1>
{/block}
{block name='article:content'}
    {if {employee_access type="view" class_name=$cClass} eq 1}
        <div class="panels row">
            <section class="panel col-ph-12">
                {if $debug}
                    {$debug}
                {/if}
                <header class="panel-header">
                    <h2 class="panel-heading h5">Gestion Api Google Translate</h2>
                </header>
                <div class="panel-body panel-body-form">
                    <div class="mc-message-container clearfix">
                        <div class="mc-message"></div>
                    </div>

                    <div class="row">
                        <form id="gtranslate_config" action="{$smarty.server.SCRIPT_NAME}?controller={$smarty.get.controller}&amp;action=edit" method="post" class="validate_form edit_form col-ph-12 col-md-6">
                            <div class="row">
                                <div class="col-ph-12 col-md-6">
                                    <div class="form-group">
                                        <label for="credentials_gt">Chemin du fichier JSON :</label>
                                        <input type="text" class="form-control" id="credentials_gt" name="apiGData[credentials_gt]" placeholder="{#ph_credentials#}" value="{$apige.credentials_gt}" size="50" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-ph-12 col-md-6">
                                    <div class="form-group">
                                        <label for="projectid_gt">Identifiant du projet :</label>
                                        <input type="text" class="form-control" id="projectid_gt" name="apiGData[projectid_gt]" placeholder="{#ph_projectid#}" value="{$apige.projectid_gt}" size="50" />
                                    </div>
                                </div>
                            </div>
                            <div id="submit">
                                <button class="btn btn-main-theme pull-right" type="submit" name="action" value="edit">{#save#|ucfirst}</button>
                                {*<button class="btn btn-main-theme pull-right" type="button" id="testApi" name="testApi" value="test">Test</button>*}
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    {else}
        {include file="section/brick/viewperms.tpl"}
    {/if}
{/block}