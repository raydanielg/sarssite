@extends('admin.layouts.admin')

@section('title', 'Ongeza Aina ya Mtihani')
@section('page_title', 'Ongeza Aina ya Mtihani')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-success">
            <form action="{{ route('admin.result-types.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Jina la Aina (Mfano: Mock Exam)</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Ingiza jina...">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Levels (Chagua level zinazohusika)</label>
                        <div class="row px-2">
                            @foreach($levels as $level)
                                <div class="col-md-4 custom-control custom-checkbox mb-2">
                                    <input type="checkbox" name="level_ids[]" 
                                           class="custom-control-input" 
                                           id="level_{{ $level->id }}" 
                                           value="{{ $level->id }}"
                                           {{ is_array(old('level_ids')) && in_array($level->id, old('level_ids')) ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-normal" for="level_{{ $level->id }}">
                                        {{ $level->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted d-block mt-1">Aina hii ya mtihani itaonekana kwa level ulizochagua pekee. Usipochagua yoyote, itaonekana kwa level zote.</small>
                        @error('level_ids')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Maelezo (Hiari)</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Maelezo mafupi...">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" checked value="1">
                            <label class="custom-control-label" for="is_active">Hali ya Aina (Active/Inactive)</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('admin.result-types.index') }}" class="btn btn-default">Ghairi</a>
                    <button type="submit" class="btn btn-success">Hifadhi Aina</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
