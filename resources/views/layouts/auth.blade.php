<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>@yield('title', 'Login') - SIPALING</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
            background: #022c22;
            background-image:
                radial-gradient(ellipse at 30% 50%, rgba(16,185,129,0.2) 0%, transparent 50%),
                radial-gradient(ellipse at 70% 80%, rgba(5,150,105,0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 10%, rgba(52,211,153,0.1) 0%, transparent 40%);
            overflow: hidden;
            position: relative;
        }
        /* Floating orbs */
        body::before, body::after {
            content: ''; position: absolute; border-radius: 50%;
            filter: blur(80px); pointer-events: none;
            animation: float 8s ease-in-out infinite;
        }
        body::before {
            width: 400px; height: 400px; top: -100px; left: -100px;
            background: rgba(16,185,129,0.15);
        }
        body::after {
            width: 300px; height: 300px; bottom: -80px; right: -80px;
            background: rgba(52,211,153,0.12);
            animation-delay: 4s; animation-direction: reverse;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.1); }
        }

        .auth-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.3), 0 0 60px rgba(16,185,129,0.1);
            overflow: hidden; width: 100%; max-width: 940px;
            display: grid; grid-template-columns: 1fr 1fr;
            position: relative; z-index: 1;
            animation: cardEntry 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes cardEntry {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .auth-left {
            background: linear-gradient(175deg, #064e3b 0%, #022c22 100%);
            padding: 56px 44px; display: flex; flex-direction: column;
            justify-content: center; align-items: center; text-align: center;
            position: relative; overflow: hidden;
        }
        .auth-left::before {
            content: ''; position: absolute; inset: 0;
            background:
                radial-gradient(circle at 30% 70%, rgba(16,185,129,0.2) 0%, transparent 50%),
                radial-gradient(circle at 70% 30%, rgba(52,211,153,0.1) 0%, transparent 50%);
        }
        /* Animated circles */
        .auth-left .circle {
            position: absolute; border-radius: 50%;
            border: 1px solid rgba(16,185,129,0.15);
            animation: spin 20s linear infinite;
        }
        .auth-left .circle:nth-child(1) { width: 300px; height: 300px; top: -50px; left: -50px; }
        .auth-left .circle:nth-child(2) { width: 200px; height: 200px; bottom: -30px; right: -30px; animation-direction: reverse; }
        .auth-left .circle:nth-child(3) { width: 150px; height: 150px; top: 50%; left: 50%; transform: translate(-50%,-50%); animation-duration: 15s; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .auth-logo {
            width: 80px; height: 80px; border-radius: 24px;
            background: linear-gradient(135deg, #10b981, #34d399);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; margin-bottom: 20px;
            position: relative; z-index: 1;
            box-shadow: 0 8px 30px rgba(16,185,129,0.4);
            animation: pulse-glow 3s ease-in-out infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 8px 30px rgba(16,185,129,0.4); }
            50% { box-shadow: 0 8px 50px rgba(16,185,129,0.6); }
        }
        .auth-title {
            font-size: 2.6rem; font-weight: 800; color: #fff;
            letter-spacing: 3px; position: relative; z-index: 1;
        }
        .auth-subtitle {
            color: rgba(255,255,255,0.6); margin-top: 12px;
            font-size: 0.92rem; line-height: 1.7;
            position: relative; z-index: 1; max-width: 280px;
        }
        .feature-pill {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.2);
            border-radius: 20px; padding: 7px 16px; font-size: 0.76rem;
            color: rgba(255,255,255,0.85); margin: 4px;
            position: relative; z-index: 1;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        .feature-pill:hover {
            background: rgba(16,185,129,0.25);
            transform: translateY(-2px);
        }

        .auth-right {
            padding: 48px 44px; display: flex;
            flex-direction: column; justify-content: center;
        }

        .tab-nav {
            display: flex; background: #f0fdf4;
            border-radius: 14px; padding: 4px; margin-bottom: 32px;
            border: 1px solid rgba(16,185,129,0.1);
        }
        .tab-btn {
            flex: 1; padding: 12px; border: none; background: transparent;
            border-radius: 11px; font-weight: 600; font-size: 0.9rem;
            color: #64748b; cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .tab-btn.active {
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff; box-shadow: 0 4px 15px rgba(5,150,105,0.35);
        }
        .tab-btn:not(.active):hover { color: #059669; background: rgba(16,185,129,0.06); }

        .form-panel { display: none; }
        .form-panel.active { display: block; animation: fadeUp .35s cubic-bezier(0.4, 0, 0.2, 1); }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(15px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .form-label { font-weight: 600; font-size: 0.84rem; color: #1e293b; margin-bottom: 6px; }
        .form-control, .form-select {
            border: 2px solid rgba(16,185,129,0.15); border-radius: 12px;
            padding: 12px 16px; font-size: 0.9rem;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.8);
        }
        .form-control:focus, .form-select:focus {
            border-color: #059669;
            box-shadow: 0 0 0 4px rgba(5,150,105,0.12);
            background: #fff;
        }
        .btn-submit {
            width: 100%; padding: 14px; border: none; border-radius: 14px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff; font-weight: 700; font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 8px;
            box-shadow: 0 4px 20px rgba(5,150,105,0.3);
            position: relative; overflow: hidden;
        }
        .btn-submit::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, transparent 30%, rgba(255,255,255,0.15) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        .btn-submit:hover::before { transform: translateX(100%); }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(5,150,105,0.4);
        }
        .btn-submit:active { transform: translateY(-1px); }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { font-size: 0.8rem; }

        .form-check-input:checked {
            background-color: #059669; border-color: #059669;
        }

        @media (max-width: 700px) {
            .auth-card { grid-template-columns: 1fr; max-width: 460px; }
            .auth-left { padding: 36px 28px; }
            .auth-right { padding: 32px 24px; }
        }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-left">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="auth-logo">🌿</div>
        <div class="auth-title">SIPALING</div>
        <div class="auth-subtitle">Sistem Pelaporan Lingkungan Kampus yang Modern & Terintegrasi</div>
        <div class="mt-4">
            <span class="feature-pill"><i class="bi bi-shield-check"></i> Aman</span>
            <span class="feature-pill"><i class="bi bi-lightning-charge"></i> Cepat</span>
            <span class="feature-pill"><i class="bi bi-phone"></i> Responsif</span>
            <span class="feature-pill"><i class="bi bi-graph-up"></i> Termonitor</span>
        </div>
    </div>
    <div class="auth-right">
        @yield('auth-content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
