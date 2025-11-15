@extends('driverPanel.layouts.main')

@section('content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">İtiraz Gönder</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if($tracks->isEmpty())
            <div class="text-gray-600">İtiraz edilecek işlem bulunmamaktadır.</div>
        @else
            @foreach($tracks as $track)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6">
                    @include('driverPanel.refDecisions.partials.track-header', ['track' => $track])

                    <form method="POST" action="{{ route('driver.appeals.submit') }}" class="mt-6 space-y-4">
                        @csrf
                        <input type="hidden" name="decision_id" value="{{ $track->decision_id }}">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Video Linki</label>
                            <input type="url" name="appeal_video" required class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                            <textarea name="appeal_desc" rows="4" required class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <div>
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                İtirazı Gönder
                            </button>
                        </div>
                    </form>
                </div>
            @endforeach
        @endif
    </div>
@endsection
