<?php
/**
 * The default English language topics
 * 
 * @package gatewaymanager
 * @subpackage lexicon
 * @language en
 * @author Bert Oost at OostDesign.nl <bertoost85@gmail.com>
 */

$_lang['gatewaymanager'] = "Gateway Manager";
$_lang['gatewaymanager.desc'] = "Manage domains and decide where to start inside your entire website.";
$_lang['gatewaymanager.manage'] = "Manage your gateway domains";
$_lang['gatewaymanager.gateways'] = "Gateways";
$_lang['gatewaymanager.gateways.desc'] = "Below you will see the list of domains and which context (and/or different startpage) you have setupped. You can simple add a new gateway domain or remove/update existing ones.";
$_lang['gatewaymanager.search'] = "Search...";

$_lang['gatewaymanager.create'] = "Create new gateway";
$_lang['gatewaymanager.domain'] = "Domain";
$_lang['gatewaymanager.domain_desc'] = "The domain only contains 'www.example.com'. No http:// or any trailing slashes and additional paths here.";
$_lang['gatewaymanager.context'] = "Context";
$_lang['gatewaymanager.context_desc'] = "Select the context where to switch this domain too.";
$_lang['gatewaymanager.context.createsettings'] = "Create necessary context settings";
$_lang['gatewaymanager.context.createsettings.desc'] = "This will create the context settings like \"site_url\" and \"http_host\" for the selected context (when not already exists!).";
$_lang['gatewaymanager.startpage'] = "Start page";
$_lang['gatewaymanager.startpage_desc'] = "It's only necessary to select a start page when this is not your context \"site_start\". Meant to bind domains to (landing) pages for example.";
$_lang['gatewaymanager.startpage.id'] = "ID";
$_lang['gatewaymanager.startpage.default'] = "Default page";
$_lang['gatewaymanager.active'] = "Active";
$_lang['gatewaymanager.update'] = "Update gateway";
$_lang['gatewaymanager.remove'] = "Remove gateway";
$_lang['gatewaymanager.remove_confirm'] = "Are you sure you want to remove this gateway?";

$_lang['gatewaymanager.error.domain_ns'] = "Domain name not specified. Please enter a domain!";
$_lang['gatewaymanager.error.domain_ae'] = "Domain already exists. Please try an other domain name!";
$_lang['gatewaymanager.error.context_ns'] = "Context not specified. Please choose a context!";
$_lang['gatewaymanager.error.context_ne'] = "Context not exists. Please choose one from the list!";
$_lang['gatewaymanager.error.context_no_resources'] = "Context does not have any resources. Please add one, or check \"create necessary context settings\" to auto-generate the first resource.";
$_lang['gatewaymanager.error.context_rne'] = "Given start page does not exists in given context. Please choose a resource that belongs to the chosen context.";

$_lang['gatewaymanager.error.save'] = "Failed to save the gateway. Refresh and try it again!";
$_lang['gatewaymanager.error.id_ns'] = "Domain ID not specified. Please try it again!";
$_lang['gatewaymanager.error.nf'] = "Domain not found. Refresh and try it again!";
$_lang['gatewaymanager.error.remove'] = "Domain cannot be removed. Refresh and try it again!";