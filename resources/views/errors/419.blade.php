<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>সেশনের মেয়াদ শেষ</title>
    <style>
        body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center;
            font-family:'Hind Siliguri',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
            background:#f6faf6; color:#1c1c1c; text-align:center; padding:24px; box-sizing:border-box; }
        .box { max-width:380px; }
        .icon { font-size:3rem; margin-bottom:14px; }
        h1 { font-size:1.3rem; margin:0 0 8px; }
        p { color:#6b7280; font-size:.95rem; margin:0 0 22px; line-height:1.6; }
        a.btn { display:inline-block; background:linear-gradient(135deg,#2e8b2e,#1f6e1f); color:#fff;
            text-decoration:none; font-weight:700; padding:12px 28px; border-radius:30px;
            box-shadow:0 6px 16px rgba(31,125,31,.35); }
    </style>
</head>
<body>
    <div class="box">
        <div class="icon">⏳</div>
        <h1>সেশনের মেয়াদ শেষ হয়ে গেছে</h1>
        <p>দুঃখিত, পেজটির মেয়াদ শেষ হয়ে গেছে। অনুগ্রহ করে আবার চেষ্টা করুন।</p>
        <a class="btn" href="{{ url()->previous() ?: '/' }}">আবার চেষ্টা করুন</a>
    </div>
</body>
</html>
