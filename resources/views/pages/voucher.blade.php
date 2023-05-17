@extends('layouts.homelay')
@section('content')
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h2>Terimakasih sudah melakukan pembayaran</h2>
            <h3>Ini voucher anda</h3>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Voucher Code</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voucher as $v)
                        <tr>
                            <td>{{$v->code}}</td>
                            <td>{{$v->period->period}}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
