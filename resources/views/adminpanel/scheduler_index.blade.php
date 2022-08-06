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
                    <form id="save-scheduler" action="{{route('scheduler-save')}}" enctype="multipart/form-data" method="POST">
                        @sessionToken
                        <div class="card-header d-flex justify-content-between align-items-center bg-white pb-1">
                            <h5>Scheduler Import via URL</h5>
                        </div>
                        <div class="card-body">
                            <input hidden type="number" name="user_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="#">Name:</label>
                                        <input required placeholder="Scheduler Name" value=""  name="name" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="#">URL Access Details:</label>
                                        <input required name="file_path" placeholder="https://example.com/import/products.csv" type="text" class="form-control csv-url">
                                    </div>
                                    <div class="form-group">
                                        <label for="#">Frequency</label>
                                        <select name="frequency" class="form-control">
                                            <option value="only_one_time">Only One Time</option>
                                            <option selected value="daily">Daily</option>
                                            <option  value="weekly">Weekly</option>
                                            <option  value="monthly">Monthly</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="ml-2">Active</label>
                                        <input type="checkbox" name="active" value="active" checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <a href="{{route('home')}}"  class="btn btn-white mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <div class="d-flex align-items-center">
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
            $('form#save-scheduler').submit(function (e) {
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
