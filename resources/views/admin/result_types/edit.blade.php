@extends('admin.layouts.admin')

@section('title', 'Badili Aina ya Mtihani')
@section('page_title', 'Badili Aina ya Mtihani')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-success shadow border-0 rounded-lg overflow-hidden">
            <div class="card-header bg-gradient-success text-white py-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <h3 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-edit mr-2"></i> Badili Aina ya Mtihani
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.result-types.index') }}" class="btn btn-light btn-sm rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
            </div>
            <form action="{{ route('admin.result-types.update', $resultType) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body p-4">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold"><i class="fas fa-tag text-muted mr-1"></i> Jina la Aina <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg shadow-sm @error('name') is-invalid @enderror" value="{{ old('name', $resultType->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold d-block mb-2"><i class="fas fa-graduation-cap text-muted mr-1"></i> Levels zinazohusika</label>
                        <div class="row px-2">
                            @php 
                                $selectedLevels = old('level_ids', $resultType->levels->pluck('id')->toArray());
                            @endphp
                            @foreach($levels as $level)
                                <div class="col-md-4 custom-control custom-checkbox mb-2">
                                    <input type="checkbox" name="level_ids[]" 
                                           class="custom-control-input" 
                                           id="level_{{ $level->id }}" 
                                           value="{{ $level->id }}"
                                           {{ in_array($level->id, $selectedLevels) ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-normal" for="level_{{ $level->id }}">
                                        {{ $level->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted d-block mt-1"><i class="fas fa-info-circle mr-1"></i> Acha bila kuchagua kwa level zote.</small>
                        @error('level_ids')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description" class="font-weight-bold"><i class="fas fa-align-left text-muted mr-1"></i> Maelezo (Hiari)</label>
                        <textarea name="description" id="description" class="form-control shadow-sm @error('description') is-invalid @enderror" rows="3">{{ old('description', $resultType->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" {{ $resultType->is_active ? 'checked' : '' }} value="1">
                            <label class="custom-control-label font-weight-bold" for="is_active">Aina hii ni Active</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light text-right py-3 border-top">
                    <a href="{{ route('admin.result-types.index') }}" class="btn btn-default rounded-pill px-4 mr-2">
                        <i class="fas fa-times mr-1"></i> Ghairi
                    </a>
                    <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">
                        <i class="fas fa-save mr-1"></i> Update Aina
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
