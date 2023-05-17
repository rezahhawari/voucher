@extends('layouts.homelay')
@section('content')
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="mb-5">Silahkan Pilih Venue</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($venue as $v)
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        @if ($v->image == null)
                        <img class="card-img-top" src="{{asset('img/noPhoto.jpeg')}}" alt="..." />

                        @else
                        <img class="card-img-top" src="{{asset('img/'.$v->image)}}" alt="..." />

                        @endif
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                @auth
                                <h5 class="fw-bolder"><a href="#modalconfirm" data-bs-toggle="modal" class="stretched-link" style="text-decoration: none" data-bs-id="{{$v->id}}" data-bs-name="{{$v->name}}">{{$v->name}}</a></h5>

                                @else
                                <h5 class="fw-bolder"><a href="#modalemail" data-bs-toggle="modal" class="stretched-link" style="text-decoration: none" data-bs-id="{{$v->id}}">{{$v->name}}</a></h5>

                                @endauth
                                <!-- Product price-->
                                {{$v->address}}
                            </div>
                        </div>
                        <!-- Product actions-->

                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>

    @auth
    <div class="modal fade" id="modalconfirm" tabindex="-1" aria-labelledby="modalconfirmLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="modalconfirmLabel"></h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form action="{{route('storeemail')}}" method="post">
                @csrf --}}
                <div class="modal-body">
                    <h5 id="text-confiramtion">Untuk melanjutkan ke venue silahkan isi form email dibawah ini</h5>
                    {{-- <h5>Apakah anda yakin?</h5> --}}
                    <input type="hidden" class="form-control" id="emailinput" name="email" placeholder="name@example.com" value="{{Auth::user()->email}}">
                    <input type="hidden" class="form-control" id="venueid" name="venue" placeholder="name@example.com">
                </div>
                <div class="modal-footer">
                    {{-- <a href="{{route('login')}}" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Sudah punya akun?</a> --}}
                    <button type="submit" class="btn btn-primary" id="button-submit" onclick="submit()">Lanjutkan</button>
                    {{-- <button type="submit" class="btn btn-primary" id="button-submit">Lanjutkan</button> --}}
                </div>
            {{-- </form> --}}
          </div>
        </div>
    </div>

    @else

    <div class="modal fade" id="modalemail" tabindex="-1" aria-labelledby="modalemailLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="modalemailLabel"></h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form action="{{route('storeemail')}}" method="post">
                @csrf --}}
                <div class="modal-body">
                    <p>Untuk melanjutkan ke venue silahkan isi form email dibawah ini</p>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="emailinput" name="email" placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>

                    </div>
                    <input type="hidden" class="form-control" id="venueid" name="venue" placeholder="name@example.com">
                </div>
                <div class="modal-footer">
                    <a href="{{route('login')}}" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Sudah punya akun?</a>
                    <button type="submit" class="btn btn-primary" id="button-submit" onclick="submit()">Submit</button>
                    {{-- <button type="submit" class="btn btn-primary" id="button-submit">Submit</button> --}}
                </div>
            {{-- </form> --}}
          </div>
        </div>
    </div>
    @endauth
@endsection
@section('script')
    <script>
        const modalconfirm = document.getElementById('modalconfirm')
        modalconfirm.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-id')
            const name = button.getAttribute('data-bs-name')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.

            const inputidvenue = modalconfirm.querySelector('#venueid')
            const inputvenuename = modalconfirm.querySelector('#text-confiramtion')


            inputidvenue.value = id
            inputvenuename.textContent = `Anda akan terhubung ke internet ${name}`
        })

    </script>
    <script>
        const modalemail = document.getElementById('modalemail')
        modalemail.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-id')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.

            const inputidvenue = modalemail.querySelector('#venueid')


            inputidvenue.value = id
        })

    </script>
    <script>
        function submit() {
            document.getElementById('button-submit').disabled = true;
            document.getElementById('button-submit').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            // document.getElementById('btnconfirm').disabled = false;
            // document.getElementById('btnconfirm').innerHTML = 'Submit';
            let email = document.getElementById('emailinput');
            let venue = document.getElementById('venueid');

            let filled = true;
            //validation input email
            if (email.value == '') {
                filled = false;
                email.classList.add('is-invalid');

            }

            if (filled == true) {
                $.ajax({
                    url:"{{route('storeemail')}}",
                    type:"POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: email.value,
                        venue: venue.value,
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Toastify({
                                text: response.message,
                                duration: 3000,
                                style: {
                                    background: "green",
                                }
                            }).showToast();
                            setTimeout(function () {
                                window.location.href = "/cusdetail/"+response.id+"/connect"; //will redirect to your blog page (an ex: blog.html)
                            }, 1500);
                        }
                    }
                });
            } else {

                document.getElementById('button-submit').disabled = false;
                document.getElementById('button-submit').innerHTML = 'Submit';
            }

        }


    </script>
@endsection
