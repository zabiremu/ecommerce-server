<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LedgerEntry;
use App\Services\ProfitReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Month-by-month list + add/edit/delete for hand-entered money-out entries.
 * ExpenseController and InvestmentController only describe themselves.
 */
abstract class LedgerController extends Controller
{
    /** @return class-string<LedgerEntry> */
    abstract protected function model(): string;

    /** route name prefix, singular/plural labels, intro text, icon */
    abstract protected function config(): array;

    /** Extra numbers for the month shown above the list. */
    protected function monthExtras(string $from, string $to): array
    {
        return [];
    }

    public function index(Request $request)
    {
        $model = $this->model();
        $dateColumn = $model::dateColumn();
        $today = ProfitReportService::today();

        $month = AccountsReportController::parseMonth($request->query('month')) ?? substr($today, 0, 7);
        $start = Carbon::parse($month . '-01');
        $from  = $start->toDateString();
        $to    = $start->copy()->endOfMonth()->toDateString();

        $categories = $model::categories();
        $category = array_key_exists((string) $request->query('category'), $categories) ? $request->query('category') : '';

        $query = $model::query()->betweenDates($from, $to);
        $byCategory = (clone $query)->groupBy('category')
            ->selectRaw('category, sum(amount) as total, count(*) as entries')
            ->orderByDesc('total')->get();
        $monthTotal = (float) (clone $query)->sum('amount');

        if ($category !== '') {
            $query->where('category', $category);
        }
        $entries = $query->with('createdBy:id,name')
            ->orderByDesc($dateColumn)->orderByDesc('id')
            ->paginate(50)->withQueryString();

        $allTimeTotal = (float) $model::sum('amount');
        $extras = $this->monthExtras($from, $to);
        $cfg = $this->config();
        $methods = LedgerEntry::PAYMENT_METHODS;
        $prevMonth = $start->copy()->subMonth()->format('Y-m');
        $nextMonth = $start->copy()->addMonth()->format('Y-m');

        return view('Admin.accounts.ledger', compact(
            'cfg', 'entries', 'categories', 'category', 'month', 'start', 'today', 'byCategory', 'monthTotal',
            'allTimeTotal', 'extras', 'methods', 'prevMonth', 'nextMonth', 'dateColumn'
        ));
    }

    public function store(Request $request)
    {
        $model = $this->model();
        $data = $this->validated($request);
        $data['created_by'] = Auth::guard('admin')->id();
        $entry = $model::create($data);

        return redirect()->route($this->config()['route'] . '.index', ['month' => $entry->entry_date->format('Y-m')])
            ->with('success', $this->config()['singular'] . ' added: ' . $entry->title . ' — ' . \App\Support\Money::format($entry->amount) . '.');
    }

    public function edit($id)
    {
        $entry = $this->model()::findOrFail($id);
        $cfg = $this->config();
        $categories = $this->model()::categories();
        $methods = LedgerEntry::PAYMENT_METHODS;
        $dateColumn = $this->model()::dateColumn();

        return view('Admin.accounts.ledger_edit', compact('entry', 'cfg', 'categories', 'methods', 'dateColumn'));
    }

    public function update(Request $request, $id)
    {
        $entry = $this->model()::findOrFail($id);
        $entry->update($this->validated($request));

        return redirect()->route($this->config()['route'] . '.index', ['month' => $entry->entry_date->format('Y-m')])
            ->with('success', $this->config()['singular'] . ' updated.');
    }

    public function destroy($id)
    {
        $entry = $this->model()::findOrFail($id);
        $month = $entry->entry_date->format('Y-m');
        $entry->delete();

        return redirect()->route($this->config()['route'] . '.index', ['month' => $month])
            ->with('success', $this->config()['singular'] . ' deleted.');
    }

    private function validated(Request $request): array
    {
        $model = $this->model();

        $data = $request->validate([
            'entry_date'     => 'required|date_format:Y-m-d',
            'category'       => 'required|in:' . implode(',', array_keys($model::categories())),
            'title'          => 'required|string|max:191',
            'amount'         => 'required|numeric|min:0.01|max:9999999999',
            'payment_method' => 'nullable|in:' . implode(',', LedgerEntry::PAYMENT_METHODS),
            'note'           => 'nullable|string|max:500',
        ]);

        $data[$model::dateColumn()] = $data['entry_date'];
        unset($data['entry_date']);

        return $data;
    }
}
