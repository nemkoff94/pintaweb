(() => {
    const datePicker = document.querySelector('[data-event-datepicker]');

    if (datePicker && typeof window.flatpickr === 'function') {
        window.flatpickr.localize(window.flatpickr.l10ns.ru);
        window.flatpickr(datePicker, {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            time_24hr: true,
            minuteIncrement: 5,
            altInput: true,
            altFormat: 'd.m.Y H:i',
        });
    }

    if (typeof window.tinymce === 'object') {
        window.tinymce.init({
            selector: '.js-richtext',
            menubar: false,
            branding: false,
            height: 260,
            plugins: 'lists link image table code fullscreen',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link table | removeformat code fullscreen',
            content_style: 'body{font-family:Manrope,sans-serif;font-size:14px;line-height:1.55;}',
            setup: (editor) => {
                const form = editor.getElement().closest('form');
                if (form) {
                    form.addEventListener('submit', () => editor.save());
                }
            },
        });
    }
})();
