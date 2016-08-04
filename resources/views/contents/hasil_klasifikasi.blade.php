@extends('master')
@section('content')
{!! Session::get('message') !!}
@foreach($tweets as $analisis => $tweets)
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title">{{ $analisis }} jumlah tweet <span>({{ count($tweets) }})</span></h4>
            <!-- <p class="category">Here is a subtitle for this table</p> -->
        </div>
        <div class="content table-responsive table-full-width">
        <div style="height: 300px; overflow: scroll;">
            <table class="table table-hover table-striped">
                <thead>
                    <tr><th>Tweet</th>
                </tr></thead>
                <tbody>
                	@foreach($tweets as $tweet)
                    <tr>
                    	<td>{{ $tweet }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="col-xs-4 text-center">
    <div id="ct-chart5" class="ct-perfect-fourth" style="margin-bottom:30px;"></div>
    <span style="background-color:#fff; padding:5px;">
        <small style="color:#1AB394;">Positif : {{ $count_analisis[0] }}</small>
        <small style="color:#79D2C0;">negatif : {{ $count_analisis[1] }}</small>
        <small style="color:#D3D3D3;">Netral : {{ $count_analisis[2] }}</small>
    </span>
</div>
@stop

@section('javascript_chart')
<script type="text/javascript">
    
    $(document).ready(function(){
        var positif = {{ isset($count_analisis) ? $count_analisis[0] : '' }};
            var negatif = {{ isset($count_analisis) ? $count_analisis[1] : '' }};
            var netral = {{ isset($count_analisis) ? $count_analisis[2] : '' }};
            var data = {
                series: [positif, negatif, netral]
            };

            var sum = function(a, b) { return a + b };

            new Chartist.Pie('#ct-chart5', data, {
                labelInterpolationFnc: function(value) {
                    return Math.round(value / data.series.reduce(sum) * 100) + '%';
                }
            });
    });

</script>
@stop