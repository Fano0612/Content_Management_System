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

  <div class="background"></div>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">

  <nav class="navbar bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="{{route ('mainpage')}}">
      <img src="{{ URL::asset('images/Logo.png') }}" alt="" width="60" height="55" style="border-radius: 50%;">
    </a>
  </div>
</nav>
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center text-lg-start">
      <li class="nav-item">
          <a class="nav-link"  href="{{route ('mainpage')}}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route ('productlist')}}">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route ('product_menu')}}">Manage</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page"href="{{route ('category')}}">Category</a>
        </li>
      </ul>



  
  
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a href="{{route ('cart.showdata')}}">
      <i class="fa fa-shopping-cart" style="font-size:36px"></i>
      </a>
    &nbsp;  &nbsp;
  <div class="dropdown ml-auto" style="margin-left: auto;">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <img src="{{ URL::asset('images/Logo.png') }}" alt="" width="60" height="55" style="border-radius: 50%;">
    </button>
    <div class="dropdown-menu dropdown-menu-right position-relative" aria-labelledby="dropdownMenuButton" >
    @if (auth()->check())
    <a class="dropdown-item" href="">Hello <b>{{ auth()->user()->user_username }}</a>
@endif
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{route ('logout')}}">Logout</a>

    </div>
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
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="number" name="id" class="form-control {{ $errors->has('id') ? 'is-invalid' : '' }}" id="id" placeholder="Enter ID" value="{{ old('id') }}" required>

                        </div>

                        <div class="mb-3">
                            <label for="product_category" class="form-label">Product Category</label>
                            <input type="text" name="product_category" class="form-control {{ $errors->has('product_category') ? 'is-invalid' : '' }}" id="product_category"  placeholder="Enter Product Category" value="{{ old('product_category') }}" required>
   
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



  <div class="container">
    <div class="row">
      <table class="table table-dark table-striped-columns">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Product Category</th>
            <th scope="col" style="text-align: center;">Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($category as $cat)
                <tr>
                    <th scope="row">{{$cat->id}}</th>
                    <td>{{$cat->product_category}}</td>
                    <td style="text-align: center;">
                    <a href="{{ route('category.edit', ['id' => $cat->id]) }}" class="btn btn-success">Edit</a>



                        <a href="#" class="btn btn-danger delete" data-id="{{$cat->id}}">Delete</a>
                    </td>
                </tr>
                @endforeach

        </tbody>
      </table>
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


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>

<script>
  $('.delete').click(function() {
    var catId = $(this).data('id');
    swal({
        title: "Delete Category?",
        text: "Delete category " + catId + "?\n" + "Once it's deleted, you won't be able to recover this category anymore",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        closeOnClickOutside: false,
        closeOnEsc: false,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "{{ url('category') }}" + '/' + catId,
            type: "POST",
            data: {
              '_method': 'DELETE',
              '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
              swal("Category has been deleted successfully!", {
                icon: "success",
              }).then(() => {
                window.location.reload();
              });
            },
            error: function(data) {
              swal("Oops", "You can't delete a category with products connected to it", "error");
            }
          });
        } else {
          swal("Category deletion cancelled!");
        }
      });
  });
</script>



</html>