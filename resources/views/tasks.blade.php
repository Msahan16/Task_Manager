<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
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
        }
        .container { max-width: 960px; margin: 0 auto; padding: 24px 20px 40px; }
        h1 { text-align: center; margin-bottom: 20px; color: #fff; font-size: 28px; font-weight: 800; letter-spacing: -0.5px; text-shadow: 0 2px 10px rgba(0,0,0,.15); }
        h1 .icon { vertical-align: middle; margin-right: 8px; font-size: 32px; }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
            border: 1px solid rgba(255,255,255,0.18);
        }

        label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #475569; letter-spacing: 0.01em; }
        input, select, textarea {
            width: 100%; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-size: 14px; margin-bottom: 16px; background: #f8fafc; transition: all .2s ease;
            font-family: inherit;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: #818cf8; background: #fff;
            box-shadow: 0 0 0 3px rgba(129,140,248,.2);
        }
        textarea { resize: vertical; min-height: 80px; }

        .btn {
            padding: 10px 20px; border: none; border-radius: 10px; cursor: pointer;
            font-size: 13px; font-weight: 600; transition: all .2s ease; font-family: inherit;
            display: inline-flex; align-items: center; gap: 6px; letter-spacing: 0.01em;
        }
        .btn:active { transform: scale(0.97); }
        .btn-primary { background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; box-shadow: 0 2px 8px rgba(79,70,229,.35); }
        .btn-primary:hover { background: linear-gradient(135deg, #4f46e5, #4338ca); box-shadow: 0 4px 14px rgba(79,70,229,.4); transform: translateY(-1px); }
        .btn-success { background: linear-gradient(135deg, #34d399, #10b981); color: #fff; box-shadow: 0 2px 8px rgba(16,185,129,.3); }
        .btn-success:hover { box-shadow: 0 4px 14px rgba(16,185,129,.4); transform: translateY(-1px); }
        .btn-danger { background: linear-gradient(135deg, #f87171, #ef4444); color: #fff; box-shadow: 0 2px 8px rgba(239,68,68,.3); }
        .btn-danger:hover { box-shadow: 0 4px 14px rgba(239,68,68,.4); transform: translateY(-1px); }
        .btn-secondary { background: #f1f5f9; color: #475569; border: 1.5px solid #e2e8f0; }
        .btn-secondary:hover { background: #e2e8f0; }
        .btn-warning { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #fff; box-shadow: 0 2px 8px rgba(245,158,11,.3); }
        .btn-warning:hover { box-shadow: 0 4px 14px rgba(245,158,11,.4); transform: translateY(-1px); }
        .btn-sm { padding: 7px 14px; font-size: 12px; border-radius: 8px; }

        .error-msg {
            color: #dc2626; font-size: 13px; margin-bottom: 12px;
            background: #fef2f2; padding: 10px 14px; border-radius: 10px; border: 1px solid #fecaca;
        }

        /* Header bar */
        .header-bar {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 16px; background: rgba(255,255,255,.15); backdrop-filter: blur(10px);
            padding: 12px 20px; border-radius: 14px; border: 1px solid rgba(255,255,255,.2);
        }
        .header-bar span { font-size: 14px; color: #fff; font-weight: 500; }
        .header-bar strong { font-weight: 700; }
        .header-bar .btn-secondary { background: rgba(255,255,255,.2); color: #fff; border: 1px solid rgba(255,255,255,.3); }
        .header-bar .btn-secondary:hover { background: rgba(255,255,255,.35); }

        /* Filters */
        .filters { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 16px; }
        .filters select, .filters input { margin-bottom: 0; flex: 1; min-width: 140px; background: #fff; }

        /* Task list */
        .task-item {
            display: flex; justify-content: space-between; align-items: flex-start;
            padding: 16px; margin-bottom: 10px; border-radius: 12px;
            background: #f8fafc; border: 1px solid #f1f5f9;
            transition: all .2s ease;
        }
        .task-item:hover { background: #f1f5f9; border-color: #e2e8f0; transform: translateX(4px); }
        .task-item:last-child { margin-bottom: 0; }
        .task-info { flex: 1; }
        .task-info h3 { font-size: 15px; margin-bottom: 6px; font-weight: 600; color: #1e293b; }
        .task-info p { font-size: 13px; color: #64748b; margin-bottom: 6px; line-height: 1.5; }
        .task-actions { display: flex; gap: 6px; flex-shrink: 0; margin-left: 16px; align-items: flex-start; }

        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;
        }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-in_progress { background: #dbeafe; color: #1e40af; }
        .badge-completed { background: #d1fae5; color: #065f46; }
        .badge-low { background: #f1f5f9; color: #475569; }
        .badge-medium { background: #fef3c7; color: #92400e; }
        .badge-high { background: #fee2e2; color: #991b1b; }

        .pagination { display: flex; justify-content: center; gap: 6px; margin-top: 20px; }
        .pagination button { padding: 8px 14px; border-radius: 10px; }

        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15,23,42,.6); backdrop-filter: blur(4px);
            z-index: 100; justify-content: center; align-items: center;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: #fff; border-radius: 20px; padding: 32px; width: 500px;
            max-width: 95vw; max-height: 90vh; overflow-y: auto;
            box-shadow: 0 25px 60px rgba(0,0,0,.2);
            animation: modalIn .25s ease;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(20px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .modal h2 { margin-bottom: 20px; font-size: 20px; font-weight: 700; color: #1e293b; }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 16px; }

        .tab-bar { display: flex; gap: 0; margin-bottom: 16px; background: rgba(255,255,255,.15); border-radius: 14px; padding: 4px; border: 1px solid rgba(255,255,255,.2); }
        .tab-bar button {
            padding: 10px 24px; border: none; background: transparent; cursor: pointer;
            font-size: 14px; font-weight: 600; border-radius: 10px; transition: all .25s ease; color: rgba(255,255,255,.7);
            font-family: inherit;
        }
        .tab-bar button.active { background: #fff; color: #4f46e5; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        .tab-bar button:hover:not(.active) { color: #fff; background: rgba(255,255,255,.1); }

        .hidden { display: none !important; }

        .card h2 { font-size: 18px; font-weight: 700; color: #1e293b; }

        .task-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }

        .task-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 2px; }
        .due-date { font-size: 11px; font-weight: 600; color: #4338ca; background: #eef2ff; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #c7d2fe; }
        .due-date .icon { font-size: 15px; color: #6366f1; }

        .empty-state { text-align: center; padding: 40px 20px; }
        .empty-state .icon { font-size: 48px; color: #cbd5e1; margin-bottom: 12px; }
        .empty-state p { color: #94a3b8; font-size: 15px; }

        /* Responsive - Tablet */
        @media (max-width: 768px) {
            .container { padding: 16px; }
            h1 { font-size: 24px; }
            .card { padding: 18px; border-radius: 14px; }
            .filters select, .filters input { min-width: 120px; }
            .modal { width: 90vw; }
        }

        /* Responsive - Mobile */
        @media (max-width: 480px) {
            .container { padding: 12px; }
            h1 { font-size: 22px; margin-bottom: 14px; }
            .card { padding: 16px; margin-bottom: 12px; }
            .header-bar { flex-direction: column; gap: 10px; align-items: flex-start; padding: 14px 16px; }
            .filters { flex-direction: column; }
            .filters select, .filters input { width: 100%; min-width: unset; flex: unset; }
            .task-item { flex-direction: column; gap: 10px; padding: 14px; }
            .task-actions { margin-left: 0; }
            .tab-bar { width: 100%; }
            .tab-bar button { flex: 1; padding: 10px 8px; font-size: 13px; }
            .modal { padding: 22px; width: 100%; border-radius: 16px; }
            .modal-actions { flex-direction: column; }
            .modal-actions .btn { width: 100%; }
            .pagination { flex-wrap: wrap; }
            .btn { padding: 10px 14px; }
            .btn-sm { padding: 8px 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><span class="material-icons-round icon">task_alt</span> Task Manager</h1>
        <div class="header-bar">
            <span>Welcome back, <strong id="user-name"></strong></span>
            <button class="btn btn-secondary btn-sm" onclick="handleLogout()">
                <span class="material-icons-round" style="font-size:16px">logout</span> Logout
            </button>
        </div>

        <!-- Tabs: Active / Trash -->
        <div class="tab-bar">
            <button class="active" onclick="switchTab('active')">
                <span class="material-icons-round" style="font-size:16px;vertical-align:middle;margin-right:4px">checklist</span>Active Tasks
            </button>
            <button onclick="switchTab('trash')">
                <span class="material-icons-round" style="font-size:16px;vertical-align:middle;margin-right:4px">delete_outline</span>Trash
            </button>
        </div>

        <!-- Active Tasks View -->
        <div id="active-view">
            <div class="card">
                <div class="task-header">
                    <h2><span class="material-icons-round" style="font-size:20px;vertical-align:middle;margin-right:6px;color:#6366f1">list_alt</span>Tasks</h2>
                    <button class="btn btn-primary btn-sm" onclick="openModal()">
                        <span class="material-icons-round" style="font-size:16px">add</span> New Task
                    </button>
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
                    <input type="text" id="filter-search" placeholder="Search tasks..." oninput="debounceSearch()" style="min-width:180px;">
                </div>
                <div id="task-list"></div>
                <div id="pagination" class="pagination"></div>
            </div>
        </div>

        <!-- Trash View -->
        <div id="trash-view" class="hidden">
            <div class="card">
                <h2 style="margin-bottom:20px;"><span class="material-icons-round" style="font-size:20px;vertical-align:middle;margin-right:6px;color:#94a3b8">delete_outline</span>Trashed Tasks</h2>
                <div id="trash-list"></div>
                <div id="trash-pagination" class="pagination"></div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div id="task-modal" class="modal-overlay">
        <div class="modal">
            <h2 id="modal-title"><span class="material-icons-round" style="font-size:22px;vertical-align:middle;margin-right:6px;color:#6366f1">edit_note</span>New Task</h2>
            <div id="modal-error" class="error-msg hidden"></div>
            <form onsubmit="handleSaveTask(event)">
                <input type="hidden" id="task-id">
                <label>Title</label>
                <input type="text" id="task-title" placeholder="What needs to be done?" required>
                <label>Description</label>
                <textarea id="task-desc" placeholder="Add details about this task..."></textarea>
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
                    <button type="submit" class="btn btn-primary">
                        <span class="material-icons-round" style="font-size:16px">save</span> Save Task
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
const API = '/api';
let token = sessionStorage.getItem('token');
let currentPage = 1;
let trashPage = 1;
let searchTimer;

// --- Guard: redirect to login if no token ---
(async function init() {
    if (!token) { window.location.href = '/login'; return; }
    try {
        const user = await api('/user');
        document.getElementById('user-name').textContent = user.name;
        loadTasks();
    } catch {
        token = null;
        sessionStorage.removeItem('token');
        window.location.href = '/login';
    }
})();

// --- API Helper ---
async function api(path, options = {}) {
    const headers = { 'Accept': 'application/json', 'Content-Type': 'application/json' };
    if (token) headers['Authorization'] = 'Bearer ' + token;
    const res = await fetch(API + path, { ...options, headers });
    const data = await res.json();
    if (res.status === 401) { sessionStorage.removeItem('token'); window.location.href = '/login'; return; }
    if (!res.ok) throw data;
    return data;
}

// --- Logout ---
async function handleLogout() {
    try { await api('/logout', { method: 'POST' }); } catch {}
    token = null;
    sessionStorage.removeItem('token');
    window.location.href = '/login';
}

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
        list.innerHTML = '<div class="empty-state"><span class="material-icons-round icon">inbox</span><p>No tasks found. Create one to get started!</p></div>';
        document.getElementById('pagination').innerHTML = '';
        return;
    }
    list.innerHTML = res.data.map(t => `
        <div class="task-item">
            <div class="task-info">
                <h3>${esc(t.title)}</h3>
                ${t.description ? '<p>' + esc(t.description) + '</p>' : ''}
                <div class="task-meta">
                    <span class="badge badge-${t.status}">${t.status.replace('_',' ')}</span>
                    <span class="badge badge-${t.priority}">${t.priority}</span>
                    ${t.due_date ? '<span class="due-date"><span class="material-icons-round icon">event</span>' + t.due_date.split('T')[0] + '</span>' : ''}
                </div>
            </div>
            <div class="task-actions">
                <button class="btn btn-success btn-sm" onclick="openModal(${t.id})" title="Edit"><span class="material-icons-round" style="font-size:14px">edit</span> Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteTask(${t.id})" title="Delete"><span class="material-icons-round" style="font-size:14px">delete</span></button>
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
            closeModal();
            Swal.fire({ title: 'Updated!', text: 'Task updated successfully.', icon: 'success', timer: 1500, showConfirmButton: false });
        } else {
            await api('/tasks', { method: 'POST', body: JSON.stringify(body) });
            closeModal();
            Swal.fire({ title: 'Created!', text: 'New task added successfully.', icon: 'success', timer: 1500, showConfirmButton: false });
        }
        loadTasks(currentPage);
    } catch (err) {
        showError('modal-error', err);
    }
}

async function deleteTask(id) {
    const result = await Swal.fire({
        title: 'Move to Trash?',
        text: 'This task will be moved to trash.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e63946',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    });
    if (!result.isConfirmed) return;
    try {
        await api('/tasks/' + id, { method: 'DELETE' });
        Swal.fire({ title: 'Deleted!', text: 'Task moved to trash.', icon: 'success', timer: 1500, showConfirmButton: false });
        loadTasks(currentPage);
    } catch (err) {
        Swal.fire('Error', 'Failed to delete task.', 'error');
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
        list.innerHTML = '<div class="empty-state"><span class="material-icons-round icon">delete_sweep</span><p>Trash is empty.</p></div>';
        document.getElementById('trash-pagination').innerHTML = '';
        return;
    }
    list.innerHTML = res.data.map(t => `
        <div class="task-item">
            <div class="task-info">
                <h3 style="opacity:.6">${esc(t.title)}</h3>
                ${t.description ? '<p>' + esc(t.description) + '</p>' : ''}
            </div>
            <div class="task-actions">
                <button class="btn btn-warning btn-sm" onclick="restoreTask(${t.id})" title="Restore"><span class="material-icons-round" style="font-size:14px">restore</span> Restore</button>
                <button class="btn btn-danger btn-sm" onclick="forceDeleteTask(${t.id})" title="Delete Forever"><span class="material-icons-round" style="font-size:14px">delete_forever</span></button>
            </div>
        </div>
    `).join('');
    renderPagination(res, 'trash-pagination', loadTrash);
}

async function restoreTask(id) {
    try {
        await api('/tasks/' + id + '/restore', { method: 'PATCH' });
        Swal.fire({ title: 'Restored!', text: 'Task has been restored.', icon: 'success', timer: 1500, showConfirmButton: false });
        loadTrash(trashPage);
    } catch { Swal.fire('Error', 'Failed to restore.', 'error'); }
}

async function forceDeleteTask(id) {
    const result = await Swal.fire({
        title: 'Permanently Delete?',
        text: 'This cannot be undone!',
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#e63946',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete forever!'
    });
    if (!result.isConfirmed) return;
    try {
        await api('/tasks/' + id + '/force-delete', { method: 'DELETE' });
        Swal.fire({ title: 'Deleted!', text: 'Task permanently removed.', icon: 'success', timer: 1500, showConfirmButton: false });
        loadTrash(trashPage);
    } catch {
        Swal.fire('Error', 'Failed to delete.', 'error');
    }
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
