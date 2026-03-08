<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-container {
            max-width: 440px;
            width: 100%;
            padding: 0 16px;
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 8px;
        }
        .auth-logo .icon {
            font-size: 48px;
            color: #fff;
            filter: drop-shadow(0 4px 12px rgba(0,0,0,.2));
        }
        h1 {
            text-align: center; margin-bottom: 20px; color: #fff;
            font-size: 28px; font-weight: 800; letter-spacing: -0.5px;
            text-shadow: 0 2px 10px rgba(0,0,0,.15);
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
            border: 1px solid rgba(255,255,255,0.18);
        }
        .auth-tabs { display: flex; margin-bottom: 24px; background: #f1f5f9; border-radius: 12px; padding: 4px; }
        .auth-tabs button {
            flex: 1; padding: 10px; border: none; background: transparent; cursor: pointer;
            font-size: 14px; font-weight: 600; transition: all .25s ease; border-radius: 10px; color: #64748b;
            font-family: inherit;
        }
        .auth-tabs button.active { background: #fff; color: #4f46e5; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }

        label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #475569; letter-spacing: 0.01em; }
        input {
            width: 100%; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-size: 14px; margin-bottom: 16px; background: #f8fafc; transition: all .2s ease;
            font-family: inherit;
        }
        input:focus {
            outline: none; border-color: #818cf8; background: #fff;
            box-shadow: 0 0 0 3px rgba(129,140,248,.2);
        }

        .btn {
            padding: 10px 20px; border: none; border-radius: 10px; cursor: pointer;
            font-size: 13px; font-weight: 600; transition: all .2s ease; font-family: inherit;
            display: inline-flex; align-items: center; gap: 6px; letter-spacing: 0.01em;
        }
        .btn:active { transform: scale(0.97); }
        .btn-primary { background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; box-shadow: 0 2px 8px rgba(79,70,229,.35); }
        .btn-primary:hover { background: linear-gradient(135deg, #4f46e5, #4338ca); box-shadow: 0 4px 14px rgba(79,70,229,.4); transform: translateY(-1px); }
        .btn-block { width: 100%; justify-content: center; padding: 12px; font-size: 15px; }

        .error-msg {
            color: #dc2626; font-size: 13px; margin-bottom: 12px;
            background: #fef2f2; padding: 10px 14px; border-radius: 10px; border: 1px solid #fecaca;
        }
        .hidden { display: none !important; }

        @media (max-width: 480px) {
            .auth-container { padding: 0 12px; }
            .card { padding: 22px; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-logo">
            <span class="material-icons-round icon">task_alt</span>
        </div>
        <h1>Task Manager</h1>
        <div class="card">
            <div class="auth-tabs">
                <button class="active" onclick="showAuthTab('login')">Login</button>
                <button onclick="showAuthTab('register')">Register</button>
            </div>
            <div id="auth-error" class="error-msg hidden"></div>

            <!-- Login Form -->
            <form id="login-form" onsubmit="handleLogin(event)">
                <label>Email</label>
                <input type="email" id="login-email" placeholder="you@example.com" required>
                <label>Password</label>
                <input type="password" id="login-password" placeholder="Enter your password" required>
                <button type="submit" class="btn btn-primary btn-block">
                    <span class="material-icons-round" style="font-size:18px">login</span> Sign In
                </button>
            </form>

            <!-- Register Form -->
            <form id="register-form" class="hidden" onsubmit="handleRegister(event)">
                <label>Name</label>
                <input type="text" id="reg-name" placeholder="Your full name" required>
                <label>Email</label>
                <input type="email" id="reg-email" placeholder="you@example.com" required>
                <label>Password</label>
                <input type="password" id="reg-password" placeholder="Min 8 characters" required minlength="8">
                <label>Confirm Password</label>
                <input type="password" id="reg-password-confirm" placeholder="Repeat password" required minlength="8">
                <button type="submit" class="btn btn-primary btn-block">
                    <span class="material-icons-round" style="font-size:18px">person_add</span> Create Account
                </button>
            </form>
        </div>
    </div>

<script>
const API = '/api';

// If already logged in, redirect to tasks
(function() {
    const token = sessionStorage.getItem('token');
    if (token) {
        fetch(API + '/user', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } })
            .then(r => { if (r.ok) window.location.href = '/tasks'; else sessionStorage.removeItem('token'); })
            .catch(() => {});
    }
})();

function showAuthTab(tab) {
    document.getElementById('auth-error').classList.add('hidden');
    document.querySelectorAll('.auth-tabs button').forEach(b => b.classList.remove('active'));
    if (tab === 'login') {
        document.querySelector('.auth-tabs button:first-child').classList.add('active');
        document.getElementById('login-form').classList.remove('hidden');
        document.getElementById('register-form').classList.add('hidden');
    } else {
        document.querySelector('.auth-tabs button:last-child').classList.add('active');
        document.getElementById('login-form').classList.add('hidden');
        document.getElementById('register-form').classList.remove('hidden');
    }
}

async function handleLogin(e) {
    e.preventDefault();
    try {
        const res = await fetch(API + '/login', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({
                email: document.getElementById('login-email').value,
                password: document.getElementById('login-password').value,
            })
        });
        const data = await res.json();
        if (!res.ok) throw data;
        sessionStorage.setItem('token', data.token);
        Swal.fire({ title: 'Welcome back!', text: 'Logged in successfully.', icon: 'success', timer: 1200, showConfirmButton: false });
        setTimeout(() => window.location.href = '/tasks', 1200);
    } catch (err) {
        showError(err);
    }
}

async function handleRegister(e) {
    e.preventDefault();
    try {
        const res = await fetch(API + '/register', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: document.getElementById('reg-name').value,
                email: document.getElementById('reg-email').value,
                password: document.getElementById('reg-password').value,
                password_confirmation: document.getElementById('reg-password-confirm').value,
            })
        });
        const data = await res.json();
        if (!res.ok) throw data;
        Swal.fire({ title: 'Success!', text: 'Account created. Please login.', icon: 'success', timer: 1500, showConfirmButton: false });
        setTimeout(() => {
            document.getElementById('register-form').reset();
            showAuthTab('login');
        }, 1500);
    } catch (err) {
        showError(err);
    }
}

function showError(err) {
    const el = document.getElementById('auth-error');
    let msg = 'Something went wrong.';
    if (err.message) msg = err.message;
    if (err.errors) msg = Object.values(err.errors).flat().join(' ');
    el.textContent = msg;
    el.classList.remove('hidden');
}
</script>
</body>
</html>
