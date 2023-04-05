<?php
if (!auth()->check() || auth()->user()->user_status != 'active') {
  echo "<script>alert('Please login to access the system!');</script>";
  echo "<script>setTimeout(function() { window.location.href = '/login'; }, 1000);</script>";
  die();
}
?>

<?php
  if(auth()->user()->user_access_rights != 'Merchant') {
  echo "<script>alert('You are not a merchant!');</script>";
  echo "<script>setTimeout(function() { window.location.href = '/mainpage'; }, 1000);</script>";
  die();
  }
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fano's Shopping Inc.</title>
  <link rel="icon" type="image/x-icon" href="{{ URL::asset('images/Logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
                        .background {
                      position: fixed;
                      background-size: cover;
                      top: 0;
                      left: 0;
                      z-index: -1;
                      width: 100%;
                      height: 100%;
                      background-image: url('https://i.pinimg.com/originals/8d/0f/90/8d0f90e5a98953baec04fb85bc69b680.jpg');
                      filter: blur(5px);
                    }
                    .hr1 {
                        padding: 0;
                        margin: 0;
                    }
                    
                    footer {
                        background-color: rgba(255, 255, 255, 0.7);
                    }
                    
                    .h1-footer {
                        color: rgb(152, 255, 200);
                        text-align: center;
                        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
                    }
                    
                    .text-muted {
                        text-align: center;
                        color: white;
                    }
                    
                    img.sosimg {
                        height: 20px;
                        width: 20px;
                        margin-right: 2px;
                    }
  </style>

</head>

<body>

<div class ="background"></div>
<nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
  <div class="container-fluid">

  <nav class="navbar bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="">
      <img src="{{ URL::asset('images/Logo.png') }}" alt="" width="60" height="55" style="border-radius: 50%;">
    </a>
  </div>
</nav>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">



      <h1 class = "position-absolute top-50 start-50 translate-middle">Category Data Update</h1>

      <nav class="navbar navbar-expand-lg navbar-light bg-light">
    &nbsp;  &nbsp;
  <div class="dropdown ml-auto">


  </div>
</nav>
    </div>
  </div>
</nav>


<div class="container" style="margin-top: 30px; margin-bottom: 30px;">
  <div class="row justify-content-center">
    <div class="col-8">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('category.update', ['id' => $category->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">ID</label>
              <input type="number" name="id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$category->id}}" onchange="checkIdLength(this.value)" readonly>
            </div>

            <div class="mb-3">
              <label for="exampleInputName" class="form-label">Product Category</label>
              <input type="text" name="product_category" class="form-control" id="exampleInputName" aria-describedby="nameHelp" value="{{$category->product_category}}" onchange="checkNameLength(this.value)" required>
            </div>
            @if($errors->any())
              <div class="alert alert-danger" role="alert">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </div>
            @endif
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          @if($errors->has('error'))
            <div class="alert alert-danger mt-2" role="alert">
              {{ $errors->first('error') }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<footer>
<hr class="hr1">
<div class="container">
    <div class="row justify-content-center" >
    <div class="col-md-3 col-sm-6">
        <h3>Links</h3>
        <ul class="list-inline">
        <li><a class ="sos" href="https://github.com/Fano0612"><img class="sosimg" src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png"alt =""> Fano0612</li>
        <br><br>
        <li><a class ="sos" href="https://www.linkedin.com/in/yonathan-fanuel-mulyadi-08a690231/"><img class="sosimg" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/LinkedIn_logo_initials.png/800px-LinkedIn_logo_initials.png" alt="">Fano12.M</a></li>
        </ul>
      </div>
      
      <div class="col-md-3 col-sm-6">
        <h3>Stay Connected</h3>
        <ul class="list-inline">
        <li><a class ="sos" href="mailto:Fanomulyadi@gmail.com"><img class="sosimg" src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Gmail_icon_%282020%29.svg/2560px-Gmail_icon_%282020%29.svg.png"alt =""> Fanomulyadi@gmail.com</li>
        <br><br>
        <li><a class ="sos" href="https://www.instagram.com/fano12.m/"><img class="sosimg" src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Instagram_logo_2016.svg/2048px-Instagram_logo_2016.svg.png" alt="">Fano12.M</a></li>
      <br><br>
      <li><a class ="sos" href="https://wa.link/dikcdp"><img class="sosimg" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/640px-WhatsApp.svg.png" alt="">+6281398590772</a></li>
        </ul>
      </div>

    <div class="row">
      <div class="col-xs-12">
        <hr>
        <p class="text-muted">©2023<a href="https://www.instagram.com/fano12.m/"> Fano Mulyadi</a></p>
      </div>
    </div>
  </div>
  </div>
  <hr class="hr1">
</footer>

<script>
  function checkIdLength(id) {
    if (id.length !== 1) {
      alert('ID must be 1 digit only.');
    }
  }
</script>
<script>
  $(document).ready(function() {
    var initialValues = {
      id: $('input[name="id"]').val(),
      product_category: $('input[name="product_category"]').val(),
    };

    function isFormChanged() {
      var currentValues = {
        id: $('input[name="id"]').val(),
        product_category: $('input[name="product_category"]').val(),
      };

      return JSON.stringify(currentValues) !== JSON.stringify(initialValues);
    }

    $('form').submit(function() {
      if (!isFormChanged()) {
        $('button[type="submit"]').prop('disabled', true);
      }
    });

    $('input').on('change', function() {
      if (isFormChanged()) {
        $('button[type="submit"]').prop('disabled', false);
      }
    });
  });
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>

</html>