@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row ml-3">
                        <a href="{{ route('job.index')}}" data-inline="true" class="btn btn-sm btn-dark" style="padding:10px; margin:4px;"><span data-feather="arrow-left">Back</span></a>
                    </div>
                    <!-- form -->
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="p-4 mb-4">
                                    <p>{{$jobs->type}} / {{$jobs->location}}</p>
                                    <h4 class="mt-3"><strong>{!! $jobs->title !!}</strong></h4><br>
                                    <div class="row text-left pl-4 pr-4">
                                        <p class="col-12 ">
                                            {!! $jobs->description !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
