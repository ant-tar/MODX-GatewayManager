<?php
/**
 * The default Dutch language topics
 * 
 * @package gatewaymanager
 * @subpackage lexicon
 * @language nl
 * @author Bert Oost at OostDesign.nl <bertoost85@gmail.com>
 */

$_lang['gatewaymanager'] = "Gateway Manager";
$_lang['gatewaymanager.desc'] = "Beheer uw domeinen en bepaal waar te starten binnen de gehele website.";
$_lang['gatewaymanager.manage'] = "Beheer uw gateway domeinen";
$_lang['gatewaymanager.gateways'] = "Gateways";
$_lang['gatewaymanager.gateways.desc'] = "Hieronder ziet u een lijst met domeinen en welke context (en/of andere startpagina) u ingesteld heeft. U kunt eenvoudig een nieuw gateway domein toevoegen of updaten/verwijderen van bestaande.";
$_lang['gatewaymanager.search'] = "Zoeken...";

$_lang['gatewaymanager.create'] = "Maak nieuwe gateway";
$_lang['gatewaymanager.domain'] = "Domein";
$_lang['gatewaymanager.domain_desc'] = "Enkel het domein invullen, als 'www.example.com'. Geen http:// of slashes en paden aan het eind invullen.";
$_lang['gatewaymanager.context'] = "Context";
$_lang['gatewaymanager.context_desc'] = "Selecteer de context waar dit domein naar toe moet leiden.";
$_lang['gatewaymanager.context.createsettings'] = "Maak nodige context instellingen aan";
$_lang['gatewaymanager.context.createsettings.desc'] = "Dit zal context instelling als \"site_url\" end \"http_host\" aanmaken voor de geselecteerde context (indien niet reeds aanwezig!).";
$_lang['gatewaymanager.startpage'] = "Startpagina";
$_lang['gatewaymanager.startpage_desc'] = "Het is enkel nodig een startpagina te selecteren wanneer deze niet al reeds je \"site_start\"  is. Bedoeld om bv. URL's aan (landings)pagin's binnen een context te koppelen.";
$_lang['gatewaymanager.startpage.id'] = "ID";
$_lang['gatewaymanager.startpage.default'] = "Standaard pagina";
$_lang['gatewaymanager.active'] = "Actief";
$_lang['gatewaymanager.update'] = "Update gateway";
$_lang['gatewaymanager.remove'] = "Verwijder gateway";
$_lang['gatewaymanager.remove_confirm'] = "Weet u zeker dat u deze gateway wilt verwijderen?";

$_lang['gatewaymanager.error.domain_ns'] = "Domeinnaam niet gespecificeerd. Vernieuw en probeer het nog eens!";
$_lang['gatewaymanager.error.domain_ae'] = "Domein bestaat al. Probeer een andere domeinnaam!";
$_lang['gatewaymanager.error.context_ns'] = "Context niet gespecificeerd. Kies een context uit de lijst!";
$_lang['gatewaymanager.error.context_ne'] = "Context bestaat niet. Kies een context uit de lijst!";
$_lang['gatewaymanager.error.context_no_resources'] = "Context bevat geen enkel document. Voeg eentje toe, of vink \"maak nodige context instelling aan\" aan, om het eerste document automatisch aan te maken.";
$_lang['gatewaymanager.error.context_rne'] = "Opgegeven startpagina bestaat niet in de opgegeven context. Kies een resource welke behoort tot de gekozen context.";

$_lang['gatewaymanager.error.save'] = "Mislukt de gateway op te slaan. Vernieuw en probeer het nog eens!";
$_lang['gatewaymanager.error.id_ns'] = "Domein ID niet gespecificeerd. Probeer het nog eens!";
$_lang['gatewaymanager.error.nf'] = "Domein niet gevonden. Vernieuw en probeer het nog eens!";
$_lang['gatewaymanager.error.remove'] = "Domein kan niet verwijderd worden. Vernieuw en probeer het nog eens!";