<?php

namespace Creagia\LaravelSignPad;

use Creagia\LaravelSignPad\Contracts\PdfElement;

class DateElement implements PdfElement
{
    public function __construct(
        public int $page,
        public string $dateFormat = 'Y m d',
        public int $X,
        public int $Y,
        public string $style = 'B',
        public int $size = 12,
        public string $color = 'black',
        public string $fill = '',
    ) {}
}
