<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💉 {{ $vaccine->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 戻るボタン --}}
            <div class="mb-4">
                <a href="{{ route('vaccines.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← ワクチンガイドに戻る
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- 種別バッジ --}}
                    <div class="mb-4">
                        @if ($vaccine->type === 'regular')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-bold">定期接種（無料）</span>
                        @else
                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-bold">任意接種（自己負担）</span>
                        @endif
                        <span class="ml-2 bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">推奨接種時期：{{ $vaccine->recommended_months }}ヶ月頃</span>
                    </div>

                    {{-- 説明 --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-700 mb-2">📖 ワクチンについて</h3>
                        <p class="text-gray-600">{{ $vaccine->description }}</p>
                    </div>

                    {{-- なぜ必要か --}}
                    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h3 class="text-lg font-bold text-yellow-700 mb-2">⚠️ なぜ必要？</h3>
                        <p class="text-gray-600">{{ $vaccine->reason }}</p>
                    </div>

                    {{-- 接種スケジュール目安 --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="text-lg font-bold text-blue-700 mb-2">📅 接種時期の目安</h3>
                        <p class="text-gray-600">生後 <span class="font-bold text-blue-700">{{ $vaccine->recommended_months }}ヶ月頃</span> からの接種が推奨されています。</p>
                        <p class="text-gray-500 text-sm mt-2">※ 詳しい接種スケジュールはかかりつけ医にご相談ください。</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>