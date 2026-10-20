<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccountCategory;
use App\Models\Expense;

class ExpenseController extends LedgerController
{
    protected function model(): string { return Expense::class; }

    protected function dateColumn(): string { return 'expense_date'; }

    protected function categoryType(): string { return AccountCategory::TYPE_EXPENSE; }

    protected function labels(): array
    {
        return ['singular' => 'Expense', 'plural' => 'Expenses', 'route' => 'expenses'];
    }
}
