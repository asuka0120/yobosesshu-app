<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            お子さん一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- 成功メッセージ --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- 登録ボタン --}}
                    <div class="mb-4">
                        <a href="{{ route('children.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            ＋ お子さんを登録する
                        </a>
                    </div>

                    {{-- 一覧表示 --}}
                    @if ($children->isEmpty())
                        <p class="text-gray-500">まだお子さんが登録されていません。</p>
                    @else
                        <table class="w-full border-collapse border border-gray-300">
                             <thead>
    <tr class="bg-gray-100">
        <th class="border border-gray-300 px-4 py-2 text-center">ニックネーム</th>
        <th class="border border-gray-300 px-4 py-2 text-center">生年月日</th>
        <th class="border border-gray-300 px-4 py-2 text-center">操作</th>
    </tr>
</thead>
<tbody>
    @foreach ($children as $child)
        <tr>
            <td class="border border-gray-300 px-4 py-2 text-center">{{ $child->nickname }}</td>
            <td class="border border-gray-300 px-4 py-2 text-center">{{ $child->birth_date->format('Y年m月d日') }}</td>
            <td class="border border-gray-300 px-4 py-2 text-center">
                <div class="flex gap-2 justify-center">
                    <a href="{{ route('schedules.index', $child) }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                       スケジュール
                    </a>
                    <a href="{{ route('children.edit', $child) }}"
                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded">
                        編集
                    </a>
                    <form action="{{ route('children.destroy', $child) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('削除しますか？')"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                            削除
                        </button>
                    </form>
                </div>
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