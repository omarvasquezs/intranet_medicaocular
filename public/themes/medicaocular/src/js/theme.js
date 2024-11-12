import $ from 'jquery';
import 'jquery-ui/dist/jquery-ui.min.js';
import 'bootstrap';

// Core editor
import { ClassicEditor } from '@ckeditor/ckeditor5-editor-classic';

// Essentials
import { Essentials } from '@ckeditor/ckeditor5-essentials';
import { Paragraph } from '@ckeditor/ckeditor5-paragraph';
import { SourceEditing } from '@ckeditor/ckeditor5-source-editing';

// Basic formatting
import { Bold, Italic } from '@ckeditor/ckeditor5-basic-styles';
import { FontFamily, FontSize, FontColor, FontBackgroundColor } from '@ckeditor/ckeditor5-font';
import { Heading } from '@ckeditor/ckeditor5-heading';
import { Alignment } from '@ckeditor/ckeditor5-alignment';
import { Indent, IndentBlock } from '@ckeditor/ckeditor5-indent';
import { BlockQuote } from '@ckeditor/ckeditor5-block-quote';
import { List, TodoList } from '@ckeditor/ckeditor5-list';

// Link and media
import { Link, AutoLink } from '@ckeditor/ckeditor5-link';
import { MediaEmbed } from '@ckeditor/ckeditor5-media-embed';

// Image functionality
import {
    Image,
    ImageCaption,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    ImageResize,
    PictureEditing,
    ImageInsert
} from '@ckeditor/ckeditor5-image';

// Table functionality
import { Table, TableToolbar } from '@ckeditor/ckeditor5-table';

$(function () {
    "use strict";

    const targetNode = document.body;
    const config = {
        childList: true,
        subtree: true,
    };

    const callback = (mutationsList, observer) => {
        const editorElement = document.querySelector('#publicacion-editor');
        if (editorElement) {
            console.log('Editor element detected');
            ClassicEditor
                .create(document.querySelector('#publicacion-editor'), {
                    language: 'es',
                    plugins: [
                        // Essential plugins
                        Essentials,
                        Paragraph,
                        SourceEditing,
                        
                        // Basic formatting
                        Bold,
                        Italic,
                        FontFamily,
                        FontSize,
                        FontColor,
                        FontBackgroundColor,
                        Heading,
                        Alignment,
                        Indent,
                        IndentBlock,
                        BlockQuote,
                        List,
                        TodoList,
                        
                        // Link and media
                        Link,
                        AutoLink,
                        MediaEmbed,
                        
                        // Image plugins
                        Image,
                        ImageCaption,
                        ImageStyle,
                        ImageToolbar,
                        ImageUpload,
                        ImageResize,
                        PictureEditing,
                        ImageInsert,
                        
                        // Table plugins
                        Table,
                        TableToolbar
                    ],
                    toolbar: {
                        items: [
                            'undo', 'redo',
                            '|',
                            'heading',
                            'bold', 'italic',
                            '|',
                            'alignment',
                            '|',
                            'imageUpload',
                            'imageInsert',
                            '|',
                            'fontSize',
                            'fontFamily',
                            'fontColor',
                            'fontBackgroundColor',
                            '|',
                            'insertTable',
                            'link',
                            'mediaEmbed',
                            'blockQuote',
                            'bulletedList',
                            'numberedList',
                            'todoList',
                            '|',
                            'outdent',
                            'indent',
                            '|',
                            'sourceEditing'
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    image: {
                        resizeUnit: 'px',
                        resizeOptions: [
                            {
                                name: 'resizeImage:original',
                                value: null,
                                icon: 'original'
                            },
                            {
                                name: 'resizeImage:50',
                                value: '50',
                                icon: 'medium'
                            },
                            {
                                name: 'resizeImage:75',
                                value: '75',
                                icon: 'large'
                            }
                        ],
                        toolbar: [
                            'imageTextAlternative',
                            '|',
                            'imageStyle:inline',
                            'imageStyle:alignLeft',
                            'imageStyle:alignCenter',
                            'imageStyle:alignRight',
                            '|',
                            'resizeImage:50',
                            'resizeImage:75',
                            'resizeImage:original',
                        ],
                        upload: {
                            types: ['jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff']
                        }
                    },
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Párrafo', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Título 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Título 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Título 3', class: 'ck-heading_heading3' },
                            { model: 'heading4', view: 'h4', title: 'Título 4', class: 'ck-heading_heading4' },
                            { model: 'heading5', view: 'h5', title: 'Título 5', class: 'ck-heading_heading5' },
                            { model: 'heading6', view: 'h6', title: 'Título 6', class: 'ck-heading_heading6' }
                        ]
                    }
                })
                .then(editor => {
                    console.log('Editor initialized', editor);
                })
                .catch(error => {
                    console.error('Editor initialization error:', error);
                });

            observer.disconnect();
        }
    };

    const observer = new MutationObserver(callback);
    observer.observe(targetNode, config);

    // Re-initialize observer on form events
    window.addEventListener('gcrud.form.add', () => {
        if (!document.querySelector('#publicacion-editor')) {
            observer.observe(targetNode, config);
        }
    });
    
    window.addEventListener('gcrud.form.edit', () => {
        if (!document.querySelector('#publicacion-editor')) {
            observer.observe(targetNode, config);
        }
    });
});