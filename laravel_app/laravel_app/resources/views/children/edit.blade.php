<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            お子さんの情報を編集する
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('children.update', $child) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        {{-- ニックネーム --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                ニックネーム
                            </label>
                            <input type="text" name="nickname"
                                value="{{ old('nickname', $child->nickname) }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg"
                                placeholder="例：あおちゃん">
                            @error('nickname')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 生年月日 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                生年月日
                            </label>
                            <input type="date" name="birth_date"
                                value="{{ old('birth_date', $child->birth_date->format('Y-m-d')) }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg">
                            @error('birth_date')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ボタン --}}
                        <div class="flex gap-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded text-lg">
                                更新する
                            </button>
                            <a href="{{ route('children.index') }}"
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