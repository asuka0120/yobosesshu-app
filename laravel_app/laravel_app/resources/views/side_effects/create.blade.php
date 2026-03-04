<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $child->nickname }}の副反応を記録する
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('side_effects.store', $child) }}" method="POST">
                        @csrf

                        {{-- ワクチン選択 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                ワクチン名
                            </label>
                            @if ($schedules->isEmpty())
                                <p class="text-red-500">接種済みのワクチンがありません。先に接種済みチェックをしてください。</p>
                            @else
                                <select name="vaccination_schedule_id"
                                    class="w-full border border-gray-300 rounded px-4 py-3 text-lg">
                                    <option value="">選択してください</option>
                                    @foreach ($schedules as $schedule)
                                        <option value="{{ $schedule->id }}"
                                            {{ old('vaccination_schedule_id') == $schedule->id ? 'selected' : '' }}>
                                            {{ $schedule->vaccine->name }}
                                            （{{ $schedule->vaccinated_date->format('Y年m月d日') }}接種）
                                        </option>
                                    @endforeach
                                </select>
                                @error('vaccination_schedule_id')
                                    <p class="text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>

                        {{-- 症状 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                症状
                            </label>
                            <input type="text" name="symptom"
                                value="{{ old('symptom') }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg"
                                placeholder="例：発熱、腫れ、機嫌が悪い">
                            @error('symptom')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 開始日 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                開始日
                            </label>
                            <input type="date" name="start_date"
                                value="{{ old('start_date') }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg">
                            @error('start_date')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 終了日 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                終了日（任意）
                            </label>
                            <input type="date" name="end_date"
                                value="{{ old('end_date') }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg">
                            @error('end_date')
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
                                placeholder="例：38度の熱が出た。翌日には回復した。">{{ old('memo') }}</textarea>
                            @error('memo')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ボタン --}}
                        <div class="flex gap-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded text-lg">
                                記録する
                            </button>
                            <a href="{{ route('side_effects.index', $child) }}"
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