<div
    wire:ignore
    x-data="{
        quill: null,
        content: @entangle($attributes->wire('model')),
        init() {
            this.quill = new Quill($refs.editor, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link', 'image'],
                        ['clean']
                    ]
                }
            });

            this.quill.root.innerHTML = this.content;

            this.quill.on('text-change', () => {
                this.content = this.quill.root.innerHTML;
            });

            this.$watch('content', (newContent) => {
                if (newContent !== this.quill.root.innerHTML) {
                    this.quill.root.innerHTML = newContent;
                }
            });
        }
    }"
>
    <div x-ref="editor" class="min-h-[300px]"></div>
</div>

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpush
