<?php

namespace Modules\System\Enums;

enum EventTypeEnum: string
{
    case EASY_TODAY = 'easy_today';
    case MEDIUM_TODAY = 'medium_today';
    case HARD_TODAY = 'hard_today';

    case EASY_ALL = 'easy_all';
    case MEDIUM_ALL = 'medium_all';
    case HARD_ALL = 'hard_all';

    case STREAK = 'streak';
    case LIFES = 'lifes';
    case FAVOURITE = 'favourite';
    case REVIEW = 'review';

}
