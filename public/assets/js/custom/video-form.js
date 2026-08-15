/**
 * Powers both the Add Video and Edit Video pages:
 * - Live Vimeo embed preview as the link is typed/pasted.
 * - Live thumbnail preview when a new image is chosen.
 * - AJAX form submission with inline validation errors and a success toast.
 */
(function () {
    const form = document.getElementById('video-form');
    if (!form) {
        return;
    }

    const videoLinkInput = document.getElementById('video_link');
    const thumbnailInput = document.getElementById('thumbnail');

    function updateVimeoPreview(link) {
        const iframe = document.getElementById('video-preview');
        const empty = document.getElementById('video-preview-empty');
        if (!iframe) {
            return;
        }

        const match = (link || '').match(/vimeo\.com\/(?:video\/)?(\d+)/i);

        if (match) {
            iframe.src = `https://player.vimeo.com/video/${match[1]}`;
            iframe.classList.remove('d-none');
            if (empty) empty.classList.add('d-none');
        } else {
            iframe.src = '';
            iframe.classList.add('d-none');
            if (empty) empty.classList.remove('d-none');
        }
    }

    function updateThumbnailPreview(file) {
        const img = document.getElementById('thumbnail-preview');
        const empty = document.getElementById('thumbnail-preview-empty');
        if (!img || !file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            img.src = e.target.result;
            img.classList.remove('d-none');
            if (empty) empty.classList.add('d-none');
        };
        reader.readAsDataURL(file);
    }

    function clearErrors() {
        form.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
        form.querySelectorAll('[data-error-for]').forEach((el) => (el.textContent = ''));
    }

    function showErrors(errors) {
        Object.keys(errors || {}).forEach((field) => {
            const input = form.querySelector(`[name="${field}"]`);
            const errorEl = form.querySelector(`[data-error-for="${field}"]`);
            if (input) input.classList.add('is-invalid');
            if (errorEl) errorEl.textContent = errors[field][0];
        });
    }

    videoLinkInput?.addEventListener('input', (e) => updateVimeoPreview(e.target.value));
    thumbnailInput?.addEventListener('change', (e) => updateThumbnailPreview(e.target.files[0]));

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        const submitBtn = document.getElementById('video-save-btn');
        const spinner = document.getElementById('video-save-spinner');
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');

        fetch(form.action, {
            method: 'POST', // Laravel method-spoofing (_method=PUT) handles the edit case.
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                Accept: 'application/json',
            },
        })
            .then(async (response) => {
                const data = await response.json();

                if (response.status === 422) {
                    showErrors(data.errors);
                    showToast('Please correct the highlighted fields.', 'danger');
                    return;
                }

                if (!response.ok) {
                    showToast(data.message || 'Something went wrong.', 'danger');
                    return;
                }

                showToast(data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1200);
            })
            .catch(() => {
                showToast('Network error. Please try again.', 'danger');
            })
            .finally(() => {
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
            });
    });
})();
