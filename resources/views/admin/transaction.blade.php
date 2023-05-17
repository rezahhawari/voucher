@extends('layouts.adminlay')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h1 class="box-title">Transactions</h1>
                    <a data-bs-target="#addvoucher" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Transaction</a>
                    <div class="table-responsive mt-4">
                        <table class="table text-nowrap table-striped table-hover" id="table">
                            <thead>
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">Tanggal</th>
                                    <th class="border-top-0">Venue</th>
                                    <th class="border-top-0">Cust Name</th>
                                    <th class="border-top-0">Cust Email</th>
                                    <th class="border-top-0">Duration</th>
                                    <th class="border-top-0">Qty</th>
                                    <th class="border-top-0">Total</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($transaction as $e)
                                    @can('venue')
                                    @if ($e->venue->user_id == Auth::user()->id)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$e->created_at}}</td>
                                            <td>{{$e->venue->name}}</td>
                                            <td>{{$e->customer->name}}</td>
                                            <td>{{$e->customer->email}}</td>
                                            <td>{{$e->period->speed}} Mbps</td>
                                            <td>{{$e->qty}}</td>
                                            <td>{{$e->amount}}</td>

                                        </tr>
                                        @endif
                                        @else
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$e->created_at}}</td>
                                            <td>{{$e->venue->name}}</td>
                                            <td>{{$e->customer->name}}</td>
                                            <td>{{$e->customer->email}}</td>
                                            <td>{{$e->period->speed}} Mbps</td>
                                            <td>{{$e->qty}}</td>
                                            <td>{{$e->amount}}</td>

                                        </tr>

                                    @endcan
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>

@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        var delconfirm = document.getElementById('delconfirm')
        delconfirm.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        // var name = button.getAttribute('data-bs-name')
        var id = button.getAttribute('data-bs-id')
        var name = button.getAttribute('data-bs-name')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var modalBodyInput = delconfirm.querySelector('.modal-body #isidelconfirm')
        var iddel = delconfirm.querySelector('.modal-footer #iddelconfirm')

        modalBodyInput.innerHTML = 'Apakah anda yakin ingin menghapus <strong>'+ name +'</strong>?'
        iddel.value = id
        })
    </script>
    <script>
        // Register the plugin with FilePond
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // Get a reference to the file input element
        const inputElement = document.querySelector('#inputexcel');

        // Create the FilePond instance
        const pond = FilePond.create(inputElement);
        FilePond.setOptions({
            server: {
                process: {
                    url: '/upload-excel',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (response) => {
                        document.getElementById('excelfile').value = response;
                    },

                },
                revert: '/delete-temp-product',
            },
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#table').DataTable();
        });
    </script>

    <script>
        function confirmdelete() {
            document.getElementById('btnconfirms').disabled = true;
            document.getElementById('btnconfirms').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            let iddelt = document.getElementById('iddelconfirm').value;
            $.ajax({
                    url: "{{ route('admin.voucher-destroy') }}",
                    type:"DELETE",
                    data:{
                        id:iddelt,
                        _token: "{{ csrf_token() }}"
                    },
                    success:function(response){
                        if(response.status == 'success') {
                            // document.getElementById('btnconfirm').disabled = false;
                            // document.getElementById('btnconfirm').innerHTML = 'Submit';
                            // document.getElementById('expensename').value = '';
                            Toastify({
                                text: 'Event Successfully Deleted',
                                duration: 3000,
                                style: {
                                    background: "green",
                                }
                            }).showToast();
                            setTimeout(function () {
                                window.location.href = "{{route('admin.voucher')}}"; //will redirect to your blog page (an ex: blog.html)
                            }, 1500); //will call the function after 2 secs.

                        }
                    },
                });
        }

        function submit() {
            document.getElementById('btnconfirm').disabled = true;
            document.getElementById('btnconfirm').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            var code = $('#inputcode').val();
            var venue = $('#inputvenue').val();
            var period = $('#inputduration').val();

            console.log(status);
            $.ajax({
                url: "{{route('admin.voucher-store')}}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    code: code,
                    venue: venue,
                    period: period,
                    user: "{{Auth::user()->id}}",
                },
                success: function (data) {
                    console.log(data);
                    Toastify({
                            text: 'Voucher Successfully Added',
                            duration: 3000,
                            style: {
                                background: "green",
                            }
                        }).showToast();
                        setTimeout(function () {
                            window.location.href = "{{route('admin.voucher')}}"; //will redirect to your blog page (an ex: blog.html)
                        }, 1500);
                }
            });
        }

        function imports() {
            document.getElementById('btnconfirmi').disabled = true;
            document.getElementById('btnconfirmi').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            var filename = $('#excelfile').val();

            $.ajax({
                url: "{{route('admin.voucher-importexcel')}}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    filename: filename,

                },
                success: function (data) {
                    console.log(data);
                    Toastify({
                            text: 'Voucher Successfully Imported',
                            duration: 3000,
                            style: {
                                background: "green",
                            }
                        }).showToast();
                        setTimeout(function () {
                            window.location.href = "{{route('admin.voucher')}}"; //will redirect to your blog page (an ex: blog.html)
                        }, 1500);
                }
            });
        }

        function findduration(id) {
            console.log(id);
            $('#inputduration').empty();
            $("#inputduration").append($('<option>',{
		    	value : '',
		    	text : 'Open this select menu',
		    }));

            $.ajax({
                url:"{{route('admin.voucher-findduration')}}",
                type:"POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id:id,

                },
                success: function (data) {
                    console.log(data);
                    $.each(data, function (index,value) {
                        $("#inputduration").append($('<option>',{
                            value : value.id,
                            text : value.period + ' (Speed :' + value.speed + 'Mbps ; Price : ' + value.period_price + ')',
                        }));
                    })
                }
            });
        }
    </script>
@endsection
