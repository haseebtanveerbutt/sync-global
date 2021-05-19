@extends('adminpanel.layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <!-- start info box -->
        <div class="row ">

            <div class="col-md-6 m-auto ">
                @if (count($errors) > 0)
                    <div class = "alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card csv-form-main">
                    <div class="csv-error-msg"></div>
                    <form id="edit-scheduler" action="{{route('edit-scheduler-save',$scheduler_data->id)}}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="card-header d-flex justify-content-between align-items-center bg-white pb-1">
                            <h5>Scheduler Import via URL</h5>
                        </div>
                        <div class="card-body">
                            <input hidden type="number" name="user_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="#">Name:</label>
                                        <input required placeholder="Scheduler Name" value="{{$scheduler_data->name}}"  name="name" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="#">URL Access Details:</label>
                                        <input required name="file_path" value="{{$scheduler_data->file_path}}"  placeholder="https://example.com/import/products.csv" type="text" class="form-control csv-url">
                                    </div>
                                    <div class="form-group">
                                        <label for="#">Frequency</label>
                                        <select name="frequency" class="form-control">

                                            <option @if($scheduler_data->frequency == 'only_one_time') selected @endif value="only_one_time">Only One Time</option>
                                            <option @if($scheduler_data->frequency == 'daily') selected @endif value="daily">Daily</option>
                                            <option @if($scheduler_data->frequency == 'weekly') selected @endif value="weekly">Weekly</option>
                                            <option @if($scheduler_data->frequency == 'monthly') selected @endif value="monthly">Monthly</option>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label class="ml-2">Active</label>
                                        <input type="checkbox" name="active" value="active" @if($scheduler_data->active == 'active') checked @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <a href="{{route('user-dashboard')}}"  class="btn btn-white mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <div class="d-flex align-items-center ">
                                        <span class="loader-span mr-2">
                                            <div class="loader"></div>
                                        </span>
                                        <div>Next</div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>

@endsection
@section('js_after')

    <script>

        $(document).ready(function() {
            $("button .loader-span").find(".loader").css('display', 'none')
            $('form#edit-scheduler').submit(function (e) {
                var csv_url = $('.csv-url').val();
                var csv_file_check = csv_url.endsWith('.csv');
                if(csv_file_check == false){
                    $('.csv-form-main .csv-error-msg').html(`<div style="padding: 5px 10px;" class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> File type must be 'CSV'.<a href="#"  class="close" data-dismiss="alert" onclick="$(this).parent().hide();" aria-label="close">&times;</a></div>`)
                    $("button .loader-span").find(".loader").css('display', 'none')
                    e.preventDefault();
                }
                $("button .loader-span").find(".loader").css('display', 'block');
            });



        });

    </script>
@endsection
