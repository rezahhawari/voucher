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
                    <h1 class="box-title">All Duration</h1>
                    <a data-bs-target="#addkos" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Duration</a>
                    <div class="table-responsive mt-4">
                        <table class="table text-nowrap table-striped table-hover" id="table">
                            <thead>
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">Duration ID</th>
                                    <th class="border-top-0">Price</th>
                                    <th class="border-top-0">Duration</th>
                                    <th class="border-top-0">Speed</th>
                                    <th class="border-top-0">Device</th>
                                    <th class="border-top-0">Venue</th>
                                    <th class="border-top-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($duration as $e)
                                <tr>
                                    <td>1</td>
                                    <td>{{$e->period_id}}</td>
                                    <td>{{$e->period_price}}</td>
                                    <td>{{$e->period}}</td>
                                    <td>{{$e->speed}}</td>
                                    <td>{{$e->device}}</td>
                                    <td>{{$e->venue->name}}</td>
                                    <td>
                                        {{-- <a href="{{route('admin.event.edit', $e->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="{{route('admin.event.delete', $e->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> --}}
                                        {{-- <a  class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> --}}
                                        <button  class="btn btn-danger btn-sm " data-bs-target="#delconfirm" data-bs-toggle="modal" data-bs-id="{{$e->id}}" data-bs-price="{{$e->period_price}}" data-bs-duration="{{$e->period}}" data-bs-speed="{{$e->speed}}" data-bs-venue="{{$e->venue->name}}"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
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

    <!-- Modal -->
    <div class="modal fade" id="addkos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Duration</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="input-group has-validation mb-3">
                    <span class="input-group-text">Rp</span>
                    <div class="form-floating is-invalid">
                      <input type="number" class="form-control" id="inputprice" placeholder="Username" required>
                      <label for="inputprice">Duration Price</label>
                    </div>

                </div>
                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="inputduration" placeholder="0821321">
                        <label for="inputduration">Duration</label>
                    </div>
                    <div class="form-floating">
                        <select class="form-select" id="inputsatuan" aria-label="Floating label select example">
                          <option selected>Open this select menu</option>
                          <option value="Hour">Hour</option>
                          <option value="Day">Day</option>
                          <option value="Week">Week</option>
                          <option value="Month">Month</option>
                          <option value="Year">Year</option>
                        </select>
                        <label for="inputsatuan">Satuan</label>
                      </div>
                </div>
                <div class="input-group mb-3">
                    <div class="form-floating">
                      <input type="number" class="form-control" id="inputspeed" placeholder="Username" required>
                      <label for="inputspeed">Speed</label>
                    </div>
                    <span class="input-group-text">Mbps</span>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="inputdevice" placeholder="bambangg">
                    <label for="inputdevice">Device</label>
                </div>
                <div class="form-floating">
                    <select class="form-select" id="inputvenue" aria-label="Floating label select example">
                      <option selected value="">Choose...</option>
                      @foreach ($venue as $v)
                        <option value="{{$v->id}}">{{$v->name}}</option>

                      @endforeach
                    </select>
                    <label for="inputvenue">Venue</label>
                </div>
                {{-- <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Status</label>
                </div> --}}
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btnconfirm" onclick="submit()">Submit</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Vertically Centered modal Modal -->
<div class="modal fade" id="delconfirm" tabindex="-1" role="dialog"
aria-labelledby="delconfirmTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
    role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="delconfirmTitle">Confirmation</h5>
            <button type="button" class="close" data-bs-dismiss="modal"
                aria-label="Close">
                <i data-feather="x"></i>
            </button>
        </div>
        <div class="modal-body">
            <p id="isidelconfirm">
                Croissant jelly-o halvah chocolate sesame snaps. Brownie caramels candy
                canes chocolate cake
                marshmallow icing lollipop I love. Gummies macaroon donut caramels
                biscuit topping danish.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary"
                data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Close</span>
            </button>
            {{-- <form action="{{route('customer.destroy')}}" method="post">
                @csrf
                @method('DELETE') --}}
                <input type="hidden" id="iddelconfirm" name="id">
                <button type="submit" class="btn btn-primary ml-1" id="btnconfirms" onclick="confirmdelete()">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Accept</span>
                </button>
            {{-- </form> --}}
        </div>
    </div>
</div>
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
        const inputElement = document.querySelector('#inputimg');

        // Create the FilePond instance
        const pond = FilePond.create(inputElement);
        FilePond.setOptions({
            server: {
                process: {
                    url: '/upload-temp-product',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (response) => {
                        document.getElementById('image').value = response;
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
                    url: "{{ route('admin.duration-destroy') }}",
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
                                text: 'Duration Successfully Deleted',
                                duration: 3000,
                                style: {
                                    background: "green",
                                }
                            }).showToast();
                            setTimeout(function () {
                                window.location.href = "{{route('admin.duration')}}"; //will redirect to your blog page (an ex: blog.html)
                            }, 1500); //will call the function after 2 secs.

                        }
                    },
                });
        }

        function submit() {
            document.getElementById('btnconfirm').disabled = true;
            document.getElementById('btnconfirm').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            let price = $('#inputprice').val();
            let duration = $('#inputduration').val();
            let satuan = $('#inputsatuan').val();
            let speed = $('#inputspeed').val();
            let device = $('#inputdevice').val();
            let venue = $('#inputvenue').val();

            $.ajax({
                    url: "{{ route('admin.duration-store') }}",
                    type:"POST",
                    data:{
                        price:price,
                        duration:duration + ' ' + satuan,
                        speed:speed,
                        device:device,
                        venue:venue,
                        _token: "{{ csrf_token() }}"
                    },
                    success:function(response){
                        if(response.status == 'success') {
                            // document.getElementById('btnconfirm').disabled = false;
                            // document.getElementById('btnconfirm').innerHTML = 'Submit';
                            // document.getElementById('expensename').value = '';
                            Toastify({
                                text: 'Duration Successfully Added',
                                duration: 3000,
                                style: {
                                    background: "green",
                                }
                            }).showToast();
                            setTimeout(function () {
                                window.location.href = "{{route('admin.duration')}}"; //will redirect to your blog page (an ex: blog.html)
                            }, 1500); //will call the function after 2 secs.

                        }
                    },
                });
        }
    </script>
@endsection
