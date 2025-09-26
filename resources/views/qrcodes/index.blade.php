@extends('layouts.app')
@section('title')
    QrCodes
@endsection
@section('content')
<div class="row mt-5">
    <div class="col-md-12">
        <div class="mb-3">
            <a href="{{ route('qrcodes.create') }}" class="text-dark text-decoration-none">
                <i class="fas fa-plus"></i>Create a Qr Code
            </a>
        </div>
    </div>
</div>
@endsection