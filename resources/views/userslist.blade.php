<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Users List</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
   </head>
   <body>
      <div class="container">
         <div class="row">
            <div class="col-md-12"><br></div>
            <div class="col-md-6" align="right">
               <h4>Users List</h4>
            </div>
            <div class="col-md-6" align="right">
               <button class="btn btn-primary btn-login text-uppercase fw-bold" type="button" onclick="logout()">Logout</button>
            </div>
            <div class="col-md-12"><br></div>
            <div class="col-md-12">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>City</th>
                     </tr>
                  </thead>
                  <tbody id="tbody"></tbody>
               </table>
            </div>
         </div>
      </div>
   </body>
</html>
<script type="text/javascript">
$(document).ready(function(){
   userslist();
});
function userslist()
{
   $.ajax({
      type: "POST",
      url: "{{url('api/userslist')}}",
      headers: {
         "Authorization": "Bearer {{Session::get('token')}}"
      },
      data: {'_token' : '{{csrf_token()}}'},
      dataType: 'json',
      success: function (msg) 
      {
         if(msg.code==200)
         {
            var data    = msg.data;
            var html    = '';
            sno = 1;
            for (var i = 0; i < data.length; i++) 
            {
               html       += '<tr><td width="20%">'+data[i]['firstname']+'</td><td width="20%">'+data[i]['lastname']+'</td><td width="20%">'+data[i]['mobile']+'</td><td width="20%">'+data[i]['email']+'</td><td width="20%">'+data[i]['city']+'</td></tr>';
            }
            $("#tbody").html(html);
         }
      },
   });
}
function logout()
{
   $.ajax({
      type: "POST",
      url: "{{url('api/logout')}}",
      headers: {
         "Authorization": "Bearer {{Session::get('token')}}"
      },
      data: {'_token' : '{{csrf_token()}}'},
      dataType: 'json',
      success: function (msg) 
      {
         if(msg.code==200)
         {
            window.location.href = "{{url('/login')}}";
         }
      },
   });
}


</script>