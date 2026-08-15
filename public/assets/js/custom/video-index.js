/**
 * Powers the video listing (Edit) page:
 * - DataTables for search / pagination / page-length.
 * - A Bootstrap modal that plays the Vimeo embed for the clicked row, with
 *   Play/Pause controls sent to the iframe via Vimeo's postMessage protocol.
 *   (Talking to the iframe directly avoids depending on an external SDK
 *   script from Vimeo's CDN, which is one more thing that can fail to load.)
 */
(function () {
    const VIMEO_ORIGIN = 'https://player.vimeo.com';

    const table = document.getElementById('videos-table');
    if (table && window.jQuery) {
        jQuery(table).DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            order: [],
        });
    }

    const modalEl = document.getElementById('video-view-modal');
    const modalIframe = document.getElementById('video-view-modal-iframe');
    const modalTitle = document.getElementById('video-view-modal-title');
    const playBtn = document.getElementById('video-view-play-btn');
    const pauseBtn = document.getElementById('video-view-pause-btn');
    const modal = modalEl ? new bootstrap.Modal(modalEl) : null;

    function sendVimeoCommand(method) {
        modalIframe.contentWindow?.postMessage(JSON.stringify({ method }), VIMEO_ORIGIN);
    }

    document.querySelectorAll('.btn-view-video').forEach((btn) => {
        btn.addEventListener('click', function () {
            const embedUrl = this.dataset.embedUrl;
            modalTitle.textContent = this.dataset.title || 'Video';
            // Autoplay as soon as the popup opens (spec: "video will be played inside the pop-up").
            modalIframe.src = embedUrl ? `${embedUrl}?autoplay=1` : '';
            modal?.show();
        });
    });

    playBtn?.addEventListener('click', () => sendVimeoCommand('play'));
    pauseBtn?.addEventListener('click', () => sendVimeoCommand('pause'));

    modalEl?.addEventListener('hidden.bs.modal', () => {
        modalIframe.src = '';
    });
})();
