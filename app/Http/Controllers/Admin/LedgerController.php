<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Shared CRUD for Expenses and Investments (same shape, different table).
 */
abstract class LedgerController extends Controller
{
    /** Eloquent model class. */
    abstract protected function model(): string;

    /** Date column name on the model. */
    abstract protected function dateColumn(): string;

    /** AccountCategory type: expense | investment. */
    abstract protected function categoryType(): string;

    /** Page labels: ['singular' => 'Expense', 'plural' => 'Expenses', 'route' => 'expenses']. */
    abstract protected function labels(): array;

    /** Expenses are browsed month by month; investments are one running list. */
    protected function byMonth(): bool
    {
        return true;
    }

    public const PAYMENT_METHODS = ['cash' => 'Cash', 'bkash' => 'bKash', 'nagad' => 'Nagad', 'rocket' => 'Rocket', 'bank' => 'Bank', 'card' => 'Card'];

    public function index(Request $request)
    {
        try {
            $month = $request->filled('month') ? Carbon::createFromFormat('Y-m', $request->month)->startOfMonth() : Carbon::now()->startOfMonth();
        } catch (\Throwable) {
            $month = Carbon::now()->startOfMonth();
        }
        $categoryId = $request->integer('category') ?: null;

        $col = $this->dateColumn();
        $query = ($this->model())::with('category', 'creator')
            ->when($this->byMonth(), fn ($q) => $q->whereBetween($col, [$month->copy()->startOfMonth()->toDateString(), $month->copy()->endOfMonth()->toDateString()]))
            ->when($categoryId, fn ($q) => $q->where('account_category_id', $categoryId))
            ->orderByDesc($col)->orderByDesc('id');

        $items      = $query->get();
        $categories = AccountCategory::ofType($this->categoryType())->orderBy('name')->get();
        $byCategory = $items->groupBy(fn ($i) => $i->category?->name ?? 'Uncategorized')->map->sum('amount')->sortDesc();
        $monthTotal = (float) $items->sum('amount');
        $allTime    = (float) ($this->model())::sum('amount');

        return view('Admin.accounts.ledger', [
            'labels'     => $this->labels(),
            'dateColumn' => $col,
            'items'      => $items,
            'categories' => $categories,
            'byCategory' => $byCategory,
            'monthTotal' => $monthTotal,
            'allTime'    => $allTime,
            'month'      => $month,
            'byMonth'    => $this->byMonth(),
            'categoryId' => $categoryId,
            'methods'    => self::PAYMENT_METHODS,
            'entriesJson' => $items->map(fn ($i) => [
                'id' => $i->id, 'account_category_id' => $i->account_category_id, 'title' => $i->title,
                'amount' => $i->amount, 'date' => $i->{$col}->toDateString(),
                'payment_method' => $i->payment_method, 'note' => $i->note,
            ])->values(),
        ]);
    }

    public function store(Request $request)
    {
        $item = ($this->model())::create($this->validated($request) + ['created_by' => Auth::guard('admin')->id()]);

        return response()->json(['success' => true, 'message' => $this->labels()['singular'] . ' added.', 'item' => $item]);
    }

    public function update(Request $request, int $id)
    {
        $item = ($this->model())::findOrFail($id);
        $item->update($this->validated($request));

        return response()->json(['success' => true, 'message' => $this->labels()['singular'] . ' updated.']);
    }

    public function destroy(int $id)
    {
        ($this->model())::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => $this->labels()['singular'] . ' deleted.']);
    }

    /** Quick-add a new category head from the form. */
    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:account_categories,name,NULL,id,type,' . $this->categoryType(),
        ]);

        $cat = AccountCategory::create(['type' => $this->categoryType(), 'name' => trim($data['name'])]);

        return response()->json(['success' => true, 'message' => 'Category added.', 'category' => $cat]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'account_category_id' => 'nullable|integer|exists:account_categories,id',
            'title'               => 'required|string|max:255',
            'amount'              => 'required|numeric|min:0.01|max:9999999999',
            'date'                => 'required|date|before_or_equal:today',
            'payment_method'      => 'required|in:' . implode(',', array_keys(self::PAYMENT_METHODS)),
            'note'                => 'nullable|string|max:1000',
        ]);

        $data[$this->dateColumn()] = $data['date'];
        unset($data['date']);

        return $data;
    }
}
