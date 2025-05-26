<?php

namespace Creagia\LaravelSignPad\Actions;

use Exception;
use Creagia\LaravelSignPad\TextElement;
use Creagia\LaravelSignPad\DateElement;
use Creagia\LaravelSignPad\Traits\PdfElementStyle;
use Creagia\LaravelSignPad\SignatureDocumentTemplate;
use Creagia\LaravelSignPad\Exceptions\InvalidConfiguration;

class AppendDateDocumentAction extends AppendTextDocumentAction
{
	use PdfElementStyle;
	/**
	 * @throws InvalidConfiguration
	 * @throws Exception
	 */

	public function getText(TextElement|DateElement $element): string
	{
		return date($element->dateFormat);
	}

	public function getElements(SignatureDocumentTemplate $signatureTemplate): array
	{
		return $signatureTemplate->dateElements ?? [];
	}

	private function validateConfig(SignatureDocumentTemplate $signatureTemplate): void
	{
		foreach ($signatureTemplate->dateElements as $element) {
			if (! is_numeric($element->X))
				throw new InvalidConfiguration("Invalid X coordinate. Check your config key 'dateEntries.[].X'");

			if (! is_numeric($element->Y))
				throw new InvalidConfiguration("Invalid Y coordinate. Check your config key 'dateEntries.[].Y'");

			if (! is_numeric($element->size))
				throw new InvalidConfiguration("Invalid size. Check your config key 'dateEntries.[].size'");

			if (! is_numeric($element->page))
				throw new InvalidConfiguration("Invalid page. Check your config key 'dateEntries.[].page'");

			if (empty($element->dateFormat))
				throw new InvalidConfiguration("Invalid date format configuration. Check your config key 'dateEntries.[].dateFormat'");
		}
	}
}
