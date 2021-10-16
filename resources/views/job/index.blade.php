@extends('layouts.app')

@section('content')
@inject('controller', 'App\Http\Controllers\JobController')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <strong>{{ __('Github Jobs') }}</strong>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row m-3 d-flex justify-content-between">
                        <div class="col-md-10">
                            <form action="{{route('search') }}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <input type="text" class="form-control col-3 mr-3" name="description" id="" placeholder="Cari Job" value="{{old('description')}}">
                                    <input type="text" class="form-control col-3 mr-3" name="location" id="" placeholder="Cari Lokasi" value="{{old('location')}}">
                                    <div class="form-check mr-3">
                                        <input type="checkbox" class="form-check-input" name="type" value="Full Time">
                                        <label class="form-check-label" for="exampleCheck1">Fulltime</label>
                                    </div>
                                    <input class="form-group btn btn-sm btn-dark mr-2" type="submit" value="Search">
                                    <a class="form-group btn btn-sm btn-light" href="{{route('job.index')}}"> Reset </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <!-- other -->
                            <h3 class="ml-3"><strong>List Jobs</strong></h3>
                            <table class="table w-100">
                                <tbody class="text-left">
                                    @forelse($jobs as $job)
                                        <tr style="cursor:pointer" onclick="location.href='{{route('detailapi', ['id'=> $job->id])}}'">
                                            <th>
                                                <h5 class=""><strong>{{$job->title}}</strong></h5>
                                                <div>
                                                    <p>
                                                        {{$job->company}} - 
                                                        <span class="text-success">{{$job->type}}</span>
                                                    </p>
                                                </div>
                                            </th>
                                            <th class="text-right">
                                                <p>{{$job->location}}</p>
                                                <p>{{ $controller->time_elapsed_string($job->created_at)}}</p>
                                            </th>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            No data found
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{$jobs->render()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
