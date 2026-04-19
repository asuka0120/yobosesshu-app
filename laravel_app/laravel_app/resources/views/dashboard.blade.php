<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>
    
    {{-- 通知ボタン --}}
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 flex gap-6 items-center">
            <span class="text-gray-700 font-bold">🔔 プッシュ通知</span>
            <button id="subscribeBtn" onclick="subscribePush()"
                class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                通知を有効にする
            </button>
            <button id="unsubscribeBtn" onclick="unsubscribePush()"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded hidden">
                通知を無効にする
            </button>
        </div>
    </div>
</div>

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
<div class="overflow-hidden shadow-sm sm:rounded-2xl" style="background: #fff9fe; border: 2px solid #e9d5ff;">
    <div class="p-6">
        <h3 class="text-lg font-bold mb-4" style="color: #7c3aed;">🍼 次回接種予定（直近10件）</h3>
        @if ($upcomingSchedules->isEmpty())
            <p class="text-gray-500">接種予定はありません。</p>
        @else
            <table class="w-full border-collapse">
                <thead>
                    <tr style="background: linear-gradient(135deg, #ede9fe, #fce7f3);">
                        <th class="px-4 py-3 text-left rounded-tl-xl" style="color: #6d28d9;">👶 お子さん</th>
                        <th class="px-4 py-3 text-left" style="color: #6d28d9;">💉 ワクチン名</th>
                        <th class="px-4 py-3 text-left" style="color: #6d28d9;">📅 接種予定日</th>
                        <th class="px-4 py-3 text-left rounded-tr-xl" style="color: #6d28d9;">種別</th>
                    </tr>
                </thead>
                <tbody>
    @foreach ($upcomingSchedules as $schedule)
        <tr class="border-b hover:opacity-80 transition"
            style="{{ $schedule->scheduled_date->isPast() ? 'background: #fce7f3;' : 'background: white;' }}">
            <td class="px-4 py-3 font-bold text-center" style="color: #7c3aed;">
                {{ $schedule->child->nickname }}
            </td>
            <td class="px-4 py-3 text-gray-700 text-center">
                {{ $schedule->vaccine->name }}
            </td>
            <td class="px-4 py-3 text-center">
                <span class="text-gray-700">{{ $schedule->scheduled_date->format('Y年m月d日') }}</span>
                @if ($schedule->scheduled_date->isPast())
                    <span class="ml-1 text-xs font-bold text-red-500">⚠️ 期限切れ</span>
                @elseif ($schedule->scheduled_date->diffInDays(now()) <= 30)
                    <span class="ml-1 text-xs font-bold text-orange-500">🔔 もうすぐ</span>
                @endif
            </td>
            <td class="px-4 py-3 text-center">
                @if ($schedule->vaccine->type === 'regular')
                    <span class="text-xs text-white px-2 py-1 rounded-full font-bold" style="background: #8b5cf6;">定期</span>
                @else
                    <span class="text-xs text-white px-2 py-1 rounded-full font-bold" style="background: #f97316;">任意</span>
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

    {{-- プッシュ通知購読 --}}
<script>
    const vapidPublicKey = '{{ env("VAPID_PUBLIC_KEY") }}';

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    async function subscribePush() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            alert('このブラウザはプッシュ通知に対応していません。');
            return;
        }

        const permission = await Notification.requestPermission();
        if (permission !== 'granted') {
            alert('通知が許可されませんでした。');
            return;
        }

        const registration = await navigator.serviceWorker.register('/sw.js');
        await navigator.serviceWorker.ready;

        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(vapidPublicKey),
        });

        await fetch('/push-subscriptions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(subscription),
        });

// ボタンを切り替える（alertの前に移動）
document.getElementById('subscribeBtn').classList.add('hidden');
document.getElementById('unsubscribeBtn').classList.remove('hidden');

        alert('プッシュ通知を有効にしました！');
    }

    async function unsubscribePush() {
        const registration = await navigator.serviceWorker.getRegistration('/sw.js');
        if (!registration) return;

        const subscription = await registration.pushManager.getSubscription();
        if (!subscription) return;

        await fetch('/push-subscriptions', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ endpoint: subscription.endpoint }),
        });

        await subscription.unsubscribe();
        alert('プッシュ通知を無効にしました。');
        // ボタンを切り替える
document.getElementById('subscribeBtn').classList.remove('hidden');
document.getElementById('unsubscribeBtn').classList.add('hidden');
    }
    // ページ読み込み時にボタンの表示を切り替える
async function updateButtonState() {
    const subscribeBtn = document.getElementById('subscribeBtn');
    const unsubscribeBtn = document.getElementById('unsubscribeBtn');
    
    try {
        const permission = Notification.permission;
        if (permission === 'granted') {
            const registration = await navigator.serviceWorker.getRegistration('/sw.js');
            if (registration) {
                const subscription = await registration.pushManager.getSubscription();
                if (subscription) {
                    subscribeBtn.classList.add('hidden');
                    unsubscribeBtn.classList.remove('hidden');
                    return;
                }
            }
        }
    } catch(e) {
        console.log(e);
    }
    
    subscribeBtn.classList.remove('hidden');
    unsubscribeBtn.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', updateButtonState);
</script>
</x-app-layout>