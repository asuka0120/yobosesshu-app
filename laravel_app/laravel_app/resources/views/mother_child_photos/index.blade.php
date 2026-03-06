<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $child->nickname }}の母子手帳写真
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- ボタン --}}
                    <div class="mb-4 flex gap-2">
                        <a href="{{ route('schedules.index', $child) }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            ← スケジュールに戻る
                        </a>
                        <a href="{{ route('mother_child_photos.create', $child) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            ＋ 写真を追加する
                        </a>
                    </div>

                    {{-- 成功メッセージ --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($photos->isEmpty())
                        <p class="text-gray-500">まだ写真が登録されていません。</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach ($photos as $photo)
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <img src="{{ Storage::url($photo->file_path) }}"
                                        alt="{{ $photo->title ?? '母子手帳写真' }}"
                                        class="w-full h-48 object-cover">
                                    <div class="p-3">
                                        <p class="font-bold text-gray-700">{{ $photo->title ?? '無題' }}</p>
                                        @if ($photo->memo)
                                            <p class="text-gray-500 text-sm mt-1">{{ $photo->memo }}</p>
                                        @endif
                                        <p class="text-gray-400 text-xs mt-1">{{ $photo->created_at->format('Y年m月d日') }}</p>
                                        <form action="{{ route('mother_child_photos.destroy', [$child, $photo]) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('削除しますか？')"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm w-full">
                                                削除
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>