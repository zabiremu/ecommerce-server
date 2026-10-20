<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccountCategory;
use App\Models\Investment;

class InvestmentController extends LedgerController
{
    protected function model(): string { return Investment::class; }

    protected function dateColumn(): string { return 'investment_date'; }

    protected function categoryType(): string { return AccountCategory::TYPE_INVESTMENT; }

    protected function labels(): array
    {
        return ['singular' => 'Investment', 'plural' => 'Investments', 'route' => 'investments'];
    }
}
