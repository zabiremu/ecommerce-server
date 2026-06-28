<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    function wpToast(message, type) {
        var bg = type === 'success' ? '#00a32a' : (type === 'error' ? '#d63638' : '#2271b1');
        var $t = $('<div></div>').css({
            position: 'fixed', top: '20px', right: '20px', zIndex: 1000,
            background: bg, color: '#fff', padding: '10px 16px', fontSize: '13px',
            borderRadius: '3px', boxShadow: '0 2px 8px rgba(0,0,0,0.15)',
            transform: 'translateX(120%)', transition: 'transform .25s'
        }).text(message).appendTo('body');
        setTimeout(function () { $t.css('transform', 'translateX(0)'); }, 30);
        setTimeout(function () { $t.css('transform', 'translateX(120%)'); setTimeout(function () { $t.remove(); }, 250); }, 2500);
    }
</script>
