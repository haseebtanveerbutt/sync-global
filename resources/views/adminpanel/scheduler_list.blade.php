@extends('adminpanel.layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <!-- start info box -->
        <div class="row ">

            <div class="col-md-12 col-lg-12 m-auto">
                <div class="card">
                    <div class="card-header bg-white pb-1 d-flex justify-content-between align-items-center">
                        <h5>Scheduler</h5>
                        <a type="button" href="{{route('schedulers')}}" class="btn btn-sm btn-primary">Create Scheduler</a>
                    </div>
                    <div class="card-body">
                        <div class="row px-3" style="overflow-x:auto;">
                            <table id="datatabled" class="table table-borderless  table-hover  table-class ">
                                <thead class="border-0 ">

                                <tr class="th-tr table-tr text-white ">
                                    <th class="font-weight-bold " >Scheduler Name</th>
                                    <th class="font-weight-bold " >Frequency</th>
                                    <th class="font-weight-bold " >Status</th>
                                    {{--                                        <th class="font-weight-bold " >Status</th>--}}
                                    <th class="font-weight-bold " >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($scheduler_data as $key=>$scheduler)

                                    <tr class="td-text-center">
                                        <td>
                                            {{$scheduler->name}}
                                        </td>
                                        <td>
                                            {{$scheduler->frequency}}
                                        </td>
                                        <td style="    max-width: 350px;" >
                                            {{$scheduler->active}}
                                        </td>
{{--                                        <td class="text-center">--}}
{{--                                            <div class="badge badge-primary text-light px-3 py-1">{{$scheduler->status}}</div>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            {{\Illuminate\Support\Carbon::createFromTimeString($scheduler->published_at)->format('d-M-Y\ h:i A')}}--}}
{{--                                        </td>--}}
{{--                                        <td >--}}
{{--                                            @if($scheduler->send_status == "Sended")--}}
{{--                                                <div class="badge badge-primary text-light p-1">Sended</div>--}}
{{--                                            @else--}}
{{--                                                <div class="badge badge-danger text-light p-1">Not Sended</div>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}

                                        <td>
                                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
{{--                                                <a  href="{{$}}"   class="btn btn-sm btn-primary edit-button" >Edit</a>--}}
                                                {{--                                            <a href="{{Route('campaign-published', $campaign->id)}}"><button type="submit" class="btn btn-sm btn-success ">Published</button></a>--}}
                                                <a href="{{Route('delete-scheduler', $scheduler->id)}}"><button type="submit" class="btn btn-sm btn-danger DeleteBtn">Delete</button></a>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('js_after')

    <script>

        $(document).ready(function() {

        });

    </script>
@endsection
