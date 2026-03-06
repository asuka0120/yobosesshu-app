<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $child->nickname }}の母子手帳写真を追加する
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('mother_child_photos.store', $child) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- 写真アップロード --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                写真 <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="photo"
                                accept="image/jpeg,image/png,image/jpg"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg">
                            <p class="text-gray-400 text-sm mt-1">※ JPEG・PNG形式、5MB以内</p>
                            @error('photo')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- タイトル --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                タイトル（任意）
                            </label>
                            <input type="text" name="title"
                                value="{{ old('title') }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg"
                                placeholder="例：1ヶ月健診">
                            @error('title')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- メモ --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                メモ（任意）
                            </label>
                            <textarea name="memo"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg"
                                rows="3"
                                placeholder="例：体重3.5kg、身長50cm">{{ old('memo') }}</textarea>
                            @error('memo')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ボタン --}}
                        <div class="flex gap-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded text-lg">
                                保存する
                            </button>
                            <a href="{{ route('mother_child_photos.index', $child) }}"
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