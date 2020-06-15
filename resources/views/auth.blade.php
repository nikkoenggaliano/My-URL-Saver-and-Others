<!DOCTYPE html>
<html>
<head>
	<title>Auth Page</title>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
	</script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" href="{{ URL::asset('css/auth.css') }}">
</head>
<body>
<div id="back">
  <div class="backRight"></div>
  <div class="backLeft"></div>
</div>

<div id="slideBox">
  <div class="topLayer">
    <div class="left">
      <div class="content">
        <h2>Sign Up</h2>
        
        @if(session()->has('success'))

        <script type="text/javascript">
          swal("Hey!", "{{ session()->get('success') }}", "success");
        </script>
        
        @elseif(session()->has('error'))
        
        <script type="text/javascript">
          swal("Opps!", "{{ session('error') }}", "error");
        </script>

        @elseif(session()->has('info'))
        
        <script type="text/javascript">
          swal("Yo!", "{{ session('info') }}", "info");
        </script>
    
        @endif

        <form action="{{ route('register-user') }}" method="POST" autocomplete="off">
          @csrf
          
          <div class="form-group">
            <input type="text" name="username" placeholder="username" />
            <input type="text" name="email" placeholder="email" />
            <input type="password" name="password" placeholder="password" />
            <input type="password" name="password_confirmation" placeholder="retype password" />
          </div>
          <div class="form-group"></div>
          <div class="form-group"></div>
          <div class="form-group"></div>
          <button id="goLeft" onclick="return false" class="off">Login</button>
          <button>Sign up</button>

        </form>
      </div>
    </div>
    <div class="right">
      <div class="content">
        <h2>Login</h2>
        <form action="{{ route('login-user') }}" method="POST" autocomplete="off">
          @csrf

          <div class="form-group">
            <!-- <label for="user" class="form-label">User</label> -->
            <input type="text" name="user" placeholder="Username / Email"/>
            <!-- <label for="password" class="form-label">Password</label> -->
            <input type="password" name="password" placeholder="Passowrd"/>
          </div>
          <button id="login" type="submit">Login</button>
          <button id="goRight" onclick="return false" class="off">Sign Up</button>
        </form>
       
      </div>
    </div>
  </div>
</div>
	<script src="{{URL::asset('js/authstyle.js')}}"></script>
<!--Inspiration from: http://ertekinn.com/loginsignup/-->
</body>
</html>