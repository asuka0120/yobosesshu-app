<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💉 ワクチンガイド
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ガイド説明 --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-blue-700 mb-2">📖 予防接種について</h3>
                <p class="text-gray-700">予防接種は、感染症から赤ちゃんや子どもを守るための大切な手段です。定期接種は国が推奨する無料のワクチンで、任意接種は自己負担で受けられるワクチンです。</p>
            </div>

            {{-- 定期接種 --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-blue-600 mb-4">📋 定期接種（無料）</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($regularVaccines as $vaccine)
                            <a href="{{ route('vaccines.show', $vaccine) }}"
                                class="border border-blue-200 rounded-lg p-4 hover:bg-blue-50 transition">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-blue-700">💉 {{ $vaccine->name }}</h4>
                                    <span class="text-sm text-gray-500">{{ $vaccine->recommended_months }}ヶ月頃</span>
                                </div>
                                <p class="text-gray-600 text-sm mt-2">{{ $vaccine->description }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 任意接種 --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-orange-600 mb-4">📋 任意接種（自己負担）</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($optionalVaccines as $vaccine)
                            <a href="{{ route('vaccines.show', $vaccine) }}"
                                class="border border-orange-200 rounded-lg p-4 hover:bg-orange-50 transition">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-orange-700">💉 {{ $vaccine->name }}</h4>
                                    <span class="text-sm text-gray-500">{{ $vaccine->recommended_months }}ヶ月頃</span>
                                </div>
                                <p class="text-gray-600 text-sm mt-2">{{ $vaccine->description }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>