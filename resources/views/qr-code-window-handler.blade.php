<div
    x-init="
        $wire.on('open-qr-code-window', ({ recordKey }) =>
            openQrCodeWindow(recordKey)
        )
    "
    x-data="{
        channel: new BroadcastChannel('qr-code-window-channel'),

        closeQrCodeWindow: function () {
            this.channel.postMessage({ type: 'close-qr-code-window' });
        },

        openQrCodeWindow: function (recordKey) {
            this.closeQrCodeWindow();

            const url = `/qr-code-page/${recordKey}`;
            window.open(url, '_blank', 'noreferrer,noopener');
        }
    }"
>
</div>

