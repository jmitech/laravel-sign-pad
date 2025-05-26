<?php

namespace Creagia\LaravelSignPad;

use Creagia\LaravelSignPad\Contracts\PdfElement;

class TextElement implements PdfElement
{
    public function __construct(
        public int $page,
        public string $text,
        public int $X,
        public int $Y,
        public string $style = '', // B, I, U
        public int $size = 12,
        public string $color = 'black',
        public string $fill = '',
    ) {}
}
