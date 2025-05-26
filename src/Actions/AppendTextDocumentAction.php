<?php

namespace Creagia\LaravelSignPad\Actions;

use Exception;
use setasign\Fpdi\Tcpdf\Fpdi;
use Creagia\LaravelSignPad\TextElement;
use Creagia\LaravelSignPad\DateElement;
use Creagia\LaravelSignPad\Traits\PdfElementStyle;
use Creagia\LaravelSignPad\SignatureDocumentTemplate;
use Creagia\LaravelSignPad\Exceptions\InvalidConfiguration;

class AppendTextDocumentAction
{
	use PdfElementStyle;
	/**
	 * @throws InvalidConfiguration
	 * @throws Exception
	 */
	public function __invoke(Fpdi $pdf, SignatureDocumentTemplate $signatureTemplate): Fpdi
	{
		$this->validateConfig($signatureTemplate);

		foreach ($this->getElements($signatureTemplate) as $element) {
			$pdf->setPage($element->page);

			$pdf->SetFont('helvetica', $element->style ?? '', $element->size ?? 12);
			$pdf->SetXY($element->X, $element->Y);
			$this->setColor($pdf, $element);

			$pdf->Cell(0, 0, $this->getText($element), 0, 1, 'C', 0, '', 0);

			$this->resetColor($pdf);
		}

		return $pdf;
	}

	public function getText(TextElement|DateElement $element): string
	{
		return $element->text ?? '';
	}

	public function getElements(SignatureDocumentTemplate $signatureTemplate): array
	{
		return $signatureTemplate->textElements ?? [];
	}

	private function validateConfig(SignatureDocumentTemplate $signatureTemplate): void
	{
		foreach($signatureTemplate->textElements as $element)
		{
			if (! is_numeric($element->X)) {
				throw new InvalidConfiguration("Invalid X coordinate. Check your config key 'textEntries.[].X'");
			}
			if (! is_numeric($element->Y)) {
				throw new InvalidConfiguration("Invalid Y coordinate. Check your config key 'textEntries.[].Y'");
			}
			if (empty($element->text)) {
				throw new InvalidConfiguration("Invalid configuration. Check your config key 'textEntries.[].text'");
			}
			if (! is_numeric($element->size)) {
				throw new InvalidConfiguration("Invalid size. Check your config key 'textEntries.[].size'");
			}
			if (! is_numeric($element->page)) {
				throw new InvalidConfiguration("Invalid page. Check your config key 'textEntries.[].page'");
			}
		}
	}
}
