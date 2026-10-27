@include('Admin._partials.wp-styles')
<style>
    .summary-card { background: #fff; border: 1px solid #c3c4c7; padding: 14px 16px; border-radius: 4px; }
    .summary-card .lbl { font-size: 12px; color: #50575e; text-transform: uppercase; letter-spacing: .04em; font-weight: 600; }
    .summary-card .val { font-size: 22px; color: #1d2327; font-weight: 700; margin-top: 4px; }
    .summary-card .sub { font-size: 12px; color: #646970; margin-top: 2px; }
    .summary-card.net-pos { border-color: #86efac; background: #f0fdf4; }
    .summary-card.net-neg { border-color: #fca5a5; background: #fef2f2; }
    .amt-pos { color: #047857; }
    .amt-neg { color: #b91c1c; }
    .acc-nav { display: inline-flex; align-items: center; gap: 6px; }
    .acc-note { font-size: 12px; color: #646970; }
    .acc-warn { padding: 8px 12px; background: #fffbeb; border-left: 4px solid #f59e0b; color: #92400e; font-size: 13px; }
    .wp-list-table tfoot td { font-weight: 700; background: #f6f7f7; }
    .bar-track { height: 6px; background: #f0f0f1; border-radius: 3px; overflow: hidden; }
    .bar-fill { height: 100%; background: #2271b1; }
</style>
