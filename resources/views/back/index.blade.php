@extends('back.layout.dashboard')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Dashboard')
@section('content')
 <!-- Main body part  -->
<div id="main-content">
    <div class="container-fluid">
        <!-- Page header section  -->
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <h1>Hii, Selamat Datang {{ $profileData->name }} </h1>
                    <span>Dashboard,</span>
                </div>
            </div>
        </div>
        <div class="row clearfix row-deck">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Grafik Rekomendasi</h2>
                        <small class="text-muted">Jumlah hasil rekomendasi per hari.</small>
                        <ul class="header-dropdown dropdown">
                            <li><a href="javascript:void(0);" class="full-screen"><i class="fa fa-expand"></i></a></li>
                        </ul>
                    </div>
                    <div class="card-body" style="height: 400px;">
                        <canvas id="recommendationChart"></canvas>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const recommendationData = {!! json_encode($recommendationCounts) !!};

    const labels = Object.keys(recommendationData);
    const data = Object.values(recommendationData);

    const ctx = document.getElementById('recommendationChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rekomendasi per Hari',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.4)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(255, 255, 255, 1)',
                pointBorderColor: 'rgba(75, 192, 192, 1)',
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(200, 200, 200, 0.5)',
                    },
                    title: {
                        display: true,
                        text: 'Angka Hasil Rekomendasi',
                        font: {
                            size: 14,
                            family: 'Helvetica Neue',
                        },
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Hari',
                        font: {
                            size: 14,
                            family: 'Helvetica Neue',
                        },
                    },
                    grid: {
                        color: 'rgba(200, 200, 200, 0.5)',
                    },
                }
            },
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    callbacks: {
                        label: function(tooltipItem) {
                            return `Recommendations: ${tooltipItem.raw}`;
                        }
                    }
                },
                legend: {
                    labels: {
                        font: {
                            size: 14,
                        },
                    },
                },
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutBounce'
            },
        }
    });
});

</script>
@endsection
