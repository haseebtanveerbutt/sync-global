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
                    <form id="" action="{{route('scheduler-save')}}" enctype="multipart/form-data" method="POST">
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
                                        <input required placeholder="Scheduler Name" value=""  name="name" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="#">URL Access Details:</label>
                                        <input required name="file_path" placeholder="https://example.com/import/products.csv" type="text" class="form-control">
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
