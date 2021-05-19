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
                    <form  class="save-scheduler" action="{{route('import-via-url')}}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="card-header d-flex justify-content-between align-items-center bg-white pb-1">
                            <h5>Import via URL</h5>
                        </div>
                        <div class="card-body">
                            {{--                        @dd($user_shop_data)--}}
                            <input hidden type="number" name="user_id" value="">
                            <div class="row">
                                <div class="col-md-12">
{{--                                    <div class="form-group">--}}
{{--                                        <label for="#">Title</label>--}}
{{--                                        <input required placeholder="My Data Feed" value=""  name="title" type="text" class="form-control">--}}
{{--                                    </div>--}}
                                    <div class="form-group">
                                        <label for="#">URL Access Details</label>
                                        <input required name="import_via_url" placeholder="https://example.com/import/products.csv" type="text" class="form-control csv-url">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <a href="{{route('user-dashboard')}}"  class="btn btn-white mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-lg">Next</button>
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
            $('form.save-scheduler').submit(function (e) {
                var csv_url = $('.csv-url').val();

                var csv_file_check = csv_url.endsWith('.csv');
                if(csv_file_check == false){
                    $('.csv-form-main .csv-error-msg').html(`<div style="padding: 5px 10px;" class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> File type must be 'CSV'.<a href="#"  class="close" data-dismiss="alert" onclick="$(this).parent().hide();" aria-label="close">&times;</a></div>`)
                    e.preventDefault();
                }
            });
        });

    </script>
@endsection
