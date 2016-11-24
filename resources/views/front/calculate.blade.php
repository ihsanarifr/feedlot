@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!--<div class="panel-heading">Hasil Optimasi</div>-->
                <div class="panel-body">
                    <h4>Inisialisasi Tableau</h4>
                    <table class="table table-bordered">
                        @for($i=0; $i <= $num[0]; $i++)
                            <tr>
                            @for($j=0; $j<=$total_number+1; $j++)
                                <td>{{ $initial_tableau[$i][$j] }}</td>
                            @endfor
                            </tr>
                        @endfor
                    </table>

                    <h4>Solusi Dasar</h4>
                    <table class="table table-bordered">
                        <tr>
                        <!--in the minimization problem, since we are using the dual, the value of the unknown variables would be the values of the slack variables-->
                        @for($i=0; $i<=$total_number; $i++)
                            @if(($i+1)<=$num[1])
                                @php $sub=$i+1; @endphp
                                <td id='each'> y{{ $sub }} = {{ $initial_tableau[$num[0]][$i] }}</td>
                            
                            @else
                                @php $sub=$i-$num[1]+1; @endphp
                                @if($sub<=$num[0])
                                    <td id='each'> x{{ $sub }} = {{ $initial_tableau[$num[0]][$i] }}</td>
                                @else
                                    <td id='each'> z = {{ $initial_tableau[$num[0]][$total_number+1] }}</td>
                                @endif
                            @endif
                        @endfor
                        </tr>
					</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection