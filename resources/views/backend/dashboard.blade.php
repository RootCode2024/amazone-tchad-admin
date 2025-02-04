@extends('backend.layouts.app')

@section('title', 'Tableau de bord - Amazone Tchad Admin')

@section('breadcrum')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Accueil</span>
            </li>
            <li class="breadcrumb-item active"><span>Tableau de Bord</span></li>

        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-lg-8 text-center">
                        <h1 class="display-8 fw-bold">Heureux de vous revoir<br> M. {{ auth()->user()->name }}</h1>
                        <p class="lead text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sit odio minima illum, aperiam aliquid ab amet quasi placeat laborum recusandae numquam officiis libero necessitatibus impedit, hic natus vero magnam. Facere.</p>
                        <a href="{{ route('clients.index') }}" class="btn btn-primary btn-md mt-2">Voir Nouveaux clients</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4 text-white bg-primary">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold">{{ $users }} <span class="fs-6 fw-normal"></span></div>
                    <div>Managers</div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button"
                        data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg class="icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-options">
                            </use>
                        </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                            href="#">Action</a><a class="dropdown-item" href="#">Another
                            action</a><a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                <canvas class="chart" id="card-chart1" height="70"></canvas>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4 text-white bg-warning">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold">{{ $clients }} <span class="fs-6 fw-normal"></div>
                    <div>Clients</div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button"
                        data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg class="icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-options">
                            </use>
                        </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                            href="#">Action</a><a class="dropdown-item" href="#">Another
                            action</a><a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <div class="c-chart-wrapper mt-3" style="height:70px;">
                <canvas class="chart" id="card-chart3" height="70"></canvas>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4 text-white bg-danger">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold">{{ $reservationsPendding }}</div>
                    <div>Reservation en attente</div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button"
                        data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg class="icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-options">
                            </use>
                        </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                            href="#">Action</a><a class="dropdown-item" href="#">Another
                            action</a><a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                <canvas class="chart" id="card-chart4" height="70"></canvas>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4 text-white bg-info">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold">{{ $reservations }}</div>
                    <div>Reservations Validées</div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button"
                        data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg class="icon">
                            <use xlink:href="assets/icons/sprites/free.svg#cil-options">
                            </use>
                        </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                            href="#">Action</a><a class="dropdown-item" href="#">Another
                            action</a><a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                <canvas class="chart" id="card-chart2" height="70"></canvas>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
@endsection
