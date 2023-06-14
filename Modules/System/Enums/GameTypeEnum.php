<?php

namespace Modules\System\Enums;

enum GameTypeEnum: string
{
    case QUARTER_MINUTE = '15s';
    case HALF_MINUTE = '30s';
    case ONE_MINUTE = '60s';
}