<?php

namespace BSouetre\ExtendedMarkdown\Classes;

use BSouetre\ExtendedMarkdown\Traits\ExParsedownExtraTrait;
use October\Rain\Support\Facades\File;
use ParsedownExtra;

class ExParsedownExtra extends ParsedownExtra
{
	use ExParsedownExtraTrait;

	public static function parseEx($text)
	{
		return static::instance()->text($text);
	}

	/////////////////////////

	protected function inlineLazyImage($Excerpt)
	{
		$img = $this->inlineImage(['text' => $Excerpt, 'context' => $Excerpt]);
		$filepath = base_path() . $img['element']['attributes']['src'];
		$imgSrc = $img['element']['attributes']['src'];
		$imgAlt = $img['element']['attributes']['alt'];
		$imgWidth = 0;
		$imgHeight = 0;

		if (File::exists($filepath))
			list($imgWidth, $imgHeight) = getimagesize($filepath);

		$heightPercentRatio = ($imgHeight / $imgWidth) * 100;

		$markup  = '<div class="lazyContainer loading" style="max-width:' . $imgWidth . 'px">';
		$markup .= '	<div class="aspectRatioBox" style="padding-bottom:' . $heightPercentRatio . '%;"></div>';
		$markup .= '	<img class="lazyImg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="' . $imgSrc . '" alt="' . $imgAlt . '">';
		$markup .= '	<noscript><img src="' . $imgSrc . '" alt="' . $imgAlt . '"></noscript>';
		$markup .= '</div>';

		return $markup;
	}

	/////////////////////////

	protected function mediaYoutube($Excerpt)
	{
		$videoId = trim($Excerpt, "[]");

		$markup = <<<YT
<iframe frameborder="0" 
		type="text/html" 
		src="https://www.youtube.com/embed/${videoId}?autoplay=0&loop=0&mute=0&playlist=${videoId}&controls=1&fs=1&iv_load_policy=3&showinfo=0&rel=0&cc_load_policy=0&start=0&end=0&color=white">
</iframe>
YT;
		// src="https://www.youtube.com/embed/${videoId}?autoplay=1&loop=1&mute=1&playlist=${videoId}&controls=0&fs=1&iv_load_policy=3&showinfo=0&rel=0&cc_load_policy=0&start=0&end=0&color=white">

		return $markup;
	}

	/////////////////////////

	protected function mediaVideo($Excerpt)
	{
		$matches = [];
		preg_match('/^\[([a-zA-Z0-9:,]*)\]\(([a-zA-Z0-9\/\-_%\.~]+\.(mp4|ogg|webm))\)$/', $Excerpt, $matches);

		$options = empty($matches[1]) ? [] : explode(',', $matches[1]);
		$src = $matches[2];
		$fileExt = $matches[3];
		$mimetype = $this->getVideoMimetype($fileExt);
		$attributes = $this->getAttributes($options);

		// ref : https://webplatform.github.io/docs/html/elements/video/
		// ref : https://developer.mozilla.org/en-US/docs/Web/HTML/Element/video
		// options : autoplay, controls, loop, muted, mw:xxx

		$markup = <<<HTML
	<video ${attributes} src="${src}" type="${mimetype}">
		<p>Votre navigateur ne supporte pas la balise vidéo</p>
	</video>
HTML;

		return $markup;
	}

	protected function getVideoMimetype($fileExt)
	{
		$mimetype = '';

		if ($fileExt === 'mp4') $mimetype = 'video/mp4';
		else if ($fileExt === 'ogg') $mimetype = 'video/ogg';
		else if ($fileExt === 'webm') $mimetype = 'video/webm';

		return $mimetype;
	}

	protected function getAttributes($options)
	{
		$attr = 'preload="metadata" ';
		$opts = array_unique($options);

		// if no options, add simply controls
		if (empty($opts)) {
			$opts[] = 'controls';
		}
		
		// add muted options if autoplay option id defined and muted doesn't exists
		if (in_array('autoplay', $opts, true) &&
			!in_array('muted', $opts, true)) {
			$opts[] = 'muted';
		}

		foreach ($opts as $opt) {
			switch ($opt) {
				case 'autoplay':
					$attr .= 'autoplay ';
					break;
				case 'controls':
					$attr .= 'controls ';
					break;
				case 'loop':
					$attr .= 'loop ';
					break;
				case 'muted':
					$attr .= 'muted ';
					break;
				case (substr($opt, 0, 3) === 'mw:'):
					$matches = [];
					$hasMatches = preg_match('/^mw:([0-9]{1,5})$/', $opt, $matches) === 1;
					$attr .= $hasMatches ? "style=\"max-width:${matches[1]}px\" " : '';
					break;
			}
		}



		return trim($attr);
	}

	/////////////////////////
}
