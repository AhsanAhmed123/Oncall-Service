@extends('layouts.layout')

@section('content')
<div class="page-content-wrapper container">
        <!-- Left Panel -->
        <div class="left-panel">
    <div class="container mt-4">
        
        <h2 class="fw-bold">Mail Configuration</h2>
        <div class="card p-3">
            <form action="{{route('update.sms')}}" method="POST">
                @csrf
                @if(isset($mail))
                    @method('PUT')
                @endif
                <div class="mb-3">
                    <input type="hidden" name="id" value="{{ $sms->id ?? '' }}">
                 
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label fw-bold">Message</label>
                    <textarea class="form-control" required id="message" name="message" rows="4" required>{{ old('message', $sms->message ?? '') }}</textarea>
                </div>
              
                
                <button type="submit" class="btn btn-primary">{{ isset($sms) ? 'Update' : 'Add' }}</button>
            </form>
        </div>
    </div>
        </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
