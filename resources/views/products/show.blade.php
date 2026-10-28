@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Product List
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('products.edit', $product) }}" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                Edit Product
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-6">
        <div class="flex items-start gap-5">
            <div class="w-24 h-24 rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center flex-shrink-0">
                @if ($product->image_path)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                @endif
            </div>

            <div class="flex-1">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">{{ $product->category }}</span>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold border {{ $product->status === 'Active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                        {{ $product->status }}
                    </span>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mt-2">{{ $product->name }}</h2>
                <p class="text-xs font-mono text-slate-400 mt-0.5">SKU: {{ $product->sku }} • Database ID: #{{ $product->id }}-MYSQL</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-slate-100">
            <div class="p-3 bg-slate-50 rounded-xl">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Regular Price</span>
                <span class="text-base font-bold text-slate-900">${{ number_format($product->price, 2) }}</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Sale Price</span>
                <span class="text-base font-bold text-emerald-600">{{ $product->sale_price ? '$' . number_format($product->sale_price, 2) : '—' }}</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Stock Level</span>
                <span class="text-base font-bold {{ $product->stock_quantity <= ($product->low_stock_threshold ?? 10) ? 'text-rose-600' : 'text-slate-900' }}">{{ $product->stock_quantity }} units</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Low Stock Alert</span>
                <span class="text-base font-bold text-slate-700">{{ $product->low_stock_threshold ?? 10 }} units</span>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Description</h4>
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/60 text-xs text-slate-700 leading-relaxed whitespace-pre-line">
                {{ $product->description ?: 'No detailed description available.' }}
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
            <span>Created at: {{ $product->created_at->format('M d, Y h:i A') }}</span>
            <span>Last updated: {{ $product->updated_at->format('M d, Y h:i A') }}</span>
        </div>
    </div>
</div>
@endsection
