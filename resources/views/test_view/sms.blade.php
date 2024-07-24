<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title>AMC</title>

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="{{ asset('assets/landing/font/fontAwesome/all.min.css') }}" />
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- swipper -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/swiper.min.css') }}">
    <!-- Custom Scrollbar -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/jquery.mCustomScrollbar.min.css') }}">
    <!-- nice select -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/nice-select.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/css/responsive.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    @yield('css')

<body>

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 mt-3 text-gray-800">Notifikasi / SMS Reminder</h1>

  <div class="row">
    <div class="col-md-6">

      <!-- Basic Card Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Test Kirim SMS</h6>
        </div>
        <div class="card-body">

          @foreach (['danger', 'warning', 'success', 'info'] as $key)
            @if(Session::has($key))
              <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
            @endif
          @endforeach
          
          <form action="{{url('send-sms')}}" method="POST" autocomplete="off">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group mb-4">
                    <label>Nomor HP</label>
                    <input type="number" name="phone_no" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Konten SMS</label>
                    <textarea class="form-control" name="pesan" rows="3"></textarea>
                    <br><br>
                    <input type="submit" class="btn btn-success">
                </div>
                
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

</div>

    <!-- jawa script -->
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>
    <!-- swipper -->
    <script src="{{ asset('assets/landing/js/swiper.min.js') }}"></script>
    <!-- nice select -->
    <script src="{{ asset('assets/landing/js/jquery.nice-select.min.js') }}"></script>
    <!-- custom Scrollbar -->
    <script src="{{ asset('assets/landing/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- matchheight -->
    <script src="{{ asset('assets/landing/js/jquery.matchHeight-min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/landing/js/main.js') }}"></script>
    @yield('modal_order')
    @yield('js')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script type="text/javascript">

    $(document).ready(function() {
        $(".select2").select2({
          theme: "classic"
        });
    });

    $(document).on('click', '.autocomplete-items div', function(){  
        $('#prospek_name').val($(this).text());  
        $('.autocomplete-items').fadeOut();  
    });
  
    $(function () {
        $('#datetimepicker4').datetimepicker({
            format: 'Y-m-d',
            timepicker:false,
            scrollInput : false,
        });
        
    $('#prospek_name').keyup(function(){
      console.log()
      let query = $(this).val();
      if(query !=''){
        let _token = $('input[name="_token"]').val();
        $.ajax({
          url:"{{ url('send-sms') }}",
          method: "POST",
          data: {query:query, _token: _token},
          success: function(data){
            if(data){
              $('.autocomplete-items').fadeIn();
              $('.autocomplete-items').html(data);
            }else{
              $('.autocomplete-items').fadeOut();
            }
            
          }
        });
      }
    });

    
     
});
  </script>
</body>
</body>

</html>