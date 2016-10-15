@extends('master')
@section('content')
<div class="col-md-12">
    {!! Session::get('message') !!}
    <div class="card">
        <div class="header">
            <h4 class="title">Daftar tweet training netral ({{ count($tweets_netral) }})</h4>
            <!-- <p class="category">Here is a subtitle for this table</p> -->
        </div>
        <div class="content table-responsive table-full-width">
        <div style="height: 300px; overflow: scroll;">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Tweet</th>
                    </tr>
                </thead>
                <tbody>
                <?php $n = 1; ?>
                @foreach($tweets_netral as $tweet_netral)
                    <tr>
                    	<td>{{ $n++ }}. {{ $tweet_netral }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>

            <div class="text-center">
            </div>
        </div>
    </div>
    <div class="card">
        <div class="header">
            <h4 class="title">Daftar tweet training positif ({{ count($tweets_positif) }})</h4>
            <!-- <p class="category">Here is a subtitle for this table</p> -->
        </div>
        <div class="content table-responsive table-full-width">
        <div style="height: 300px; overflow: scroll;">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Tweet</th>
                    </tr>
                </thead>
                <tbody>
                <?php $p = 1; ?>
                @foreach($tweets_positif as $tweet_positif)
                    <tr>
                        <td>{{ $p++ }}. {{ $tweet_positif }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
            <div class="text-center">
            </div>
        </div>
    </div>
    <div class="card">
        <div class="header">
            <h4 class="title">Daftar tweet training negatif ({{ count($tweets_negatif) }})</h4>
            <!-- <p class="category">Here is a subtitle for this table</p> -->
        </div>
        <div class="content table-responsive table-full-width">
        <div style="height: 300px; overflow: scroll;">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Tweet</th>
                    </tr>
                </thead>
                <tbody>
                <?php $ng = 1; ?>
                @foreach($tweets_negatif as $tweet_negatif)
                    <tr>
                        <td>{{ $ng++ }}. {{ $tweet_negatif }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
            <div class="text-center">
            </div>
        </div>
    </div>
</div>
@stop