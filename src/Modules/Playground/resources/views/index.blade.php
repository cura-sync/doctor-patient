@extends('layouts.playground')

@section('content')
<div x-data="{}" :class="$root.sidebarOpen ? 'pl-64' : 'pl-20'" class="transition-all duration-300 bg-[#EFF2FB] min-h-screen px-10 py-8">
    <p class="text-center text-sm mb-10">{{ now()->format('F j, Y') }}</p>
    <div class="flex flex-row gap-8 mb-10">
        <!-- Left Greeting Card -->
        <div class="flex-1 bg-white rounded-3xl flex items-center p-8 shadow-sm min-h-[260px] relative overflow-visible">
            <div class="flex-1 flex flex-col justify-center z-10">
                <div class="text-3xl mb-2">Hi, {{ Auth::user()->name }}!</div>
                <div class="text-gray-400 text-lg">What are we doing today?</div>
            </div>
            <img src="/resources/playground-panda.png" alt="Panda" class="absolute -top-24 right-8 h-72 w-auto z-20 drop-shadow-xl" />
        </div>
        <!-- Right Vertical Cards -->
        <div class="flex flex-col gap-6 w-[320px]">
            <a href="{{ route('prescriptions.index') }}" class="rounded-2xl h-20 flex items-center justify-center text-white text-2xl font-bold shadow-md transition-transform duration-200 hover:scale-105" style="background: url('/resources/bg_abstract_1.png') center/cover;">
                <span class="drop-shadow">CuraLex</span>
            </a>
            <a href="{{ route('audioTranslation.index') }}" class="rounded-2xl h-20 flex items-center justify-center text-white text-2xl font-bold shadow-md transition-transform duration-200 hover:scale-105" style="background: url('/resources/bg_abstract_2.png') center/cover;">
                <span class="drop-shadow">CuraVox</span>
            </a>
            <a href="{{ route('alarm.index') }}" class="rounded-2xl h-20 flex items-center justify-center text-white text-2xl font-bold shadow-md transition-transform duration-200 hover:scale-105" style="background: url('/resources/bg_abstract_3.png') center/cover;">
                <span class="drop-shadow">CuraTempus</span>
            </a>
        </div>
    </div>
    <!-- Calendar Cards Row -->
    <div class="flex flex-row gap-6 ">
        @for ($i = 0; $i < 4; $i++)
        <div class="bg-white rounded-2xl p-6 flex flex-col gap-2 shadow-sm w-72">
            <div class="flex items-center justify-between">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="4"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                <svg class="w-6 h-6 text-gray-400 cursor-pointer" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="1.5"/><circle cx="19.5" cy="12" r="1.5"/><circle cx="4.5" cy="12" r="1.5"/></svg>
            </div>
            <div class="font-semibold text-lg mt-2">Calendar</div>
            <div class="text-gray-400 text-sm">diverse alliance of businesses from all ends of the Hookah experience, from manufacturers and importers</div>
        </div>
        @endfor
    </div>
</div>
@endsection
