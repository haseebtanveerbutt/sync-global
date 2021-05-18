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
                <div class="card">
                    <form id="" action="{{route('import-via-url')}}" enctype="multipart/form-data" method="POST">
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
                                        <input required name="import_via_url" placeholder="https://example.com/import/products.csv" type="text" class="form-control">
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

        });

    </script>
@endsection
