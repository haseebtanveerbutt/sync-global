@extends('adminpanel.layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <!-- start info box -->

        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex col-md-6 m-auto">
                <div class="row">
                    <div class="col-sm-12 col-md-12" style="padding: 0px 8px !important;">
                        <div class="alert-message alert-message-warning column-mapping-req-msg">
                            <a href="#"  class="close" data-dismiss="alert" onclick="$(this).parent().hide();" aria-label="close">&times;</a>
                            <h4><i class="fas fa-exclamation-circle"></i> Columns mapping required</h4>
                            <p>
                                Please go to Map Columns tab and help the app to match columns from your CSV to products attributes in your store.
                                At least <strong>title or sku</strong> mapping is required for app to work.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center ">
            <div class="d-flex col-md-6 m-auto" id="print-button-main ">
                <div class="row">
                    <div class="col-sm-12 col-md-12" style="padding: 0px 8px !important;">
                        <div class="alert-message alert-message-primary mapping-alert-msg">
                            <a href="#"  class="close" data-dismiss="alert" onclick="$(this).parent().hide();" aria-label="close">&times;</a>
                            <h4><i class="fas fa-exclamation-circle"></i>Mapping SKU without Title</h4>
                            <p>
                                Mapping SKU without Title will not work if it is the very first import. SKU without Title will only
                                update items previously imported via Moose Sync.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--        <div class="d-flex justify-content-between align-items-center">--}}
        {{--            <div class="d-flex col-md-6 m-auto">--}}
        {{--                <div class="row" style="    width: 104%;">--}}
        {{--                    <div class="col-sm-12 col-md-12 w-100" style="padding: 0px 8px !important;">--}}
        {{--                        <div style="width: 100%" class="alert-message alert-message-warning run-mapped-sku">--}}
        {{--                            <a href="#"  class="close" data-dismiss="alert" onclick="$(this).parent().hide();" aria-label="close">&times;</a>--}}
        {{--                            <h4 ><i class="fas fa-exclamation-circle"></i> Ready for import</h4>--}}
        {{--                            <p>--}}
        {{--                                Now we need to upload the file to inspect its contents.--}}
        {{--                            </p>--}}
        {{--                            <div class="d-flex justify-content-start">--}}
        {{--                                <button type="submit" class="btn btn-outline-warning btn-lg">Run Upload File</button>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--        @dd($csv_items)--}}
        <div class="row printableArea">
            <div class="col-md-6 m-auto ">
                <div class="error-msg"></div>
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
                    <form id="csv-mapped-field-form" action="{{route('scheduler-url-mapped-field')}}" method="post">
                        @csrf
                        <input hidden value="{{$user_id}}" name="user_id">
                        <input hidden value="{{$schedule_id}}" name="schedule_id">
                        <input hidden value="{{$file_path}}" name="file_path">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white pb-1">
                            <h5>Mapped Fields</h5>
                        </div>
                        <div class="card-body">
                            {{--                        @dd($user_shop_data)--}}
                            {{--                            <input hidden type="number" name="user_id" value="">--}}
                            <div class="row">
                                <div class="col-md-12 header-main">
                                    @foreach($csv_headers as $key => $csv_header)
                                        <div class="d-flex mb-4 justify-content-between align-items-center suggestion-main-div">
                                            <div class="w-25">
                                                <label for="#">{{$key+(1).'. '.$csv_header}}</label>
                                                <input type="hidden" class="csv-filed" value="{{$csv_header}}" name="mapped_csv_header[]">
                                            </div>
                                            <div class="w-75">
                                                <select name="shopify_fields[]" class="form-control shopify-select shopify-select-div-{{$key}}" aria-invalid="false">
                                                    {{--                                               <option value="metafields_global_title_tag">Metafields global title tag</option><option value="metafields_global_descriptio_tag">Metafields global description tag</option><option value="metafield">Metafield</option><option value="collection">Collection</option><option value="option_name_1">Option name 1</option><option value="option_name_2">Option name 2</option><option value="option_name_3">Option name 3</option>  <option value="template_suffix">Template suffix</option> <option value="variant_metafield">- Variant Metafield</option> --}}
                                                    <option value="" disabled="">Select shopify product attribute...</option><option value="ignore" selected>Ignore</option><option value="description">Description (Body HTML)</option><option value="handle">Handle</option><option value="image">Image</option><option value="multiple_images">Multiple Images</option><option value="product_type">Product type</option><option value="published_scope">Published scope</option><option value="published">Published</option><option value="tags">Tags</option><option value="title">Title</option><option value="vendor">Vendor</option><option value="variant_barcode">- Variant Barcode</option><option value="variant_compare_at_price">- Variant Compare at price</option><option value="variant_fulfillment_service">- Variant Fulfillment service</option><option value="variant_inventory_management">- Variant Inventory management</option><option value="variant_inventory_policy">- Variant Inventory policy</option><option value="variant_inventory_quantity">- Variant Inventory quantity</option><option value="variant_cost_per_item">- Variant - Cost per item</option><option value="variant_option1_value">- Variant Option 1 Value</option><option value="variant_option2_value">- Variant Option 2 Value</option><option value="variant_option3_value">- Variant Option 3 Value</option><option value="variant_position">- Variant Position</option><option value="variant_price">- Variant Price</option><option value="variant_requires_shipping">- Variant Requires shipping</option><option value="variant_sku">- Variant Sku</option><option value="variant_taxable">- Variant Taxable</option><option value="variant_title">- Variant Title</option><option value="variant_weight">- Variant Weight</option><option value="variant_weight_unit">- Variant Weight unit</option>
                                                </select>
                                                <div class="suggestion-div-{{$key}} mt-3">
                                                    <b style="font-size: 14px;">Suggestion:</b>
                                                    <p style="font-size: 14px;color: #5F8DBE;cursor: pointer" class="suggested-option">no-found</p>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <a href="{{route('user-dashboard')}}"  class="btn btn-white mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-lg import-button">
                                    <div class="d-flex align-items-center ">
                                        <span class="loader-span mr-2">
                                            <div class="loader"></div>
                                        </span>
                                        <div>Import</div>
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
            var shopify_select_option = $("select.shopify-select-div-0 option").map(function() {return $(this).val();}).get();
            var csv_filed = $("input.csv-filed").map(function() {return $(this).val();}).get();
            $('.mapping-alert-msg').css('display', 'none');

            // import loader
            $("#csv-mapped-field-form").submit(function () {
                $("button .loader-span").find(".loader").css('display', 'block')
            });
            //            display suggestion fields
            csv_filed.forEach(myFunction);
            function myFunction(item, index) {
                var value = item.toLowerCase();

                shopify_select_option.forEach(myFunction2);
                function myFunction2(item2, index2) {
                    if((item2.toLowerCase().indexOf(value)) > -1){
                        // console.log('a',item2,index)
                        $(`.suggestion-div-${index}`).find('.suggested-option').text(item2)
                    }
                }
            }

            $('.suggested-option').click(function () {
                if(($(this).text()) != 'no-found'){
                    $(this).parent().siblings('select').val($(this).text()).change();
                    $(this).parent().hide()
                }

            });
            //      check for create or update product to store
            $( ".shopify-select" ).change(function() {

                var shopify_select_array =  $(".shopify-select :selected").map(function(i, el) {
                    return $(el).val();
                }).get();
                var check_variant_sku =  $.inArray('variant_sku', shopify_select_array)
                var check_title =  $.inArray('title', shopify_select_array)

                if((check_variant_sku > -1) && (check_title == -1)){
                    $('.mapping-alert-msg').css('display', 'block');
                }else if((check_variant_sku > -1) && (check_title > -1)){
                    $('.mapping-alert-msg').css('display', 'none');
                }
                $(this).next().hide()
            });

            $("#csv-mapped-field-form").submit(function(e){
                var shopify_select_array =  $(".shopify-select :selected").map(function(i, el) {
                    return $(el).val();
                }).get();

                var check_variant_sku =  $.inArray('variant_sku', shopify_select_array)
                var check_title =  $.inArray('title', shopify_select_array)

                if((check_variant_sku > -1) && (check_title > -1) ){

                } else if((check_title > -1) || (check_variant_sku > -1)){
                    if((check_title > -1) && (check_variant_sku == -1)){
                        $('.printableArea').find('.error-msg').html(`<div style="padding: 5px 10px;" class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> To Import new products on store title and sku required must.<a href="#"  class="close" data-dismiss="alert" onclick="$(this).parent().hide();" aria-label="close">&times;</a></div>`)
                        $("button .loader-span").find(".loader").css('display', 'none')
                        e.preventDefault()
                    }else if(check_variant_sku > -1){

                    }
                } else if((check_variant_sku == -1) && (check_title == -1)){
                    $('.printableArea').find('.error-msg').html(`<div style="padding: 5px 10px;" class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> At least title or sku mapping is required for app to work.<a href="#"  class="close" data-dismiss="alert" onclick="$(this).parent().hide();" aria-label="close">&times;</a></div>`)
                    $("button .loader-span").find(".loader").css('display', 'none')
                    e.preventDefault();

                }

            });
        });

    </script>
@endsection



