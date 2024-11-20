
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* General Styles */

        .form-group.profile-icon {
    position: relative;
}
span.fa.fa-fw.fa-eye.field-icon.toggle-password, span.fa.fa-fw.field-icon.toggle-password.fa-eye-slash {
    position: absolute;
    right: 10px;
    top: 13px;
    color: #828282;
}
        .main-container {
            background-color: #e0f0ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            background: url('{{ asset('assets/images/imagebgLogin.png') }}');
            background-position: bottom;
            background-size: contain;
            background-repeat: no-repeat;
        }

        .login-container {
            max-width: 900px;
            width: 100%;
            display: flex;
            flex-direction: row;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            height: 507px;
        }

        .profile-icon {
            position: relative;
        }

        .profile-icon img {
            position: absolute;
            top: 10px;
        }

        /* Left Panel */
        .login-left {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            width: 35%;
            background-image: url('{{ asset('assets/images/login-left.png') }}');
            background-position: top;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .login-left h2 {
            font-size: 30px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        /* Right Panel */
        .login-right {
            flex-grow: 1;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h4 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #2a5298;
        }

        .form-control {
            border-radius: 5px;
            padding: 15px;
        }

        .form-control {

            font-size: 18px !important;
            font-weight: 400;
            line-height: 1.5;
            color: #B4B4B4 !important;
            border-radius: 0px !important;
            border-width: 0px 0px 1px 0px;
            padding-left: 31px;


        }

        .form-group.form-check label,
        .form-check a {
            color: #282760 !important;
            font-weight: 500;
            font-size: 17px;
        }

        .btn-login {
            background-color: #3753A4;
            color: #fff;
            font-weight: bold;
            width: 100%;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 40px !important;
        }

        .btn:hover {
            color: #ffffff !important;
            text-decoration: none;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 90%;
            }

            .login-left {
                width: 100%;
                padding: 40px 20px;
                text-align: center;

            }

            .login-right {
                width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="login-container">
            <!-- Left Panel -->
            <div class="login-left">

            </div>

            <!-- Right Panel -->
            <div class="login-right">
                <h4>
                    <img src="{{ asset('assets/images/logoBrand.png')}}" alt="logo">
                </h4>

                 @if (session('error'))
            <div class="col-sm-12">
              <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
            @endif
                <form action="{{route('saveChangePassword')}}" method="post">
              @csrf()
                    <div class="form-group profile-icon">
                        <img src="{{ asset('assets/images/profile.png')}}" alt="">
                        <input  id="password-field" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                        <div style="color:red">{{ $message }}</div>
                        @enderror
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span> 
                    </div>
                   
                    <div class="form-group profile-icon">
                        <img src="{{ asset('assets/images/profile.png')}}" alt="">
                        <input  id="password-field" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>
                        @error('password_confirmation')
                        <div style="color:red">{{ $message }}</div>
                        @enderror
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span> 
                    </div>
                   


                   
                    <button type="submit" class="btn btn-login">Submit</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS, jQuery, and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <script>
    $(".toggle-password").click(function() {

      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
  </script>
</body>

</html>