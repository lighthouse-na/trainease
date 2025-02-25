<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <!-- Include the Alpine library on your page -->
    <script src="https://unpkg.com/alpinejs" defer></script>
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

            .focus\:border-cyan-300:focus {
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

                .dark\:focus\:border-cyan-700:focus {
                    --tw-border-opacity: 1;
                    border-color: rgb(29 78 216 / var(--tw-border-opacity, 1))
                }

                .dark\:focus\:border-cyan-800:focus {
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

<body class="font-nunito flex h-full flex-col">
    <header class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav class="relative z-50 flex justify-between">
                <div class="flex items-center md:gap-x-12">
                    <a aria-label="Home" href="#">
                        <div class="shrink-0 flex items-center">
                            <x-application-mark class="block h-9 w-auto" />
                        </div>
                    </a>
                    <div class="hidden md:flex md:gap-x-6">
                        <a class="inline-block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-200" href="#features">Features</a>
                        <a class="inline-block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-200" href="#testimonials">Testimonials</a>
                        <a class="inline-block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-200" href="#pricing">Pricing</a>
                    </div>
                </div>
                <div class="flex items-center gap-x-5 md:gap-x-8">
                    <div class="hidden md:block"><a
                            class="inline-block rounded-lg px-2 py-1 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900"
                            href="/login">Sign in</a></div><a
                        class="group inline-flex items-center justify-center rounded-full py-2 px-4 text-sm font-semibold focus:outline-hidden focus-visible:outline-2 focus-visible:outline-offset-2 bg-cyan-600 text-white hover:text-slate-100 hover:bg-cyan-500 active:bg-cyan-800 active:text-cyan-100 focus-visible:outline-cyan-600"
                        color="cyan" variant="solid" href="/register"><span>Get started <span
                                class="hidden lg:inline">today</span></span></a>
                    <div class="-mr-1 md:hidden">
                        <div data-headlessui-state=""><button
                                class="relative z-10 flex h-8 w-8 items-center justify-center focus:not-data-focus:outline-hidden"
                                aria-label="Toggle Navigation" type="button" aria-expanded="false"
                                data-headlessui-state="" id="headlessui-popover-button-:R5v6fja:"><svg
                                    aria-hidden="true" class="h-3.5 w-3.5 overflow-visible stroke-slate-700"
                                    fill="none" stroke-width="2" stroke-linecap="round">
                                    <path d="M0 1H14M0 7H14M0 13H14" class="origin-center transition"></path>
                                    <path d="M2 2L12 12M12 2L2 12" class="origin-center transition scale-90 opacity-0">
                                    </path>
                                </svg></button></div>
                        <div hidden=""
                            style="position:fixed;top:1px;left:1px;width:1px;height:0;padding:0;margin:-1px;overflow:hidden;clip:rect(0, 0, 0, 0);white-space:nowrap;border-width:0;display:none">
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-20 pb-16 text-center min-h-screen lg:pt-32">
            <h1 class="mx-auto max-w-4xl font-display text-5xl font-medium tracking-tight text-slate-900 sm:text-7xl">
                Training<!-- --> <span class="relative whitespace-nowrap text-green-400"><svg aria-hidden="true"
                        viewBox="0 0 418 42" class="absolute top-2/3 left-0 h-[0.58em] w-full fill-cyan-400/70"
                        preserveAspectRatio="none">
                        <path
                            d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.78 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.54-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.81 23.239-7.825 27.934-10.149 28.304-14.005.417-4.348-3.529-6-16.878-7.066Z">
                        </path>
                    </svg><span class="relative">made simple</span></span> <!-- -->for all businesses.</h1>
            <p class="mx-auto mt-6 max-w-2xl text-lg tracking-tight text-slate-700">Most E-Learning software is
                accurate, but hard to use. We make the opposite trade-off, and hope you get smarter.</p>


        </div>
        <section id="features" aria-label="Features for running your books"
            class="relative overflow-hidden bg-cyan-600 pt-20 pb-28 sm:py-32"><img alt="" loading="lazy"
                width="2245" height="1636" decoding="async" data-nimg="1"
                class="absolute top-1/2 left-1/2 max-w-none translate-x-[-44%] translate-y-[-42%]"
                style="color:transparent" src="/_next/static/media/background-features.5f7a9ac9.jpg">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
                <div class="max-w-2xl md:mx-auto md:text-center xl:max-w-none">
                    <h2 class="font-display text-3xl tracking-tight text-white sm:text-4xl md:text-5xl">Everything you
                        need to train your staff.</h2>
                </div>
                <div
                    class="mt-16 grid grid-cols-1 items-center gap-y-2 pt-10 sm:gap-y-6 md:mt-20 lg:grid-cols-12 lg:pt-0">
                    <div class="-mx-4 flex overflow-x-auto pb-4 sm:mx-0 sm:overflow-visible sm:pb-0 lg:col-span-5">
                        <div class="relative z-10 flex gap-x-4 px-4 whitespace-nowrap sm:mx-auto sm:px-0 lg:mx-0 lg:block lg:gap-x-0 lg:gap-y-1 lg:whitespace-normal"
                            role="tablist" aria-orientation="vertical">
                            <div
                                class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 bg-white lg:bg-white/10 lg:ring-1 lg:ring-white/10 lg:ring-inset">
                                <h3><button
                                        class="font-display text-lg data-selected:not-data-focus:outline-hidden text-cyan-600 lg:text-white"
                                        id="tab-course-management" role="tab" type="button" aria-selected="true"
                                        tabindex="0" data-headlessui-state="selected" data-selected=""
                                        aria-controls="panel-course-management">
                                        <span
                                            class="absolute inset-0 rounded-full lg:rounded-l-xl lg:rounded-r-none"></span>
                                        Course Management
                                    </button>
                                </h3>
                                <p class="mt-2 hidden text-sm lg:block text-white">Create and manage training courses,
                                    track progress, and assess employee performance efficiently.</p>
                            </div>
                            <div
                                class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 hover:bg-white/10 lg:hover:bg-white/5">
                                <h3><button
                                        class="font-display text-lg data-selected:not-data-focus:outline-hidden text-cyan-100 hover:text-white lg:text-white"
                                        id="tab-skills-tracking" role="tab" type="button" aria-selected="false"
                                        tabindex="-1" data-headlessui-state=""
                                        aria-controls="panel-skills-tracking">
                                        <span
                                            class="absolute inset-0 rounded-full lg:rounded-l-xl lg:rounded-r-none"></span>
                                        Skills Tracking
                                    </button>
                                </h3>
                                <p class="mt-2 hidden text-sm lg:block text-cyan-100 group-hover:text-white">Monitor
                                    employee skill development and identify training needs with our comprehensive
                                    tracking system.</p>
                            </div>
                            <div
                                class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 hover:bg-white/10 lg:hover:bg-white/5">
                                <h3><button
                                        class="font-display text-lg data-selected:not-data-focus:outline-hidden text-cyan-100 hover:text-white lg:text-white"
                                        id="tab-certifications" role="tab" type="button" aria-selected="false"
                                        tabindex="-1" data-headlessui-state="" aria-controls="panel-certifications">
                                        <span
                                            class="absolute inset-0 rounded-full lg:rounded-l-xl lg:rounded-r-none"></span>
                                        Certifications
                                    </button>
                                </h3>
                                <p class="mt-2 hidden text-sm lg:block text-cyan-100 group-hover:text-white">Manage and
                                    track employee certifications, ensuring compliance and professional development
                                    requirements are met.</p>
                            </div>
                            <div
                                class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 hover:bg-white/10 lg:hover:bg-white/5">
                                <h3><button
                                        class="font-display text-lg data-selected:not-data-focus:outline-hidden text-cyan-100 hover:text-white lg:text-white"
                                        id="tab-analytics" role="tab" type="button" aria-selected="false"
                                        tabindex="-1" data-headlessui-state="" aria-controls="panel-analytics">
                                        <span
                                            class="absolute inset-0 rounded-full lg:rounded-l-xl lg:rounded-r-none"></span>
                                        Analytics
                                    </button>
                                </h3>
                                <p class="mt-2 hidden text-sm lg:block text-cyan-100 group-hover:text-white">Get
                                    detailed insights into training effectiveness and employee progress through
                                    comprehensive analytics and reporting.</p>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-7">
                        <div id="panel-course-management" role="tabpanel" tabindex="0"
                            data-headlessui-state="selected" aria-labelledby="tab-course-management">
                            <div class="relative sm:px-6 lg:hidden">
                                <div
                                    class="absolute -inset-x-4 top-[-6.5rem] bottom-[-4.25rem] bg-white/10 ring-1 ring-white/10 ring-inset sm:inset-x-0 sm:rounded-t-xl">
                                </div>
                                <p class="relative mx-auto max-w-2xl text-base text-white sm:text-center">
                                    Create and manage training courses, track progress, and assess employee performance
                                    efficiently.
                                </p>
                            </div>
                            <div
                                class="mt-10 w-[45rem] overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-cyan-900/20 sm:w-auto lg:mt-0 lg:w-[67.8125rem]">
                                <img alt="Course Management Interface" width="1024" height="768" class="w-full"
                                    src="https://cdn.dribbble.com/userupload/6340825/file/original-04ebf72576ebbf578cb21baa3685fdbe.png?resize=1024x768&vertical=center">
                            </div>
                        </div>

                        <div id="panel-skills-tracking" role="tabpanel" class="hidden" tabindex="-1"
                            aria-labelledby="tab-skills-tracking">
                            <div
                                class="mt-10 w-[45rem] overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-cyan-900/20 sm:w-auto lg:mt-0 lg:w-[67.8125rem]">
                                <img alt="Skills Tracking Interface" width="1504" height="1128" class="w-full"
                                    src="https://cdn.dribbble.com/userupload/20812023/file/original-f847da681530f812dd38e256eff7bfc9.png?resize=1504x1128&vertical=center">
                            </div>
                        </div>

                        <div id="panel-certifications" role="tabpanel" class="hidden" tabindex="-1"
                            aria-labelledby="tab-certifications">
                            <div
                                class="mt-10 w-[45rem] overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-cyan-900/20 sm:w-auto lg:mt-0 lg:w-[67.8125rem]">
                                <img alt="Certifications Interface" width="1024" height="768" class="w-full"
                                    src="https://cdn.dribbble.com/userupload/6340827/file/original-49019ded289dbfb7dcd133c570984b42.png?resize=1024x768&vertical=center">
                            </div>
                        </div>
                        <div id="panel-analytics" role="tabpanel" class="hidden" tabindex="-1"
                            aria-labelledby="tab-analytics">
                            <div
                                class="mt-10 w-[45rem] overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-cyan-900/20 sm:w-auto lg:mt-0 lg:w-[67.8125rem]">
                                <img alt="Analytics Interface" width="1024" height="768" class="w-full"
                                    src="https://cdn.dribbble.com/userupload/16525185/file/original-81f4bc352cab419f69f46f4171b04df7.jpg?resize=1504x1128&vertical=center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="secondary-features" aria-label="Features for simplifying everyday business tasks"
            class="pt-20 pb-14 sm:pt-32 sm:pb-20 lg:pb-32">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl md:text-center">
                    <h2 class="font-display text-3xl tracking-tight text-slate-900 sm:text-4xl">Simplify everyday
                        business tasks.</h2>
                    <p class="mt-4 text-lg tracking-tight text-slate-700">Because you’d probably be a little confused
                        if we suggested you complicate your everyday business tasks instead.</p>
                </div>
                <div class="-mx-4 mt-20 flex flex-col gap-y-10 overflow-hidden px-4 sm:-mx-6 sm:px-6 lg:hidden">
                    <div>
                        <div class="mx-auto max-w-2xl">
                            <div class="w-9 rounded-lg bg-cyan-600"><svg aria-hidden="true" class="h-9 w-9"
                                    fill="none">
                                    <defs>
                                        <linearGradient id=":Rapqfja:" x1="11.5" y1="18" x2="36"
                                            y2="15.5" gradientUnits="userSpaceOnUse">
                                            <stop offset=".194" stop-color="#fff"></stop>
                                            <stop offset="1" stop-color="#6692F1"></stop>
                                        </linearGradient>
                                    </defs>
                                    <path d="m30 15-4 5-4-11-4 18-4-11-4 7-4-5" stroke="url(#:Rapqfja:)"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg></div>
                            <h3 class="mt-6 text-sm font-medium text-cyan-600">Reporting</h3>
                            <p class="mt-2 font-display text-xl text-slate-900">Stay on top of things with always
                                up-to-date reporting features.</p>
                            <p class="mt-4 text-sm text-slate-600">We talked about reporting in the section above but
                                we needed three items here, so mentioning it one more time for posterity.</p>
                        </div>
                        <div class="relative mt-10 pb-10">
                            <div class="absolute -inset-x-4 top-8 bottom-0 bg-slate-200 sm:-inset-x-6"></div>
                            <div
                                class="relative mx-auto w-[52.75rem] overflow-hidden rounded-xl bg-white ring-1 shadow-lg shadow-slate-900/5 ring-slate-500/10">
                                <img alt="" loading="lazy" width="1688" height="856" decoding="async"
                                    data-nimg="1" class="w-full" style="color:transparent" sizes="52.75rem"
                                    srcset="https://cdn.dribbble.com/userupload/2999484/file/original-7064877ce42f47033be7b9782a562fa6.png?resize=1504x847&vertical=center">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mx-auto max-w-2xl">
                            <div class="w-9 rounded-lg bg-cyan-600"><svg aria-hidden="true" class="h-9 w-9"
                                    fill="none">
                                    <path opacity=".5"
                                        d="M8 17a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-2Z"
                                        fill="#fff"></path>
                                    <path opacity=".3"
                                        d="M8 24a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-2Z"
                                        fill="#fff"></path>
                                    <path d="M8 10a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-2Z"
                                        fill="#fff"></path>
                                </svg></div>
                            <h3 class="mt-6 text-sm font-medium text-cyan-600">Inventory</h3>
                            <p class="mt-2 font-display text-xl text-slate-900">Never lose track of what’s in stock
                                with accurate inventory tracking.</p>
                            <p class="mt-4 text-sm text-slate-600">We don’t offer this as part of our software but that
                                statement is inarguably true. Accurate inventory tracking would help you for sure.</p>
                        </div>
                        <div class="relative mt-10 pb-10">
                            <div class="absolute -inset-x-4 top-8 bottom-0 bg-slate-200 sm:-inset-x-6"></div>
                            <div
                                class="relative mx-auto w-[52.75rem] overflow-hidden rounded-xl bg-white ring-1 shadow-lg shadow-slate-900/5 ring-slate-500/10">
                                <img alt="" loading="lazy" width="1688" height="856" decoding="async"
                                    data-nimg="1" class="w-full" style="color:transparent" sizes="52.75rem"
                                    srcset="https://cdn.dribbble.com/userupload/3161795/file/original-5b6eb6d06051e6fa317ad459f31079c4.png?resize=1504x846&vertical=center">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mx-auto max-w-2xl">
                            <div class="w-9 rounded-lg bg-cyan-600"><svg aria-hidden="true" class="h-9 w-9"
                                    fill="none">
                                    <path opacity=".5"
                                        d="M25.778 25.778c.39.39 1.027.393 1.384-.028A11.952 11.952 0 0 0 30 18c0-6.627-5.373-12-12-12S6 11.373 6 18c0 2.954 1.067 5.659 2.838 7.75.357.421.993.419 1.384.028.39-.39.386-1.02.036-1.448A9.959 9.959 0 0 1 8 18c0-5.523 4.477-10 10-10s10 4.477 10 10a9.959 9.959 0 0 1-2.258 6.33c-.35.427-.354 1.058.036 1.448Z"
                                        fill="#fff"></path>
                                    <path
                                        d="M12 28.395V28a6 6 0 0 1 12 0v.395A11.945 11.945 0 0 1 18 30c-2.186 0-4.235-.584-6-1.605ZM21 16.5c0-1.933-.5-3.5-3-3.5s-3 1.567-3 3.5 1.343 3.5 3 3.5 3-1.567 3-3.5Z"
                                        fill="#fff"></path>
                                </svg></div>
                            <h3 class="mt-6 text-sm font-medium text-cyan-600">Contacts</h3>
                            <p class="mt-2 font-display text-xl text-slate-900">Organize all of your contacts, service
                                providers, and invoices in one place.</p>
                            <p class="mt-4 text-sm text-slate-600">This also isn’t actually a feature, it’s just some
                                friendly advice. We definitely recommend that you do this, you’ll feel really organized
                                and professional.</p>
                        </div>
                        <div class="relative mt-10 pb-10">
                            <div class="absolute -inset-x-4 top-8 bottom-0 bg-slate-200 sm:-inset-x-6"></div>
                            <div
                                class="relative mx-auto w-[52.75rem] overflow-hidden rounded-xl bg-white ring-1 shadow-lg shadow-slate-900/5 ring-slate-500/10">
                                <img alt="" loading="lazy" width="1688" height="856" decoding="async"
                                    data-nimg="1" class="w-full" style="color:transparent" sizes="52.75rem"
                                    srcset="https://cdn.dribbble.com/userupload/18355035/file/original-1008659e8663e416903b1d1f327c4967.png?resize=1905x1072&vertical=center">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:mt-20 lg:block">
                    <div class="grid grid-cols-3 gap-x-8" role="tablist" aria-orientation="horizontal">
                        <div class="relative">
                            <div class="w-9 rounded-lg bg-cyan-600"><svg aria-hidden="true" class="h-9 w-9"
                                    fill="none">
                                    <defs>
                                        <linearGradient id=":R1bdqfja:" x1="11.5" y1="18" x2="36"
                                            y2="15.5" gradientUnits="userSpaceOnUse">
                                            <stop offset=".194" stop-color="#fff"></stop>
                                            <stop offset="1" stop-color="#6692F1"></stop>
                                        </linearGradient>
                                    </defs>
                                    <path d="m30 15-4 5-4-11-4 18-4-11-4 7-4-5" stroke="url(#:R1bdqfja:)"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg></div>
                            <h3 class="mt-6 text-sm font-medium text-cyan-600"><button
                                    class="data-selected:not-data-focus:outline-hidden"
                                    id="headlessui-tabs-tab-:R2bdqfja:" role="tab" type="button"
                                    aria-selected="true" tabindex="0" data-headlessui-state="selected"
                                    data-selected="" aria-controls="headlessui-tabs-panel-:R1ddqfja:"><span
                                        class="absolute inset-0"></span>Reporting</button></h3>
                            <p class="mt-2 font-display text-xl text-slate-900">Stay on top of things with always
                                up-to-date reporting features.</p>
                            <p class="mt-4 text-sm text-slate-600">We talked about reporting in the section above but
                                we needed three items here, so mentioning it one more time for posterity.</p>
                        </div>
                        <div class="relative opacity-75 hover:opacity-100">
                            <div class="w-9 rounded-lg bg-slate-500"><svg aria-hidden="true" class="h-9 w-9"
                                    fill="none">
                                    <path opacity=".5"
                                        d="M8 17a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-2Z"
                                        fill="#fff"></path>
                                    <path opacity=".3"
                                        d="M8 24a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-2Z"
                                        fill="#fff"></path>
                                    <path d="M8 10a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-2Z"
                                        fill="#fff"></path>
                                </svg></div>
                            <h3 class="mt-6 text-sm font-medium text-slate-600"><button
                                    class="data-selected:not-data-focus:outline-hidden"
                                    id="headlessui-tabs-tab-:R2jdqfja:" role="tab" type="button"
                                    aria-selected="false" tabindex="-1" data-headlessui-state=""
                                    aria-controls="headlessui-tabs-panel-:R2ddqfja:"><span
                                        class="absolute inset-0"></span>Inventory</button></h3>
                            <p class="mt-2 font-display text-xl text-slate-900">Never lose track of what’s in stock
                                with accurate inventory tracking.</p>
                            <p class="mt-4 text-sm text-slate-600">We don’t offer this as part of our software but that
                                statement is inarguably true. Accurate inventory tracking would help you for sure.</p>
                        </div>
                        <div class="relative opacity-75 hover:opacity-100">
                            <div class="w-9 rounded-lg bg-slate-500"><svg aria-hidden="true" class="h-9 w-9"
                                    fill="none">
                                    <path opacity=".5"
                                        d="M25.778 25.778c.39.39 1.027.393 1.384-.028A11.952 11.952 0 0 0 30 18c0-6.627-5.373-12-12-12S6 11.373 6 18c0 2.954 1.067 5.659 2.838 7.75.357.421.993.419 1.384.028.39-.39.386-1.02.036-1.448A9.959 9.959 0 0 1 8 18c0-5.523 4.477-10 10-10s10 4.477 10 10a9.959 9.959 0 0 1-2.258 6.33c-.35.427-.354 1.058.036 1.448Z"
                                        fill="#fff"></path>
                                    <path
                                        d="M12 28.395V28a6 6 0 0 1 12 0v.395A11.945 11.945 0 0 1 18 30c-2.186 0-4.235-.584-6-1.605ZM21 16.5c0-1.933-.5-3.5-3-3.5s-3 1.567-3 3.5 1.343 3.5 3 3.5 3-1.567 3-3.5Z"
                                        fill="#fff"></path>
                                </svg></div>
                            <h3 class="mt-6 text-sm font-medium text-slate-600"><button
                                    class="data-selected:not-data-focus:outline-hidden"
                                    id="headlessui-tabs-tab-:R2rdqfja:" role="tab" type="button"
                                    aria-selected="false" tabindex="-1" data-headlessui-state=""
                                    aria-controls="headlessui-tabs-panel-:R3ddqfja:"><span
                                        class="absolute inset-0"></span>Contacts</button></h3>
                            <p class="mt-2 font-display text-xl text-slate-900">Organize all of your contacts, service
                                providers, and invoices in one place.</p>
                            <p class="mt-4 text-sm text-slate-600">This also isn’t actually a feature, it’s just some
                                friendly advice. We definitely recommend that you do this, you’ll feel really organized
                                and professional.</p>
                        </div>
                    </div>
                    <div class="relative mt-20 overflow-hidden rounded-4xl bg-slate-200 px-14 py-16 xl:px-16">
                        <div class="-mx-5 flex">
                            <div class="px-5 transition duration-500 ease-in-out data-selected:not-data-focus:outline-hidden"
                                style="transform:translateX(-0%)" aria-hidden="false"
                                id="headlessui-tabs-panel-:R1ddqfja:" role="tabpanel" tabindex="0"
                                data-headlessui-state="selected" data-selected=""
                                aria-labelledby="headlessui-tabs-tab-:R2bdqfja:">
                                <div
                                    class="w-[52.75rem] overflow-hidden rounded-xl bg-white ring-1 shadow-lg shadow-slate-900/5 ring-slate-500/10">
                                    <img alt="" loading="lazy" width="1688" height="856"
                                        decoding="async" data-nimg="1" class="w-full" style="color:transparent"
                                        sizes="52.75rem"
                                        srcset="https://cdn.dribbble.com/userupload/2999484/file/original-7064877ce42f47033be7b9782a562fa6.png?resize=1504x847&vertical=center">
                                </div>
                            </div>
                            <div class="px-5 transition duration-500 ease-in-out data-selected:not-data-focus:outline-hidden opacity-60"
                                style="transform:translateX(-0%)" aria-hidden="true"
                                id="headlessui-tabs-panel-:R2ddqfja:" role="tabpanel" tabindex="-1"
                                data-headlessui-state="" aria-labelledby="headlessui-tabs-tab-:R2jdqfja:">
                                <div
                                    class="w-[52.75rem] overflow-hidden rounded-xl bg-white ring-1 shadow-lg shadow-slate-900/5 ring-slate-500/10">
                                    <img alt="" loading="lazy" width="1688" height="856"
                                        decoding="async" data-nimg="1" class="w-full" style="color:transparent"
                                        sizes="52.75rem"
                                        srcset="https://cdn.dribbble.com/userupload/3161795/file/original-5b6eb6d06051e6fa317ad459f31079c4.png?resize=1504x846&vertical=center">
                                </div>
                            </div>
                            <div class="px-5 transition duration-500 ease-in-out data-selected:not-data-focus:outline-hidden opacity-60"
                                style="transform:translateX(-0%)" aria-hidden="true"
                                id="headlessui-tabs-panel-:R3ddqfja:" role="tabpanel" tabindex="-1"
                                data-headlessui-state="" aria-labelledby="headlessui-tabs-tab-:R2rdqfja:">
                                <div
                                    class="w-[52.75rem] overflow-hidden rounded-xl bg-white ring-1 shadow-lg shadow-slate-900/5 ring-slate-500/10">
                                    <img alt="" loading="lazy" width="1688" height="856"
                                        decoding="async" data-nimg="1" class="w-full" style="color:transparent"
                                        sizes="52.75rem"
                                        srcset="https://cdn.dribbble.com/userupload/18355035/file/original-1008659e8663e416903b1d1f327c4967.png?resize=1905x1072&vertical=center">
                                </div>
                            </div>
                        </div>
                        <div
                            class="pointer-events-none absolute inset-0 rounded-4xl ring-1 ring-slate-900/10 ring-inset">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="get-started-today" class="relative overflow-hidden bg-cyan-600 py-32"><img alt=""
                loading="lazy" width="2347" height="1244" decoding="async" data-nimg="1"
                class="absolute top-1/2 left-1/2 max-w-none -translate-x-1/2 -translate-y-1/2"
                style="color:transparent" src="/_next/static/media/background-call-to-action.6a5a5672.jpg">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
                <div class="mx-auto max-w-lg text-center">
                    <h2 class="font-display text-3xl tracking-tight text-white sm:text-4xl">Get started today</h2>
                    <p class="mt-4 text-lg tracking-tight text-white">It’s time to take control of your books. Buy our
                        software so you can feel like you’re doing something productive.</p><a
                        class="group inline-flex items-center justify-center rounded-full py-2 px-4 text-sm font-semibold focus:outline-hidden focus-visible:outline-2 focus-visible:outline-offset-2 bg-white text-slate-900 hover:bg-cyan-50 active:bg-cyan-200 active:text-slate-600 focus-visible:outline-white mt-10"
                        color="white" variant="solid" href="/register">Get 6 months free</a>
                </div>
            </div>
        </section>
{{--
        <section id="pricing" aria-label="Pricing" class="bg-slate-900 py-20 sm:py-32">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="md:text-center">
                    <h2 class="font-display text-3xl tracking-tight text-white sm:text-4xl"><span
                            class="relative whitespace-nowrap"><svg aria-hidden="true" viewBox="0 0 281 40"
                                preserveAspectRatio="none"
                                class="absolute top-1/2 left-0 h-[1em] w-full fill-cyan-400">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M240.172 22.994c-8.007 1.246-15.477 2.23-31.26 4.114-18.506 2.21-26.323 2.977-34.487 3.386-2.971.149-3.727.324-6.566 1.523-15.124 6.388-43.775 9.404-69.425 7.31-26.207-2.14-50.986-7.103-78-15.624C10.912 20.7.988 16.143.734 14.657c-.066-.381.043-.344 1.324.456 10.423 6.506 49.649 16.322 77.8 19.468 23.708 2.65 38.249 2.95 55.821 1.156 9.407-.962 24.451-3.773 25.101-4.692.074-.104.053-.155-.058-.135-1.062.195-13.863-.271-18.848-.687-16.681-1.389-28.722-4.345-38.142-9.364-15.294-8.15-7.298-19.232 14.802-20.514 16.095-.934 32.793 1.517 47.423 6.96 13.524 5.033 17.942 12.326 11.463 18.922l-.859.874.697-.006c2.681-.026 15.304-1.302 29.208-2.953 25.845-3.07 35.659-4.519 54.027-7.978 9.863-1.858 11.021-2.048 13.055-2.145a61.901 61.901 0 0 0 4.506-.417c1.891-.259 2.151-.267 1.543-.047-.402.145-2.33.913-4.285 1.707-4.635 1.882-5.202 2.07-8.736 2.903-3.414.805-19.773 3.797-26.404 4.829Zm40.321-9.93c.1-.066.231-.085.29-.041.059.043-.024.096-.183.119-.177.024-.219-.007-.107-.079ZM172.299 26.22c9.364-6.058 5.161-12.039-12.304-17.51-11.656-3.653-23.145-5.47-35.243-5.576-22.552-.198-33.577 7.462-21.321 14.814 12.012 7.205 32.994 10.557 61.531 9.831 4.563-.116 5.372-.288 7.337-1.559Z">
                                </path>
                            </svg><span class="relative">Simple pricing,</span></span> <!-- -->for everyone.</h2>
                    <p class="mt-4 text-lg text-slate-400">It doesn’t matter what size your business is, our software
                        won’t work well for you.</p>
                </div>
                <div
                    class="-mx-4 mt-16 grid max-w-2xl grid-cols-1 gap-y-10 sm:mx-auto lg:-mx-8 lg:max-w-none lg:grid-cols-3 xl:mx-0 xl:gap-x-8">
                    <section class="flex flex-col rounded-3xl px-6 sm:px-8 lg:py-8">
                        <h3 class="mt-5 font-display text-lg text-white">Starter</h3>
                        <p class="mt-2 text-base text-slate-400">Good for anyone who is self-employed and just getting
                            started.</p>
                        <p class="order-first font-display text-5xl font-light tracking-tight text-white">$9</p>
                        <ul role="list" class="order-last mt-10 flex flex-col gap-y-3 text-sm text-slate-200">
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-slate-400">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Send 10 quotes and invoices</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-slate-400">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Connect up to 2 bank accounts</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-slate-400">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Track up to 15 expenses per month</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-slate-400">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Manual payroll support</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-slate-400">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Export up to 3 reports</span></li>
                        </ul><a
                            class="group inline-flex ring-1 items-center justify-center rounded-full py-2 px-4 text-sm focus:outline-hidden ring-slate-700 text-white hover:ring-slate-500 active:ring-slate-700 active:text-slate-400 focus-visible:outline-white mt-8"
                            variant="outline" color="white" aria-label="Get started with the Starter plan for $9"
                            href="/register">Get started</a>
                    </section>
                    <section class="flex flex-col rounded-3xl px-6 sm:px-8 order-first bg-cyan-600 py-8 lg:order-none">
                        <h3 class="mt-5 font-display text-lg text-white">Small business</h3>
                        <p class="mt-2 text-base text-white">Perfect for small / medium sized businesses.</p>
                        <p class="order-first font-display text-5xl font-light tracking-tight text-white">$15</p>
                        <ul role="list" class="order-last mt-10 flex flex-col gap-y-3 text-sm text-white">
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-white">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Send 25 quotes and invoices</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-white">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Connect up to 5 bank accounts</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-white">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Track up to 50 expenses per month</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-white">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Automated payroll support</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-white">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Export up to 12 reports</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-white">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Bulk reconcile transactions</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-white">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Track in multiple currencies</span></li>
                        </ul><a
                            class="group inline-flex items-center justify-center rounded-full py-2 px-4 text-sm font-semibold focus:outline-hidden focus-visible:outline-2 focus-visible:outline-offset-2 bg-white text-slate-900 hover:bg-cyan-50 active:bg-cyan-200 active:text-slate-600 focus-visible:outline-white mt-8"
                            variant="solid" color="white"
                            aria-label="Get started with the Small business plan for $15" href="/register">Get
                            started</a>
                    </section>
                    <section class="flex flex-col rounded-3xl px-6 sm:px-8 lg:py-8">
                        <h3 class="mt-5 font-display text-lg text-white">Enterprise</h3>
                        <p class="mt-2 text-base text-slate-400">For even the biggest enterprise companies.</p>
                        <p class="order-first font-display text-5xl font-light tracking-tight text-white">$39</p>
                        <ul role="list" class="order-last mt-10 flex flex-col gap-y-3 text-sm text-slate-200">
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-slate-400">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Send unlimited quotes and invoices</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-slate-400">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Connect up to 15 bank accounts</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-slate-400">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Track up to 200 expenses per month</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-slate-400">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Automated payroll support</span></li>
                            <li class="flex"><svg aria-hidden="true"
                                    class="h-6 w-6 flex-none fill-current stroke-current text-slate-400">
                                    <path
                                        d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                        stroke-width="0"></path>
                                    <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg><span class="ml-4">Export up to 25 reports, including TPS</span></li>
                        </ul><a
                            class="group inline-flex ring-1 items-center justify-center rounded-full py-2 px-4 text-sm focus:outline-hidden ring-slate-700 text-white hover:ring-slate-500 active:ring-slate-700 active:text-slate-400 focus-visible:outline-white mt-8"
                            variant="outline" color="white"
                            aria-label="Get started with the Enterprise plan for $39" href="/register">Get started</a>
                    </section>
                </div>
            </div>
        </section> --}}

    </main>
    <footer class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="py-16">
                <x-application-logo class="h-8 w-auto" />
                <nav class="mt-10 text-sm" aria-label="quick links">
                    <div class="-my-1 flex justify-center gap-x-6"><a
                            class="inline-block rounded-lg px-2 py-1 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900"
                            href="#features">Features</a><a
                            class="inline-block rounded-lg px-2 py-1 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900"
                            href="#testimonials">Testimonials</a><a
                            class="inline-block rounded-lg px-2 py-1 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900"
                            href="#pricing">Pricing</a></div>
                </nav>
            </div>
            <div
                class="flex flex-col items-center border-t border-slate-400/10 py-10 sm:flex-row-reverse sm:justify-between">
                <div class="flex gap-x-6"><a class="group" aria-label="TaxPal on X" href="#"><svg
                            class="h-6 w-6 fill-slate-500 group-hover:fill-slate-700" aria-hidden="true"
                            viewBox="0 0 24 24">
                            <path
                                d="M13.3174 10.7749L19.1457 4H17.7646L12.7039 9.88256L8.66193 4H4L10.1122 12.8955L4 20H5.38119L10.7254 13.7878L14.994 20H19.656L13.3171 10.7749H13.3174ZM11.4257 12.9738L10.8064 12.0881L5.87886 5.03974H8.00029L11.9769 10.728L12.5962 11.6137L17.7652 19.0075H15.6438L11.4257 12.9742V12.9738Z">
                            </path>
                        </svg></a><a class="group" aria-label="TaxPal on GitHub" href="#"><svg
                            class="h-6 w-6 fill-slate-500 group-hover:fill-slate-700" aria-hidden="true"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844a9.59 9.59 0 0 1 2.504.337c1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.02 10.02 0 0 0 22 12.017C22 6.484 17.522 2 12 2Z">
                            </path>
                        </svg></a></div>
                <p class="mt-6 text-sm text-slate-500 sm:mt-0">Copyright ©
                    <!-- -->{{ $year = (new DateTime())->format('Y') }}<!-- --> TrainEase. All rights
                    reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('[role="tab"]');
            const tabPanels = document.querySelectorAll('[role="tabpanel"]');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const selectedPanel = document.getElementById(tab.getAttribute(
                    'aria-controls'));

                    tabs.forEach(t => {
                        t.setAttribute('aria-selected', 'false');
                        t.setAttribute('tabindex', '-1');
                    });

                    tabPanels.forEach(panel => {
                        panel.classList.add('hidden');
                        panel.setAttribute('tabindex', '-1');
                    });

                    tab.setAttribute('aria-selected', 'true');
                    tab.setAttribute('tabindex', '0');
                    selectedPanel.classList.remove('hidden');
                    selectedPanel.setAttribute('tabindex', '0');
                });
            });
        });
    </script>
</body>

</html>
