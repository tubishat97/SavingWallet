{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'History')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
@endsection

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@endsection

@section('content')
    <div class="section section-data-tables">
        <div class="row">
            <div class="col xl12 m12 s12">
                <div class="card">
                    <div class="card-content px-36">
                        <!-- header section -->
                        <div class="row mb-3">
                            <form method="get" action="">
                                <div class="col s12 m4 l4">
                                    <label for="">Start Date</label>
                                    <input type="date" class="validate" id="start_id"
                                        value="{{ Request::get('start_date') ?? '' }}" name="start_date">
                                </div>
                                <div class="col s12 m4 l4">
                                    <label for="">End Date</label>
                                    <input type="date" class="validate" id="start_id"
                                        value="{{ Request::get('end_date') ?? '' }}" name="end_date">
                                </div>
                                <div class="col s12 m4 l4">
                                    <label for="">Product</label>
                                    <select name="product" class="form-control">
                                        <option value=""></option>
                                        @foreach($products as $product)
                                        <option @if(Request::get('product')== $product->id ) selected @endif
                                            value="{{$product->id}} ">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="col xl4 m12 display-flex align-items-center">
                            <div class="form-row">
                                <div class="col xl12 sm12 m12">
                                    <button type="submit" class="btn btn-md btn-outline-dark btn-loading">
                                        Filter
                                    </button>
                                    <a class="btn btn-outline-danger btn-loading" href="{{ route('admin.product.log') }}">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l12">
                <div id="button-trigger" class="card card card-default scrollspy">
                    <div class="card-content">
                        <h4 class="card-title">{{ __('List') }}</h4>
                        <div class="row">
                            <div class="col s12">
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>{{ __('#') }}</th>
                                            <th>{{ __('Product Name') }}</th>
                                            <th>{{ __('Quantity Before Change') }}</th>
                                            <th>{{ __('Quantity Change') }}</th>
                                            <th>{{ __('Quantity After Change') }}</th>
                                            <th>{{ __('Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logs as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->product->name }}</td>
                                                <td>
                                                    <span class="chip lighten-2 yellow white-text">{{ $item->quantity_before_change }}</span>
                                                </td>
                                                <td>
                                                    @if ($item->operation == 'increment')
                                                        <span
                                                            class="chip lighten-2 green white-text">+{{ $item->quantity_change }}</span>
                                                    @endif

                                                    @if ($item->operation == 'decrement')
                                                        <span
                                                            class="chip lighten-2 red white-text">{{ $item->quantity_change }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="chip lighten-2 blue white-text">{{ $item->quantity_after_change }}</span>
                                                </td>
                                                <td>
                                                    {{ $item->created_at }}
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
    </div>
    <div id="modalDelete" class="modal">
        <div class="modal-content">
            <h4>{{ __('Delete') }}</h4>
            <p>{{ __('Are you sure you need to delete this') }} ?</p>
        </div>
        <div class="modal-footer">
            <form id="frm_confirm_delete" action="#" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" value="" name="id" id="item_id">
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancel</a>
                <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>
@endsection
{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{ asset('js/scripts/data-tables.js') }}"></script>
    <script src="{{ asset('js/scripts/advance-ui-modals.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script>
        function setRoute($id, $route) {
            $('#item_id').val($id);
            $('#frm_confirm_delete').attr('action', $route);
        }
    </script>
@endsection
