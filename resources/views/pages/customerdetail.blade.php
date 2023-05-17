@extends('layouts.homelay')
@section('content')
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h2>Anda akan terhubung di {{$venue->name}}</h2>
            <h4 class="mb-5">Silahkan isi detail pembelian</h4>
            {{-- <form action="{{route('payment', $transaction->id)}}" method="post">
                @csrf --}}
                <input type="hidden" id="inputid" name="id" value="{{$transaction->id}}">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="inputnama" name="nama" placeholder="name@example.com" value="{{$transaction->customer->name}}">
                    <label for="inputnama">Name</label>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="inputemail" name="email" placeholder="name@example.com" value="{{$transaction->customer->email}}">
                            <label for="inputemail">Email address</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="inputhp" name="phone" placeholder="name@example.com" value="{{$transaction->customer->phone_number}}">
                            <label for="inputhp">Phone Number</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-floating">
                            <select class="form-select" id="inputpaketwifi" name="paket" aria-label="Floating label select example" onchange="wifichange()">
                              <option selected>Open this select menu</option>
                              @foreach ($duration as $d)
                                <option value="{{$d->id}}|{{$d->period_price}}">{{$d->period . ' (Speed :' . $d->speed . 'Mbps ; Price : ' . $d->period_price . ')'}}</option>
                              @endforeach
                            </select>
                            <label for="inputpaketwifi">Paket Voucher Wifi</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="inputqty" name="qty" placeholder="name@example.com" disabled onkeyup="qtychange()">
                            <label for="inputqty">Quantity</label>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="10000" name="total" id="total" disabled>
                    <label for="inputnama">Total</label>
                </div>

                <hr>
                <button type="submit" class="btn btn-success w-100" id="btn-pay" disabled onclick="submit()">Payment</button>
            {{-- </form> --}}
        </div>
    </section>
@endsection
@section('script')
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        function submit() {
            document.getElementById('btn-pay').disabled = true;
            document.getElementById('btn-pay').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            var id = document.getElementById('inputid').value;
            var nama = document.getElementById('inputnama').value;
            var email = document.getElementById('inputemail').value;
            var hp = document.getElementById('inputhp').value;
            var paketwifi = paketvalue();
            var qty = qtyvalue();
            var total = document.getElementById('total').value;
            var data = {
                id: id,
                nama: nama,
                email: email,
                hp: hp,
                paketwifi: paketwifi[0],
                qty: qty,
                total: total,
                _token: "{{ csrf_token() }}",
            };
            console.log(data);
            $.ajax({
                type: "POST",
                url: `/cusdetail/${id}/connect/payment`,
                data: data,
                success: function (response) {
                    snap.pay(response.snaptoken, {
                        // Optional
                        onSuccess: function(result) {
                            /* You may add your own js here, this is just example */
                            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                            // window.location.href = "/getvoucher"; //will redirect to your blog page (an ex: blog.html)
                            $.ajax({
                                type: "POST",
                                url: "{{route('store.payment')}}",
                                data: {
                                    amount: result.gross_amount,
                                    order_id: result.order_id,
                                    payment_method: result.payment_type,
                                    _token: "{{ csrf_token() }}",
                                },
                                success: function (hasil) {
                                    Toastify({
                                        text: hasil.message,
                                        duration: 3000,
                                        style: {
                                            background: "green",
                                        }
                                    }).showToast();
                                    console.log(hasil);
                                    window.location.href = "/getvoucher?order="+hasil.order_id; //will redirect to your blog page (an ex: blog.html)
                                }
                            });


                            console.log(result)
                        },
                        // Optional
                        onPending: function(result) {
                            /* You may add your own js here, this is just example */
                            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                            console.log(result)
                        },
                        // Optional
                        onError: function(result) {
                            /* You may add your own js here, this is just example */
                            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                            console.log(result)
                        }
                    });
                }
            });
        }

        function wifichange(){
            var paketwifi = paketvalue();
            let price = paketwifi[1];
            document.getElementById('inputqty').disabled=false;
            document.getElementById('inputqty').value='1';
            var qty = qtyvalue();
            var total = price * qty;
            document.getElementById('total').value = total;
            document.getElementById('btn-pay').disabled=false;
        }

        function qtychange(){
            var paketwifi = paketvalue();
            let price = paketwifi[1];
            var qty = qtyvalue();
            document.getElementById('total').value = sumtotal(price, qty);
        }

        function sumtotal(price, qty){
            return price * qty;
        }

        function paketvalue(){
            return document.getElementById('inputpaketwifi').value.split('|');
        }

        function qtyvalue(){
            return document.getElementById('inputqty').value;
        }
    </script>
@endsection
