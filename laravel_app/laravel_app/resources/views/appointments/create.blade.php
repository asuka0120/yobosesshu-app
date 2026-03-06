<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $child->nickname }}の予約を登録する
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('appointments.store', $child) }}" method="POST">
                        @csrf

                        {{-- 医療機関選択 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                医療機関 <span class="text-red-500">*</span>
                            </label>
                            @if ($institutions->isEmpty())
                                <p class="text-red-500">医療機関が登録されていません。
                                    <a href="{{ route('medical_institutions.create') }}" class="text-blue-500 underline">先に登録してください。</a>
                                </p>
                            @else
                                <select name="medical_institution_id"
                                    class="w-full border border-gray-300 rounded px-4 py-3 text-lg">
                                    <option value="">選択してください</option>
                                    @foreach ($institutions as $institution)
                                        <option value="{{ $institution->id }}"
                                            {{ old('medical_institution_id') == $institution->id ? 'selected' : '' }}>
                                            {{ $institution->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('medical_institution_id')
                                    <p class="text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>

                        {{-- ワクチン選択 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                ワクチン（任意）
                            </label>
                            <select name="vaccination_schedule_id"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg">
                                <option value="">選択してください</option>
                                @foreach ($schedules as $schedule)
                                    <option value="{{ $schedule->id }}"
                                        {{ old('vaccination_schedule_id') == $schedule->id ? 'selected' : '' }}>
                                        {{ $schedule->vaccine->name }}
                                        （{{ $schedule->scheduled_date->format('Y年m月d日') }}予定）
                                    </option>
                                @endforeach
                            </select>
                            @error('vaccination_schedule_id')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 予約日 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                予約日 <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="appointment_date"
                                value="{{ old('appointment_date') }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg">
                            @error('appointment_date')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 予約時間 --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                予約時間（任意）
                            </label>
                            <input type="time" name="appointment_time"
                                value="{{ old('appointment_time') }}"
                                class="w-full border border-gray-300 rounded px-4 py-3 text-lg">
                            @error('appointment_time')
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
                                placeholder="例：母子手帳を持参する">{{ old('memo') }}</textarea>
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
                            <a href="{{ route('appointments.index', $child) }}"
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