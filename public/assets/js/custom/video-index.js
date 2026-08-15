/**
 * Powers the video listing (Edit) page:
 * - DataTables for search / pagination / page-length.
 * - A Bootstrap modal that plays the Vimeo embed for the clicked row, with
 *   explicit Play/Pause controls wired to the real Vimeo Player API (so
 *   playback can be controlled reliably, not just via the tiny native bar).
 */
(function () {
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

    let player = null;

    document.querySelectorAll('.btn-view-video').forEach((btn) => {
        btn.addEventListener('click', function () {
            const embedUrl = this.dataset.embedUrl;
            modalTitle.textContent = this.dataset.title || 'Video';
            // Autoplay as soon as the popup opens (spec: "video will be played inside the pop-up").
            modalIframe.src = embedUrl ? `${embedUrl}?autoplay=1` : '';

            player = embedUrl && window.Vimeo ? new Vimeo.Player(modalIframe) : null;

            modal?.show();
        });
    });

    playBtn?.addEventListener('click', () => player?.play());
    pauseBtn?.addEventListener('click', () => player?.pause());

    modalEl?.addEventListener('hidden.bs.modal', () => {
        player?.unload().catch(() => {});
        player = null;
        modalIframe.src = '';
    });
})();
