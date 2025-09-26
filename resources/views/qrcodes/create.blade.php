@extends('layouts.app')
@section('title')
    Create Qrcodes
@endsection
@section('content')
<div class="row mt-5">
    <div class="col-md-12">
        <div class="mb-3">
            <a href="{{ route('qrcodes.create') }}" class="text-dark text-decoration-none">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
</div>
@endsection