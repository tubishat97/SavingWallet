{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', __('Increment quantity'))

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
@endsection

@section('content')
    <div class="section">
        <div class="row">
            <div class="col s12">
                <div id="html-validations" class="card card-tabs">
                    <div class="card-content">
                        <div class="card-title">
                            <div class="row">
                                <div class="col s12 m6 l10">
                                    <h4 class="card-title">{{ __('Increment quantity [ ') . $product->name . " ]"  }}</h4>
                                </div>
                                <div class="col s12 m6 l2">
                                </div>
                            </div>
                        </div>
                        <div id="html-view-validations">
                            <form id="addform" class="forms-sample" method="POST"
                                action="{{ route('admin.product.increment-qty', $product->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="number" name="quantity" id="quantity"
                                            value="" class="validate" required />
                                        <label for="quantity">{{ __('Quantity') }}*</label>
                                    </div>
                                    <button class="btn cyan waves-effect waves-light right" type="submit"
                                        name="action">{{ __('submit') }}
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
{{-- vendor script --}}
@section('vendor-script')
    <script src="{{ asset('vendors/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>

@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/form-file-uploads.js') }}"></script>
    <script src="{{ asset('js/scripts/form-validation.js') }}"></script>
@endsection
