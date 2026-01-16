<div
    wire:ignore
    x-data="toastuiEditor(@entangle($attributes->wire('model')))"
    x-init="init()"
>
    <div class="flex items-center gap-2 mb-2">
        <button type="button" @click="bold()" class="px-3 py-1 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Bold
        </button>
    </div>
    <div x-ref="editor"></div>
    <textarea class="hidden" {{ $attributes->wire('model') }}></textarea>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('toastuiEditor', (value) => ({
            editor: null,
            init() {
                this.editor = new toastui.Editor({
                    el: this.$refs.editor,
                    initialValue: value.get(),
                    height: '500px',
                    initialEditType: 'markdown',
                    previewStyle: 'vertical',
                    events: {
                        change: () => {
                            value.set(this.editor.getMarkdown());
                        },
                    },
                });

                this.$watch('value', (newValue) => {
                    if (newValue !== this.editor.getMarkdown()) {
                        this.editor.setMarkdown(newValue);
                    }
                });
            },
            bold() {
                if (this.editor) {
                    this.editor.exec('bold');
                }
            }
        }));
    });
</script>
