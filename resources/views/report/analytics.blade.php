@extends('layouts.master-layouts')
@section('title'){{ __('Analytics Report') }}@endsection
@section('body')

<body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Analytics @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_3') Analytics @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __('translation.total-revenue') }}</p>
                                        <h4 class="mb-0">Rp {{ number_format($data['revenue'], 0) }}</h4>
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-dollar font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __("translation.total-invoices") }}</p>
                                        <h4 class="mb-0">{{ $data['total_invoices'] }}</h4>
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary" style="background-color: #e3b707 !important">
                                            <i class="bx bx-file  font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('translation.monthly-invoices-revenue') }}</h4>
                        <div id="monthly_invoices_revenue" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('script')
        <!-- Plugin Js-->
        <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script>
            function monthlyInvoicesRevenue() {
                var total_invoice = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                var total_revenue = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

                $.ajax({
                    type: 'GET',
                    url: 'getMonthlyInvoicesRevenue',
                    dataType: 'json',
                    success: function(data) {
                        var i;
                        for (i = 0; i < 12; i++) {
                            if (data.total_invoice[i] !== undefined) {
                                // data.total_customer;
                                total_invoice.splice(data.total_invoice[i].Month - 1, 1, data.total_invoice[i].total_invoice);
                            }

                            if (data.total_revenue[i] !== undefined) {
                                total_revenue.splice(data.total_revenue[i].Month - 1, 1, data.total_revenue[i].total_revenue);
                            }
                        }
                        var options = {
                            theme: {
                                palette: 'palette3' // upto palette10
                            },
                            series: [{
                                name: 'Invoice',
                                type: 'column',
                                data: total_invoice
                            }, {
                                name: 'Revenue',
                                type: 'line',
                                data: total_revenue
                            }],
                            chart: {
                                height: 350,
                                type: 'line'
                            },
                            markers: {
                                size: 5,
                            },
                            stroke: {
                                width: [0, 4]
                            },
                            //labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            xaxis: {
                                //type: 'datetime'
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                            },
                            yaxis: [{
                                title: {
                                    text: '# of invoice',
                                },
                                tickAmount: 1
                            }, {
                                opposite: true,
                                title: {
                                    text: '# of revenue'
                                },
                                labels: {
                                    formatter: function(val, index) {
                                        return "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    }
                                }
                            }]
                        };
                        var monthly_user_chart = new ApexCharts(document.querySelector("#monthly_invoices_revenue"), options);
                        monthly_user_chart.render();
                    },
                    error: function(data) {
                        console.log('oops! Something Went Wrong!!!');
                    }
                });
            }

            function yearlyInvoicesRevenue() {
                var total_invoice = [];
                var total_revenue = [];
                var categories = []
                $.ajax({
                    type: 'GET',
                    url: 'getYearlyInvoicesRevenue',
                    dataType: 'json',
                    success: function(data) {
                        var i;
                        for (i = 0; i < data.total_invoice.length; i++) {
                            if (data.total_invoice[i] !== undefined) {
                                total_invoice.push(data.total_invoice[i].total_invoice);
                            }

                            if (data.total_revenue[i] !== undefined) {
                                total_revenue.push(data.total_revenue[i].total_revenue);
                            }

                            categories.push(data.total_invoice[i].year)
                        }
                        var options = {
                            chart: {
                                type: "line",
                                stacked: false
                            },
                            dataLabels: {
                                enabled: false
                            },
                            theme: {
                                palette: 'palette2' // upto palette10
                            },
                            series: [

                                {
                                    name: 'Column A',
                                    type: 'column',
                                    data: [21.1, 23]
                                },
                                {
                                    name: "Line C",
                                    type: 'line',
                                    data: [1.4, 2]
                                },
                            ],
                            markers: {
                                size: 5,
                            },
                            xaxis: {
                                categories: [2009]
                            },
                            yaxis: [{
                                    seriesName: 'Column A',
                                    axisTicks: {
                                        show: true
                                    },
                                    axisBorder: {
                                        show: true,
                                    },
                                    title: {
                                        text: "Columns"
                                    }
                                }, {
                                    opposite: true,
                                    seriesName: 'Line C',
                                    axisTicks: {
                                        show: true
                                    },
                                    axisBorder: {
                                        show: true,
                                    },
                                    title: {
                                        text: "Line"
                                    }
                                }
                            ],
                            legend: {
                                horizontalAlign: "center"
                            }
                        };
                        var yearly_invoices_revenue = new ApexCharts(document.querySelector("#yearly_invoices_revenue"), options);
                        yearly_invoices_revenue.render();
                    },
                    error: function(data) {
                        console.log('oops! Something Went Wrong!!!');
                    }
                });
            }

            function monthlyEarnings() {
                $.ajax({

                    type: 'GET',
                    url: 'getMonthlyEarning',
                    dataType: 'json',
                    success: function(data) {

                        //console.log(data);

                        var options = {
                            chart: {
                                height: 150,
                                type: 'radialBar',
                                offsetY: -10
                            },
                            plotOptions: {
                                radialBar: {
                                    startAngle: -135,
                                    endAngle: 135,
                                    dataLabels: {
                                        name: {
                                            fontSize: '13px',
                                            color: undefined,
                                            offsetY: 60
                                        },
                                        value: {
                                            offsetY: 22,
                                            fontSize: '16px',
                                            color: undefined,
                                            formatter: function formatter(val) {
                                                return val + "%";
                                            }
                                        }
                                    }
                                }
                            },
                            colors: ['#e0b402'],
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    shadeIntensity: 0.15,
                                    inverseColors: false,
                                    opacityFrom: 1,
                                    opacityTo: 1,
                                    stops: [0, 50, 65, 91]
                                }
                            },
                            stroke: {
                                dashArray: 4
                            },
                            series: [data['diff']],
                            labels: ['Monthly Analytics']
                        };
                        var chart = new ApexCharts(document.querySelector("#radialBar-chart"), options);
                        chart.render();

                    },
                    error: function(data) {
                        console.log('oops! Something Went Wrong!!!');
                    }

                });
            }

            $(document).ready(function() {
                monthlyInvoicesRevenue(); 
                //monthlyEarnings();
                //yearlyInvoicesRevenue();
            });
        </script>

       
    @endsection
