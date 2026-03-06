<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏥 医療機関管理
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
                        <a href="{{ route('medical_institutions.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            ＋ 医療機関を登録する
                        </a>
                    </div>

                    @if ($institutions->isEmpty())
                        <p class="text-gray-500">まだ医療機関が登録されていません。</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($institutions as $institution)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h3 class="font-bold text-lg text-blue-700 mb-2">🏥 {{ $institution->name }}</h3>
                                    <table class="w-full text-sm">
                                        <tr>
                                            <td class="text-gray-500 w-24">住所</td>
                                            <td>{{ $institution->address ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-gray-500">電話番号</td>
                                            <td>{{ $institution->phone ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-gray-500">受付時間</td>
                                            <td>{{ $institution->reception_hours ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-gray-500">休診日</td>
                                            <td>{{ $institution->closed_days ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-gray-500">メモ</td>
                                            <td>{{ $institution->memo ?? '-' }}</td>
                                        </tr>
                                    </table>
                                    <div class="mt-3 flex gap-2">
                                        <a href="{{ route('medical_institutions.edit', $institution) }}"
                                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            編集
                                        </a>
                                        <form action="{{ route('medical_institutions.destroy', $institution) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('削除しますか？')"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
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