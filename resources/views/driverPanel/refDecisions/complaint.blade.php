@extends('driverPanel.layouts.main')

@section('content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Şikayet Gönder</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if($tracks->isEmpty())
            <div class="text-gray-600">Şikayet gönderebileceğiniz bir yarış bulunmamaktadır.</div>
        @else
            @foreach($tracks as $track)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-10">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('assets/img/flags/' . $track->track_id . '.jpg') }}" alt="Bayrak" class="w-12 h-8">
                            <div>
                                <div class="text-sm text-gray-500">Lig</div>
                                <div class="text-xl font-semibold text-indigo-800">{{ $track->league_name ?? 'Bilinmeyen Lig' }}</div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 text-right">
                            <div><strong>Pist:</strong> {{ $track->track_name }}</div>
                            <div><strong>Yarış Tarihi:</strong> {{ tarihBicimi($track->race_date, 4) }}</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('driver.complaints.submit') }}" class="mt-6 space-y-4">
                        @csrf
                        <input type="hidden" name="track_id" value="{{ $track->track_id }}">
                        <input type="hidden" name="league_id" value="{{ $track->league_id }}">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Şikayet Edilen Pilot</label>
                            <select name="complained" required class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Seçiniz</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->name }} {{ $driver->surname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Video Linki</label>
                            <input type="url" name="video_link" required class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                            <textarea name="reminder" rows="4" required class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <div>
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Şikayeti Gönder
                            </button>
                        </div>
                    </form>

                    @if(isset($track->previous_decisions) && $track->previous_decisions->count())
                        <div class="mt-10 border-t pt-6">
                            <h4 class="text-md font-semibold mb-3 text-gray-800">Daha önce gönderdiğiniz şikayetler</h4>
                            <div class="space-y-4">
                                @foreach($track->previous_decisions as $decision)
                                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-md text-sm">
                                        <div class="mb-1"><strong>Şikayet Edilen:</strong> {{ $decision->complained_name }}</div>
                                        <div><strong>Video:</strong> <a href="{{ $decision->video_link }}" target="_blank" class="text-blue-600 underline">YouTube'a Git</a></div>
                                        <div class="mt-2">
                                            <iframe width="100%" height="200" src="https://www.youtube.com/embed/{{ \Str::after($decision->video_link, 'v=') }}" frameborder="0" allowfullscreen class="rounded"></iframe>
                                        </div>
                                        <div class="mt-2"><strong>Açıklama:</strong> {{ $decision->reminder }}</div>

                                        @if($decision->comp_video || $decision->comp_desc)
                                            <div class="mt-3 border-t pt-2">
                                                <strong>Savunma:</strong>
                                                @if($decision->comp_video)
                                                    <div><a href="{{ $decision->comp_video }}" target="_blank" class="text-blue-600 underline">Savunma Videosu</a></div>
                                                @endif
                                                @if($decision->comp_desc)
                                                    <div class="text-gray-700">{{ $decision->comp_desc }}</div>
                                                @endif
                                            </div>
                                        @endif

                                        @if($decision->can_delete)
                                            <form method="POST" action="{{ route('driver.complaints.delete', $decision->id) }}" class="mt-3 delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 text-sm underline delete-button">
                                                    Şikayeti Sil (silebileceğin son saat: {{ $decision->delete_deadline }})
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
@endsection
