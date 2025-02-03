<?php

declare(strict_types=1);

arch('architecture test')
    ->expect('App')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);
