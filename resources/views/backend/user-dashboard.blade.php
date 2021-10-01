{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Dashboard Ecommerce')

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section">
    <!--card stats start-->
    <div id="card-stats" class="pt-0">
        <div class="row">
            <div class="col s12 m6 l6 xl4">
                <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text animate fadeRight">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">attach_money</i>
                                <p>Wallet Balance</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">${{ $user->wallet->amount }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6 xl4">
                <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeLeft">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">trending_up</i>
                                <p>Total of income</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">${{ $user->income->sum('amount') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6 xl4">
                <div
                    class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeRight">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">trending_down</i>
                                <p>Total of expenses</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">${{ $user->expenses->sum('amount') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--card stats end-->
    <!--yearly & weekly revenue chart start-->
    <div id="sales-chart">
        <div class="row">
            <div class="col s12">
                <div id="revenue-chart" class="card animate fadeUp">
                    <div class="card-content">
                        <h4 class="header mt-0">
                            Income / Expenses FOR {{ $thisYear }}
                            <span class="purple-text small text-darken-1 ml-1">
                            <a href="{{ route('admin.transaction.index') }}" class="waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow right">Details</a>
                        </h4>
                        <div class="row">
                            <div class="col s12">
                                <div class="yearly-revenue-chart">
                                    <canvas id="thisYearIncome" class="firstShadow" height="350"></canvas>
                                    <canvas id="thisYearExpenses" height="350"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/chartjs/chart.min.js')}}"></script>
@endsection

@section('page-script')
<script>
    (function (window, document, $) {
        var thisYearctx = document
            .getElementById("thisYearIncome")
            .getContext("2d");
        var lastYearctx = document
            .getElementById("thisYearExpenses")
            .getContext("2d");

        Chart.defaults.LineAlt = Chart.defaults.line;
        var draw =
            Chart.controllers.line.prototype.draw;
        var custom = Chart.controllers.line.extend({
            draw: function () {
                draw.apply(this, arguments);
                var ctx = this.chart.chart.ctx;
                var _stroke = ctx.stroke;
                ctx.stroke = function () {
                    ctx.save();
                    ctx.shadowColor =
                        "rgba(156, 46, 157,0.5)";
                    ctx.shadowBlur = 20;
                    ctx.shadowOffsetX = 2;
                    ctx.shadowOffsetY = 20;
                    _stroke.apply(this, arguments);
                    ctx.restore();
                };
            }
        });
        Chart.controllers.LineAlt = custom;

        Chart.defaults.LineAlt2 =
            Chart.defaults.line;
        var draw =
            Chart.controllers.line.prototype.draw;
        var custom = Chart.controllers.line.extend({
            draw: function () {
                draw.apply(this, arguments);
                var ctx = this.chart.chart.ctx;
                var _stroke = ctx.stroke;
                ctx.stroke = function () {
                    ctx.save();
                    _stroke.apply(this, arguments);
                    ctx.restore();
                };
            }
        });

        Chart.controllers.LineAlt2 = custom;

        var thisYearIncomeData = @json($thisYearIncome);
        var thisYearExpensesData = @json($thisYearExpenses);

        var thisYearData = {
            labels: Object.keys(thisYearIncomeData),
            datasets: [
                {
                    label: "Income",
                    data: Object.values(thisYearIncomeData),
                    fill: false,
                    pointRadius: 2.2,
                    pointBorderWidth: 1,
                    borderColor: "#9C2E9D",
                    borderWidth: 5,
                    pointBorderColor: "#9C2E9D",
                    pointHighlightFill: "#9C2E9D",
                    pointHoverBackgroundColor:
                        "#9C2E9D",
                    pointHoverBorderWidth: 2
                }
            ]
        };

        var lastYearData = {
            labels: Object.keys(thisYearExpensesData),
            datasets: [
                {
                    label: "Expenses",
                    data: Object.values(thisYearExpensesData),
                    borderDash: [15, 5],
                    fill: false,
                    pointRadius: 0,
                    pointBorderWidth: 0,
                    borderColor: "#E4E4E4",
                    borderWidth: 5
                }
            ]
        };

        var incomeOption = {
            responsive: true,
            maintainAspectRatio: true,
            datasetStrokeWidth: 3,
            pointDotStrokeWidth: 4,
            tooltipFillColor: "rgba(0,0,0,0.6)",
            legend: {
                display: false,
                position: "bottom"
            },
            hover: {
                mode: "label"
            },
            scales: {
                xAxes: [
                    {
                        display: false
                    }
                ],
                yAxes: [
                    {
                        ticks: {
                            padding: 20,
                            stepSize: 10,
                            max: 100,
                            min: 0,
                            fontColor: "#9e9e9e"
                        },
                        gridLines: {
                            display: true,
                            drawBorder: false,
                            lineWidth: 1,
                            zeroLineColor: "#e5e5e5"
                        }
                    }
                ]
            },
            title: {
                display: false,
                fontColor: "#FFF",
                fullWidth: false,
                fontSize: 40,
                text: "82%"
            }
        };

        var expensesOption = {
            responsive: true,
            maintainAspectRatio: true,
            datasetStrokeWidth: 3,
            pointDotStrokeWidth: 4,
            tooltipFillColor: "rgba(0,0,0,0.6)",
            legend: {
                display: false,
                position: "bottom"
            },
            hover: {
                mode: "label"
            },
            scales: {
                xAxes: [
                    {
                        display: false
                    }
                ],
                yAxes: [
                    {
                        ticks: {
                            padding: 20,
                            stepSize: 10,
                            max: 100,
                            min: 0
                        },
                        gridLines: {
                            display: true,
                            drawBorder: false,
                            lineWidth: 1
                        }
                    }
                ]
            },
            title: {
                display: false,
                fontColor: "#FFF",
                fullWidth: false,
                fontSize: 40,
                text: "82%"
            }
        };

        var thisYearChart = new Chart(thisYearctx, {
            type: "LineAlt",
            data: thisYearData,
            options: incomeOption
        });

        var lastYearChart = new Chart(lastYearctx, {
            type: "LineAlt2",
            data: lastYearData,
            options: expensesOption
        });
    })(window, document, jQuery);
</script>
@endsection