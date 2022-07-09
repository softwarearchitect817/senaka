@extends('master')

@section('content')
<div class="container my-5">
    @if (session('info_message'))
        <div class="alert alert-info alert-dismissible mt-5">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ session('info_message') }}
        </div>
    @endif
    @if (session('error_message'))
        <div class="alert alert-danger alert-dismissible mt-5">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ session('error_message') }}
        </div>
    @endif
    <div class="row mt-5">
        <div class="col-12">
            <h3><span class="pt-2 pb-2 pl-4 pr-4 bg-success text-white">{{ $aisle }}</span></h3>
        </div>

    </div>

    <div class="row mt-5">
        <div class="col-2 offset-1">
            <h3><span class="pt-2 pb-2 pl-4 pr-4 bg-success text-white">0%</span></h3>
        </div>

        <div class="col-2">
            <h3><span class="pt-2 pb-2 pl-4 pr-4 bg-primary text-white">25%</span></h3>
        </div>

        <div class="col-2">
            <h3><span class="pt-2 pb-2 pl-4 pr-4 bg-secondary text-white">50%</span></h3>
        </div>

        <div class="col-2">
            <h3><span class="pt-2 pb-2 pl-4 pr-4 bg-warning text-white">75%</span></h3>
        </div>

        <div class="col-2">
            <h3><span class="pt-2 pb-2 pl-4 pr-4 bg-danger text-white">100%</span></h3>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <table id="rack-info" class="table table-bordered table-responsive">
                <tbody>
                    <tr>
                        @for($i = 100; $i <= $end; $i += 25)
                            <td>
                                <div class="rack @if(empty($rackA[$i]) || !$rackA[$i]['capacity']) bg-success @elseif($rackA[$i]['capacity'] == 25) bg-primary @elseif($rackA[$i]['capacity'] == 50) bg-secondary @elseif($rackA[$i]['capacity'] == 75) bg-warning @else bg-danger @endif">
                                    @if(!empty($rackA[$i]))
                                        <div class="tooltip bg-white border">
                                            <b>Weight: </b><span>{{ $rackA[$i]['weight'] }}</span><br>
                                            <b>Qty: </b><span>{{ $rackA[$i]['qty'] }}</span><br>
                                            <b>Capacity: </b><span>{{ $rackA[$i]['capacity']?$rackA[$i]['capacity']:0 }}%</span><br>
                                            <b>Item Number:</b>
                                            @foreach($rackA[$i]['item_number'] as $item)
                                                <div class="pl-2">{{ $item }}</div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        @for($i = 100; $i <= $end; $i += 25)
                            <td class="rack_name">{{ 'A'.$i }}</td>
                        @endfor
                    </tr>
                <tr>
                    @for($i = 100; $i <= $end; $i += 25)
                        <td>
                            <div class="rack @if(empty($rackB[$i]) || !$rackB[$i]['capacity']) bg-success @elseif($rackB[$i]['capacity'] == 25) bg-primary @elseif($rackB[$i]['capacity'] == 50) bg-secondary @elseif($rackB[$i]['capacity'] == 75) bg-warning @else bg-danger @endif">
                                @if(!empty($rackB[$i]))
                                    <div class="tooltip bg-white border">
                                        <b>Weight: </b><span>{{ $rackB[$i]['weight'] }}</span><br>
                                        <b>Qty: </b><span>{{ $rackB[$i]['qty'] }}</span><br>
                                        <b>Capacity: </b><span>{{ $rackB[$i]['capacity'] }}</span><br>
                                        <b>Item Number:</b>
                                        @foreach($rackB[$i]['item_number'] as $item)
                                            <div class="pl-2">{{ $item }}</div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </td>
                    @endfor
                </tr>
                <tr>
                    @for($i = 100; $i <= $end; $i += 25)
                        <td class="rack_name">{{ 'B'.$i }}</td>
                    @endfor
                </tr>

                <tr>
                    @for($i = 100; $i <= $end; $i += 25)
                        <td>
                            <div class="rack @if(empty($rackC[$i]) || !$rackC[$i]['capacity']) bg-success @elseif($rackC[$i]['capacity'] == 25) bg-primary @elseif($rackC[$i]['capacity'] == 50) bg-secondary @elseif($rackC[$i]['capacity'] == 75) bg-warning @else bg-danger @endif">
                                @if(!empty($rackC[$i]))
                                    <div class="tooltip bg-white border">
                                        <b>Weight: </b><span>{{ $rackC[$i]['weight'] }}</span><br>
                                        <b>Qty: </b><span>{{ $rackC[$i]['qty'] }}</span><br>
                                        <b>Capacity: </b><span>{{ $rackC[$i]['capacity'] }}</span><br>
                                        <b>Item Number:</b>
                                        @foreach($rackC[$i]['item_number'] as $item)
                                            <div class="pl-2">{{ $item }}</div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </td>
                    @endfor
                </tr>
                <tr>
                    @for($i = 100; $i <= $end; $i += 25)
                        <td class="rack_name">{{ 'C'.$i }}</td>
                    @endfor
                </tr>

                <tr>
                    @for($i = 100; $i <= $end; $i += 25)
                        <td>
                            <div class="rack @if(empty($rackG[$i]) || !$rackG[$i]['capacity']) bg-success @elseif($rackG[$i]['capacity'] == 25) bg-primary @elseif($rackG[$i]['capacity'] == 50) bg-secondary @elseif($rackG[$i]['capacity'] == 75) bg-warning @else bg-danger @endif">
                                @if(!empty($rackG[$i]))
                                    <div class="tooltip bg-white border">
                                        <b>Weight: </b><span>{{ $rackG[$i]['weight'] }}</span><br>
                                        <b>Qty: </b><span>{{ $rackG[$i]['qty'] }}</span><br>
                                        <b>Capacity: </b><span>{{ $rackG[$i]['capacity'] }}</span><br>
                                        <b>Item Number:</b>
                                        @foreach($rackG[$i]['item_number'] as $item)
                                            <div class="pl-2">{{ $item }}</div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </td>
                    @endfor
                </tr>
                <tr>
                    @for($i = 100; $i <= $end; $i += 25)
                        <td class="rack_name">{{ 'G'.$i }}</td>
                    @endfor
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection
