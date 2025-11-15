@extends('driverPanel.layouts.main')

@section('content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Savunma Gönder</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if($tracks->isEmpty())
            <div class="text-gray-600">Savunma yapmanız gereken bir şikayet bulunmamaktadır.</div>
        @else
            @foreach($tracks as $track)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6">
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                        <div class="text-sm text-gray-700 mb-1"><strong>Şikayet Eden:</strong> {{ $track->complainant_name }}</div>
                        <div class="text-sm"><strong>Video:</strong> <a href="{{ $track->video_link }}" target="_blank" class="text-blue-600 underline">YouTube'a Git</a></div>
                        <div class="mt-2">
                            <iframe width="100%" height="240" src="https://www.youtube.com/embed/{{ \Str::after($track->video_link, 'v=') }}" frameborder="0" allowfullscreen class="rounded-md shadow"></iframe>
                        </div>
                        <div class="mt-2 text-lg text-gray-700"><strong>Açıklama:</strong> {{ $track->reminder }}</div>
                    </div>

                    @if($track->has_defense)
                        <div class="p-4 bg-green-50 border border-green-200 rounded-md">
                            <div class="text-green-700 font-medium">Bu şikayete savunma yapılmış.</div>
                            @if($track->comp_video)
                                <div class="mt-2 text-sm"><strong>Video:</strong> <a href="{{ $track->comp_video }}" target="_blank" class="text-blue-600 underline">Savunma Videosu</a></div>
                                <div class="mt-2">
                                    <iframe width="100%" height="240" src="https://www.youtube.com/embed/{{ \Str::after($track->comp_video, 'v=') }}" frameborder="0" allowfullscreen class="rounded-md shadow"></iframe>
                                </div>
                            @endif
                            @if($track->comp_desc)
                                <div class="mt-2 text-lg"><strong>Açıklama:</strong> {{ $track->comp_desc }}</div>
                            @endif
                        </div>
                    @else
                        <form method="POST" action="{{ route('driver.defenses.submit') }}" class="mt-6 space-y-4">
                            @csrf
                            <input type="hidden" name="decision_id" value="{{ $track->decision_id }}">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Video Linki</label>
                                <input type="url" name="comp_video" required class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                                <textarea name="comp_desc" rows="4" required class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                            </div>

                            <div>
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    Savunmayı Gönder
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
@endsection