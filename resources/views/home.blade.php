@extends('layouts.app')

@section('content')
    <x-breadcrumb />
    <div class="card">
        <div class="card-body">
            This is Home || {{ Auth::user()->isAuthor() ? "yes" : "no" }}

            {{-- {{ QrCode::size(200)
            ->color(255,0,0)
            ->generate(request()->url()) }} --}}

            <div class="">
                <form action="{{ route('home.upload') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <x-input type="file" name="upload" label="File Test" />
                    <button class="btn btn-primary">Upload</button>
                </form>
            </div>

        </div>


    </div>
@endsection
