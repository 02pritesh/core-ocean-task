/**
 * Small shared helper used across the admin pages.
 * Shows a Bootstrap 5 toast with a success/danger tint.
 */
function showToast(message, type = 'success') {
    const toastEl = document.getElementById('app-toast');
    const bodyEl = document.getElementById('app-toast-body');

    if (!toastEl || !bodyEl) {
        return;
    }

    bodyEl.textContent = message;
    toastEl.classList.remove('bg-success', 'bg-danger', 'text-white');
    toastEl.classList.add(type === 'success' ? 'bg-success' : 'bg-danger', 'text-white');

    const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
    toast.show();
}
