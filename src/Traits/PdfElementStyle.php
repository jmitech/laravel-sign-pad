<?php

namespace Jmitech\LaravelSignPad\Traits;

use setasign\Fpdi\Tcpdf\Fpdi;
use Jmitech\LaravelSignPad\DateElement;
use Jmitech\LaravelSignPad\TextElement;

trait PdfElementStyle
{
	public function setColor(Fpdi $pdf, null|TextElement|DateElement $element = null): void
	{
		$color = $element->color ?? 'black';

		$fill = $element->fill ?? false;

		list($R, $G, $B) = $this->getRGB($color);
		$pdf->setColor('text', $R, $G, $B);

		if ($fill) {
			// TODO: recode this hell			
			$width = $pdf->GetStringWidth($this->getText($element)) * 1.1;
			$height = $element->size / 2;
			$x = $pdf->GetX() / 1.85 + 85;
			$y = $pdf->GetY();

			list($fill_R, $fill_G, $fill_B) = $this->getRGB($element->fill ?? 'white');
			$pdf->SetFillColor($fill_R, $fill_G, $fill_B);
			$pdf->Rect($x, $y, $width, $height, 'F'); // Draw filled rectangle
		}
	}

	public function getRGB($color): array
	{
		$R = 0;
		$G = 0;
		$B = 0;

		switch ($color) {
			case 'red':
				$R = 255;
				break;
			case 'green':
				$G = 255;
				break;
			case 'blue':
				$B = 255;
				break;
			case 'gray':
				$R = 128;
				$G = 128;
				$B = 128;
				break;
			case 'white':
				$R = 255;
				$G = 255;
				$B = 255;
				break;
			case 'black':
			default:
				// detect if hexadecimal color e.g. #FF0000, #38AA38 or #00F
				if (preg_match('/^#([a-f0-9]{6}|[a-f0-9]{3})$/i', $color)) {
					$hex = str_replace('#', '', $color);
					if (strlen($hex) == 3) {
						$R = hexdec(substr($hex, 0, 1) . $hex[0]);
						$G = hexdec(substr($hex, 1, 1) . $hex[1]);
						$B = hexdec(substr($hex, 2, 1) . $hex[2]);
					} else {
						$R = hexdec(substr($hex, 0, 2));
						$G = hexdec(substr($hex, 2, 2));
						$B = hexdec(substr($hex, 4, 2));
					}
				}
		}

		return [$R, $G, $B];
	}

	public function resetColor($pdf): void
	{
		$this->setColor($pdf);
	}
}
