<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🗑️ ゴミ箱
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- 戻るボタン --}}
                    <div class="mb-4">
                        <a href="{{ route('children.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            ← お子さん一覧に戻る
                        </a>
                    </div>

                    {{-- 成功メッセージ --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($trashedChildren->isEmpty())
                        <p class="text-gray-500">ゴミ箱は空です。</p>
                    @else
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">ニックネーム</th>
                                    <th class="border border-gray-300 px-4 py-2">生年月日</th>
                                    <th class="border border-gray-300 px-4 py-2">削除日時</th>
                                    <th class="border border-gray-300 px-4 py-2">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashedChildren as $child)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $child->nickname }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $child->birth_date->format('Y年m月d日') }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $child->deleted_at->format('Y年m月d日 H:i') }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{-- 復元ボタン --}}
                                            <form action="{{ route('trash.restore', $child->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded">
                                                    復元
                                                </button>
                                            </form>

                                            {{-- 完全削除ボタン --}}
                                            <form action="{{ route('trash.forceDelete', $child->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('完全に削除します。この操作は元に戻せません。よろしいですか？')"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                                    完全削除
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>