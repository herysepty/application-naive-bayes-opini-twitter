@extends('master')
@section('content')
<div class="col-md-12">
    {!! Session::get('message') !!}
    <div class="card">
        <div class="header">
            <h4 class="title">Daftar tweet</h4>
            <!-- <p class="category">Here is a subtitle for this table</p> -->
        </div>
        <div class="content table-responsive table-full-width">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Tweet</th>
                        <th>tanggal</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tweets as $tweet)
                    <tr>
                    	<td>{{ $tweet->username }}</td>
                        <td>{{ $tweet->tweet }}</td>
                        <td>{{ $tweet->date_tweet }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {!! $tweets->render() !!}    
            </div>
        </div>
    </div>
</div>
@stop