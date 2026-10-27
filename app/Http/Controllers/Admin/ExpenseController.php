<?php

namespace App\Http\Controllers\Admin;

use App\Models\Expense;

/** Shop rent, salaries, delivery charges… — subtracted from profit. */
class ExpenseController extends LedgerController
{
    protected function model(): string
    {
        return Expense::class;
    }

    protected function config(): array
    {
        return [
            'route'    => 'admin.expenses',
            'singular' => 'Expense',
            'plural'   => 'Expenses',
            'icon'     => 'fa-receipt',
            'intro'    => 'Running costs — shop rent, staff salary, delivery charges and more. These are taken out of profit.',
        ];
    }
}
