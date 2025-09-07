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
	$lang = array();
}

$lang = array_merge($lang, [
	'AILABS_MJ_BUTTONS'					=> 'Reageer door een van de ondersteunde acties te citeren [size=60][url=https://docs.midjourney.com/docs/quick-start#8-upscale-or-create-variations]1[/url] [url=https://docs.midjourney.com/docs/quick-start#9-enhance-or-modify-your-image]2[/url] [url=https://docs.midjourney.com/docs/zoom-out#custom-zoom]3[/url] [url=https://docs.midjourney.com/docs/seeds]4[/url][/size]: ',
	'AILABS_QUOTE_BUTTONS'				=> 'Reageer door een van de ondersteunde acties te citeren: ',
	'AILABS_MJ_BUTTON_ALREADY_USED'		=> 'Actie %1s is al [url=%2$s?p=%3$d#p%3$d]uitgevoerd[/url]',
	'AILABS_ERROR_CHECK_LOGS'			=> '[color=#FF0000]Fout. Controleer de logs.[/color]',
	'AILABS_ERROR_UNABLE_DOWNLOAD_URL'	=> 'Kan niet downloaden ',
	'AILABS_NO_PROMPT'					=> 'Prompt ontbreekt.',
	'AILABS_ERROR_PROVIDE_URL' 			=> 'Voeg een afbeelding bij of geef een afbeelding-URL op voor analyse.',
	'AILABS_ERROR_PROVIDE_URL_2x'		=> 'Voeg afbeeldingen bij of geef afbeelding-URL’s op voor zowel de bron- als doelafbeelding voor gezichtsuitwisseling.',
	'AILABS_ERROR'						=> '[color=#FF0000]%1s[/color]',
	'AILABS_POSTS_DISCARDED'  			=> ', berichten vanaf [url=%1$s?p=%2$d#p%2$d]dit bericht[/url] zijn genegeerd',
	'AILABS_DISCARDED_INFO' 			=> '[size=75][url=%1$s?p=%2$d#p%2$d]Begin[/url] van een conversatie met %3$d berichten%4$s (%5$d tokens van %6$d gebruikt)[/size]',
	'AILABS_THINKING' 					=> 'aan het nadenken',
	'AILABS_REPLYING' 					=> 'beantwoorden…',
	'AILABS_REPLIED' 					=> 'beantwoord ↓',
	'AILABS_UNABLE_TO_REPLY' 			=> 'kan niet antwoorden',
	'AILABS_QUERY' 						=> 'bezig met query',
	'L_AILABS_AI'						=> 'AI',
	'AILABS_SETTINGS_OVERRIDE'			=> '[size=75]%1$s[/size]'
]);
