<?php

use Illuminate\Support\Str;

function slugify(string $title): string
{
    return Str::slug($title, '-', null);
}

function g2j(DateTime $georgian, string $format = 'EEEE Y/M/d - H:m'): string
{
    $date = new IntlDateFormatter('fa_IR@calendar=persian', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Asia/Tehran', IntlDateFormatter::TRADITIONAL, $format);

    return $date->format($georgian);
}

function j2g(int $year, int $month, int $day, string $format = 'EEEE Y/M/d - H:m'): string
{
    $fmt = new IntlDateFormatter(
        'en_US@calendar=persian',
        IntlDateFormatter::SHORT,
        IntlDateFormatter::NONE,
        'Asia/Tehran',
        IntlDateFormatter::TRADITIONAL
    );
    $time = $fmt->parse(sprintf('%d/%d/%d AP', $month, $day, $year));

    $formatter = IntlDateFormatter::create(
        'en_US',
        IntlDateFormatter::FULL,
        IntlDateFormatter::FULL,
        'Asia/Tehran',
        IntlDateFormatter::GREGORIAN,
        $format
    );

    return $formatter->format($time);
}

function englishNumber(string $persianNumber): string
{
    return str_replace(['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٬'], ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ','], $persianNumber);
}

function persianNumber(string $englishNumber): string
{
    return str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ','], ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٬'], $englishNumber);
}

function persianNumberFormat(float | int $englishNumber): string
{
    return persianNumber(number_format($englishNumber));
}
