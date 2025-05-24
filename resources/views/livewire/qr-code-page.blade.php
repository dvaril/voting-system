<x-filament-panels::page>
    <div
        x-data="{
            channel: new BroadcastChannel('qr-code-window-channel'),

            init: function () {
                this.channel.onmessage = (e) => {
                    if (e.data.type === 'close-qr-code-window') {
                        window.close();
                    }
                };
            }
        }"
    >

        <x-filament-panels::form
            :wire:key="$this->getId() . '.forms.' . $this->getFormStatePath()"
            wire:submit="save"
        >
            {{ $this->form }}

            <x-filament-panels::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament-panels::form>
    </div>

</x-filament-panels::page>
