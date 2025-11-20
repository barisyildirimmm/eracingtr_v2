@extends('driverPanel.layouts.main')

@section('content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">
            @switch($type)
                @case('complaint') {{ __('common.send_complaint_title') }} @break
                @case('defense') {{ __('common.send_defense_title') }} @break
                @case('appeal') {{ __('common.send_appeal_title') }} @break
            @endswitch
        </h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if($tracks->isEmpty())
            <div class="text-gray-600">{{ __('common.no_operation_available') }}</div>
        @else
            @php
                $videoField = $type === 'complaint' ? 'video_link' : ($type === 'defense' ? 'comp_video' : 'appeal_video');
                $descField = $type === 'complaint' ? 'reminder' : ($type === 'defense' ? 'comp_desc' : 'appeal_desc');
                $idField = $type === 'complaint' ? 'track_id' : 'decision_id';
            @endphp

            <div class="space-y-10">
                @foreach($tracks as $track)
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-2">
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('assets/img/flags/' . $track->track_id . '.jpg') }}" alt="Bayrak" class="w-12 h-8">
                                <div>
                                    <div class="text-sm text-gray-500">{{ __('common.league') }}</div>
                                    <div class="text-xl font-semibold text-indigo-800">{{ $track->league_name ?? __('common.unknown_league') }}</div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 text-right">
                                <div><strong>{{ __('common.track') }}:</strong> {{ $track->track_name }}</div>
                                <div><strong>{{ __('common.race_date') }}:</strong> {{ tarihBicimi($track->race_date, 4) }}</div>
                            </div>
                        </div>

                        @if($type === 'defense')
                            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                                <div class="text-sm text-gray-700 mb-1"><strong>{{ __('common.complainant') }}:</strong> {{ $track->complainant_name }}</div>
                                <div class="text-sm"><strong>{{ __('common.video') }}:</strong> <a href="{{ $track->video_link }}" target="_blank" class="text-blue-600 underline">{{ __('common.go_to_youtube') }}</a></div>
                                <div class="mt-2">
                                    <iframe width="100%" height="240" src="https://www.youtube.com/embed/{{ \Str::after($track->video_link, 'v=') }}" frameborder="0" allowfullscreen class="rounded-md shadow"></iframe>
                                </div>
                                <div class="mt-2 text-sm text-gray-700"><strong>{{ __('common.description') }}:</strong> {{ $track->reminder }}</div>
                            </div>

                            @if($track->has_defense)
                                <div class="p-4 bg-green-50 border border-green-200 rounded-md mt-4">
                                    <div class="text-green-700 font-medium">{{ __('common.defense_made_for_complaint') }}</div>
                                    @if($track->comp_video)
                                        <div class="mt-2 text-sm"><strong>{{ __('common.video') }}:</strong> <a href="{{ $track->comp_video }}" target="_blank" class="text-blue-600 underline">{{ __('common.defense_video') }}</a></div>
                                    @endif
                                    @if($track->comp_desc)
                                        <div class="mt-2 text-sm"><strong>{{ __('common.description') }}:</strong> {{ $track->comp_desc }}</div>
                                    @endif
                                </div>
                            @else
                                <form method="POST" action="{{ route('driver.defenses.submit') }}" class="mt-6 space-y-4">
                                    @csrf
                                    <input type="hidden" name="decision_id" value="{{ $track->decision_id }}">

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('common.video_link') }}</label>
                                        <input type="url" name="comp_video" required class="w-full border-gray-300 rounded-md shadow-sm">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('common.description') }}</label>
                                        <textarea name="comp_desc" rows="4" required class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                    </div>

                                    <div>
                                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                            {{ __('common.send_defense') }}
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @endif

                        @if($type === 'complaint')
                            <form method="POST" action="{{ route('driver.complaints.submit') }}" class="mt-6 space-y-4">
                                @csrf
                                <input type="hidden" name="track_id" value="{{ $track->id }}">
                                <input type="hidden" name="league_id" value="{{ $track->league_id }}">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('common.complained_driver') }}</label>
                                    <select name="complained" required class="w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">{{ __('common.select_driver') }}</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->id }}">{{ $driver->name }} {{ $driver->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('common.video_link') }}</label>
                                    <input type="url" name="video_link" required class="w-full border-gray-300 rounded-md shadow-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('common.description') }}</label>
                                    <textarea name="reminder" rows="4" required class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                </div>

                                <div>
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                        {{ __('common.send_complaint') }}
                                    </button>
                                </div>
                            </form>

                            @if(isset($track->previous_decisions) && $track->previous_decisions->count())
                                <div class="mt-10 border-t pt-6">
                                    <h4 class="text-md font-semibold mb-3 text-gray-800">{{ __('common.previous_complaints_sent') }}</h4>
                                    <div class="space-y-4">
                                        @foreach($track->previous_decisions as $decision)
                                            <div class="p-4 bg-gray-50 border border-gray-200 rounded-md text-sm">
                                                <div class="mb-1"><strong>{{ __('common.complained') }}:</strong> {{ $decision->complained_name }}</div>
                                                <div><strong>{{ __('common.video') }}:</strong> <a href="{{ $decision->video_link }}" target="_blank" class="text-blue-600 underline">{{ __('common.go_to_youtube') }}</a></div>
                                                <div class="mt-2">
                                                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/{{ \Str::after($decision->video_link, 'v=') }}" frameborder="0" allowfullscreen class="rounded"></iframe>
                                                </div>
                                                <div class="mt-2"><strong>{{ __('common.description') }}:</strong> {{ $decision->reminder }}</div>

                                                @if($decision->comp_video || $decision->comp_desc)
                                                    <div class="mt-3 border-t pt-2">
                                                        <strong>{{ __('common.my_defenses') }}:</strong>
                                                        @if($decision->comp_video)
                                                            <div><a href="{{ $decision->comp_video }}" target="_blank" class="text-blue-600 underline">{{ __('common.defense_video') }}</a></div>
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
                                                            {{ str_replace(':time', $decision->delete_deadline, __('common.delete_complaint_with_time')) }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
