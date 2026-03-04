<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 接種期限アラート --}}
            @if ($alertSchedules->isNotEmpty())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <p class="font-bold">⚠️ 接種期限が近いワクチンがあります！</p>
                    <ul class="mt-2">
                        @foreach ($alertSchedules as $schedule)
                            <li class="mt-1">
                                ・{{ $schedule->child->nickname }} →
                                {{ $schedule->vaccine->name }}
                                （{{ $schedule->scheduled_date->format('Y年m月d日') }}）
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- お子さん一覧 --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">👶 お子さん一覧</h3>
                    @if ($children->isEmpty())
                        <p class="text-gray-500">まだお子さんが登録されていません。</p>
                        <a href="{{ route('children.create') }}"
                            class="mt-2 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            ＋ お子さんを登録する
                        </a>
                    @else
                        <div class="flex gap-4 flex-wrap">
                            @foreach ($children as $child)
                                <a href="{{ route('schedules.index', $child) }}"
                                    class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg p-4 text-center">
                                    <p class="font-bold text-blue-700 text-lg">{{ $child->nickname }}</p>
                                    <p class="text-gray-500 text-sm">{{ $child->birth_date->format('Y年m月d日') }}生まれ</p>
                                </a>
                            @endforeach
                            <a href="{{ route('children.create') }}"
                                class="bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg p-4 text-center">
                                <p class="font-bold text-gray-400 text-lg">＋ 追加</p>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- 次回接種予定 --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">📅 次回接種予定（直近10件）</h3>
                    @if ($upcomingSchedules->isEmpty())
                        <p class="text-gray-500">接種予定はありません。</p>
                    @else
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">お子さん</th>
                                    <th class="border border-gray-300 px-4 py-2">ワクチン名</th>
                                    <th class="border border-gray-300 px-4 py-2">接種予定日</th>
                                    <th class="border border-gray-300 px-4 py-2">種別</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($upcomingSchedules as $schedule)
                                    <tr class="{{ $schedule->scheduled_date->isPast() ? 'bg-red-50' : '' }}">
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $schedule->child->nickname }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $schedule->vaccine->name }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $schedule->scheduled_date->format('Y年m月d日') }}
                                            @if ($schedule->scheduled_date->isPast())
                                                <span class="text-red-500 text-sm">（期限切れ）</span>
                                            @elseif ($schedule->scheduled_date->diffInDays(now()) <= 30)
                                                <span class="text-orange-500 text-sm">（もうすぐ）</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($schedule->vaccine->type === 'regular')
                                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-sm">定期</span>
                                            @else
                                                <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-sm">任意</span>
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