import $ from 'jquery';
import 'jquery-ui/dist/jquery-ui.min.js';
import 'bootstrap';
import {
    ClassicEditor, Essentials, Bold, Italic, Font, Paragraph, SourceEditing, CKFinder, CKFinderUploadAdapter,
    Link, Alignment, Image, ImageInsert, ImageCaption, AutoImage, ImageResize, ImageStyle, ImageResizeEditing,
    ImageResizeHandles, ImageToolbar, ImageUpload, PictureEditing, CloudServices, Table, TableToolbar, LinkImage,
    ImageUploadEditing, ImageUploadProgress, DecoupledEditor, Heading, HeadingButtonsUI, ParagraphButtonUI,
    Indent, IndentBlock, BlockQuote, List, AutoLink, MediaEmbed, TodoList, ImageResizeButtons
} from 'ckeditor5';
import coreTranslations from 'ckeditor5/translations/es.js';
import premiumFeaturesTranslations from 'ckeditor5-premium-features/translations/es.js';

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
            console.log('Detected');
            ClassicEditor
                .create(document.querySelector('#publicacion-editor'), {
                    language: 'es', // Set language to Spanish
                    plugins: [
                        SourceEditing, Essentials, Table, TableToolbar, Bold, Italic, Font, Paragraph,
                        CKFinderUploadAdapter, Link, Image, AutoImage, PictureEditing,
                        ImageToolbar, ImageInsert, ImageCaption, ImageStyle, ImageResize, ImageResizeEditing, ImageResizeHandles,
                        LinkImage, ImageUpload, ImageUploadEditing, ImageUploadProgress, CloudServices, Heading, Indent, IndentBlock,
                        BlockQuote, List, AutoLink, MediaEmbed, TodoList, Alignment, ImageResizeButtons
                    ],
                    toolbar: [
                        'undo', 'redo', '|',
                        'heading',
                        'bold', 'italic', '|', 'alignment', '|', 'insertImage', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                        'insertTable',
                        'link',
                        'mediaEmbed',
                        'blockQuote',
                        'bulletedList', 'numberedList', 'todoList',
                        'outdent', 'indent',
                        'SourceEditing'
                    ],
                    translations: [
                        coreTranslations,
                        premiumFeaturesTranslations
                    ],
                    ckfinder: {
                        uploadUrl: '/upload',
                        options: {
                            resourceType: 'Images'
                        }
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
                                name: 'resizeImage:custom',
                                value: 'custom',
                                icon: 'custom'
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
                            'toggleImageCaption',
                            'imageTextAlternative',
                            '|',  // Separator
                            'imageStyle:Inline',
                            'imageStyle:alignBlockLeft',
                            'imageStyle:alignCenter',
                            'imageStyle:alignBlockRight',
                            '|',  // Separator
                            'imageStyle:alignLeft',
                            'imageStyle:alignRight',
                            '|',  // Separator
                            'resizeImage:50',
                            'resizeImage:75',
                            'resizeImage:original',
                            'resizeImage:custom'
                        ]
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
                .then(editor => { console.log(editor); })
                .catch(error => { console.error(error); });

            observer.disconnect(); // Stop observing
        }
    };

    const observer = new MutationObserver(callback);

    observer.observe(targetNode, config);

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