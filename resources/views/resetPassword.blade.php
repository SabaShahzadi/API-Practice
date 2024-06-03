<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>
<body>
    <form action="{{ route('new.password') }}" method="post">
        @csrf
         <div class="form-group">
 
    <input type="hidden" class="form-control"  name="id",value={{ $userData[0]['id'] }}>
    
  </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Enter Name</label>
    <input type="text" class="form-control"  name="name" value="{{ $userData[0]['name'] }}">
  
  </div>
  @error('name')
           {{ $message }}
         @enderror
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control"  name="email" value="{{ $userData[0]['email'] }}">
    
  </div>
    @error('email')
           {{ $message }}
         @enderror
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control"  name="password">
  </div>

  
   @error('password')
           {{ $message }}
         @enderror

   <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control"  name="re-password">
  </div>

   @error('re-password')
           {{ $message }}
         @enderror
 <input type="submit" value="Submit"> Submit
</form>
</body>
</html>