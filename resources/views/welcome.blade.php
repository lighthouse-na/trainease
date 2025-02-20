<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pines UI</title>
    <style>
        [x-cloak] {
            display: none
        }
    </style>
    <!-- Include the Alpine library on your page -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <!-- Include the TailwindCSS library on your page -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* ! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com */
            *,
            :before,
            :after {
                --tw-border-spacing-x: 0;
                --tw-border-spacing-y: 0;
                --tw-translate-x: 0;
                --tw-translate-y: 0;
                --tw-rotate: 0;
                --tw-skew-x: 0;
                --tw-skew-y: 0;
                --tw-scale-x: 1;
                --tw-scale-y: 1;
                --tw-pan-x: ;
                --tw-pan-y: ;
                --tw-pinch-zoom: ;
                --tw-scroll-snap-strictness: proximity;
                --tw-gradient-from-position: ;
                --tw-gradient-via-position: ;
                --tw-gradient-to-position: ;
                --tw-ordinal: ;
                --tw-slashed-zero: ;
                --tw-numeric-figure: ;
                --tw-numeric-spacing: ;
                --tw-numeric-fraction: ;
                --tw-ring-inset: ;
                --tw-ring-offset-width: 0px;
                --tw-ring-offset-color: #fff;
                --tw-ring-color: rgb(59 130 246 / .5);
                --tw-ring-offset-shadow: 0 0 #0000;
                --tw-ring-shadow: 0 0 #0000;
                --tw-shadow: 0 0 #0000;
                --tw-shadow-colored: 0 0 #0000;
                --tw-blur: ;
                --tw-brightness: ;
                --tw-contrast: ;
                --tw-grayscale: ;
                --tw-hue-rotate: ;
                --tw-invert: ;
                --tw-saturate: ;
                --tw-sepia: ;
                --tw-drop-shadow: ;
                --tw-backdrop-blur: ;
                --tw-backdrop-brightness: ;
                --tw-backdrop-contrast: ;
                --tw-backdrop-grayscale: ;
                --tw-backdrop-hue-rotate: ;
                --tw-backdrop-invert: ;
                --tw-backdrop-opacity: ;
                --tw-backdrop-saturate: ;
                --tw-backdrop-sepia: ;
                --tw-contain-size: ;
                --tw-contain-layout: ;
                --tw-contain-paint: ;
                --tw-contain-style:
            }

            ::backdrop {
                --tw-border-spacing-x: 0;
                --tw-border-spacing-y: 0;
                --tw-translate-x: 0;
                --tw-translate-y: 0;
                --tw-rotate: 0;
                --tw-skew-x: 0;
                --tw-skew-y: 0;
                --tw-scale-x: 1;
                --tw-scale-y: 1;
                --tw-pan-x: ;
                --tw-pan-y: ;
                --tw-pinch-zoom: ;
                --tw-scroll-snap-strictness: proximity;
                --tw-gradient-from-position: ;
                --tw-gradient-via-position: ;
                --tw-gradient-to-position: ;
                --tw-ordinal: ;
                --tw-slashed-zero: ;
                --tw-numeric-figure: ;
                --tw-numeric-spacing: ;
                --tw-numeric-fraction: ;
                --tw-ring-inset: ;
                --tw-ring-offset-width: 0px;
                --tw-ring-offset-color: #fff;
                --tw-ring-color: rgb(59 130 246 / .5);
                --tw-ring-offset-shadow: 0 0 #0000;
                --tw-ring-shadow: 0 0 #0000;
                --tw-shadow: 0 0 #0000;
                --tw-shadow-colored: 0 0 #0000;
                --tw-blur: ;
                --tw-brightness: ;
                --tw-contrast: ;
                --tw-grayscale: ;
                --tw-hue-rotate: ;
                --tw-invert: ;
                --tw-saturate: ;
                --tw-sepia: ;
                --tw-drop-shadow: ;
                --tw-backdrop-blur: ;
                --tw-backdrop-brightness: ;
                --tw-backdrop-contrast: ;
                --tw-backdrop-grayscale: ;
                --tw-backdrop-hue-rotate: ;
                --tw-backdrop-invert: ;
                --tw-backdrop-opacity: ;
                --tw-backdrop-saturate: ;
                --tw-backdrop-sepia: ;
                --tw-contain-size: ;
                --tw-contain-layout: ;
                --tw-contain-paint: ;
                --tw-contain-style:
            }

            *,
            :before,
            :after {
                box-sizing: border-box;
                border-width: 0;
                border-style: solid;
                border-color: #e5e7eb
            }

            :before,
            :after {
                --tw-content: ""
            }

            html,
            :host {
                line-height: 1.5;
                -webkit-text-size-adjust: 100%;
                -moz-tab-size: 4;
                -o-tab-size: 4;
                tab-size: 4;
                font-family: Figtree, ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", Segoe UI Symbol, "Noto Color Emoji";
                font-feature-settings: normal;
                font-variation-settings: normal;
                -webkit-tap-highlight-color: transparent
            }

            body {
                margin: 0;
                line-height: inherit
            }

            hr {
                height: 0;
                color: inherit;
                border-top-width: 1px
            }

            abbr:where([title]) {
                -webkit-text-decoration: underline dotted;
                text-decoration: underline dotted
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-size: inherit;
                font-weight: inherit
            }

            a {
                color: inherit;
                text-decoration: inherit
            }

            b,
            strong {
                font-weight: bolder
            }

            code,
            kbd,
            samp,
            pre {
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, Liberation Mono, Courier New, monospace;
                font-feature-settings: normal;
                font-variation-settings: normal;
                font-size: 1em
            }

            small {
                font-size: 80%
            }

            sub,
            sup {
                font-size: 75%;
                line-height: 0;
                position: relative;
                vertical-align: baseline
            }

            sub {
                bottom: -.25em
            }

            sup {
                top: -.5em
            }

            table {
                text-indent: 0;
                border-color: inherit;
                border-collapse: collapse
            }

            button,
            input,
            optgroup,
            select,
            textarea {
                font-family: inherit;
                font-feature-settings: inherit;
                font-variation-settings: inherit;
                font-size: 100%;
                font-weight: inherit;
                line-height: inherit;
                letter-spacing: inherit;
                color: inherit;
                margin: 0;
                padding: 0
            }

            button,
            select {
                text-transform: none
            }

            button,
            input:where([type=button]),
            input:where([type=reset]),
            input:where([type=submit]) {
                -webkit-appearance: button;
                background-color: transparent;
                background-image: none
            }

            :-moz-focusring {
                outline: auto
            }

            :-moz-ui-invalid {
                box-shadow: none
            }

            progress {
                vertical-align: baseline
            }

            ::-webkit-inner-spin-button,
            ::-webkit-outer-spin-button {
                height: auto
            }

            [type=search] {
                -webkit-appearance: textfield;
                outline-offset: -2px
            }

            ::-webkit-search-decoration {
                -webkit-appearance: none
            }

            ::-webkit-file-upload-button {
                -webkit-appearance: button;
                font: inherit
            }

            summary {
                display: list-item
            }

            blockquote,
            dl,
            dd,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            hr,
            figure,
            p,
            pre {
                margin: 0
            }

            fieldset {
                margin: 0;
                padding: 0
            }

            legend {
                padding: 0
            }

            ol,
            ul,
            menu {
                list-style: none;
                margin: 0;
                padding: 0
            }

            dialog {
                padding: 0
            }

            textarea {
                resize: vertical
            }

            input::-moz-placeholder,
            textarea::-moz-placeholder {
                opacity: 1;
                color: #9ca3af
            }

            input::placeholder,
            textarea::placeholder {
                opacity: 1;
                color: #9ca3af
            }

            button,
            [role=button] {
                cursor: pointer
            }

            :disabled {
                cursor: default
            }

            img,
            svg,
            video,
            canvas,
            audio,
            iframe,
            embed,
            object {
                display: block;
                vertical-align: middle
            }

            img,
            video {
                max-width: 100%;
                height: auto
            }

            [hidden]:where(:not([hidden=until-found])) {
                display: none
            }

            .absolute {
                position: absolute
            }

            .relative {
                position: relative
            }

            .-bottom-16 {
                bottom: -4rem
            }

            .-left-16 {
                left: -4rem
            }

            .-left-20 {
                left: -5rem
            }

            .top-0 {
                top: 0
            }

            .z-0 {
                z-index: 0
            }

            .\!row-span-1 {
                grid-row: span 1 / span 1 !important
            }

            .-mx-3 {
                margin-left: -.75rem;
                margin-right: -.75rem
            }

            .-ml-px {
                margin-left: -1px
            }

            .ml-3 {
                margin-left: .75rem
            }

            .mt-4 {
                margin-top: 1rem
            }

            .mt-6 {
                margin-top: 1.5rem
            }

            .flex {
                display: flex
            }

            .inline-flex {
                display: inline-flex
            }

            .table {
                display: table
            }

            .grid {
                display: grid
            }

            .\!hidden {
                display: none !important
            }

            .hidden {
                display: none
            }

            .aspect-video {
                aspect-ratio: 16 / 9
            }

            .size-12 {
                width: 3rem;
                height: 3rem
            }

            .size-5 {
                width: 1.25rem;
                height: 1.25rem
            }

            .size-6 {
                width: 1.5rem;
                height: 1.5rem
            }

            .h-12 {
                height: 3rem
            }

            .h-40 {
                height: 10rem
            }

            .h-5 {
                height: 1.25rem
            }

            .h-full {
                height: 100%
            }

            .min-h-screen {
                min-height: 100vh
            }

            .w-5 {
                width: 1.25rem
            }

            .w-\[calc\(100\%_\+_8rem\)\] {
                width: calc(100% + 8rem)
            }

            .w-auto {
                width: auto
            }

            .w-full {
                width: 100%
            }

            .max-w-2xl {
                max-width: 42rem
            }

            .max-w-\[877px\] {
                max-width: 877px
            }

            .flex-1 {
                flex: 1 1 0%
            }

            .shrink-0 {
                flex-shrink: 0
            }

            .transform {
                transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
            }

            .cursor-default {
                cursor: default
            }

            .resize {
                resize: both
            }

            .grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .\!flex-row {
                flex-direction: row !important
            }

            .flex-col {
                flex-direction: column
            }

            .items-start {
                align-items: flex-start
            }

            .items-center {
                align-items: center
            }

            .items-stretch {
                align-items: stretch
            }

            .justify-end {
                justify-content: flex-end
            }

            .justify-center {
                justify-content: center
            }

            .justify-between {
                justify-content: space-between
            }

            .justify-items-center {
                justify-items: center
            }

            .gap-2 {
                gap: .5rem
            }

            .gap-4 {
                gap: 1rem
            }

            .gap-6 {
                gap: 1.5rem
            }

            .self-center {
                align-self: center
            }

            .overflow-hidden {
                overflow: hidden
            }

            .rounded-\[10px\] {
                border-radius: 10px
            }

            .rounded-full {
                border-radius: 9999px
            }

            .rounded-lg {
                border-radius: .5rem
            }

            .rounded-md {
                border-radius: .375rem
            }

            .rounded-sm {
                border-radius: .125rem
            }

            .rounded-l-md {
                border-top-left-radius: .375rem;
                border-bottom-left-radius: .375rem
            }

            .rounded-r-md {
                border-top-right-radius: .375rem;
                border-bottom-right-radius: .375rem
            }

            .border {
                border-width: 1px
            }

            .border-gray-300 {
                --tw-border-opacity: 1;
                border-color: rgb(209 213 219 / var(--tw-border-opacity, 1))
            }

            .bg-\[\#FF2D20\]\/10 {
                background-color: #ff2d201a
            }

            .bg-gray-50 {
                --tw-bg-opacity: 1;
                background-color: rgb(249 250 251 / var(--tw-bg-opacity, 1))
            }

            .bg-white {
                --tw-bg-opacity: 1;
                background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1))
            }

            .bg-gradient-to-b {
                background-image: linear-gradient(to bottom, var(--tw-gradient-stops))
            }

            .from-transparent {
                --tw-gradient-from: transparent var(--tw-gradient-from-position);
                --tw-gradient-to: rgb(0 0 0 / 0) var(--tw-gradient-to-position);
                --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
            }

            .via-white {
                --tw-gradient-to: rgb(255 255 255 / 0) var(--tw-gradient-to-position);
                --tw-gradient-stops: var(--tw-gradient-from), #fff var(--tw-gradient-via-position), var(--tw-gradient-to)
            }

            .to-white {
                --tw-gradient-to: #fff var(--tw-gradient-to-position)
            }

            .to-zinc-900 {
                --tw-gradient-to: #18181b var(--tw-gradient-to-position)
            }

            .stroke-\[\#FF2D20\] {
                stroke: #ff2d20
            }

            .object-cover {
                -o-object-fit: cover;
                object-fit: cover
            }

            .object-top {
                -o-object-position: top;
                object-position: top
            }

            .p-6 {
                padding: 1.5rem
            }

            .px-2 {
                padding-left: .5rem;
                padding-right: .5rem
            }

            .px-3 {
                padding-left: .75rem;
                padding-right: .75rem
            }

            .px-4 {
                padding-left: 1rem;
                padding-right: 1rem
            }

            .px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .py-10 {
                padding-top: 2.5rem;
                padding-bottom: 2.5rem
            }

            .py-16 {
                padding-top: 4rem;
                padding-bottom: 4rem
            }

            .py-2 {
                padding-top: .5rem;
                padding-bottom: .5rem
            }

            .pt-3 {
                padding-top: .75rem
            }

            .text-center {
                text-align: center
            }

            .font-sans {
                font-family: Figtree, ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", Segoe UI Symbol, "Noto Color Emoji"
            }

            .text-sm {
                font-size: .875rem;
                line-height: 1.25rem
            }

            .text-sm\/relaxed {
                font-size: .875rem;
                line-height: 1.625
            }

            .text-xl {
                font-size: 1.25rem;
                line-height: 1.75rem
            }

            .font-medium {
                font-weight: 500
            }

            .font-semibold {
                font-weight: 600
            }

            .leading-5 {
                line-height: 1.25rem
            }

            .text-black {
                --tw-text-opacity: 1;
                color: rgb(0 0 0 / var(--tw-text-opacity, 1))
            }

            .text-black\/50 {
                color: #00000080
            }

            .text-gray-500 {
                --tw-text-opacity: 1;
                color: rgb(107 114 128 / var(--tw-text-opacity, 1))
            }

            .text-gray-700 {
                --tw-text-opacity: 1;
                color: rgb(55 65 81 / var(--tw-text-opacity, 1))
            }

            .text-white {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity, 1))
            }

            .underline {
                text-decoration-line: underline
            }

            .antialiased {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale
            }

            .shadow-\[0px_14px_34px_0px_rgba\(0\,0\,0\,0\.08\)\] {
                --tw-shadow: 0px 14px 34px 0px rgba(0, 0, 0, .08);
                --tw-shadow-colored: 0px 14px 34px 0px var(--tw-shadow-color);
                box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
            }

            .shadow-sm {
                --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / .05);
                --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
                box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
            }

            .ring-1 {
                --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
                --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
                box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
            }

            .ring-black {
                --tw-ring-opacity: 1;
                --tw-ring-color: rgb(0 0 0 / var(--tw-ring-opacity, 1))
            }

            .ring-gray-300 {
                --tw-ring-opacity: 1;
                --tw-ring-color: rgb(209 213 219 / var(--tw-ring-opacity, 1))
            }

            .ring-transparent {
                --tw-ring-color: transparent
            }

            .ring-white {
                --tw-ring-opacity: 1;
                --tw-ring-color: rgb(255 255 255 / var(--tw-ring-opacity, 1))
            }

            .ring-white\/\[0\.05\] {
                --tw-ring-color: rgb(255 255 255 / .05)
            }

            .drop-shadow-\[0px_4px_34px_rgba\(0\,0\,0\,0\.06\)\] {
                --tw-drop-shadow: drop-shadow(0px 4px 34px rgba(0, 0, 0, .06));
                filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)
            }

            .drop-shadow-\[0px_4px_34px_rgba\(0\,0\,0\,0\.25\)\] {
                --tw-drop-shadow: drop-shadow(0px 4px 34px rgba(0, 0, 0, .25));
                filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)
            }

            .filter {
                filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)
            }

            .transition {
                transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-backdrop-filter;
                transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
                transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter;
                transition-timing-function: cubic-bezier(.4, 0, .2, 1);
                transition-duration: .15s
            }

            .duration-150 {
                transition-duration: .15s
            }

            .duration-300 {
                transition-duration: .3s
            }

            .ease-in-out {
                transition-timing-function: cubic-bezier(.4, 0, .2, 1)
            }

            .selection\:bg-\[\#FF2D20\] *::-moz-selection {
                --tw-bg-opacity: 1;
                background-color: rgb(255 45 32 / var(--tw-bg-opacity, 1))
            }

            .selection\:bg-\[\#FF2D20\] *::selection {
                --tw-bg-opacity: 1;
                background-color: rgb(255 45 32 / var(--tw-bg-opacity, 1))
            }

            .selection\:text-white *::-moz-selection {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity, 1))
            }

            .selection\:text-white *::selection {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity, 1))
            }

            .selection\:bg-\[\#FF2D20\]::-moz-selection {
                --tw-bg-opacity: 1;
                background-color: rgb(255 45 32 / var(--tw-bg-opacity, 1))
            }

            .selection\:bg-\[\#FF2D20\]::selection {
                --tw-bg-opacity: 1;
                background-color: rgb(255 45 32 / var(--tw-bg-opacity, 1))
            }

            .selection\:text-white::-moz-selection {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity, 1))
            }

            .selection\:text-white::selection {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity, 1))
            }

            .hover\:text-black:hover {
                --tw-text-opacity: 1;
                color: rgb(0 0 0 / var(--tw-text-opacity, 1))
            }

            .hover\:text-black\/70:hover {
                color: #000000b3
            }

            .hover\:text-gray-400:hover {
                --tw-text-opacity: 1;
                color: rgb(156 163 175 / var(--tw-text-opacity, 1))
            }

            .hover\:text-gray-500:hover {
                --tw-text-opacity: 1;
                color: rgb(107 114 128 / var(--tw-text-opacity, 1))
            }

            .hover\:ring-black\/20:hover {
                --tw-ring-color: rgb(0 0 0 / .2)
            }

            .focus\:z-10:focus {
                z-index: 10
            }

            .focus\:border-blue-300:focus {
                --tw-border-opacity: 1;
                border-color: rgb(147 197 253 / var(--tw-border-opacity, 1))
            }

            .focus\:outline-none:focus {
                outline: 2px solid transparent;
                outline-offset: 2px
            }

            .focus\:ring:focus {
                --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
                --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color);
                box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
            }

            .focus-visible\:ring-1:focus-visible {
                --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
                --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
                box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
            }

            .focus-visible\:ring-\[\#FF2D20\]:focus-visible {
                --tw-ring-opacity: 1;
                --tw-ring-color: rgb(255 45 32 / var(--tw-ring-opacity, 1))
            }

            .active\:bg-gray-100:active {
                --tw-bg-opacity: 1;
                background-color: rgb(243 244 246 / var(--tw-bg-opacity, 1))
            }

            .active\:text-gray-500:active {
                --tw-text-opacity: 1;
                color: rgb(107 114 128 / var(--tw-text-opacity, 1))
            }

            .active\:text-gray-700:active {
                --tw-text-opacity: 1;
                color: rgb(55 65 81 / var(--tw-text-opacity, 1))
            }

            @media (min-width: 640px) {
                .sm\:flex {
                    display: flex
                }

                .sm\:hidden {
                    display: none
                }

                .sm\:size-16 {
                    width: 4rem;
                    height: 4rem
                }

                .sm\:size-6 {
                    width: 1.5rem;
                    height: 1.5rem
                }

                .sm\:flex-1 {
                    flex: 1 1 0%
                }

                .sm\:items-center {
                    align-items: center
                }

                .sm\:justify-between {
                    justify-content: space-between
                }

                .sm\:pt-5 {
                    padding-top: 1.25rem
                }
            }

            @media (min-width: 768px) {
                .md\:row-span-3 {
                    grid-row: span 3 / span 3
                }
            }

            @media (min-width: 1024px) {
                .lg\:col-start-2 {
                    grid-column-start: 2
                }

                .lg\:h-16 {
                    height: 4rem
                }

                .lg\:max-w-7xl {
                    max-width: 80rem
                }

                .lg\:grid-cols-2 {
                    grid-template-columns: repeat(2, minmax(0, 1fr))
                }

                .lg\:grid-cols-3 {
                    grid-template-columns: repeat(3, minmax(0, 1fr))
                }

                .lg\:flex-col {
                    flex-direction: column
                }

                .lg\:items-end {
                    align-items: flex-end
                }

                .lg\:justify-center {
                    justify-content: center
                }

                .lg\:gap-8 {
                    gap: 2rem
                }

                .lg\:p-10 {
                    padding: 2.5rem
                }

                .lg\:pb-10 {
                    padding-bottom: 2.5rem
                }

                .lg\:pt-0 {
                    padding-top: 0
                }

                .lg\:text-\[\#FF2D20\] {
                    --tw-text-opacity: 1;
                    color: rgb(255 45 32 / var(--tw-text-opacity, 1))
                }
            }

            .rtl\:flex-row-reverse:where([dir=rtl], [dir=rtl] *) {
                flex-direction: row-reverse
            }

            @media (prefers-color-scheme: dark) {
                .dark\:block {
                    display: block
                }

                .dark\:hidden {
                    display: none
                }

                .dark\:border-gray-600 {
                    --tw-border-opacity: 1;
                    border-color: rgb(75 85 99 / var(--tw-border-opacity, 1))
                }

                .dark\:bg-black {
                    --tw-bg-opacity: 1;
                    background-color: rgb(0 0 0 / var(--tw-bg-opacity, 1))
                }

                .dark\:bg-gray-800 {
                    --tw-bg-opacity: 1;
                    background-color: rgb(31 41 55 / var(--tw-bg-opacity, 1))
                }

                .dark\:bg-zinc-900 {
                    --tw-bg-opacity: 1;
                    background-color: rgb(24 24 27 / var(--tw-bg-opacity, 1))
                }

                .dark\:via-zinc-900 {
                    --tw-gradient-to: rgb(24 24 27 / 0) var(--tw-gradient-to-position);
                    --tw-gradient-stops: var(--tw-gradient-from), #18181b var(--tw-gradient-via-position), var(--tw-gradient-to)
                }

                .dark\:to-zinc-900 {
                    --tw-gradient-to: #18181b var(--tw-gradient-to-position)
                }

                .dark\:text-gray-300 {
                    --tw-text-opacity: 1;
                    color: rgb(209 213 219 / var(--tw-text-opacity, 1))
                }

                .dark\:text-gray-400 {
                    --tw-text-opacity: 1;
                    color: rgb(156 163 175 / var(--tw-text-opacity, 1))
                }

                .dark\:text-gray-600 {
                    --tw-text-opacity: 1;
                    color: rgb(75 85 99 / var(--tw-text-opacity, 1))
                }

                .dark\:text-white {
                    --tw-text-opacity: 1;
                    color: rgb(255 255 255 / var(--tw-text-opacity, 1))
                }

                .dark\:text-white\/50 {
                    color: #ffffff80
                }

                .dark\:text-white\/70 {
                    color: #ffffffb3
                }

                .dark\:ring-zinc-800 {
                    --tw-ring-opacity: 1;
                    --tw-ring-color: rgb(39 39 42 / var(--tw-ring-opacity, 1))
                }

                .dark\:hover\:text-gray-300:hover {
                    --tw-text-opacity: 1;
                    color: rgb(209 213 219 / var(--tw-text-opacity, 1))
                }

                .dark\:hover\:text-white:hover {
                    --tw-text-opacity: 1;
                    color: rgb(255 255 255 / var(--tw-text-opacity, 1))
                }

                .dark\:hover\:text-white\/70:hover {
                    color: #ffffffb3
                }

                .dark\:hover\:text-white\/80:hover {
                    color: #fffc
                }

                .dark\:hover\:ring-zinc-700:hover {
                    --tw-ring-opacity: 1;
                    --tw-ring-color: rgb(63 63 70 / var(--tw-ring-opacity, 1))
                }

                .dark\:focus\:border-blue-700:focus {
                    --tw-border-opacity: 1;
                    border-color: rgb(29 78 216 / var(--tw-border-opacity, 1))
                }

                .dark\:focus\:border-blue-800:focus {
                    --tw-border-opacity: 1;
                    border-color: rgb(30 64 175 / var(--tw-border-opacity, 1))
                }

                .dark\:focus-visible\:ring-\[\#FF2D20\]:focus-visible {
                    --tw-ring-opacity: 1;
                    --tw-ring-color: rgb(255 45 32 / var(--tw-ring-opacity, 1))
                }

                .dark\:focus-visible\:ring-white:focus-visible {
                    --tw-ring-opacity: 1;
                    --tw-ring-color: rgb(255 255 255 / var(--tw-ring-opacity, 1))
                }

                .dark\:active\:bg-gray-700:active {
                    --tw-bg-opacity: 1;
                    background-color: rgb(55 65 81 / var(--tw-bg-opacity, 1))
                }

                .dark\:active\:text-gray-300:active {
                    --tw-text-opacity: 1;
                    color: rgb(209 213 219 / var(--tw-text-opacity, 1))
                }
            }
        </style>
    @endif
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <section
        class="w-full px-3 antialiased bg-gradient-to-br from-slate-600 via-black to-gray-800 lg:px-6 overflow-y-auto">
        <div class="mx-auto max-w-7xl">
            <nav class="flex items-center w-full h-24 select-none" x-data="{ showMenu: false }">
                <div
                    class="relative flex flex-wrap items-start justify-between w-full mx-auto font-medium md:items-center md:h-24 md:justify-between">
                    <a href="#_"
                        class="flex items-center w-1/4 py-4 pl-6 pr-4 space-x-2 font-extrabold text-white md:py-0">

                        <span>
                            <h1 x-data="{
                                startingAnimation: { opacity: 0 },
                                endingAnimation: { opacity: 1, stagger: 0.08, duration: 2.7, ease: 'power4.easeOut' },
                                addCNDScript: true,
                                splitCharactersIntoSpans(element) {
                                    text = element.innerHTML;
                                    modifiedHTML = [];
                                    for (var i = 0; i < text.length; i++) {
                                        attributes = '';
                                        if (text[i].trim()) { attributes = 'class=\'inline-block\''; }
                                        modifiedHTML.push('<span ' + attributes + '>' + text[i] + '</span>');
                                    }
                                    element.innerHTML = modifiedHTML.join('');
                                },

                                addScriptToHead(url) {
                                    script = document.createElement('script');
                                    script.src = url;
                                    document.head.appendChild(script);
                                },
                                animateText() {
                                    $el.classList.remove('invisible');
                                    gsap.fromTo($el.children, this.startingAnimation, this.endingAnimation);
                                }
                            }" x-init="splitCharactersIntoSpans($el);
                            if (addCNDScript) {
                                addScriptToHead('https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js');
                            }
                            gsapInterval3 = setInterval(function() {
                                if (typeof gsap !== 'undefined') {
                                    animateText();
                                    clearInterval(gsapInterval3);
                                }
                            }, 5);"
                                class="invisible block pb-0.5 overflow-hidden text-3xl text-white font-bold custom-font">
                                TrainEase
                            </h1>
                        </span>
                    </a>
                    <div :class="{ 'flex': showMenu, 'hidden md:flex': !showMenu }"
                        class="absolute z-50 flex-col items-center justify-center w-full h-auto px-2 text-center text-gray-400 -translate-x-1/2 border-0 border-gray-700 rounded-full md:border md:w-auto md:h-10 left-1/2 md:flex-row md:items-center">
                        <a href="#"
                            class="relative inline-block w-full h-full px-4 py-5 mx-2 font-medium leading-tight text-center text-white md:py-2 group md:w-auto md:px-2 lg:mx-3 md:text-center">
                            <span>Home</span>
                            <span
                                class="absolute bottom-0 left-0 w-full h-px duration-300 ease-out translate-y-px bg-gradient-to-r md:from-gray-700 md:via-gray-400 md:to-gray-700 from-gray-900 via-gray-600 to-gray-900"></span>
                        </a>
                        <a href="#"
                            class="relative inline-block w-full h-full px-4 py-5 mx-2 font-medium leading-tight text-center duration-300 ease-out md:py-2 group hover:text-white md:w-auto md:px-2 lg:mx-3 md:text-center">
                            <span>Features</span>
                            <span
                                class="absolute bottom-0 w-0 h-px duration-300 ease-out translate-y-px group-hover:left-0 left-1/2 group-hover:w-full bg-gradient-to-r md:from-gray-700 md:via-gray-400 md:to-gray-700 from-gray-900 via-gray-600 to-gray-900"></span>
                        </a>
                        <a href="#"
                            class="relative inline-block w-full h-full px-4 py-5 mx-2 font-medium leading-tight text-center duration-300 ease-out md:py-2 group hover:text-white md:w-auto md:px-2 lg:mx-3 md:text-center">
                            <span>Blog</span>
                            <span
                                class="absolute bottom-0 w-0 h-px duration-300 ease-out translate-y-px group-hover:left-0 left-1/2 group-hover:w-full bg-gradient-to-r md:from-gray-700 md:via-gray-400 md:to-gray-700 from-gray-900 via-gray-600 to-gray-900"></span>
                        </a>
                        <a href="#"
                            class="relative inline-block w-full h-full px-4 py-5 mx-2 font-medium leading-tight text-center duration-300 ease-out md:py-2 group hover:text-white md:w-auto md:px-2 lg:mx-3 md:text-center">
                            <span>Contact</span>
                            <span
                                class="absolute bottom-0 w-0 h-px duration-300 ease-out translate-y-px group-hover:left-0 left-1/2 group-hover:w-full bg-gradient-to-r md:from-gray-700 md:via-gray-400 md:to-gray-700 from-gray-900 via-gray-600 to-gray-900"></span>
                        </a>
                    </div>
                    <div class="fixed top-0 left-0 z-40 items-center hidden w-full h-full p-3 text-sm bg-gray-900 bg-opacity-50 md:w-auto md:bg-transparent md:p-0 md:relative md:flex"
                        :class="{ 'flex': showMenu, 'hidden': !showMenu }">
                        <div
                            class="flex-col items-center w-full h-full p-3 overflow-hidden bg-black bg-opacity-50 rounded-lg select-none md:p-0 backdrop-blur-lg md:h-auto md:bg-transparent md:rounded-none md:relative md:flex md:flex-row md:overflow-auto">
                            <div
                                class="flex flex-col items-center justify-end w-full h-full pt-2 md:w-full md:flex-row md:py-0">
                                <a href="{{ route('login') }}"
                                    class="w-full py-5 mr-0 text-center text-gray-200 md:py-3 md:w-auto hover:text-white md:pl-0 md:mr-3 lg:mr-5">Sign
                                    In</a>
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center justify-center w-full px-4 py-3 md:py-1.5 font-medium leading-6 text-center whitespace-no-wrap transition duration-150 ease-in-out border border-transparent md:mr-1 text-gray-600 md:w-auto bg-white rounded-lg md:rounded-full hover:bg-white focus:outline-none focus:border-gray-700 focus:shadow-outline-gray active:bg-gray-700">Sign
                                    Up</a>
                            </div>
                        </div>
                    </div>
                    <div @click="showMenu = !showMenu"
                        class="absolute right-0 z-50 flex flex-col items-end translate-y-1.5 w-10 h-10 p-2 mr-4 rounded-full cursor-pointer md:hidden hover:bg-gray-200/10 hover:bg-opacity-10"
                        :class="{ 'text-gray-400': showMenu, 'text-gray-100': !showMenu }">
                        <svg class="w-6 h-6" x-show="!showMenu" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="w-6 h-6" x-show="showMenu" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
            </nav>
            <div class="container px-6 py-32 mx-auto md:text-center md:px-4">
                <h1
                    class="text-4xl font-extrabold leading-none leading-10 tracking-tight text-white sm:text-5xl md:text-6xl xl:text-7xl">
                    <span class="block">Simplify the way you</span> <span
                        class="relative inline-block mt-3 text-white">Train Employees</span></h1>
                <p
                    class="mx-auto mt-6 text-sm text-left text-gray-200 md:text-center md:mt-12 sm:text-base md:max-w-xl md:text-lg xl:text-xl">
                    If you are ready to change the way you train your companys' employees, then you'll want to use our
                    system to make it fun and easy!</p>
                <div
                    class="relative flex items-center mx-auto mt-12 overflow-hidden text-left border border-gray-700 rounded-md md:max-w-md md:text-center">
                    <input type="text" name="email" placeholder="Email Address"
                        class="w-full h-12 px-6 py-2 font-medium text-gray-800 focus:outline-none">
                    <span class="relative top-0 right-0 block">
                        <button type="button"
                            class="inline-flex items-center w-32 h-12 px-8 text-base font-bold leading-6 text-white transition duration-150 ease-in-out bg-gray-800 border border-transparent hover:bg-gray-700 focus:outline-none active:bg-gray-700"
                            data-primary="gray-600">
                            Sign Up
                        </button>
                    </span>
                </div>
                <div class="mt-8 text-sm text-gray-300">By signing up, you agree to our terms and services.</div>
            </div>
        </div>
        <div class="flex justify-center items-center w-full h-16 text-sm text-gray-100">
            <div class="relative w-auto h-auto mb-12" x-data>
                <div x-data="{
                    title: 'Default Toast Notification',
                    description: '',
                    type: 'default',
                    position: 'top-center',
                    expanded: false,
                    popToast(custom) {
                        let html = '';
                        if (typeof custom != 'undefined') {
                            html = custom;
                        }
                        toast(this.title, { description: this.description, type: this.type, position: this.position, html: html })
                    }
                }" x-init="window.toast = function(message, options = {}) {
                    let description = '';
                    let type = 'default';
                    let position = 'top-center';
                    let html = '';
                    if (typeof options.description != 'undefined') description = options.description;
                    if (typeof options.type != 'undefined') type = options.type;
                    if (typeof options.position != 'undefined') position = options.position;
                    if (typeof options.html != 'undefined') html = options.html;

                    window.dispatchEvent(new CustomEvent('toast-show', { detail: { type: type, message: message, description: description, position: position, html: html } }));
                }

                window.customToastHTML = `
                                                            <div class='relative flex items-start justify-center p-4'>
                                                                <img src='https://cdn.devdojo.com/images/august2023/headshot-new.jpeg' class='w-10 h-10 mr-2 rounded-full'>
                                                                <div class='flex flex-col'>
                                                                    <p class='text-sm font-medium text-gray-800'>New Friend Request</p>
                                                                    <p class='mt-1 text-xs leading-none text-gray-800'>Friend request from John Doe.</p>
                                                                    <div class='flex mt-3'>
                                                                        <button type='button' @click='burnToast(toast.id)' class='inline-flex items-center px-2 py-1 text-xs font-semibold text-white bg-indigo-600 rounded shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'>Accept</button>
                                                                        <button type='button' @click='burnToast(toast.id)' class='inline-flex items-center px-2 py-1 ml-3 text-xs font-semibold text-gray-900 bg-white rounded shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-800'>Decline</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        `" class="relative space-y-5">
                    <div class="relative">
                        <p class="mb-2 text-xs font-medium text-center text-gray-500 sm:text-left">Types</p>
                        <div
                            class="relative flex flex-col px-10 space-y-2 sm:space-x-5 sm:space-y-0 sm:flex-row sm:px-0">
                            <button
                                @click="title='Default Toast Notification'; type='default'; description=''; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': type=='default' && description=='' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Default</button>
                            <button
                                @click="title='Toast Notification'; type='default'; description='This is an example toast notification'; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': type=='default' && description!='' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">With
                                Description</button>
                            <button @click="title='Success Notification'; type='success'; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': type=='success' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Success</button>
                            <button @click="title='Info Notification'; type='info'; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': type=='info' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Info</button>
                            <button @click="title='Warning Notification'; type='warning'; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': type=='warning' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Warning</button>
                            <button @click="title='Danger Notification'; type='danger'; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': type=='danger' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Danger</button>

                            <button @click="popToast(customToastHTML)"
                                :class="{ 'ring-2 ring-neutral-200/60': type=='success' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Custom</button>
                        </div>
                    </div>
                    <div class="relative">
                        <p class="mb-2 text-xs font-medium text-center text-gray-500 sm:text-left">Position</p>
                        <div
                            class="relative flex flex-col px-10 space-y-2 sm:space-x-5 sm:space-y-0 sm:flex-row sm:px-0">

                            <button @click="position='top-left'; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': position=='top-left' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Top
                                Left</button>
                            <button @click="position='top-center'; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': position=='top-center' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Top
                                Center</button>
                            <button @click="position='top-right'; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': position=='top-right' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Top
                                Right</button>
                            <button @click="position='bottom-right'; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': position=='bottom-right' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Bottom
                                Right</button>
                            <button @click="position='bottom-center'; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': position=='bottom-center' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Bottom
                                Center</button>
                            <button @click="position='bottom-left'; popToast()"
                                :class="{ 'ring-2 ring-neutral-200/60': position=='bottom-left' }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Bottom
                                Left</button>
                        </div>
                    </div>
                    <div class="relative">
                        <p class="mb-2 text-xs font-medium text-center text-gray-500 sm:text-left">Layout</p>
                        <div
                            class="relative flex flex-col px-10 space-y-2 sm:space-x-5 sm:space-y-0 sm:flex-row sm:px-0">
                            <button
                                @click="expanded=false; window.dispatchEvent(new CustomEvent('set-toasts-layout', { detail: { layout: 'default' }}));"
                                :class="{ 'ring-2 ring-neutral-200/60': !expanded }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Default</button>
                            <button
                                @click="expanded=true; window.dispatchEvent(new CustomEvent('set-toasts-layout', { detail: { layout: 'expanded' }}));"
                                :class="{ 'ring-2 ring-neutral-200/60': expanded }"
                                class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-800 active:bg-white focus:bg-white focus:outline-none">Expanded</button>
                        </div>
                    </div>
                </div>
                <template x-teleport="body">
                    <ul x-data="{
                        toasts: [],
                        toastsHovered: false,
                        expanded: false,
                        layout: 'default',
                        position: 'top-center',
                        paddingBetweenToasts: 15,
                        deleteToastWithId(id) {
                            for (let i = 0; i < this.toasts.length; i++) {
                                if (this.toasts[i].id === id) {
                                    this.toasts.splice(i, 1);
                                    break;
                                }
                            }
                        },
                        burnToast(id) {
                            burnToast = this.getToastWithId(id);
                            burnToastElement = document.getElementById(burnToast.id);
                            if (burnToastElement) {
                                if (this.toasts.length == 1) {
                                    if (this.layout == 'default') {
                                        this.expanded = false;
                                    }
                                    burnToastElement.classList.remove('translate-y-0');
                                    if (this.position.includes('bottom')) {
                                        burnToastElement.classList.add('translate-y-full');
                                    } else {
                                        burnToastElement.classList.add('-translate-y-full');
                                    }
                                    burnToastElement.classList.add('-translate-y-full');
                                }
                                burnToastElement.classList.add('opacity-0');
                                let that = this;
                                setTimeout(function() {
                                    that.deleteToastWithId(id);
                                    setTimeout(function() {
                                        that.stackToasts();
                                    }, 1)
                                }, 300);
                            }
                        },
                        getToastWithId(id) {
                            for (let i = 0; i < this.toasts.length; i++) {
                                if (this.toasts[i].id === id) {
                                    return this.toasts[i];
                                }
                            }
                        },
                        stackToasts() {
                            this.positionToasts();
                            this.calculateHeightOfToastsContainer();
                            let that = this;
                            setTimeout(function() {
                                that.calculateHeightOfToastsContainer();
                            }, 300);
                        },
                        positionToasts() {
                            if (this.toasts.length == 0) return;
                            let topToast = document.getElementById(this.toasts[0].id);
                            topToast.style.zIndex = 100;
                            if (this.expanded) {
                                if (this.position.includes('bottom')) {
                                    topToast.style.top = 'auto';
                                    topToast.style.bottom = '0px';
                                } else {
                                    topToast.style.top = '0px';
                                }
                            }

                            let bottomPositionOfFirstToast = this.getBottomPositionOfElement(topToast);

                            if (this.toasts.length == 1) return;
                            let middleToast = document.getElementById(this.toasts[1].id);
                            middleToast.style.zIndex = 90;

                            if (this.expanded) {
                                middleToastPosition = topToast.getBoundingClientRect().height +
                                    this.paddingBetweenToasts + 'px';

                                if (this.position.includes('bottom')) {
                                    middleToast.style.top = 'auto';
                                    middleToast.style.bottom = middleToastPosition;
                                } else {
                                    middleToast.style.top = middleToastPosition;
                                }

                                middleToast.style.scale = '100%';
                                middleToast.style.transform = 'translateY(0px)';

                            } else {
                                middleToast.style.scale = '94%';
                                if (this.position.includes('bottom')) {
                                    middleToast.style.transform = 'translateY(-16px)';
                                } else {
                                    this.alignBottom(topToast, middleToast);
                                    middleToast.style.transform = 'translateY(16px)';
                                }
                            }


                            if (this.toasts.length == 2) return;
                            let bottomToast = document.getElementById(this.toasts[2].id);
                            bottomToast.style.zIndex = 80;
                            if (this.expanded) {
                                bottomToastPosition = topToast.getBoundingClientRect().height +
                                    this.paddingBetweenToasts +
                                    middleToast.getBoundingClientRect().height +
                                    this.paddingBetweenToasts + 'px';

                                if (this.position.includes('bottom')) {
                                    bottomToast.style.top = 'auto';
                                    bottomToast.style.bottom = bottomToastPosition;
                                } else {
                                    bottomToast.style.top = bottomToastPosition;
                                }

                                bottomToast.style.scale = '100%';
                                bottomToast.style.transform = 'translateY(0px)';
                            } else {
                                bottomToast.style.scale = '88%';
                                if (this.position.includes('bottom')) {
                                    bottomToast.style.transform = 'translateY(-32px)';
                                } else {
                                    this.alignBottom(topToast, bottomToast);
                                    bottomToast.style.transform = 'translateY(32px)';
                                }
                            }



                            if (this.toasts.length == 3) return;
                            let burnToast = document.getElementById(this.toasts[3].id);
                            burnToast.style.zIndex = 70;
                            if (this.expanded) {
                                burnToastPosition = topToast.getBoundingClientRect().height +
                                    this.paddingBetweenToasts +
                                    middleToast.getBoundingClientRect().height +
                                    this.paddingBetweenToasts +
                                    bottomToast.getBoundingClientRect().height +
                                    this.paddingBetweenToasts + 'px';

                                if (this.position.includes('bottom')) {
                                    burnToast.style.top = 'auto';
                                    burnToast.style.bottom = burnToastPosition;
                                } else {
                                    burnToast.style.top = burnToastPosition;
                                }

                                burnToast.style.scale = '100%';
                                burnToast.style.transform = 'translateY(0px)';
                            } else {
                                burnToast.style.scale = '82%';
                                this.alignBottom(topToast, burnToast);
                                burnToast.style.transform = 'translateY(48px)';
                            }

                            burnToast.firstElementChild.classList.remove('opacity-100');
                            burnToast.firstElementChild.classList.add('opacity-0');

                            let that = this;
                            // Burn 🔥 (remove) last toast
                            setTimeout(function() {
                                that.toasts.pop();
                            }, 300);

                            if (this.position.includes('bottom')) {
                                middleToast.style.top = 'auto';
                            }

                            return;
                        },
                        alignBottom(element1, element2) {
                            // Get the top position and height of the first element
                            let top1 = element1.offsetTop;
                            let height1 = element1.offsetHeight;

                            // Get the height of the second element
                            let height2 = element2.offsetHeight;

                            // Calculate the top position for the second element
                            let top2 = top1 + (height1 - height2);

                            // Apply the calculated top position to the second element
                            element2.style.top = top2 + 'px';
                        },
                        alignTop(element1, element2) {
                            // Get the top position of the first element
                            let top1 = element1.offsetTop;

                            // Apply the same top position to the second element
                            element2.style.top = top1 + 'px';
                        },
                        resetBottom() {
                            for (let i = 0; i < this.toasts.length; i++) {
                                if (document.getElementById(this.toasts[i].id)) {
                                    let toastElement = document.getElementById(this.toasts[i].id);
                                    toastElement.style.bottom = '0px';
                                }
                            }
                        },
                        resetTop() {
                            for (let i = 0; i < this.toasts.length; i++) {
                                if (document.getElementById(this.toasts[i].id)) {
                                    let toastElement = document.getElementById(this.toasts[i].id);
                                    toastElement.style.top = '0px';
                                }
                            }
                        },
                        getBottomPositionOfElement(el) {
                            return (el.getBoundingClientRect().height + el.getBoundingClientRect().top);
                        },
                        calculateHeightOfToastsContainer() {
                            if (this.toasts.length == 0) {
                                $el.style.height = '0px';
                                return;
                            }

                            lastToast = this.toasts[this.toasts.length - 1];
                            lastToastRectangle = document.getElementById(lastToast.id).getBoundingClientRect();

                            firstToast = this.toasts[0];
                            firstToastRectangle = document.getElementById(firstToast.id).getBoundingClientRect();

                            if (this.toastsHovered) {
                                if (this.position.includes('bottom')) {
                                    $el.style.height = ((firstToastRectangle.top + firstToastRectangle.height) - lastToastRectangle.top) + 'px';
                                } else {
                                    $el.style.height = ((lastToastRectangle.top + lastToastRectangle.height) - firstToastRectangle.top) + 'px';
                                }
                            } else {
                                $el.style.height = firstToastRectangle.height + 'px';
                            }
                        }
                    }"
                        @set-toasts-layout.window="
                                            layout=event.detail.layout;
                                            if(layout == 'expanded'){
                                                expanded=true;
                                            } else {
                                                expanded=false;
                                            }
                                            stackToasts();
                                        "
                        @toast-show.window="
                                            event.stopPropagation();
                                            if(event.detail.position){
                                                position = event.detail.position;
                                            }
                                            toasts.unshift({
                                                id: 'toast-' + Math.random().toString(16).slice(2),
                                                show: false,
                                                message: event.detail.message,
                                                description: event.detail.description,
                                                type: event.detail.type,
                                                html: event.detail.html
                                            });
                                        "
                        @mouseenter="toastsHovered=true;" @mouseleave="toastsHovered=false" x-init="if (layout == 'expanded') {
                            expanded = true;
                        }
                        stackToasts();
                        $watch('toastsHovered', function(value) {

                            if (layout == 'default') {
                                if (position.includes('bottom')) {
                                    resetBottom();
                                } else {
                                    resetTop();
                                }

                                if (value) {
                                    // calculate the new positions
                                    expanded = true;
                                    if (layout == 'default') {
                                        stackToasts();
                                    }
                                } else {
                                    if (layout == 'default') {
                                        expanded = false;
                                        //setTimeout(function(){
                                        stackToasts();
                                        //}, 10);
                                        setTimeout(function() {
                                            stackToasts();
                                        }, 10)
                                    }
                                }
                            }
                        });"
                        class="fixed block w-full group z-[99] sm:max-w-xs"
                        :class="{ 'right-0 top-0 sm:mt-6 sm:mr-6': position=='top-right', 'left-0 top-0 sm:mt-6 sm:ml-6': position=='top-left', 'left-1/2 -translate-x-1/2 top-0 sm:mt-6': position=='top-center', 'right-0 bottom-0 sm:mr-6 sm:mb-6': position=='bottom-right', 'left-0 bottom-0 sm:ml-6 sm:mb-6': position=='bottom-left', 'left-1/2 -translate-x-1/2 bottom-0 sm:mb-6': position=='bottom-center' }"
                        x-cloak>

                        <template x-for="(toast, index) in toasts" :key="toast.id">
                            <li :id="toast.id" x-data="{
                                toastHovered: false
                            }" x-init="if (position.includes('bottom')) {
                                $el.firstElementChild.classList.add('toast-bottom');
                                $el.firstElementChild.classList.add('opacity-0', 'translate-y-full');
                            } else {
                                $el.firstElementChild.classList.add('opacity-0', '-translate-y-full');
                            }
                            setTimeout(function() {

                                setTimeout(function() {
                                    if (position.includes('bottom')) {
                                        $el.firstElementChild.classList.remove('opacity-0', 'translate-y-full');
                                    } else {
                                        $el.firstElementChild.classList.remove('opacity-0', '-translate-y-full');
                                    }
                                    $el.firstElementChild.classList.add('opacity-100', 'translate-y-0');

                                    setTimeout(function() {
                                        stackToasts();
                                    }, 10);
                                }, 5);
                            }, 50);

                            setTimeout(function() {
                                setTimeout(function() {
                                    $el.firstElementChild.classList.remove('opacity-100');
                                    $el.firstElementChild.classList.add('opacity-0');
                                    if (toasts.length == 1) {
                                        $el.firstElementChild.classList.remove('translate-y-0');
                                        $el.firstElementChild.classList.add('-translate-y-full');
                                    }
                                    setTimeout(function() {
                                        deleteToastWithId(toast.id)
                                    }, 300);
                                }, 5);
                            }, 4000);"
                                @mouseover="toastHovered=true" @mouseout="toastHovered=false"
                                class="absolute w-full duration-300 ease-out select-none sm:max-w-xs"
                                :class="{ 'toast-no-description': !toast.description }">
                                <span
                                    class="relative flex flex-col items-start shadow-[0_5px_15px_-3px_rgb(0_0_0_/_0.08)] w-full transition-all duration-300 ease-out bg-white border border-gray-100 sm:rounded-md sm:max-w-xs group"
                                    :class="{ 'p-4': !toast.html, 'p-0': toast.html }">
                                    <template x-if="!toast.html">
                                        <div class="relative">
                                            <div class="flex items-center"
                                                :class="{ 'text-green-500': toast.type=='success', 'text-blue-500': toast.type=='info', 'text-orange-400': toast.type=='warning', 'text-red-500': toast.type=='danger', 'text-gray-800': toast.type=='default' }">

                                                <svg x-show="toast.type=='success'"
                                                    class="w-[18px] h-[18px] mr-1.5 -ml-1" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM16.7744 9.63269C17.1238 9.20501 17.0604 8.57503 16.6327 8.22559C16.2051 7.87615 15.5751 7.93957 15.2256 8.36725L10.6321 13.9892L8.65936 12.2524C8.24484 11.8874 7.61295 11.9276 7.248 12.3421C6.88304 12.7566 6.92322 13.3885 7.33774 13.7535L9.31046 15.4903C10.1612 16.2393 11.4637 16.1324 12.1808 15.2547L16.7744 9.63269Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                                <svg x-show="toast.type=='info'"
                                                    class="w-[18px] h-[18px] mr-1.5 -ml-1" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM12 9C12.5523 9 13 8.55228 13 8C13 7.44772 12.5523 7 12 7C11.4477 7 11 7.44772 11 8C11 8.55228 11.4477 9 12 9ZM13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12V16C11 16.5523 11.4477 17 12 17C12.5523 17 13 16.5523 13 16V12Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                                <svg x-show="toast.type=='warning'"
                                                    class="w-[18px] h-[18px] mr-1.5 -ml-1" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9.44829 4.46472C10.5836 2.51208 13.4105 2.51168 14.5464 4.46401L21.5988 16.5855C22.7423 18.5509 21.3145 21 19.05 21L4.94967 21C2.68547 21 1.25762 18.5516 2.4004 16.5862L9.44829 4.46472ZM11.9995 8C12.5518 8 12.9995 8.44772 12.9995 9V13C12.9995 13.5523 12.5518 14 11.9995 14C11.4473 14 10.9995 13.5523 10.9995 13V9C10.9995 8.44772 11.4473 8 11.9995 8ZM12.0009 15.99C11.4486 15.9892 11.0003 16.4363 10.9995 16.9886L10.9995 16.9986C10.9987 17.5509 11.4458 17.9992 11.9981 18C12.5504 18.0008 12.9987 17.5537 12.9995 17.0014L12.9995 16.9914C13.0003 16.4391 12.5532 15.9908 12.0009 15.99Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                                <svg x-show="toast.type=='danger'"
                                                    class="w-[18px] h-[18px] mr-1.5 -ml-1" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9996 7C12.5519 7 12.9996 7.44772 12.9996 8V12C12.9996 12.5523 12.5519 13 11.9996 13C11.4474 13 10.9996 12.5523 10.9996 12V8C10.9996 7.44772 11.4474 7 11.9996 7ZM12.001 14.99C11.4488 14.9892 11.0004 15.4363 10.9997 15.9886L10.9996 15.9986C10.9989 16.5509 11.446 16.9992 11.9982 17C12.5505 17.0008 12.9989 16.5537 12.9996 16.0014L12.9996 15.9914C13.0004 15.4391 12.5533 14.9908 12.001 14.99Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                                <p class="text-[13px] font-medium leading-none text-gray-800"
                                                    x-text="toast.message"></p>
                                            </div>
                                            <p x-show="toast.description" :class="{ 'pl-5': toast.type!='default' }"
                                                class="mt-1.5 text-xs leading-none opacity-70"
                                                x-text="toast.description"></p>
                                        </div>
                                    </template>
                                    <template x-if="toast.html">
                                        <div x-html="toast.html"></div>
                                    </template>
                                    <span @click="burnToast(toast.id)"
                                        class="absolute right-0 p-1.5 mr-2.5 text-gray-400 duration-100 ease-in-out rounded-full opacity-0 cursor-pointer hover:bg-gray-800 hover:text-gray-500"
                                        :class="{ 'top-1/2 -translate-y-1/2': !toast.description && !toast
                                            .html, 'top-0 mt-2.5': (toast.description || toast
                                                .html), 'opacity-100': toastHovered, 'opacity-0': !toastHovered }">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                </span>
                            </li>
                        </template>
                    </ul>
                </template>
            </div>


        </div>

    </section>




</body>

</html>
