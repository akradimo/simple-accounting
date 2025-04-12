@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">خوش آمدید {{ Auth::user()->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- آمار کلی -->
                        <div class="col-md-3 mb-4">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title mb-0">اشخاص</h6>
                                            <h2 class="mt-2 mb-0">{{ number_format($counts['persons']) }}</h2>
                                        </div>
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-4">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title mb-0">کالاها</h6>
                                            <h2 class="mt-2 mb-0">{{ number_format($counts['products']) }}</h2>
                                        </div>
                                        <i class="fas fa-box fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-4">
                            <div class="card bg-info text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title mb-0">فروش‌ها</h6>
                                            <h2 class="mt-2 mb-0">{{ number_format($counts['sales']) }}</h2>
                                        </div>
                                        <i class="fas fa-shopping-cart fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-4">
                            <div class="card bg-warning text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title mb-0">خریدها</h6>
                                            <h2 class="mt-2 mb-0">{{ number_format($counts['purchases']) }}</h2>
                                        </div>
                                        <i class="fas fa-shopping-basket fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- نمودار در آینده اضافه می‌شود -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">عملیات سریع</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('persons.create') }}" class="btn btn-outline-primary btn-block">
                                                <i class="fas fa-user-plus mb-2"></i>
                                                <br>
                                                شخص جدید
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('products.create') }}" class="btn btn-outline-success btn-block">
                                                <i class="fas fa-box-open mb-2"></i>
                                                <br>
                                                کالای جدید
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('sales.create') }}" class="btn btn-outline-info btn-block">
                                                <i class="fas fa-cart-plus mb-2"></i>
                                                <br>
                                                فروش جدید
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('purchases.create') }}" class="btn btn-outline-warning btn-block">
                                                <i class="fas fa-shopping-cart mb-2"></i>
                                                <br>
                                                خرید جدید
                                            </a>
                                        </div>
                                    </div>
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