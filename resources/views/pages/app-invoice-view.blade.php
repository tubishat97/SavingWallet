{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','App Invoice View' )

{{-- page styles --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
<!-- app invoice View Page -->
<section class="invoice-view-wrapper section">
  <div class="row">
    <!-- invoice view page -->
    <div class="col xl9 m8 s12">
      <div class="card">
        <div class="card-content invoice-print-area">
          <!-- header section -->
          <div class="row invoice-date-number">
            <div class="col xl4 s12">
              <span class="invoice-number mr-1">Invoice#</span>
              <span>000756</span>
            </div>
            <div class="col xl8 s12">
              <div class="invoice-date display-flex align-items-center flex-wrap">
                <div class="mr-3">
                  <small>Date Issue:</small>
                  <span>08/10/2019</span>
                </div>
                <div>
                  <small>Date Due:</small>
                  <span>08/10/2019</span>
                </div>
              </div>
            </div>
          </div>
          <!-- logo and title -->
          <div class="row mt-3 invoice-logo-title">
            <div class="col m6 s12 display-flex invoice-logo mt-1 push-m6">
              <img src="{{asset('images/gallery/pixinvent-logo.png')}}" alt="logo" height="46" width="164">
            </div>
            <div class="col m6 s12 pull-m6">
              <h4 class="indigo-text">Invoice</h4>
              <span>Software Development</span>
            </div>
          </div>
          <div class="divider mb-3 mt-3"></div>
          <!-- invoice address and contact -->
          <div class="row invoice-info">
            <div class="col m6 s12">
              <h6 class="invoice-from">Bill From</h6>
              <div class="invoice-address">
                <span>Clevision PVT. LTD.</span>
              </div>
              <div class="invoice-address">
                <span>9205 Whitemarsh Street New York, NY 10002</span>
              </div>
              <div class="invoice-address">
                <span>hello@clevision.net</span>
              </div>
              <div class="invoice-address">
                <span>601-678-8022</span>
              </div>
            </div>
            <div class="col m6 s12">
              <div class="divider show-on-small hide-on-med-and-up mb-3"></div>
              <h6 class="invoice-to">Bill To</h6>
              <div class="invoice-address">
                <span>Pixinvent PVT. LTD.</span>
              </div>
              <div class="invoice-address">
                <span>203 Sussex St. Suite B Waukegan, IL 60085</span>
              </div>
              <div class="invoice-address">
                <span>pixinvent@gmail.com</span>
              </div>
              <div class="invoice-address">
                <span>987-352-5603</span>
              </div>
            </div>
          </div>
          <div class="divider mb-3 mt-3"></div>
          <!-- product details table-->
          <div class="invoice-product-details">
            <table class="striped responsive-table">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Description</th>
                  <th>Cost</th>
                  <th>Qty</th>
                  <th class="right-align">Price</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Frest Admin</td>
                  <td>HTML Admin Template</td>
                  <td>28</td>
                  <td>1</td>
                  <td class="indigo-text right-align">$28.00</td>
                </tr>
                <tr>
                  <td>Apex Admin</td>
                  <td>Anguler Admin Template</td>
                  <td>24</td>
                  <td>1</td>
                  <td class="indigo-text right-align">$24.00</td>
                </tr>
                <tr>
                  <td>Stack Admin</td>
                  <td>HTML Admin Template</td>
                  <td>24</td>
                  <td>1</td>
                  <td class="indigo-text right-align">$24.00</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- invoice subtotal -->
          <div class="divider mt-3 mb-3"></div>
          <div class="invoice-subtotal">
            <div class="row">
              <div class="col m5 s12">
                <p>Thanks for your business.</p>
              </div>
              <div class="col xl4 m7 s12 offset-xl3">
                <ul>
                  <li class="display-flex justify-content-between">
                    <span class="invoice-subtotal-title">Subtotal</span>
                    <h6 class="invoice-subtotal-value">$72.00</h6>
                  </li>
                  <li class="display-flex justify-content-between">
                    <span class="invoice-subtotal-title">Discount</span>
                    <h6 class="invoice-subtotal-value">- $ 09.60</h6>
                  </li>
                  <li class="display-flex justify-content-between">
                    <span class="invoice-subtotal-title">Tax</span>
                    <h6 class="invoice-subtotal-value">21%</h6>
                  </li>
                  <li class="divider mt-2 mb-2"></li>
                  <li class="display-flex justify-content-between">
                    <span class="invoice-subtotal-title">Invoice Total</span>
                    <h6 class="invoice-subtotal-value">$ 61.40</h6>
                  </li>
                  <li class="display-flex justify-content-between">
                    <span class="invoice-subtotal-title">Paid to date</span>
                    <h6 class="invoice-subtotal-value">- $ 00.00</h6>
                  </li>
                  <li class="display-flex justify-content-between">
                    <span class="invoice-subtotal-title">Balance (USD)</span>
                    <h6 class="invoice-subtotal-value">$ 10,953</h6>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- invoice action  -->
    <div class="col xl3 m4 s12">
      <div class="card invoice-action-wrapper">
        <div class="card-content">
          <div class="invoice-action-btn">
            <a href="#"
              class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">
              <i class="material-icons mr-4">check</i>
              <span class="text-nowrap">Send Invoice</span>
            </a>
          </div>
          <div class="invoice-action-btn">
            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light invoice-print">
              <span>Print</span>
            </a>
          </div>
          <div class="invoice-action-btn">
            <a href="{{asset('app-invoice-edit')}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
              <span>Edit Invoice</span>
            </a>
          </div>
          <div class="invoice-action-btn">
            <a href="#" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
              <i class="material-icons mr-3">attach_money</i>
              <span class="text-nowrap">Add Payment</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/app-invoice.js')}}"></script>
@endsection