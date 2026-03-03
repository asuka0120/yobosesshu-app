<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $child->nickname }}の接種スケジュール
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 戻るボタン --}}
            <div class="mb-4">
                <a href="{{ route('children.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← お子さん一覧に戻る
                </a>
            </div>

            {{-- 定期接種 --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-blue-600 mb-4">📋 定期接種</h3>
                    @if ($regularSchedules->isEmpty())
                        <p class="text-gray-500">定期接種のスケジュールはありません。</p>
                    @else
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-blue-50">
                                    <th class="border border-gray-300 px-4 py-2">ワクチン名</th>
                                    <th class="border border-gray-300 px-4 py-2">接種予定日</th>
                                    <th class="border border-gray-300 px-4 py-2">ステータス</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($regularSchedules as $schedule)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $schedule->vaccine->name }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $schedule->scheduled_date->format('Y年m月d日') }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($schedule->status === 'completed')
                                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded">✅ 接種済</span>
                                            @elseif ($schedule->status === 'scheduled')
                                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">📅 次回予定</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded">⏳ 未接種</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            {{-- 任意接種 --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-orange-600 mb-4">📋 任意接種</h3>
                    @if ($optionalSchedules->isEmpty())
                        <p class="text-gray-500">任意接種のスケジュールはありません。</p>
                    @else
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-orange-50">
                                    <th class="border border-gray-300 px-4 py-2">ワクチン名</th>
                                    <th class="border border-gray-300 px-4 py-2">接種予定日</th>
                                    <th class="border border-gray-300 px-4 py-2">ステータス</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($optionalSchedules as $schedule)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $schedule->vaccine->name }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $schedule->scheduled_date->format('Y年m月d日') }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($schedule->status === 'completed')
                                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded">✅ 接種済</span>
                                            @elseif ($schedule->status === 'scheduled')
                                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">📅 次回予定</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded">⏳ 未接種</span>
                                            @endif
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