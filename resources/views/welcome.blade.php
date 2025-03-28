
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TrainEase</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="data:,">

    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">



    <script type="text/javascript">
        ! function() {
            "use strict";
            window.RudderSnippetVersion = "3.0.60";
            var e = "rudderanalytics";
            window[e] || (window[e] = []);
            var rudderanalytics = window[e];
            if (Array.isArray(rudderanalytics)) {
                if (true === rudderanalytics.snippetExecuted && window.console && console.error) {
                    console.error("RudderStack JavaScript SDK snippet included more than once.")
                } else {
                    rudderanalytics.snippetExecuted = true,
                        window.rudderAnalyticsBuildType = "legacy";
                    var sdkBaseUrl = "https://cdn.rudderlabs.com";
                    var sdkVersion = "v3";
                    var sdkFileName = "rsa.min.js";
                    var scriptLoadingMode = "async";
                    var r = ["setDefaultInstanceKey", "load", "ready", "page", "track", "identify", "alias", "group",
                        "reset", "setAnonymousId", "startSession", "endSession", "consent"
                    ];
                    for (var n = 0; n < r.length; n++) {
                        var t = r[n];
                        rudderanalytics[t] = function(r) {
                            return function() {
                                var n;
                                Array.isArray(window[e]) ? rudderanalytics.push([r].concat(Array.prototype.slice
                                    .call(arguments))) : null === (n = window[e][r]) || void 0 === n || n.apply(
                                    window[e], arguments)
                            }
                        }(t)
                    }
                    try {
                        new Function(
                                'class Test{field=()=>{};test({prop=[]}={}){return prop?(prop?.property??[...prop]):import("");}}'
                            ),
                            window.rudderAnalyticsBuildType = "modern"
                    } catch (i) {}
                    var d = document.head || document.getElementsByTagName("head")[0];
                    var o = document.body || document.getElementsByTagName("body")[0];
                    window.rudderAnalyticsAddScript = function(e, r, n) {
                            var t = document.createElement("script");
                            t.src = e, t.setAttribute("data-loader", "RS_JS_SDK"), r && n && t.setAttribute(r, n),
                                "async" === scriptLoadingMode ? t.async = true : "defer" === scriptLoadingMode && (t.defer =
                                    true),
                                d ? d.insertBefore(t, d.firstChild) : o.insertBefore(t, o.firstChild)
                        }, window.rudderAnalyticsMount = function() {
                            ! function() {
                                if ("undefined" == typeof globalThis) {
                                    var e;
                                    var r = function getGlobal() {
                                        return "undefined" != typeof self ? self : "undefined" != typeof window ?
                                            window : null
                                    }();
                                    r && Object.defineProperty(r, "globalThis", {
                                        value: r,
                                        configurable: true
                                    })
                                }
                            }(), window.rudderAnalyticsAddScript("".concat(sdkBaseUrl, "/").concat(sdkVersion, "/").concat(
                                    window.rudderAnalyticsBuildType, "/").concat(sdkFileName), "data-rsa-write-key",
                                "2tIgiM5BEfPM9aCeq4BprNU6wCK")
                        },
                        "undefined" == typeof Promise || "undefined" == typeof globalThis ? window.rudderAnalyticsAddScript(
                            "https://polyfill-fastly.io/v3/polyfill.min.js?version=3.111.0&features=Symbol%2CPromise&callback=rudderAnalyticsMount"
                        ) : window.rudderAnalyticsMount();
                    var loadOptions = {};
                    rudderanalytics.load("2tIgiM5BEfPM9aCeq4BprNU6wCK", "https://laraveltrxdkoq.dataplane.rudderstack.com",
                        loadOptions)
                }
            }
        }();
    </script>
    <link rel="preload" as="style"
        href="https://dxr3k2zm7n01i.cloudfront.net/088868e8-022d-44c8-b68c-ad198fbe2260/build/assets/app-BpSaJuR2.css">
    <link rel="modulepreload"
        href="https://dxr3k2zm7n01i.cloudfront.net/088868e8-022d-44c8-b68c-ad198fbe2260/build/assets/marketing-hwCxTrXl.js">
    <link rel="modulepreload"
        href="https://dxr3k2zm7n01i.cloudfront.net/088868e8-022d-44c8-b68c-ad198fbe2260/build/assets/rudderPageTracker-BTkLti3M.js">
    <link rel="modulepreload"
        href="https://dxr3k2zm7n01i.cloudfront.net/088868e8-022d-44c8-b68c-ad198fbe2260/build/assets/_sentry-release-injection-file-g2fYFsM4.js">
    <link rel="modulepreload"
        href="https://dxr3k2zm7n01i.cloudfront.net/088868e8-022d-44c8-b68c-ad198fbe2260/build/assets/favicon-DENZA_Ca.js">
    <link rel="stylesheet"
        href="https://dxr3k2zm7n01i.cloudfront.net/088868e8-022d-44c8-b68c-ad198fbe2260/build/assets/app-BpSaJuR2.css">
    <script type="module"
        src="https://dxr3k2zm7n01i.cloudfront.net/088868e8-022d-44c8-b68c-ad198fbe2260/build/assets/marketing-hwCxTrXl.js">
    </script>
    <link rel="apple-touch-icon" sizes="180x180"
        href="https://dxr3k2zm7n01i.cloudfront.net/088868e8-022d-44c8-b68c-ad198fbe2260/apple-touch-icon-light.png"
        media="">
    <script type="module"
        src="https://dxr3k2zm7n01i.cloudfront.net/088868e8-022d-44c8-b68c-ad198fbe2260/build/assets/favicon-DENZA_Ca.js">
    </script>

<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/logo/mark.png') }}" media="">
</head>

<body x-data=""
    class="bg-[#00001e] font-instrument text-default tracking-[-0.01rem] antialiased [--header-height:58px]">
    <div x-data="{ open: false }">

        <header x-data="{
            showBorder: window.pageYOffset >= 24,
            navOpen: false,
            dark: true,
            init() {
                this.evaluateScrollPosition()
            },
            evaluateScrollPosition() {
                this.showBorder = window.pageYOffset >= 24

                if (true && this.$refs.darkHero) {
                    this.dark =
                        window.pageYOffset <=
                        this.$refs.darkHero.getBoundingClientRect().height +
                        this.$el.getBoundingClientRect().height / 2
                }
            },
        }" x-on:scroll.window.passive="evaluateScrollPosition"
            :class="{ 'border-[#DEE0E2]! dark:border-[white]/10!': showBorder, 'dark': dark }"
            class="dark bg-default sticky top-0 isolate z-20 mt-6 flex h-[var(--header-height)] items-center justify-center border-b border-transparent px-6 backdrop-blur-lg transition-all duration-300 dark:bg-[#00001e]/85!">
            <div class="z-10 mx-auto flex w-full max-w-7xl items-center justify-end py-3 text-sm font-medium">
                <div class="flex flex-1 items-center">
                    <a href="/"
                        class="focus-visible:shadow-xs-selected -m-2 inline-flex items-center gap-3 rounded-sm p-2 transition duration-100 hover:opacity-90 focus:outline-hidden">
                        <img src="{{ asset('assets/logo/mark.png') }}" alt="TrainEase" class="h-8 w-auto" />
                        <span class="text-xl font-semibold tracking-tight text-white">
                            TrainEase
                            <span class="ml-1 text-xs font-medium text-cyan-300">beta</span>
                        </span>
                    </a>
                </div>



                <div class="flex flex-1 items-center justify-end gap-6">
                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-end sm:gap-4">
                        @if (Route::has('login'))

                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
                    </div>

                    <button x-on:click.prevent="navOpen = !navOpen"
                        class="text-icon-default focus-visible:shadow-xs-selected relative size-8 rounded-md focus:outline-hidden lg:hidden dark:text-white">
                        <span
                            class="bg-stronger dark:bg-default absolute top-[11px] left-1.5 block h-0.5 w-5 rounded-full transition-transform duration-300"
                            :class="{ 'rotate-45 translate-y-1': navOpen }"></span>
                        <span
                            class="bg-stronger dark:bg-default absolute top-[19px] left-1.5 block h-0.5 w-5 rounded-full transition-transform duration-300"
                            :class="{ '-rotate-45 -translate-y-1': navOpen }"></span>
                    </button>
                </div>
            </div>


            <div x-dialog="" x-model="navOpen"
                class="bg-default fixed inset-0 z-0 flex h-screen flex-col px-6 pt-[calc(var(--header-height)+48px)] pb-10 lg:hidden dark:bg-[#00001e]!"
                aria-labelledby="alpine-dialog-title-1" aria-describedby="alpine-dialog-description-1" role="dialog"
                aria-modal="true" style="display: none;">


                @if (Route::has('login'))
                <div
                    class="border-weaker mt-8 flex items-center justify-center gap-4 border-t pt-8 sm:hidden dark:border-[white]/10">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
                @endif
            </div>
        </header>

        <section x-ref="darkHero" class="relative bg-[#00001e] text-white">
            <div x-dialog="" x-model="open" x-on:keydown.esc.window="$dialog.close()" class="fixed inset-0 z-50"
                aria-labelledby="alpine-dialog-title-2" aria-describedby="alpine-dialog-description-2" role="dialog"
                aria-modal="true" style="display: none;">
                <div x-dialog:overlay="" x-transition.opacity=""
                    class="bg-stronger/50 fixed inset-0 flex items-center justify-center backdrop-blur-xl"
                    style="display: none;"></div>

                <div class="relative flex size-full items-center justify-center">
                    <div x-dialog:panel="" x-transition.opacity.duration.300ms=""
                        class="flex size-full items-center justify-center" style="display: none;">
                        <div class="fixed inset-x-0 bottom-2.5 flex items-center justify-center">
                            <button @click.prevent="$dialog.close()"
                                class="flex items-center gap-2 rounded-md bg-black/90 px-4 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    class="shrink-0 fill-none stroke-current [stroke-linecap:round] [stroke-linejoin:round] size-4 stroke-[2.25]">
                                    <path d="M4.75 4.75L19.25 19.25M19.25 4.75L4.75 19.25"></path>

                                </svg>


                            </button>
                        </div>


                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute inset-0 mx-auto max-w-[1920px]">
                    <div class="absolute inset-0 top-80 bottom-64 mix-blend-hard-light blur-[80px]"
                        style="
                            background: linear-gradient(
                                to bottom,
                                rgba(0, 0, 0, 0) 0%,
                                rgba(0, 200, 255, 0.9) 40%,
                                #00eeff 70%,
                                #00d0a0 80%,
                                #00aa78 100%
                            );
                        ">
                    </div>
                    <div class="absolute inset-0 bottom-64 mix-blend-soft-light blur-[80px]"
                        style="
                            background: linear-gradient(
                                to bottom,
                                rgba(0, 0, 0, 0) 0%,
                                rgba(0, 200, 255, 0.9) 40%,
                                #00eeff 70%,
                                #00d0a0 80%,
                                #00aa78 100%
                            );
                        ">
                    </div>
                </div>

                <div class="relative px-6 pt-16 sm:pt-32">
                    <div class="relative mx-auto max-w-7xl">
                        <div>
                            <h1 class="text-4xl leading-[1.2]! tracking-tight sm:text-5xl xl:text-6xl">
                                <span
                                    class="duration-1000 ease-[cubic-bezier(0.22,0.61,0.36,1)] will-change-transform md:inline-block starting:translate-y-8 starting:opacity-0 starting:blur-xs">
                                    The fastest way to train and
                                </span>
                                <br class="max-md:hidden">
                                <span
                                    class="duration-1000 ease-[cubic-bezier(0.22,0.61,0.36,1)] will-change-transform md:inline-block md:delay-[100ms] starting:translate-y-8 starting:opacity-0 starting:blur-xs">
                                    upskill your employees
                                </span>
                            </h1>

                            <p
                                class="mt-6! text-base leading-normal font-medium text-white/80 mix-blend-plus-lighter sm:text-xl">
                                <span
                                    class="delay-[200ms] duration-1000 ease-[cubic-bezier(0.22,0.61,0.36,1)] will-change-transform sm:inline-block starting:translate-y-8 starting:opacity-0 starting:blur-xs">
                                    Deploy your training courses in minutes with TrainEase.
                                </span>
                                <br class="max-md:hidden">
                                <span
                                    class="delay-[200ms] duration-1000 ease-[cubic-bezier(0.22,0.61,0.36,1)] will-change-transform sm:inline-block sm:delay-[300ms] starting:translate-y-8 starting:opacity-0 starting:blur-xs">
                                    Automatically track training progress, completion and costs.
                                </span>
                            </p>

                            <div class="mt-12 flex flex-col gap-x-6 gap-y-4 min-[400px]:flex-row">
                                <span
                                    class="delay-[400ms] duration-1000 ease-[cubic-bezier(0.22,0.61,0.36,1)] will-change-transform starting:translate-y-8 starting:opacity-0 starting:blur-xs">
                                    <a href="{{ route('register') }}"
                                        class="bg-default text-strong hover:bg-hovered inline-flex h-10 items-center justify-center rounded-md px-6 font-medium transition-colors duration-100">
                                        Get started
                                    </a>
                                </span>


                            </div>
                        </div>

                        <div class="relative mt-8 h-fit w-full md:mt-28">
                            <div
                                class="relative -mx-6 flex max-w-screen justify-center overflow-hidden p-8 delay-[800ms] duration-1000 will-change-transform starting:translate-y-16 starting:opacity-0 starting:blur-xs">
                                <div class="relative aspect-3252/2160">
                                    <div
                                        class="plus-lighter bg-default/20 absolute inset-0 isolate -m-3 rounded-3xl border border-[white]/20 p-3 mix-blend-plus-lighter">
                                    </div>

                                    <div
                                        class="bg-default relative w-[1280px] max-w-[calc(100vw-48px)] min-w-[800px] rounded-xl">

                                        <img class="rounded-xl border" src="{{ asset('assets/images/dashboard.png') }}" />
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="absolute inset-x-0 -bottom-[68px] h-[528px]">
                        <div class="absolute inset-x-0 bottom-0 h-[240px] bg-[hsl(240,100%,6%)]"></div>
                        <div class="absolute inset-x-0 top-0 h-[320px]"
                            style="
                                background: linear-gradient(
                                    to top,
                                    hsl(240, 100%, 6%) 0%,
                                    hsla(240, 100%, 6%, 0.987) 8.1%,
                                    hsla(240, 100%, 6%, 0.951) 15.5%,
                                    hsla(240, 100%, 6%, 0.896) 22.5%,
                                    hsla(240, 100%, 6%, 0.825) 29%,
                                    hsla(240, 100%, 6%, 0.741) 35.3%,
                                    hsla(240, 100%, 6%, 0.648) 41.2%,
                                    hsla(240, 100%, 6%, 0.55) 47.1%,
                                    hsla(240, 100%, 6%, 0.45) 52.9%,
                                    hsla(240, 100%, 6%, 0.352) 58.8%,
                                    hsla(240, 100%, 6%, 0.259) 64.7%,
                                    hsla(240, 100%, 6%, 0.175) 71%,
                                    hsla(240, 100%, 6%, 0.104) 77.5%,
                                    hsla(240, 100%, 6%, 0.049) 84.5%,
                                    hsla(240, 100%, 6%, 0.013) 91.9%,
                                    hsla(240, 100%, 6%, 0) 100%
                                );
                            ">
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="mx-auto -mt-12 max-w-7xl space-y-12 pb-36 text-center font-medium text-white/80 mix-blend-plus-lighter">
                <p class="text-pretty">Trusted by teams who want to grow efficiently.</p>


            </div>
        </section>



        {{-- <section
            class="relative bg-[url(/public/images/marketing/commits-bg.png)] bg-[size:1540px] bg-left-top bg-repeat px-6 pb-0.5">
            <div
                class="absolute inset-0 h-full w-full bg-linear-to-r from-[#00eeff99] via-[#00eeff] via-80% to-[#00c8ff]">
            </div>
            <div class="mx-auto max-w-xl py-32 lg:relative lg:max-w-7xl">
                <div class="relative">
                    <h2 class="text-3xl font-medium text-white sm:text-4xl xl:text-5xl/[1.2]">Ready to train?</h2>
                    <p class="mt-3 text-lg text-[#A8EFFF]">Let’s grow efficiently with, TrainEase</p>

                </div>
            </div>
        </section> --}}
    </div>

    <footer
        class="text-default bg-[#00001e] bg-[url(/public/images/marketing/commits-dark-bg.png)] bg-[size:1540px] bg-left-top bg-no-repeat px-6">
        <div class="relative mx-auto w-full max-w-xl lg:max-w-7xl">
            <div class="pt-32 pb-10">
                <div class="flex w-full">
                    <div class="flex-col justify-end items-stretch">
                        <h3 class="text-[#B2B2D0]">Optimized and crafted with Laravel.</h3>
                        <p class="mt-1 text-[#B2B2D0]">So you can focus on training, not excel.</p>


                        <nav class="col-span-full flex items-center gap-6 sm:gap-10">
                            <a href="#" target="_blank"
                                class="focus-visible:shadow-xs-selected rounded-sm text-[#6F6F91] transition-colors duration-100 hover:text-white focus:outline-hidden">
                                © 2025 TrainEase
                            </a>

                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </footer>

</body>

</html>
