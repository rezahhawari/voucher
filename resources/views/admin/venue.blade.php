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
                    <h1 class="box-title">All Venue</h1>
                    <a data-bs-target="#addkos" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Venue</a>
                    <div class="table-responsive mt-4">
                        <table class="table text-nowrap table-striped table-hover" id="table">
                            <thead>
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">Image</th>
                                    <th class="border-top-0">Venue Name</th>
                                    <th class="border-top-0">Venue Category</th>
                                    <th class="border-top-0">Phone Number</th>
                                    <th class="border-top-0">Address</th>
                                    <th class="border-top-0">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($venue as $e)
                                <tr>
                                    <td>1</td>
                                    @if ($e->image == null)
                                    <td>
                                        <img src="{{asset('img/noPhoto.jpeg')}}" alt="" width="100px">
                                    </td>

                                    @else
                                    <td>
                                        <img src="{{asset('img/'.$e->image)}}" alt="" width="100px">
                                    </td>

                                    @endif
                                    <td>{{$e->name}}</td>
                                    <td>{{$e->name}}</td>
                                    <td>{{$e->name}}</td>
                                    <td>{{$e->name}}</td>
                                    @if ($e->status == '1')
                                        <td>
                                            <div class="dropdown">
                                                <span class="badge rounded-pill bg-success ganti-badge{{$e->id}}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Active</span>
                                                {{-- <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button> --}}
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changestatus('active', {{$e->id}})"> Active</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changestatus('unactive', {{$e->id}})"> Unactive</a>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                    @if ($e->status == '0')
                                        <td>
                                            <div class="dropdown">
                                                <span class="badge rounded-pill bg-danger ganti-badge{{$e->id}}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Unactive</span>
                                                {{-- <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button> --}}
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changestatus('active', {{$e->id}})"> Active</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changestatus('unactive', {{$e->id}})"> Unactive</a>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
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
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Venue</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="file" name="image" id="inputimg">
                <input type="hidden" id="image">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputname" placeholder="nama evntmu">
                            <label for="inputname">Venue Name*</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="inputcat" aria-label="Floating label select example">
                              <option selected value="">Open this select menu</option>
                              @foreach ($cat as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                              @endforeach
                            </select>
                            <label for="inputcat">Venue Category*</label>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Leave a comment here" id="inputaddress" style="height: 100px"></textarea>
                    <label for="inputaddress">Address / Location*</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="inputphone" placeholder="0821321">
                    <label for="inputphone">Phone Number*</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Leave a comment here" id="inputdesc" style="height: 100px"></textarea>
                    <label for="inputdesc">Description</label>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="inputsdate" placeholder="nama evntmu">
                            <label for="inputsdate">Start Date</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="inputedate" placeholder="nama evntmu">
                            <label for="inputedate">End Date</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputownname" placeholder="bambangg">
                            <label for="inputownname">Owner Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputownemail" placeholder="0821321">
                            <label for="inputownemail">Owner Email</label>
                        </div>
                    </div>
                </div>
                <label for="">Capacity</label>
                <div class="input-group ">

                    <input type="number" class="form-control"
                        placeholder="Minimal Capacity" id="inputmincap">
                    <span class="input-group-text">
                        -
                    </span>
                    <input type="number" class="form-control"
                        placeholder="Maximal Capacity" id="inputmaxcap">

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
                    url: "{{ route('admin.event-destroy') }}",
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
                                window.location.href = "{{route('admin.event')}}"; //will redirect to your blog page (an ex: blog.html)
                            }, 1500); //will call the function after 2 secs.

                        }
                    },
                });
        }

        function submit() {
            document.getElementById('btnconfirm').disabled = true;
            document.getElementById('btnconfirm').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            let name = $('#inputname').val();
            let image = $('#image').val();
            let cat = $('#inputcat').val();
            let desc = $('#inputdesc').val();
            let address = $('#inputaddress').val();
            let phone = $('#inputphone').val();
            let sdate = $('#inputsdate').val();
            let edate = $('#inputedate').val();
            let ownname = $('#inputownname').val();
            let ownemail = $('#inputownemail').val();
            let mincap = $('#inputmincap').val();
            let maxcap = $('#inputmaxcap').val();

            $.ajax({
                    url: "{{ route('admin.venue-store') }}",
                    type:"POST",
                    data:{
                        name:name,
                        image:image,
                        cat:cat,
                        desc:desc,
                        address:address,
                        phone:phone,
                        sdate:sdate,
                        edate:edate,
                        ownname:ownname,
                        ownemail:ownemail,
                        capacity:mincap + ' - ' + maxcap,
                        _token: "{{ csrf_token() }}"
                    },
                    success:function(response){
                        if(response.status == 'success') {
                            // document.getElementById('btnconfirm').disabled = false;
                            // document.getElementById('btnconfirm').innerHTML = 'Submit';
                            // document.getElementById('expensename').value = '';
                            Toastify({
                                text: 'Venue Successfully Added',
                                duration: 3000,
                                style: {
                                    background: "green",
                                }
                            }).showToast();
                            setTimeout(function () {
                                window.location.href = "{{route('admin.venue')}}"; //will redirect to your blog page (an ex: blog.html)
                            }, 1500); //will call the function after 2 secs.

                        }
                    },
                });
            // console.log();

        }

        function changestatus(value, id) {
            $.ajax({
            url:"{{route('admin.venue-changestatus')}}",
            type:'POST',
            data:{
                id:id,
                status:value,
                _token: "{{ csrf_token() }}",
            },
            success:function(data){
                console.log(data);

                if(value == 'active'){
                    let badge = document.querySelector('.ganti-badge'+id);
                    badge.classList.remove('bg-danger');
                    badge.classList.add('bg-success');
                    badge.innerHTML = 'Active';
                }

                if(value == 'unactive'){
                    let badge = document.querySelector('.ganti-badge'+id);
                    badge.classList.remove('bg-success');
                    badge.classList.add('bg-danger');
                    badge.innerHTML = 'Unactive';
                }
            }
        });
        }
    </script>
@endsection
