@extends('layouts/report_layout')


@section('header')

    <div class="row">
        <div class="col-xs-8">
            <h2 class="text-left no-margin">Container Movement
                <span class="muted">
                    report
                </span>
            </h2>
        </div>
        <div class="col-xs-4">
            <h2 class="text-right no-margin">
                Date: {{ $info['date']->format('Y-m-d') }}
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-payment">
                <ul class="list-unstyled">
                    <li>
                        <strong>Locations:</strong> {{ $info['locations'] }}
                    </li>                   
                </ul>
            </div>              
        </div>
    </div>

@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table class="table table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Container #</th>
                        <th>Size</th>
                        <th>Work Order</th>
                        <th>Movement</th>
                        <th>Location</th>
                        <th>Activity</th>
                    </tr>
                </thead>
            <tbody>
            <?php $no = 1; ?>
            @foreach($rpt as $row)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $row['confirmed_at']->format('Y-m-d') }}</td>
                <td>{{ $row['confirmed_at']->format('H:i') }}</td>
                <td>{{ $row['container_no'] }}</td>
                <td>{{ $row['size'] }}</td>
                <td>{{ $row['workorder'] }}</td>
                <td>{{ $row['movement'] }}</td>
                <td>{{ $row['location'] }}</td>
                <td>{{ $row['activity'] }}</td>
            </tr>
            <?php $no++; ?>
            @endforeach                                     
            </tbody>
            </table>
        </div>
    </div>

@stop