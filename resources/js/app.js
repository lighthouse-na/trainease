import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Document from '@tiptap/extension-document'
import Paragraph from '@tiptap/extension-paragraph'
import Text from '@tiptap/extension-text'
import Bold from '@tiptap/extension-bold'
import Italic from '@tiptap/extension-italic'
import Underline from '@tiptap/extension-underline'
import Code from '@tiptap/extension-code'
import Image from '@tiptap/extension-image'
import Youtube from '@tiptap/extension-youtube'

document.addEventListener('alpine:init', () => {
    window.setupEditor = function (content) {
        let editor;

        return {
            content: content,
            init(element) {
                editor = new Editor({
                    element: element,
                    extensions: [
                        StarterKit,
                        Document,
                        Paragraph,
                        Text,
                        Bold,
                        Italic,
                        Underline,
                        Code,
                        Image.configure({
                            inline: false, // Set to false for block images
                            allowBase64: true, // Allows base64 images (optional)
                        }),
                        Youtube.configure({
                            modestBranding: true, // Hides YouTube logo
                            showControls: true, // Shows video controls
                            rel: 0, // Prevents showing related videos
                            nocookie: true // Uses YouTube's privacy-friendly embed
                        }),
                    ],
                    content: this.content,
                    editorProps: {
                        attributes: {
                            class: 'h-screen prose prose-sm sm:prose-base lg:prose-lg xl:prose-2xl m-5 p-3 border rounded-lg shadow-md focus:outline-none',
                        },
                    },
                    onUpdate: ({ editor }) => {
                        this.content = editor.getHTML();
                    },
                });

                this.editor = editor;

                // Formatting Actions
                this.toggleBold = () => editor.chain().focus().toggleBold().run();
                this.toggleItalic = () => editor.chain().focus().toggleItalic().run();
                this.toggleUnderline = () => editor.chain().focus().toggleUnderline().run();
                this.toggleCode = () => editor.chain().focus().toggleCode().run();

                // Insert Image
                this.insertImage = () => {
                    const url = prompt('Enter image URL:');
                    if (url) editor.chain().focus().setImage({ src: url }).run();
                };

                // Insert YouTube Video
                this.insertYoutube = () => {
                    const url = prompt('Enter YouTube URL:');
                    if (url) editor.chain().focus().setYoutubeVideo({ src: url }).run();
                };

                // Sync content changes with external sources (Livewire, etc.)
                this.$watch('content', (newContent) => {
                    if (newContent !== editor.getHTML()) {
                        editor.commands.setContent(newContent, false);
                    }
                });
            }
        }
    }
});
