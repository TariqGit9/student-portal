<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>
<body>
    <div class="d-flex justify-content-center">
        <h3>Teacher credentials</h3>
    </div>
    <div class="container">
    <p>   Hello <strong> {{$user->name}}</strong>...</p>
    <p>   Your login credentials are </p>

    <p>   User Name :  {{$user_name}}</p>
    <p>   Password : {{$pass}}</p>
        <a class="btn btn-primary" href="http://localhost/student-portal/login" role="button">Login here!</a>
    </div>


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
