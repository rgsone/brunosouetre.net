<?php

namespace BSouetre\ExtendedMarkdown\Classes;

use BSouetre\ExtendedMarkdown\Traits\ExParsedownExtraTrait;
use ParsedownExtra;

class ExParsedownExtra extends ParsedownExtra
{
	use ExParsedownExtraTrait;

	public static function parseEx( $text )
	{
		return static::instance()->text( $text );
	}
}
