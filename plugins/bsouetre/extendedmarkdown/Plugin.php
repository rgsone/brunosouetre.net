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

		## underline inline block (<span style="text-decoration: underline;">text</span>)
		## template: --text--

		$exParsedown->addInlineType( '-', 'UnderlineText' );

		$exParsedown->inlineUnderlineText = function( $excerpt )
		{
			if ( !isset( $excerpt['text'][1] ) ) return;

			if ( $excerpt['text'][0] === '-' && $excerpt['text'][1] === '-'
				 && preg_match( '/^--(.+)--/us', $excerpt['text'], $matches )
			)
			{
				$tag = 'span';
				$attrStyleValue = 'text-decoration:underline;';
			}
			else
			{
				return;
			}

			return array(
				'extent' => strlen($matches[0]),
				'element' => array(
					'name' => $tag,
					//'handler' => 'line',
					'text' => $matches[1],
					'attributes' => array(
						'style' => $attrStyleValue
					)
				),
			);
		};

		## figure block outside <p> block
		## template: !![alt text](path/to/img.ext)

		$exParsedown->addBlockType( '!', 'Figure', false, false );

		$exParsedown->blockFigure = function( $Line, $Block = null )
		{
			if ( !isset( $Line[ 'text' ][ 1 ] ) || $Line[ 'text' ][ 1 ] !== '!'
				|| !isset( $Line[ 'text' ][ 2 ] ) || $Line[ 'text' ][ 2 ] !== '[' )
			{
				return;
			}

			# remove first '!' and trim
			$text = trim( substr_replace( $Line[ 'text' ], '', 0, 1 ) );

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

		## figure block outside <p> block with lazyload image
		## template: !>[alt text](path/to/img.ext)

		$exParsedown->addBlockType( '!', 'LazyLoadFigure', false, false );

		$exParsedown->blockLazyLoadFigure = function( $Line, $Block = null )
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
						'handler' => 'inlineLazyImage'
					]
				];

				return $Block;
			}
		};

		## image caption ( <p class="caption"></p>)
		## template: |> text

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
