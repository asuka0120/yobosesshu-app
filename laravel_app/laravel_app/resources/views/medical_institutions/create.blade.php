<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏥 医療機関を登録する
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('medical_institutions.store') }}" method="POST">
                        @csrf

                        {{-- 医療機関名 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">医療機関名 <span class="text-red-500">*</span></label>
                            <input type="text" name="name"
                                value="{{ old('name') }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg"
                                placeholder="例：○○こどもクリニック">
                            @error('name')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 住所 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">住所</label>
                            <input type="text" name="address"
                                value="{{ old('address') }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg"
                                placeholder="例：東京都渋谷区○○1-2-3">
                            @error('address')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 電話番号 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">電話番号</label>
                            <input type="text" name="phone"
                                value="{{ old('phone') }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg"
                                placeholder="例：03-1234-5678">
                            @error('phone')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 受付時間 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">受付時間</label>
                            <input type="text" name="reception_hours"
                                value="{{ old('reception_hours') }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg"
                                placeholder="例：9:00〜12:00 / 15:00〜18:00">
                            @error('reception_hours')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 休診日 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">休診日</label>
                            <input type="text" name="closed_days"
                                value="{{ old('closed_days') }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg"
                                placeholder="例：水曜・日曜・祝日">
                            @error('closed_days')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- メモ --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">メモ</label>
                            <textarea name="memo"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg"
                                rows="3"
                                placeholder="例：駐車場あり、予約制">{{ old('memo') }}</textarea>
                            @error('memo')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ボタン --}}
                        <div class="flex gap-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded text-lg">
                                登録する
                            </button>
                            <a href="{{ route('medical_institutions.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded text-lg">
                                戻る
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>