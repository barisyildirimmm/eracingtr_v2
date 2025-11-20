<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="{{ $formId }}">
                    @foreach ($fields as $field)
                        @if ($field['type'] === 'hidden')
                            <input type="hidden" id="{{ $field['id'] }}" name="{{ $field['name'] }}" value="{{ $field['value'] ?? '' }}">
                        @elseif ($field['type'] === 'select')
                            <div class="mb-3">
                                <label for="{{ $field['id'] }}" class="form-label">{{ $field['label'] }}</label>
                                <select class="form-control" id="{{ $field['id'] }}" name="{{ $field['name'] }}">
                                    @foreach ($field['options'] as $value => $option)
                                        <option value="{{ $value }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="{{ $field['id'] }}" class="form-label">{{ $field['label'] }}</label>
                                <input type="{{ $field['type'] }}" class="form-control" id="{{ $field['id'] }}" name="{{ $field['name'] }}" value="{{ $field['value'] ?? '' }}" {{ $field['required'] ? 'required' : '' }}>
                            </div>
                        @endif
                    @endforeach
                    <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
