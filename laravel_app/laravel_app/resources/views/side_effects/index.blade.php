<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $child->nickname }}の副反応記録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- 戻るボタン --}}
                    <div class="mb-4 flex gap-2">
                        <a href="{{ route('schedules.index', $child) }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            ← スケジュールに戻る
                        </a>
                        <a href="{{ route('side_effects.create', $child) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            ＋ 副反応を記録する
                        </a>
                    </div>

                    {{-- 成功メッセージ --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($sideEffects->isEmpty())
                        <p class="text-gray-500">まだ副反応の記録はありません。</p>
                    @else
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">ワクチン名</th>
                                    <th class="border border-gray-300 px-4 py-2">症状</th>
                                    <th class="border border-gray-300 px-4 py-2">開始日</th>
                                    <th class="border border-gray-300 px-4 py-2">終了日</th>
                                    <th class="border border-gray-300 px-4 py-2">メモ</th>
                                    <th class="border border-gray-300 px-4 py-2">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sideEffects as $sideEffect)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $sideEffect->vaccinationSchedule->vaccine->name }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $sideEffect->symptom }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $sideEffect->start_date->format('Y年m月d日') }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $sideEffect->end_date ? $sideEffect->end_date->format('Y年m月d日') : '継続中' }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $sideEffect->memo ?? '-' }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <form action="{{ route('side_effects.destroy', [$child, $sideEffect]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('削除しますか？')"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                                    削除
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