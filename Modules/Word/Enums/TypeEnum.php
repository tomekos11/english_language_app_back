<?php

namespace Modules\Word\Enums;

enum TypeEnum: string
{
    case SENTENCES = 'fill_sentence';
    case PAIRS = 'connect_pair';
    case WORDS = 'translate_word';
    case PUZZLE = 'puzzle';
}
