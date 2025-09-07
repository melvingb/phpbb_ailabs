<?php

/**
 *
 * AI Labs extension
 *
 * @copyright (c) 2023-2025, privet.fun, https://privet.fun
 * @license GNU General Public License, version 2 (GPL-2.0)
 * 
 * Dutch translation by goztov https://github.com/goztow
 * 
 */

if (!defined('IN_PHPBB')) {
	exit;
}

if (empty($lang) || !is_array($lang)) {
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_AILABS_TITLE' 			=> 'AI Labs',
	'ACP_AILABS_TITLE_VIEW' 	=> 'AI Labs Weergaveconfiguratie',
	'ACP_AILABS_TITLE_ADD' 		=> 'AI Labs Toevoegen Configuratie',
	'ACP_AILABS_TITLE_EDIT'		=> 'AI Labs Bewerken Configuratie',
	'ACP_AILABS_SETTINGS' 		=> 'Instellingen',

	'ACP_AILABS_ADD' 			=> 'Configuratie Toevoegen',

	'AILABS_USER_EMPTY' 				=> 'Selecteer een gebruiker',
	'AILABS_USER_NOT_FOUND'				=> 'Kan gebruiker %1$s niet vinden',
	'AILABS_USER_ALREADY_CONFIGURED'	=> 'Gebruiker %1$s is al geconfigureerd, slechts één configuratie per gebruiker toegestaan',
	'AILABS_SPECIFY_FORUM'				=> 'Selecteer ten minste één forum',

	'LOG_ACP_AILABS_ADDED' 				=> 'AI Labs-configuratie toegevoegd',
	'LOG_ACP_AILABS_EDITED' 			=> 'AI Labs-configuratie bijgewerkt',
	'LOG_ACP_AILABS_DELETED' 			=> 'AI Labs-configuratie verwijderd',

	'ACP_AILABS_ADDED' 				=> 'Configuratie succesvol aangemaakt',
	'ACP_AILABS_UPDATED' 			=> 'Configuratie succesvol bijgewerkt',
	'ACP_AILABS_DELETED_CONFIRM'	=> 'Weet u zeker dat u de configuratie die gekoppeld is aan gebruiker %1$s wilt verwijderen?',

	'LBL_AILABS_SETTINGS_DESC'		=> 'Bezoek 👉 <a href="https://github.com/privet-fun/phpbb_ailabs" target="_blank" rel="nofollow">https://github.com/privet-fun/phpbb_ailabs</a> voor gedetailleerde configuratie-instructies, probleemoplossing en voorbeelden.',
	'LBL_AILABS_USERNAME'			=> 'AI-bot',
	'LBL_AILABS_CONTROLLER'			=> 'AI',
	'LBL_AILABS_CONFIG'             => 'Configuratie JSON',
	'LBL_AILABS_TEMPLATE'           => 'Sjabloon',

	'LBL_AILABS_REPLY_TO'			=> 'Forums waar de AI-bot op reageert',
	'LBL_AILABS_POST_FORUMS'		=> 'Nieuw onderwerp',
	'LBL_AILABS_REPLY_FORUMS'		=> 'Reageren in een onderwerp',
	'LBL_AILABS_QUOTE_FORUMS'		=> 'Citeren of <a href="https://www.phpbb.com/customise/db/extension/simple_mentions/" target="_blank" rel="nofollow">vermelden</a>',
	'LBL_AILABS_ENABLED'			=> 'Ingeschakeld',
	'LBL_AILABS_SELECT_FORUMS'		=> 'Selecteer forums...',

	'LBL_AILABS_BOT_URL'			=> 'Bot-URL (test)',
	'LBL_AILABS_BOT_URL_EXPLAIN'	=> 'Klik op de opgegeven URL en er zou een nieuw tabblad moeten openen met de melding "Processing job 0". <a href="https://github.com/privet-fun/phpbb_ailabs?tab=readme-ov-file#troubleshooting" target="_blank" rel="nofollow">Probleemoplossing</a>',

	'LBL_AILABS_CONFIG_EXPLAIN'				=> 'Moet geldige JSON zijn, raadpleeg de documentatie voor details',
	'LBL_AILABS_TEMPLATE_EXPLAIN'			=> 'Geldige variabelen: {post_id}, {request}, {info}, {response}, {images}, {mp4}, {attachments}, {poster_id}, {poster_name}, {ailabs_username}, {settings}',
	'LBL_AILABS_POST_FORUMS_EXPLAIN'		=> 'Geef forums op waar AI zal reageren op nieuwe onderwerpen',
	'LBL_AILABS_REPLY_FORUMS_EXPLAIN'		=> 'Geef forums op waar AI zal reageren binnen een onderwerp',
	'LBL_AILABS_QUOTE_FORUMS_EXPLAIN'		=> 'Geef forums op waar AI zal reageren wanneer geciteerd of <a href="https://www.phpbb.com/customise/db/extension/simple_mentions/" target="_blank" rel="nofollow">vermeld</a>',

	'LBL_AILABS_IP_VALIDATION'				=> '⚠️ Waarschuwing: Uw ACP > Algemeen > Serverconfiguratie > Beveiligingsinstellingen > ' .
		'<a href="%1$s">Instelling voor sessie-IP-validatie is NIET ingesteld op Geen</a>, ' .
		'dit kan voorkomen dat AI Labs reageert als u phpBB-extensies gebruikt die vereisen dat een gebruiker is ingelogd ' .
		'(bijv. <a href="https://www.phpbb.com/customise/db/extension/login_required" target="_blank" rel="nofollow">Login Required</a>). ' .
		'Stel de sessie-IP-validatie in op Geen of voeg "/ailabs/*" toe aan de extensiewhitelist. ' .
		'Raadpleeg de <a href="https://github.com/privet-fun/phpbb_ailabs#troubleshooting" target="_blank" rel="nofollow">probleemoplossingssectie</a> voor meer details.',

	'LBL_AILABS_CONFIG_DEFAULT'				=> 'Laad standaardconfiguratie',
	'LBL_AILABS_TEMPLATE_DEFAULT'			=> 'Laad standaardsjabloon',
	
	'LBL_AILABS_API_DOCS'			=> 'API-documentatie',
]);
