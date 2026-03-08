<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            👨‍👩‍👧 家族共有
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 成功・エラーメッセージ --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- 自分のグループ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">👑 自分のグループ</h3>

                    @if ($ownedGroup)
                        {{-- 招待コード表示 --}}
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-4">
                            <p class="text-gray-600 mb-2">招待コードをパートナーに共有してください。</p>
                            <div class="flex items-center gap-3">
                                <span class="text-3xl font-bold tracking-widest text-purple-700">
                                    {{ $ownedGroup->invite_code }}
                                </span>
                            </div>
                        </div>

                        {{-- メンバー一覧 --}}
                        <h4 class="font-bold text-gray-700 mb-2">👥 メンバー</h4>
                        @if ($ownedGroup->members->isEmpty())
                            <p class="text-gray-500 mb-4">まだメンバーがいません。</p>
                        @else
                            <table class="w-full border-collapse border border-gray-300 mb-4">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-300 px-4 py-2">名前</th>
                                        <th class="border border-gray-300 px-4 py-2">メールアドレス</th>
                                        <th class="border border-gray-300 px-4 py-2">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ownedGroup->members as $member)
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2">{{ $member->name }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $member->email }}</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <form action="{{ route('family_groups.removeMember', [$ownedGroup->id, $member->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('メンバーを削除しますか？')"
                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                        削除
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        {{-- グループ削除 --}}
                        <form action="{{ route('family_groups.destroy', $ownedGroup->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('グループを削除しますか？')"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                グループを削除する
                            </button>
                        </form>

                    @else
                        <p class="text-gray-500 mb-4">まだグループを作成していません。</p>
                        <form action="{{ route('family_groups.store') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                ＋ グループを作成する
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- 参加しているグループ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">🤝 参加しているグループ</h3>

                    @if ($joinedGroups->isEmpty())
                        <p class="text-gray-500 mb-4">まだグループに参加していません。</p>
                    @else
                        @foreach ($joinedGroups as $group)
                            <div class="border border-gray-200 rounded-lg p-4 mb-3">
                                <p class="font-bold text-gray-700">オーナー：{{ $group->owner->name }}</p>
                                <p class="text-gray-500 text-sm">メンバー数：{{ $group->members->count() }}人</p>
                            </div>
                        @endforeach
                    @endif

                    {{-- 招待コードで参加 --}}
                    <h4 class="font-bold text-gray-700 mb-2 mt-4">招待コードで参加する</h4>
                    <form action="{{ route('family_groups.join') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="invite_code"
                            class="border border-gray-300 rounded px-4 py-2 text-lg w-48"
                            placeholder="招待コード"
                            maxlength="8">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            参加する
                        </button>
                    </form>
                    @error('invite_code')
                        <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

        </div>
    </div>
</x-app-layout>