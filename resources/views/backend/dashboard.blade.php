@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Dashboard Ecommerce')

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/dashboard.css') }}">
@endsection

{{-- page content --}}
@section('content')
    <div class="section">
        <!--card stats start-->
        <div id="card-stats" class="pt-0">
            <div class="row">
                <!-- Today's Profit Card -->
                <div class="col s12 m6 l4 xl4">
                    <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text animate fadeRight">
                        <div class="padding-4">
                            <div class="row">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">today</i>
                                    <p>Today's Sales</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h5 class="mb-0 white-text">{{ $todayProfit }} JOD</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- This Month's Profit Card -->
                <div class="col s12 m6 l4 xl4">
                    <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
                        <div class="padding-4">
                            <div class="row">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">date_range</i>
                                    <p>This Month's Sales</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h5 class="mb-0 white-text">{{ $thisMonthProfit }} JOD</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Last Month's Profit Card -->
                <div class="col s12 m6 l4 xl4">
                    <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeRight">
                        <div class="padding-4">
                            <div class="row">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">local_car_wash</i>
                                    <p>Last Month's Sales</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h5 class="mb-0 white-text">{{ $lastMonthProfit }} JOD</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--
            <!-- Last 4 Months' Profit Card -->
             <div class="col s12 m6 l4 xl4">
                <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">bar_chart</i>
                                <p>Last 4 Months' Profit</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">${{ $lastFourMonthsProfit }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- This Year's Profit Card -->
            <div class="col s12 m6 l4 xl4">
                <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">bar_chart</i>
                                <p>This Year's Profit</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">${{ $thisYearProfit }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

        <!-- Last Year's Profit Card -->
        <div class="col s12 m6 l4 xl4">
            <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
                <div class="padding-4">
                    <div class="row">
                        <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">trending_up</i>
                            <p>Last Year's Profit</p>
                        </div>
                        <div class="col s5 m5 right-align">
                            <h5 class="mb-0 white-text">${{ $lastYearProfit }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
                <!--card stats end-->

                <!-- Orders and Products Chart Start -->
                <div id="orders-products-chart">
                    <div class="row">
                        <div class="col s12 m12 l8">
                            <div id="recent-orders-chart" class="card animate fadeUp">
                                <div class="card-content">
                                    <h4 class="header mt-0">Recent Orders</h4>
                                    <table class="highlight">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentOrders as $order)
                                                <tr>
                                                    <td>{{ $order->name }}</td>
                                                    <td>{{ $order->price }} JOD</td>
                                                    <td>{{ $order->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col s12 m12 l4">
                            <div id="top-products-chart" class="card animate fadeUp">
                                <div class="card-content">
                                    <h4 class="header mt-0">Top Products</h4>
                                    <canvas id="topProducts" height="350"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Orders and Products Chart End -->
            </div>
        @endsection

        {{-- vendor script --}}
        @section('vendor-script')
            <script src="{{ asset('vendors/chartjs/chart.min.js') }}"></script>
        @endsection

        @section('page-script')
            <script>
                (function(window, document, $) {
                    // Top Products Chart
                    var topProductsCtx = document.getElementById("topProducts").getContext("2d");
                    var topProductsData = @json($topProducts);

                    // Generate an array of colors for each bar
                    var colors = Object.keys(topProductsData).map(() => {
                        // You can use a predefined set of colors or generate random colors
                        return '#' + Math.floor(Math.random() * 16777215).toString(16); // Generates a random color
                    });

                    var topProductsChart = new Chart(topProductsCtx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(topProductsData),
                            datasets: [{
                                label: 'Quantity Sold',
                                data: Object.values(topProductsData),
                                backgroundColor: colors, // Use the array of colors
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                })(window, document, jQuery);
            </script>
        @endsection
