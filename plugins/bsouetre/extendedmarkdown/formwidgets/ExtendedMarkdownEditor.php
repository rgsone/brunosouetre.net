<?php

namespace BSouetre\ExtendedMarkdown\FormWidgets;

use Backend\FormWidgets\MarkdownEditor;
use BSouetre\ExtendedMarkdown\Classes\ExParsedownExtra;

class ExtendedMarkdownEditor extends MarkdownEditor
{
	protected $defaultAlias = 'ex_markdown_editor';

	public function init()
	{
		$this->viewPath = base_path() . '/modules/backend/formwidgets/markdowneditor/partials';
		parent::init();
	}
	protected function loadAssets()
	{
		$this->assetPath = '/modules/backend/formwidgets/markdowneditor/assets';
		parent::loadAssets();
	}

	public function onRefresh()
	{
		$value = post($this->formField->getName());
		$previewHtml = ExParsedownExtra::parseEx($value);

		return ['preview' => $previewHtml];
	}
}
