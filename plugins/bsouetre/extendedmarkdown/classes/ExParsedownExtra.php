<?php

namespace BSouetre\ExtendedMarkdown\Classes;

use BSouetre\ExtendedMarkdown\Traits\ExParsedownExtraTrait;
use October\Rain\Support\Facades\File;
use ParsedownExtra;

class ExParsedownExtra extends ParsedownExtra
{
	use ExParsedownExtraTrait;

	public static function parseEx( $text )
	{
		return static::instance()->text( $text );
	}

	protected function inlineLazyImage( $Excerpt )
	{
		$img = $this->inlineImage([ 'text' => $Excerpt, 'context' => $Excerpt ]);
		$filepath = base_path() . $img['element']['attributes']['src'];
		$imgSrc = $img['element']['attributes']['src'];
		$imgAlt = $img['element']['attributes']['alt'];
		$imgWidth = 0;
		$imgHeight = 0;

		if ( File::exists( $filepath ) )
			list( $imgWidth, $imgHeight ) = getimagesize( $filepath );

		$heightPercentRatio = ( $imgHeight / $imgWidth ) * 100;

		$markup  = '<div class="lazyContainer loading" style="max-width:' . $imgWidth . 'px">';
		$markup .= '	<div class="aspectRatioBox" style="padding-bottom:' . $heightPercentRatio . '%;"></div>';
		$markup .= '	<img class="lazyImg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="' . $imgSrc . '" alt="' . $imgAlt . '">';
		$markup .= '	<noscript><img src="' . $imgSrc . '" alt="' . $imgAlt . '"></noscript>';
		$markup .= '</div>';

		return $markup;
	}
}
