<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Login</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
      <style type="text/css">
         body {
         background: #007bff;
         background: linear-gradient(to right, #0062E6, #33AEFF);
         }
         .btn-login {
         font-size: 0.9rem;
         letter-spacing: 0.05rem;
         padding: 0.75rem 1rem;
         }
         .btn-google {
         color: white !important;
         background-color: #ea4335;
         }
         .btn-facebook {
         color: white !important;
         background-color: #3b5998;
         }
      </style>
   </head>
   <body>
      <div class="container">
         <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
               <div class="card border-0 shadow rounded-3 my-5">
                  <div class="card-body p-4 p-sm-5">
                     <h5 class="card-title text-center mb-5 fw-light fs-5">Log In</h5>
                     <form>
                        <div class="form-floating mb-3">
                           <input type="email" class="form-control" id="email">
                           <label for="email">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                           <input type="password" class="form-control" id="password">
                           <label for="password">Password</label>
                        </div>
                        <div class="d-grid">
                           <button class="btn btn-primary btn-login text-uppercase fw-bold" type="button" onclick="login()">Login</button>
                        </div>
                        <hr class="my-4">
                        <div class="d-grid">
                           <a href="{{url('/register')}}" class="btn btn-danger btn-login text-uppercase fw-bold" type="submit">Register</a>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
<script type="text/javascript">
function login()
{
   var email         = $("#email").val();
   var password      = $("#password").val();

   if(isEmail(email) ==true && password !="")
   {
      $.ajax({
         type: "POST",
         url: "{{url('api/login')}}",
         headers: {
         "Accept": "application/json"
         },
         data: {'_token' : '{{csrf_token()}}','email' : email,'password' : password},
         dataType: 'json',
         success: function (msg) 
         {
            if(msg.code==200)
            {
               alert(msg.message);
               window.location.href = "{{url('/userslist')}}";
            }
            else
            {
               alert(msg.message);
            }
         },
      });
   }
   else
   {
      alert("Please Check Login Details");
   }
}
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
</script>