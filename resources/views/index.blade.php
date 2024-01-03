@extends('master.layout')
@section('content')
  <main class="main" id="main">
      <div class="pagetitle">
          <h1>Tableau de bord</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                      <a href="index.html">Accueil</a>
                  </li>
                  <li class="breadcrumb-item active">Tableau de Bord</li>
              </ol>
          </nav>
      </div>
      <!-- End Page Title -->
      <div class="container">
        @php
            $role = Auth::user()->id;
        @endphp
        @dd($role)
        <form action="" method="post">
            @if (strcmp("admin", $role) == 0)

                <div class="row">
                    <div class="col ms-2 contenuTb">
                        <div class="row">
                            <div class="col mt-1 ms-2">
                                <img src="{{ asset('agence.png') }}" height="100%" width="100%" alt="">
                            </div>
                            <div class="col">
                                <h2 class=" mt-1"><a href="{{ route('afficherAgence') }}" class="fw-bold text-success text-center">Agences</a></h2>
                                <p class="nombre">{{ $nombreAgence }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col ms-5 contenuTb">
                    <div class="row">
                        <div class="col mt-1 ms-2">
                            <img src="{{ asset('agent.png') }}" height="100%" width="100%" alt="">
                        </div>
                        <div class="col">
                                <h2 class="fw-bold mt-1"><a href="{{ route('listeAgent') }}" class="fw-bold text-success text-center">Agents</a></h2>
                                <p class="nombre">{{ $nombreAgent }}</p>
                        </div>
                    </div>
                </div>

                    <div class="col ms-5 contenuTb">
                    <div class="row">
                            <div class="col mt-1 ms-2">
                                <img src="{{ asset('membres.jpg') }}" height="100%" width="100%" alt="">
                            </div>
                            <div class="col">
                                <h3 class="text-center "><a href="{{ route('membre') }}" class="fw-bold text-success  mt-1">Membres</a></h3>
                                <p class="nombre">{{ $nombreMembre }}</p>
                            </div>
                    </div>
                    </div>

                </div>


                <div class="row mt-4">
                        <div class="col ms-3 contenuTb">
                        <div class="row mt-2">
                            <div class="col ms-2 mt-1">
                                <img src="{{ asset('tontine2.jpg') }}" height="100%" width="100%" alt="">
                            </div>
                            <div class="col">
                                <h3 class="fw-bold text-success mt-3"><a href="{{ route('listeTontine') }}" class="fw-bold text-success "></a>T Collectives</h3>
                                <div class="row" >
                                    <div class="col">
                                        <h5 class="text-success fw-bold " style="font-size: 100%">En Cours</h5>
                                        <p class="text-center fw-bold " style="font-size: 250%">{{ $tontineCollectivesEncours }}</p>
                                    </div>
                                    <div class="col">
                                        <h5 class="text-success fw-bold " style="font-size: 100%">Terminé</h5>
                                        <p class="text-center fw-bold " style="font-size: 250%">{{ $tontineCollectivesTermine }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col ms-5 contenuTb">
                        <div class="row mt-2">
                        <div class="col mt-1 ms-2">
                            <img src="{{ asset('tontine2.jpg') }}" height="100%" width="100%" alt="">
                        </div>
                        <div class="col">
                                <h3 class="fw-bold text-success mt-3" style="font-size: 150%"><a href="{{ route('listeTontineInd') }}" ></a>T Individuelles</h3>
                                <div class="row" >
                                    <div class="col">
                                        <h5 class="text-success fw-bold " style="font-size: 100%">En Cours</h5>
                                        <p class="text-center fw-bold " style="font-size: 250%">{{ $tontineIndividuelleEncours }}</p>
                                    </div>
                                    <div class="col">
                                        <h5 class="text-success fw-bold " style="font-size: 100%">Terminé</h5>
                                        <p class="text-center fw-bold " style="font-size: 250%">{{ $tontineIndividuelleTermine }}</p>
                                    </div>
                                </div>
                        </div>
                        </div>
                    </div>

                    <div class="col ms-5 contenuTb">
                        <div class="row">
                            <div class="col mt-1 ms-2">
                            <img src="{{ asset('moneypng.png') }}" height="100%" width="100%" alt="">
                            </div>
                            <div class="col">
                                <h3 class="fw-bold text-success mt-3" style="font-size: 120%"><a href="{{ route('listeTontineInd') }}" ></a>Montant Collectés</h3>
                                <div class="row" >
                                    <div class="row">
                                        <h5 class="text-success text-center fw-bold " style="font-size: 120%">Individuelle</h5>
                                        <p class="text-center fw-bold " style="font-size: 120%">{{ $compteTindividuelle }}</p>
                                    </div>
                                    <div class="row">
                                        <h5 class="text-success text-center fw-bold " style="font-size: 120%">Collectives</h5>
                                        <p class="text-center fw-bold " style="font-size: 120%">{{ $compteCollectives }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            @elseif (strcmp("delegue", $role) == 0)

            @elseif(strcmp("agent", $role) == 0)

            @elseif (strcmp("membre", $role) == 0)

            @endif

        </form>


          <div class="row mt-3">
            <div class="col">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtrer</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="#">Ce Mois</a></li>
                    <li><a class="dropdown-item" href="#">Cette Année</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Rapport <p>/Aujourd'hui</p></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Payement',
                          data: [31, 40, 28, 51, 42, 82, 56],
                        }, {
                          name: 'Montant Rassemblé',
                          data: [11, 32, 45, 32, 34, 52, 41]
                        }, {
                          name: 'Nombre de participant',
                          data: [15, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div>
            <div class="col">

              <div class="card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtrer</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="#">Cet Mois</a></li>
                    <li><a class="dropdown-item" href="#">Cette Année</a></li>
                  </ul>
                </div>

                <div class="card-body pb-0 bg">
                  <h5 class="card-title">Website Traffic <p>| Aujourd'hui</p></h5>

                  <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      echarts.init(document.querySelector("#trafficChart")).setOption({
                        tooltip: {
                          trigger: 'item'
                        },
                        legend: {
                          top: '5%',
                          left: 'center'
                        },
                        series: [{

                          type: 'pie',
                          radius: ['40%', '70%'],
                          avoidLabelOverlap: false,
                          label: {
                            show: false,
                            position: 'center'
                          },
                          emphasis: {
                            label: {
                              show: true,
                              fontSize: '18',
                              fontWeight: 'bold'
                            }
                          },
                          labelLine: {
                            show: false
                          },
                          data: [{
                              value: 1048,
                              name: 'Membres'
                            },
                            {
                              value: 735,
                              name: 'Tontines terminés'
                            },
                            {
                              value: 580,
                              name: 'Tontines en cours'
                            },
                            {
                              value: 484,
                              name: 'Montant rassemblé'
                            }

                          ]
                        }]
                      });
                    });
                  </script>

                </div>
              </div>

            </div>
          </div>


      </div>
  </main>
@endsection




<!-- End #main -->






