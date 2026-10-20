@include('Admin._partials.wp-styles')
<style>
    .acc-tabs { display:flex; gap:4px; flex-wrap:wrap; border-bottom:1px solid #c3c4c7; margin:10px 0 16px; }
    .acc-tabs a { padding:7px 12px; font-size:13px; color:#50575e; border:1px solid transparent; border-bottom:none; border-radius:4px 4px 0 0; margin-bottom:-1px; }
    .acc-tabs a:hover { color:#2271b1; }
    .acc-tabs a.on { background:#fff; color:#1d2327; font-weight:600; border-color:#c3c4c7; }
    .report-filters { display:flex; align-items:center; gap:10px; margin-bottom:14px; flex-wrap:wrap; }
    .report-filters label { font-size:13px; color:#1d2327; display:flex; align-items:center; gap:6px; }
    .report-filters input, .report-filters select { border:1px solid #8c8f94; border-radius:4px; padding:5px 10px; font-size:13px; background:#fff; min-width:140px; }
    .stat-cards { display:grid; grid-template-columns:repeat(auto-fit, minmax(170px, 1fr)); gap:12px; margin-bottom:18px; }
    .stat-card { background:#fff; border:1px solid #c3c4c7; border-radius:4px; padding:14px 16px; box-shadow:0 1px 1px rgba(0,0,0,.04); }
    .stat-card .label { font-size:12px; color:#50575e; text-transform:uppercase; letter-spacing:.04em; }
    .stat-card .value { font-size:21px; font-weight:700; color:#1d2327; margin-top:4px; font-variant-numeric:tabular-nums; }
    .stat-card .sub { font-size:11px; color:#787c82; margin-top:2px; }
    .stat-card.hl { border-color:#2271b1; box-shadow:0 0 0 1px #2271b1; }
    .pos { color:#00733b !important; } .neg { color:#b32d2e !important; }
    .num { text-align:right; font-variant-numeric:tabular-nums; white-space:nowrap; }
    .calc-box { background:#fff; border:1px solid #c3c4c7; border-radius:4px; padding:12px 16px; font-size:13px; max-width:520px; }
    .calc-box .row { display:flex; justify-content:space-between; padding:4px 0; }
    .calc-box .row.total { border-top:1px solid #dcdcde; margin-top:4px; padding-top:8px; font-weight:700; font-size:14px; }
    .acc-section-h { font-size:15px; font-weight:600; color:#1d2327; margin:22px 0 8px; }
    .wp-list-table tfoot td { font-weight:700; background:#f6f7f7; }
    .table-scroll { overflow-x:auto; }
</style>
