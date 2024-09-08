{{-- Extend the master layout --}}
@extends('layouts.contentLayoutMaster')

{{-- Page Title --}}
@section('title', 'Add Order')

{{-- Page Styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-invoice.css') }}">
@endsection

@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/icon.css')}}">
@endsection


{{-- Page Content --}}
@section('content')
    <section class="invoice-edit-wrapper section">
        <div class="row">
            <!-- Invoice form starts -->
            <div class="col xl9 m8 s12">
                <div class="card">
                    <div class="card-content px-36">
                        <!-- Invoice form -->
                        <form action="{{ route('admin.order.store') }}" method="POST" class="form invoice-item-repeater">
                            @csrf
                            <!-- Header section -->
                            <!-- Logo and title -->
                            <div class="row mb-3">
                                <div class="col m6 s12 invoice-logo display-flex pt-1 push-m6">
                                    <img src="{{ asset('images/gallery/spare-parts.png') }}"
                                        style="height: 100% !important;" alt="logo" height="46" width="164" />
                                </div>
                                <div class="col m6 s12 pull-m6">
                                    <h4 class="indigo-text">Invoice</h4>
                                </div>
                            </div>
                            <!-- Invoice address and contact -->
                            <div class="row mb-3">
                                <div class="col l6 s12">
                                    <h6>Customer</h6>
                                    <div class="input-field">
                                        <input type="text" name="cname" placeholder="Name" required>
                                    </div>
                                    <div class="input-field">
                                        <input type="text" name="c_mobile_number" placeholder="Mobile">
                                    </div>
                                </div>
                            </div>
                            <!-- Product details table -->
                            <div class="invoice-product-details mb-3">
                                <div data-repeater-list="items">
                                    <div class="mb-2" data-repeater-item>
                                        <!-- Invoice Titles -->
                                        <div class="row mb-1">
                                            <div class="col s3 m6">
                                              <h6 class="m-0">Item</h6>
                                            </div>
                                            <div class="col s3">
                                              <h6 class="m-0">Cost</h6>
                                            </div>
                                            <div class="col s3">
                                              <h6 class="m-0">Qty</h6>
                                            </div>
                                          </div>
                                        <div class="invoice-item display-flex mb-1">
                                            <div class="invoice-item-filed row pt-1">
                                                <div class="col s12 m6 input-field">
                                                    <select name="product" id="product">

                                                        @foreach ($products as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                               
                                                <div class="col m3 s12 input-field">
                                                    <input type="number" name="cost" placeholder="JOD" required>
                                                </div>
                                                <div class="col m3 s12 input-field">
                                                    <input type="number" name="quantity" placeholder="0" required>
                                                </div>
                                            </div>
                                            <div class="invoice-icon display-flex flex-column justify-content-between">
                                                <span data-repeater-delete class="delete-row-btn">
                                                    <i class="material-icons">clear</i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-field">
                                    <button class="btn invoice-repeat-btn" data-repeater-create type="button">
                                        <i class="material-icons left">add</i>
                                        <span>Add Item</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Invoice subtotal -->
                            <div class="invoice-subtotal">
                                <div class="row">
                                    <div class="col m5 s12">
                                    </div>
                                    <div class="col xl4 m7 s12 offset-xl3">
                                        <ul>
                                        
                                            <li class="mt-2">
                                                <button type="submit" class="btn btn-block waves-effect waves-light">Save
                                                    Invoice</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Invoice action -->
            <div class="col xl3 m4 s12">
                <div class="card invoice-action-wrapper mb-10">
                    <div class="card-content">
                        <div class="invoice-payment-option mb-3">
                            <p class="mb-0">Accept payments via</p>
                            <select name="payment_option" id="paymentOption">
                                <option value="Cash">Cash</option>
                                {{-- <option value="Credit Card">Credit Card</option>
                                <option value="Cliq Transfer">Cliq Transfer</option> --}}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- Vendor Scripts --}}
@section('vendor-script')
    <script src="{{ asset('vendors/form_repeater/jquery.repeater.min.js') }}"></script>
@endsection

{{-- Page Scripts --}}
@section('page-script')
    <script src="{{ asset('js/scripts/app-invoice.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the form repeater
            $('.invoice-item-repeater').repeater({
                show: function() {
                    $(this).slideDown(); // Animation effect for adding new item
                    initializeSelect(); // Reinitialize select elements
                },
                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement); // Animation effect for removing item
                    calculateTotals();
                }
            });

            initializeSelect(); // Initialize select on page load

            function initializeSelect() {
                $('select').formSelect(); // Initialize Materialize select
            }
        });
    </script>
@endsection
