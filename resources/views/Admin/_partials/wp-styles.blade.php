<style>
    body.font-sans { background: #f0f0f1 !important; }
    main { background: #f0f0f1 !important; }

    .wp-h1 { font-size: 23px; font-weight: 400; color: #1d2327; line-height: 1.3; padding: 9px 0; margin: 0; }
    .wp-add-new { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; margin-left: 4px; font-size: 13px; line-height: 2; border: 1px solid #2271b1; color: #2271b1; background: #f6f7f7; border-radius: 3px; }
    .wp-add-new:hover { background: #f0f0f1; }

    .wp-panel { background: #fff; border: 1px solid #c3c4c7; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
    .wp-panel-h { padding: 10px 12px; font-size: 14px; font-weight: 600; color: #1d2327; border-bottom: 1px solid #c3c4c7; display: flex; align-items: center; justify-content: space-between; }
    .wp-panel-body { padding: 12px; }

    .wp-field { margin-bottom: 14px; }
    .wp-field > label { display: block; font-size: 13px; font-weight: 500; color: #1d2327; margin-bottom: 4px; }
    .wp-input { padding: 6px 10px; font-size: 13px; border: 1px solid #8c8f94; border-radius: 4px; background: #fff; outline: none; width: 100%; }
    .wp-input:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    textarea.wp-input { min-height: 80px; resize: vertical; }
    .wp-help { font-size: 12px; color: #646970; margin-top: 4px; }
    .wp-err { font-size: 12px; color: #d63638; margin-top: 4px; }

    .wp-btn { padding: 5px 12px; font-size: 13px; font-weight: 500; border-radius: 3px; cursor: pointer; border: 1px solid #2271b1; background: #f6f7f7; color: #2271b1; line-height: 1.4; transition: all .15s; }
    .wp-btn:hover { background: #f0f0f1; }
    .wp-btn-primary { background: #2271b1; color: #fff; }
    .wp-btn-primary:hover { background: #135e96; border-color: #135e96; color: #fff; }
    .wp-btn-link { background: transparent; border: 0; color: #2271b1; cursor: pointer; padding: 0; font-size: 13px; }
    .wp-btn-link:hover { color: #135e96; text-decoration: underline; }

    .wp-list-table { border: 1px solid #c3c4c7; background: #fff; box-shadow: 0 1px 1px rgba(0,0,0,.04); width: 100%; border-collapse: collapse; }
    .wp-list-table thead th { background: #fff; color: #2c3338; font-weight: 600; font-size: 13px; padding: 10px 8px; border-bottom: 1px solid #c3c4c7; text-align: left; }
    .wp-list-table tbody td { font-size: 13px; padding: 12px 8px; vertical-align: top; color: #2c3338; border-bottom: 1px solid #f0f0f1; }
    .wp-list-table tbody tr:hover { background: #f6f7f7; }
    .wp-list-table tbody tr:hover .wp-row-actions { visibility: visible; }
    .wp-row-actions { visibility: hidden; margin-top: 4px; font-size: 12px; color: #50575e; }
    .wp-row-actions button, .wp-row-actions a { color: #2271b1; background: none; border: 0; cursor: pointer; font-size: 12px; padding: 0; }
    .wp-row-actions button:hover, .wp-row-actions a:hover { color: #135e96; text-decoration: underline; }
    .wp-row-actions .trash, .wp-row-actions .trash:hover { color: #b32d2e; }

    .wp-status-pill { display: inline-block; padding: 1px 8px; font-size: 11px; font-weight: 600; border-radius: 3px; cursor: pointer; }
    .wp-status-on { background: #edf7ed; color: #2e7d32; }
    .wp-status-off { background: #fdecea; color: #b32d2e; }

    .wp-search-box { display: flex; align-items: center; gap: 6px; }

    /* WooCommerce-style form controls (reused across create/edit/show) */
    .wc-title-input { width: 100%; padding: 6px 8px; font-size: 1.5em; line-height: 1.4; border: 1px solid #8c8f94; border-radius: 4px; background: #fff; outline: none; }
    .wc-title-input:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    .wc-submit-bar { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; background: #fff; border: 1px solid #c3c4c7; }
    .wc-info-grid { display: grid; grid-template-columns: 130px 1fr; gap: 6px 12px; font-size: 13px; }
    .wc-info-grid .lbl { color: #50575e; }
    .wc-info-grid .val { color: #1d2327; font-weight: 500; }
    .wc-empty { text-align: center; color: #787c82; padding: 30px 12px; font-size: 13px; }
    .wc-summary-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; border-bottom: 1px dashed #dcdcde; }
    .wc-summary-row:last-child { border-bottom: 0; }
    .wc-summary-row .lbl { color: #50575e; }
    .wc-summary-row .val { color: #1d2327; font-weight: 600; }
    .wc-summary-total { display: flex; justify-content: space-between; padding: 10px 0 0; margin-top: 6px; border-top: 2px solid #2c3338; font-size: 14px; }
    .wc-summary-total .val { font-weight: 700; font-size: 15px; }

    /* DataTables WP-style overrides */
    .dataTables_wrapper .dataTables_filter { float: right; margin-bottom: 8px; }
    .dataTables_wrapper .dataTables_filter input { border: 1px solid #8c8f94; border-radius: 4px; padding: 5px 10px; font-size: 13px; outline: none; }
    .dataTables_wrapper .dataTables_filter input:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    .dataTables_wrapper .dataTables_length { float: left; margin-bottom: 8px; font-size: 13px; color: #50575e; }
    .dataTables_wrapper .dataTables_length select { border: 1px solid #8c8f94; border-radius: 4px; padding: 4px 6px; font-size: 13px; outline: none; }
    .dataTables_wrapper .dataTables_info { font-size: 13px; color: #50575e; padding-top: 12px; clear: both; }
    .dataTables_wrapper .dataTables_paginate { padding-top: 8px; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { font-size: 13px; padding: 4px 9px; border: 1px solid #c3c4c7 !important; background: #fff !important; color: #2271b1 !important; border-radius: 3px; margin-left: 2px; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #2c3338 !important; color: #fff !important; border-color: #2c3338 !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #f0f0f1 !important; color: #135e96 !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover { color: #c3c4c7 !important; background: #fff !important; cursor: default; }
    table.dataTable.wp-list-table thead .sorting:after, table.dataTable.wp-list-table thead .sorting_asc:after, table.dataTable.wp-list-table thead .sorting_desc:after { color: #50575e; }

    /* Mobile responsive additions */
    @media (max-width: 768px) {
        .wp-list-table { display: block; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .wc-field { display: block !important; }
        .wc-field > * { max-width: 100% !important; }
        .wc-info-grid { grid-template-columns: max-content 1fr !important; }
        .wc-submit-bar { flex-wrap: wrap !important; gap: 8px !important; }
        .wp-h1 { font-size: 18px !important; }
        .wp-row-actions { visibility: visible !important; }
    }
    @media (max-width: 480px) {
        .wc-info-grid { grid-template-columns: 1fr !important; }
    }
</style>
