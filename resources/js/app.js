import Editor from '@toast-ui/editor';
import '@toast-ui/editor/dist/toastui-editor.css';
import '@toast-ui/editor/dist/theme/toastui-editor-dark.css';

document.addEventListener('alpine:init', () => {
    Alpine.data('toastuiEditor', (wireModel) => ({
        editor: null,
        init() {
            this.editor = new Editor({
                el: this.$refs.editor,
                initialValue: this.$el.querySelector('textarea').value,
                height: '500px',
                initialEditType: 'wysiwyg',
                previewStyle: 'vertical',
                theme: document.documentElement.classList.contains('dark') ? 'dark' : ''
            });

            this.editor.on('change', () => {
                wireModel.set(this.editor.getMarkdown());
            });

            this.$watch(wireModel, (value) => {
                if (value !== this.editor.getMarkdown()) {
                    this.editor.setMarkdown(value);
                }
            });
        }
    }));
});
