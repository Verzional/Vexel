<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vexel - AI Grading Assistant</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#6366f1',
                            600: '#4f46e5',
                            900: '#1e1b4b',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans antialiased bg-[#F8F9FE] text-slate-800 pt-28">
    <div
        class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-purple-200 rounded-full blur-3xl opacity-50 mix-blend-multiply filter">
    </div>
    <div
        class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-blue-200 rounded-full blur-3xl opacity-50 mix-blend-multiply filter overflow-visible">
    </div>

    <nav class="fixed top-0 left-0 w-full z-50 bg-white/70 backdrop-blur-lg border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo_vexel.png') }}" alt="Vexel Logo" class="h-9 w-auto">
            </div>

            <div class="hidden md:flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="font-medium text-slate-700 hover:text-indigo-600 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition">
                            Login Now
                        </a>
                    @endauth
                @endif
            </div>

            <button id="menu-btn" class="md:hidden text-slate-700 focus:outline-none">
                ☰
            </button>
        </div>

        <div id="mobile-menu"
            class="hidden md:hidden bg-white border-t border-slate-200 px-6 py-4 space-y-4 text-sm font-medium text-slate-600">
            <a href="#" class="block hover:text-indigo-600">Home</a>
            <a href="#fitur" class="block hover:text-indigo-600">How It Works</a>

            <div class="pt-4 border-t border-slate-200">
                @auth
                    <a href="{{ url('/dashboard') }}" class="block text-slate-700 font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('register') }}"
                        class="block mt-2 text-center bg-indigo-600 text-white py-2 rounded-full font-semibold">
                        Try for Free
                    </a>
                @endauth
            </div>
        </div>
    </nav>


    <header class="relative pb-32 overflow-hidden">


        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center relative z-10">
            <div class="space-y-8">
                <h1 class="text-5xl lg:text-6xl font-bold leading-tight text-slate-900">
                    Objective & Consistent Grading with <span class="text-brand-600">AI Grading</span>.
                </h1>
                <p class="text-lg text-slate-600 leading-relaxed max-w-lg">
                    Eliminate grading bias caused by fatigue. Vexel helps educators evaluate student work based on
                    custom rubrics with fairness, detail, and efficiency.
                </p>

                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}"
                        class="bg-brand-600 text-white px-8 py-4 rounded-full font-semibold hover:bg-brand-900 transition shadow-xl shadow-brand-600/20 flex items-center gap-2">
                        Get Started
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <div
                class="relative h-[500px] w-full bg-gradient-to-br from-indigo-100 to-white rounded-[2.5rem] flex items-end justify-center overflow-hidden border border-white shadow-2xl">

                <div class="absolute inset-0 bg-gradient-to-t from-indigo-50/80 via-transparent to-transparent"></div>

                <img src="{{ asset('images/welcome.png') }}" class="absolute bottom-0 h-[90%] object-contain z-0"
                    alt="Happy User">

                <div class="absolute top-12 left-8 bg-white p-3 rounded-2xl shadow-lg border border-slate-100 flex items-center gap-3 animate-bounce"
                    style="animation-duration: 3s;">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-xl">📄</div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Incoming Document</p>
                        <p class="text-sm font-bold text-slate-800">Final_Thesis.pdf</p>
                    </div>
                </div>

                <div
                    class="absolute bottom-20 right-0 mr-3 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 max-w-[200px] animate-bounce">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-slate-400">Analysis Result</span>
                        <span
                            class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold">Done</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 border-2 border-white shadow-sm overflow-hidden">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="Student">
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Score: 88/100</p>
                            <p class="text-[10px] text-slate-500">High Consistency</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </header>

    <section class="max-w-6xl mx-auto px-6 relative z-20 mt-30 mb-20">
        <div
            class="bg-brand-900 rounded-3xl p-10 shadow-2xl text-white grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left items-center">

            <div class="space-y-1">
                <p class="text-brand-500 font-medium text-sm tracking-wider uppercase">Efficiency</p>
                <h3 class="text-4xl font-bold">500+ Hours</h3>
                <p class="text-slate-400 text-sm">Grading time saved per semester.</p>
            </div>

            <div class="space-y-1 border-l border-white/10 pl-8 hidden md:block">
                <p class="text-brand-500 font-medium text-sm tracking-wider uppercase">Accuracy</p>
                <h3 class="text-4xl font-bold">99.9%</h3>
                <p class="text-slate-400 text-sm">Rubric-based consistency.</p>
            </div>

            <div class="bg-white/10 rounded-2xl p-6 backdrop-blur-sm border border-white/10">
                <p class="text-lg font-semibold mb-2">#1 Grading Platform</p>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Trusted by lecturers and educational institutions to reduce administrative workload.
                </p>
            </div>

        </div>
    </section>

    <section id="fitur" class="py-24 max-w-7xl mx-auto px-6 mb-15">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-brand-600 font-semibold tracking-wide uppercase text-sm">Workflow</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-2">Seamless Grading Flow,<br>Exceptional
                Results.</h2>
            <p class="text-slate-500 mt-4">From document upload to detailed reporting, Vexel handles the cognitive load
                of your grading.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <div
                class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 hover:shadow-2xl transition duration-300 border border-slate-100 flex flex-col justify-between h-full">
                <div class="mb-8 relative">
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded bg-brand-100 text-brand-600 flex items-center justify-center">R
                            </div>
                            <div class="h-2 w-24 bg-slate-200 rounded"></div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm text-slate-600">
                                <span>Criteria: Background</span>
                                <span class="font-bold text-green-600">Weight 20%</span>
                            </div>
                            <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full w-3/4 bg-brand-500"></div>
                            </div>
                            <p class="text-xs text-slate-400 mt-2">"Must include 3 key findings..."</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">1. Define Rubrics & Weights</h3>
                    <p class="text-slate-500 leading-relaxed">
                        Set success specifications for each criterion. You maintain full control over grading standards.
                    </p>
                </div>
            </div>

            <div
                class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 hover:shadow-2xl transition duration-300 border border-slate-100 flex flex-col justify-between h-full">
                <div
                    class="mb-8 flex justify-center items-center h-48 bg-brand-50 rounded-2xl relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div
                            class="w-32 h-32 border-4 border-brand-200 rounded-full animate-spin flex items-center justify-center border-t-brand-600">
                        </div>
                        <div class="absolute bg-white p-3 rounded-full shadow-md">
                            <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">2. Automated Evaluation & Reports</h3>
                    <p class="text-slate-500 leading-relaxed">
                        AI analyzes student work and provides scores along with constructive written feedback.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-slate-100 py-12">
        <div class="max-w-7xl mx-auto px-6 text-center text-slate-400 text-sm">
            <p>&copy; 2025 Vexel. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>
