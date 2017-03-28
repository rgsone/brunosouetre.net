<?php

namespace BSouetre\ExtendedMarkdown;

use BSouetre\ExtendedMarkdown\Classes\ExParsedownExtra;
use October\Rain\Parse\MarkdownData;
use System\Classes\PluginBase;

/**
 * Class Plugin
 * @package BSouetre\ExtendedMarkdown
 */
class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'ExtendedMarkdown',
            'description' => 'Ajoute des tags à la syntax Markdown existante',
            'author' => 'rgsone',
            'icon' => 'icon-leaf'
        ];
    }

    public function boot()
	{
		# Add block to parsedown

		$exParsedown = ExParsedownExtra::instance();

		## figure block outside <p> block

		$exParsedown->addBlockType( '!', 'Figure', false, false );

		$exParsedown->blockFigure = function( $Line, $Block = null )
		{
			if ( !isset( $Line[ 'text' ][ 1 ] ) || $Line[ 'text' ][ 1 ] !== '>'
				|| !isset( $Line[ 'text' ][ 2 ] ) || $Line[ 'text' ][ 2 ] !== '[' )
			{
				return;
			}

			# remove '>' and trim
			$text = trim( substr_replace( $Line[ 'text' ], '', 1, 1 ) );

			if ( preg_match( '/^!\[(.*)\]\((.*)\)$/', $text ) )
			{
				$Block = [
					'element' => [
						'name' => 'figure',
						'text' => $text,
						'handler' => 'line'
					]
				];

				return $Block;
			}
		};

		## image caption ( <p class="caption"></p>)

		$exParsedown->addBlockType( '|', 'Caption', false, false );

		$exParsedown->blockCaption = function( $Line, $Block = null )
		{
			if ( !isset( $Line[ 'text' ][ 1 ] ) || $Line[ 'text' ][ 1 ] !== '>'
				|| !isset( $Line[ 'text' ][ 2 ] ) || $Line[ 'text' ][ 2 ] !== ' ' )
			{
				return;
			}

			if ( preg_match( '/^\|>[ ]{1}(.*)/', $Line[ 'text' ], $matches ) )
			{
				$Block = [
					'element' => [
						'name' => 'p',
						'attributes' => [ 'class' => 'caption' ],
						'text' => $matches[1],
						'handler' => 'line'
					]
				];

				return $Block;
			}
		};
	}

	public function registerFormWidgets()
	{
		return [
			'BSouetre\\ExtendedMarkdown\\FormWidgets\\ExtendedMarkdownEditor' => 'ex_markdown_editor'
		];
	}

	public function registerMarkupTags()
	{
		return [
			'filters' => [
				'exmd' => [ 'BSouetre\\ExtendedMarkdown\\Classes\\ExParsedownExtra', 'parseEx' ]
			]
		];
	}
}
