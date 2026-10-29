@extends('layouts.app')

@section('title', 'User Profile')

@section('breadcrumbs')
    <span class="text-slate-400 font-medium">Enterprise</span>
    <span class="text-slate-300">/</span>
    <h1 class="text-slate-900 font-bold text-base tracking-tight">Account & Profile Settings</h1>
@endsection

@section('content')
<div class="space-y-6 max-w-5xl">

    <!-- Profile Header Banner -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-extrabold text-2xl flex items-center justify-center shadow-md shadow-blue-500/20">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-extrabold text-slate-900">{{ $user->name }}</h2>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Administrator</span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">{{ $user->email }}</p>
                <div class="flex items-center gap-3 mt-2 text-[11px] text-slate-400 font-medium">
                    <span>Member since {{ $user->created_at ? $user->created_at->format('M Y') : 'Recently' }}</span>
                    <span>•</span>
                    <span class="text-emerald-600 font-semibold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Active Session
                    </span>
                </div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 border border-rose-200 hover:bg-rose-50 text-rose-600 font-bold text-xs rounded-xl transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Log Out</span>
            </button>
        </form>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-800 font-semibold space-y-1">
            @foreach ($errors->all() as $error)
                <div class="flex items-center gap-2">
                    <span>&bull;</span>
                    <span>{{ $error }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Forms -->
        <div class="lg:col-span-2 space-y-6">

            <!-- 1. Profile Information -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <div class="pb-4 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Personal Information</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Update your account name and email address</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="pt-4 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Full Name</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $user->name) }}" 
                               required 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $user->email) }}" 
                               required 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- 2. Security & Password Update -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <div class="pb-4 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Security & Password</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Ensure your account is using a long, random password</p>
                </div>

                <form action="{{ route('profile.password') }}" method="POST" class="pt-4 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Current Password</label>
                        <input type="password" 
                               name="current_password" 
                               id="current_password" 
                               required 
                               placeholder="••••••••"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="new_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">New Password</label>
                            <input type="password" 
                                   name="password" 
                                   id="new_password" 
                                   required 
                                   placeholder="Minimum 8 characters"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Confirm New Password</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   required 
                                   placeholder="Repeat new password"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition-colors">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Right 1 Col: Account Metadata & Shortcuts -->
        <div class="space-y-6">
            
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider text-slate-400 text-[10px]">Account Metadata</h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400">Database Record ID</span>
                        <span class="font-mono font-bold text-slate-800">#{{ $user->id }}-MYSQL</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400">Account Role</span>
                        <span class="font-bold text-blue-600">Enterprise Admin</span>
                    </div>

                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400">Authentication Driver</span>
                        <span class="font-mono text-slate-800">Eloquent / Session</span>
                    </div>

                    <div class="flex justify-between py-2">
                        <span class="text-slate-400">Database Storage</span>
                        <span class="font-bold text-emerald-600">MySQL Synchronized</span>
                    </div>
                </div>
            </div>

            <!-- Fast Navigation Shortcuts -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-3">
                <h3 class="text-sm font-bold text-slate-900">Quick Navigation</h3>
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 flex items-center justify-between text-xs font-semibold text-slate-700 transition-colors">
                        <span>Dashboard Overview</span>
                        <span>&rarr;</span>
                    </a>
                    <a href="{{ route('pos.index') }}" class="p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 flex items-center justify-between text-xs font-semibold text-slate-700 transition-colors">
                        <span>Launch POS Terminal</span>
                        <span>&rarr;</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 flex items-center justify-between text-xs font-semibold text-slate-700 transition-colors">
                        <span>Products Catalog</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
