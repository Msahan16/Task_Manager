<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f0f2f5; color: #333; }
        .container { max-width: 1100px; margin: 0 auto; padding: 16px 20px; }
        h1 { text-align: center; margin-bottom: 14px; color: #1a1a2e; font-size: 24px; }
        .card { background: #fff; border-radius: 10px; padding: 20px; margin-bottom: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }

        /* Auth forms */
        .auth-container { max-width: 420px; margin: 30px auto; padding: 0 16px; }
        .auth-tabs { display: flex; margin-bottom: 20px; }
        .auth-tabs button { flex: 1; padding: 12px; border: none; background: #e9ecef; cursor: pointer; font-size: 15px; transition: .2s; }
        .auth-tabs button.active { background: #4361ee; color: #fff; }
        .auth-tabs button:first-child { border-radius: 8px 0 0 8px; }
        .auth-tabs button:last-child { border-radius: 0 8px 8px 0; }

        label { display: block; margin-bottom: 4px; font-weight: 600; font-size: 14px; }
        input, select, textarea { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; margin-bottom: 14px; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #4361ee; box-shadow: 0 0 0 3px rgba(67,97,238,.15); }
        textarea { resize: vertical; min-height: 70px; }

        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600; transition: .2s; }
        .btn-primary { background: #4361ee; color: #fff; }
        .btn-primary:hover { background: #3a56d4; }
        .btn-success { background: #2ec4b6; color: #fff; }
        .btn-success:hover { background: #28b0a3; }
        .btn-danger { background: #e63946; color: #fff; }
        .btn-danger:hover { background: #cf3240; }
        .btn-secondary { background: #6c757d; color: #fff; }
        .btn-secondary:hover { background: #5a6268; }
        .btn-warning { background: #ff9f1c; color: #fff; }
        .btn-warning:hover { background: #e8900f; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-block { width: 100%; }

        .error-msg { color: #e63946; font-size: 13px; margin-bottom: 10px; }
        .success-msg { color: #2ec4b6; font-size: 13px; margin-bottom: 10px; }

        /* Header bar */
        .header-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .header-bar span { font-size: 15px; color: #555; }

        /* Filters */
        .filters { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 12px; }
        .filters select, .filters input { margin-bottom: 0; flex: 1; min-width: 140px; }

        /* Task list */
        .task-item { display: flex; justify-content: space-between; align-items: flex-start; padding: 14px 0; border-bottom: 1px solid #f0f0f0; }
        .task-item:last-child { border-bottom: none; }
        .task-info { flex: 1; }
        .task-info h3 { font-size: 16px; margin-bottom: 4px; }
        .task-info p { font-size: 13px; color: #777; margin-bottom: 4px; }
        .task-actions { display: flex; gap: 6px; flex-shrink: 0; margin-left: 12px; }

        .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-in_progress { background: #cce5ff; color: #004085; }
        .badge-completed { background: #d4edda; color: #155724; }
        .badge-low { background: #e2e3e5; color: #383d41; }
        .badge-medium { background: #fff3cd; color: #856404; }
        .badge-high { background: #f8d7da; color: #721c24; }

        .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 16px; }
        .pagination button { padding: 6px 14px; }

        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.4); z-index: 100; justify-content: center; align-items: center; }
        .modal-overlay.active { display: flex; }
        .modal { background: #fff; border-radius: 10px; padding: 28px; width: 480px; max-width: 95vw; max-height: 90vh; overflow-y: auto; }
        .modal h2 { margin-bottom: 16px; }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 10px; }

        .tab-bar { display: flex; gap: 0; margin-bottom: 10px; }
        .tab-bar button { padding: 8px 20px; border: 1px solid #ddd; background: #f8f9fa; cursor: pointer; font-size: 14px; }
        .tab-bar button.active { background: #4361ee; color: #fff; border-color: #4361ee; }
        .tab-bar button:first-child { border-radius: 6px 0 0 6px; }
        .tab-bar button:last-child { border-radius: 0 6px 6px 0; }

        .hidden { display: none !important; }

        /* Responsive - Tablet */
        @media (max-width: 768px) {
            .container { padding: 14px; }
            h1 { font-size: 22px; }
            .card { padding: 16px; }
            .filters select, .filters input { min-width: 120px; }
            .modal { width: 90vw; }
        }

        /* Responsive - Mobile */
        @media (max-width: 480px) {
            .container { padding: 10px; }
            h1 { font-size: 20px; margin-bottom: 10px; }
            .card { padding: 14px; margin-bottom: 10px; }

            .auth-container { margin: 16px auto; padding: 0 10px; max-width: 100%; }

            .header-bar { flex-direction: column; gap: 8px; align-items: flex-start; }

            .filters { flex-direction: column; }
            .filters select, .filters input { width: 100%; min-width: unset; flex: unset; }

            .task-item { flex-direction: column; gap: 8px; }
            .task-actions { margin-left: 0; }

            .tab-bar { width: 100%; }
            .tab-bar button { flex: 1; padding: 10px 8px; font-size: 13px; }

            .modal { padding: 18px; width: 100%; }

            .modal-actions { flex-direction: column; }
            .modal-actions .btn { width: 100%; }

            .pagination { flex-wrap: wrap; }

            .btn { padding: 10px 14px; }
            .btn-sm { padding: 8px 10px; }
        }
    </style>
</head>
<body>
    <!-- AUTH SECTION -->
    <div id="auth-section" class="auth-container">
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
                <input type="email" id="login-email" required>
                <label>Password</label>
                <input type="password" id="login-password" required>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

            <!-- Register Form -->
            <form id="register-form" class="hidden" onsubmit="handleRegister(event)">
                <label>Name</label>
                <input type="text" id="reg-name" required>
                <label>Email</label>
                <input type="email" id="reg-email" required>
                <label>Password</label>
                <input type="password" id="reg-password" required minlength="8">
                <label>Confirm Password</label>
                <input type="password" id="reg-password-confirm" required minlength="8">
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
        </div>
    </div>

    <!-- APP SECTION -->
    <div id="app-section" class="container hidden">
        <h1>Task Manager</h1>
        <div class="header-bar">
            <span>Welcome, <strong id="user-name"></strong></span>
            <button class="btn btn-secondary btn-sm" onclick="handleLogout()">Logout</button>
        </div>

        <!-- Tabs: Active / Trash -->
        <div class="tab-bar">
            <button class="active" onclick="switchTab('active')">Active Tasks</button>
            <button onclick="switchTab('trash')">Trash</button>
        </div>

        <!-- Active Tasks View -->
        <div id="active-view">
            <div class="card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <h2>Tasks</h2>
                    <button class="btn btn-primary btn-sm" onclick="openModal()">+ New Task</button>
                </div>
                <div class="filters">
                    <select id="filter-status" onchange="loadTasks()">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                    <select id="filter-priority" onchange="loadTasks()">
                        <option value="">All Priorities</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                    <input type="text" id="filter-search" placeholder="Search..." oninput="debounceSearch()" style="min-width:180px;">
                </div>
                <div id="task-list"></div>
                <div id="pagination" class="pagination"></div>
            </div>
        </div>

        <!-- Trash View -->
        <div id="trash-view" class="hidden">
            <div class="card">
                <h2 style="margin-bottom:16px;">Trashed Tasks</h2>
                <div id="trash-list"></div>
                <div id="trash-pagination" class="pagination"></div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div id="task-modal" class="modal-overlay">
        <div class="modal">
            <h2 id="modal-title">New Task</h2>
            <div id="modal-error" class="error-msg hidden"></div>
            <form onsubmit="handleSaveTask(event)">
                <input type="hidden" id="task-id">
                <label>Title</label>
                <input type="text" id="task-title" required>
                <label>Description</label>
                <textarea id="task-desc"></textarea>
                <label>Status</label>
                <select id="task-status">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
                <label>Priority</label>
                <select id="task-priority">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
                <label>Due Date</label>
                <input type="date" id="task-due">
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

<script>
const API = '/api';
let token = localStorage.getItem('token');
let currentPage = 1;
let trashPage = 1;
let searchTimer;

// --- API Helper ---
async function api(path, options = {}) {
    const headers = { 'Accept': 'application/json', 'Content-Type': 'application/json' };
    if (token) headers['Authorization'] = 'Bearer ' + token;
    const res = await fetch(API + path, { ...options, headers });
    const data = await res.json();
    if (!res.ok) throw data;
    return data;
}

// --- Auth ---
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
        const data = await api('/login', { method: 'POST', body: JSON.stringify({
            email: document.getElementById('login-email').value,
            password: document.getElementById('login-password').value,
        })});
        token = data.token;
        localStorage.setItem('token', token);
        showApp(data.user);
    } catch (err) {
        showError('auth-error', err);
    }
}

async function handleRegister(e) {
    e.preventDefault();
    try {
        const data = await api('/register', { method: 'POST', body: JSON.stringify({
            name: document.getElementById('reg-name').value,
            email: document.getElementById('reg-email').value,
            password: document.getElementById('reg-password').value,
            password_confirmation: document.getElementById('reg-password-confirm').value,
        })});
        token = data.token;
        localStorage.setItem('token', token);
        showApp(data.user);
    } catch (err) {
        showError('auth-error', err);
    }
}

async function handleLogout() {
    try { await api('/logout', { method: 'POST' }); } catch {}
    token = null;
    localStorage.removeItem('token');
    document.getElementById('app-section').classList.add('hidden');
    document.getElementById('auth-section').classList.remove('hidden');
}

function showApp(user) {
    document.getElementById('user-name').textContent = user.name;
    document.getElementById('auth-section').classList.add('hidden');
    document.getElementById('app-section').classList.remove('hidden');
    loadTasks();
}

// --- Init on page load ---
(async function init() {
    if (token) {
        try {
            const user = await api('/user');
            showApp(user);
        } catch {
            token = null;
            localStorage.removeItem('token');
        }
    }
})();

// --- Tasks ---
async function loadTasks(page = 1) {
    currentPage = page;
    const status = document.getElementById('filter-status').value;
    const priority = document.getElementById('filter-priority').value;
    const search = document.getElementById('filter-search').value;
    let query = `?page=${page}`;
    if (status) query += `&status=${encodeURIComponent(status)}`;
    if (priority) query += `&priority=${encodeURIComponent(priority)}`;
    if (search) query += `&search=${encodeURIComponent(search)}`;

    try {
        const res = await api('/tasks' + query);
        renderTasks(res);
    } catch (err) {
        document.getElementById('task-list').innerHTML = '<p class="error-msg">Failed to load tasks.</p>';
    }
}

function renderTasks(res) {
    const list = document.getElementById('task-list');
    if (!res.data.length) {
        list.innerHTML = '<p style="color:#999;text-align:center;padding:20px;">No tasks found.</p>';
        document.getElementById('pagination').innerHTML = '';
        return;
    }
    list.innerHTML = res.data.map(t => `
        <div class="task-item">
            <div class="task-info">
                <h3>${esc(t.title)}</h3>
                <p>${esc(t.description || '')}</p>
                <p>
                    <span class="badge badge-${t.status}">${t.status.replace('_',' ')}</span>
                    <span class="badge badge-${t.priority}">${t.priority}</span>
                    ${t.due_date ? '&nbsp; Due: ' + t.due_date.split('T')[0] : ''}
                </p>
            </div>
            <div class="task-actions">
                <button class="btn btn-success btn-sm" onclick="openModal(${t.id})">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteTask(${t.id})">Delete</button>
            </div>
        </div>
    `).join('');
    renderPagination(res, 'pagination', loadTasks);
}

function renderPagination(res, elId, loadFn) {
    const el = document.getElementById(elId);
    if (res.last_page <= 1) { el.innerHTML = ''; return; }
    let html = '';
    for (let i = 1; i <= res.last_page; i++) {
        html += `<button class="btn btn-sm ${i === res.current_page ? 'btn-primary' : 'btn-secondary'}" onclick="${loadFn.name}(${i})">${i}</button>`;
    }
    el.innerHTML = html;
}

function debounceSearch() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => loadTasks(), 400);
}

// --- Modal ---
async function openModal(id = null) {
    document.getElementById('modal-error').classList.add('hidden');
    document.getElementById('task-id').value = '';
    document.getElementById('task-title').value = '';
    document.getElementById('task-desc').value = '';
    document.getElementById('task-status').value = 'pending';
    document.getElementById('task-priority').value = 'medium';
    document.getElementById('task-due').value = '';

    if (id) {
        document.getElementById('modal-title').textContent = 'Edit Task';
        try {
            const t = await api('/tasks/' + id);
            document.getElementById('task-id').value = t.id;
            document.getElementById('task-title').value = t.title;
            document.getElementById('task-desc').value = t.description || '';
            document.getElementById('task-status').value = t.status;
            document.getElementById('task-priority').value = t.priority;
            document.getElementById('task-due').value = t.due_date ? t.due_date.split('T')[0] : '';
        } catch (err) {
            showError('modal-error', err);
        }
    } else {
        document.getElementById('modal-title').textContent = 'New Task';
    }
    document.getElementById('task-modal').classList.add('active');
}

function closeModal() {
    document.getElementById('task-modal').classList.remove('active');
}

async function handleSaveTask(e) {
    e.preventDefault();
    const id = document.getElementById('task-id').value;
    const body = {
        title: document.getElementById('task-title').value,
        description: document.getElementById('task-desc').value,
        status: document.getElementById('task-status').value,
        priority: document.getElementById('task-priority').value,
        due_date: document.getElementById('task-due').value || null,
    };
    try {
        if (id) {
            await api('/tasks/' + id, { method: 'PUT', body: JSON.stringify(body) });
        } else {
            await api('/tasks', { method: 'POST', body: JSON.stringify(body) });
        }
        closeModal();
        loadTasks(currentPage);
    } catch (err) {
        showError('modal-error', err);
    }
}

async function deleteTask(id) {
    if (!confirm('Move this task to trash?')) return;
    try {
        await api('/tasks/' + id, { method: 'DELETE' });
        loadTasks(currentPage);
    } catch (err) {
        alert('Failed to delete task.');
    }
}

// --- Trash ---
async function loadTrash(page = 1) {
    trashPage = page;
    try {
        const res = await api('/tasks-trashed?page=' + page);
        renderTrash(res);
    } catch {
        document.getElementById('trash-list').innerHTML = '<p class="error-msg">Failed to load trash.</p>';
    }
}

function renderTrash(res) {
    const list = document.getElementById('trash-list');
    if (!res.data.length) {
        list.innerHTML = '<p style="color:#999;text-align:center;padding:20px;">Trash is empty.</p>';
        document.getElementById('trash-pagination').innerHTML = '';
        return;
    }
    list.innerHTML = res.data.map(t => `
        <div class="task-item">
            <div class="task-info">
                <h3>${esc(t.title)}</h3>
                <p>${esc(t.description || '')}</p>
            </div>
            <div class="task-actions">
                <button class="btn btn-warning btn-sm" onclick="restoreTask(${t.id})">Restore</button>
                <button class="btn btn-danger btn-sm" onclick="forceDeleteTask(${t.id})">Delete Forever</button>
            </div>
        </div>
    `).join('');
    renderPagination(res, 'trash-pagination', loadTrash);
}

async function restoreTask(id) {
    try {
        await api('/tasks/' + id + '/restore', { method: 'PATCH' });
        loadTrash(trashPage);
    } catch { alert('Failed to restore.'); }
}

async function forceDeleteTask(id) {
    if (!confirm('Permanently delete this task? This cannot be undone.')) return;
    try {
        await api('/tasks/' + id + '/force-delete', { method: 'DELETE' });
        loadTrash(trashPage);
    } catch { alert('Failed to delete.'); }
}

// --- Tabs ---
function switchTab(tab) {
    document.querySelectorAll('.tab-bar button').forEach(b => b.classList.remove('active'));
    if (tab === 'active') {
        document.querySelector('.tab-bar button:first-child').classList.add('active');
        document.getElementById('active-view').classList.remove('hidden');
        document.getElementById('trash-view').classList.add('hidden');
        loadTasks();
    } else {
        document.querySelector('.tab-bar button:last-child').classList.add('active');
        document.getElementById('active-view').classList.add('hidden');
        document.getElementById('trash-view').classList.remove('hidden');
        loadTrash();
    }
}

// --- Helpers ---
function esc(str) {
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}

function showError(elId, err) {
    const el = document.getElementById(elId);
    let msg = 'Something went wrong.';
    if (err.message) msg = err.message;
    if (err.errors) msg = Object.values(err.errors).flat().join(' ');
    el.textContent = msg;
    el.classList.remove('hidden');
}
</script>
</body>
</html>
