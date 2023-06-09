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

<?php
if (isset($_FILES['product_picture']) && $_FILES['product_picture']['error'] == UPLOAD_ERR_OK) {
  $tmp_name = $_FILES['product_picture']['tmp_name'];
  $name = $_FILES['product_picture']['name'];
  move_uploaded_file($tmp_name, "uploads/$name");
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
  <script>
    $(document).ready(function() {

      $("form").submit(function(event) {
        var product_id = $("#exampleInputEmail1").val();
        var product_name = $("#exampleInputName").val();
        var exist = false;
        $("table tbody tr").each(function() {
          var id = $(this).find("th:eq(0)").text();
          var name = $(this).find("td:eq(0)").text();
          if (id == product_id || name == product_name) {
            exist = true;
            return false;
          }
        });
        if (exist) {
          alert("Product already exists in the table.");
          event.preventDefault();
        }
      });
    });
  </script>

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
          <a class="nav-link active" aria-current="page" href="{{route ('product_menu')}}">Manage</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route ('category')}}">Category</a>
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
            <form action="/insertproduct" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Product ID</label>
                <input type="number" name="product_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" onchange="checkIdLength(this.value)" required>
                <script>
                  function checkIdLength(id) {
                    if (id.length !== 5) {
                      alert("Invalid Product ID! \nPlease enter a 5 digit number.");
                      document.getElementById("exampleInputEmail1").value = "";
                    }
                  }
                </script>
              </div>

              <div class="mb-3">
                <label for="exampleInputName" class="form-label">Product Name</label>
                <input type="text" name="product_name" class="form-control" id="exampleInputName" aria-describedby="nameHelp" onchange="checkNameLength(this.value)" required>
                <span id="name-error-msg" class="error-msg"></span>
                <script>
                  function checkNameLength(name) {
                    if (name.length > 255) {
                      alert("Invalid Name! Please enter a name with less than 255 characters.");
                      document.getElementById("exampleInputName").value = "";
                      document.getElementById("name-error-msg").textContent = "";
                    } else {
                      document.getElementById("name-error-msg").textContent = "";
                    }
                  }
                </script>
              </div>

              <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Price</label>
                  <div class="input-group mb-3">
                  <span class="input-group-text">Rp</span>
                  <input type="number" name="product_price" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  <span class="input-group-text">.00</span>
                </div>
                <script>
                  $(document).ready(function() {
                    $('form').submit(function(event) {
                      var price = $('input[name="product_price"]').val();
                      if (isNaN(price)) {
                        alert('Please enter a valid number for the price.');
                        event.preventDefault();
                      }
                    });
                  });
                </script>

              </div>

              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Stock</label>
                <input type="number" name="product_stock" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="1" min="1" required>
              </div>



              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Picture</label>
                <input type="file" name="product_picture" class="form-control custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" required>
              </div>

              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Product Category</label>
                <select class="form-select" name="category_id" aria-label="Default select example" required>
                  <option value="" selected disabled hidden>Choose a category</option>
                  @php
                    $category = App\Models\Product_Category::all();
                  @endphp
                  @foreach($category as $cat)
                  <option value="{{$cat->id}}">{{$cat->product_category}}</option>
                @endforeach
                </select>
                <span id="category-error-msg" class="error-msg"></span>
                <script>
                  function checkCategory(category) {
                    if (category === "") {
                      document.getElementById("category-error-msg").textContent = "Please choose a category";
                      return false;
                    } else {
                      document.getElementById("category-error-msg").textContent = "";
                      return true;
                    }
                  }

                  document.querySelector("form").addEventListener("submit", function(event) {
                    const category = document.querySelector("[name='category_id']").value;
                    if (!checkCategory(category)) {
                      event.preventDefault();
                    }
                  });
                </script>
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
            <th scope="col">Product ID</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Stock</th>
            <th scope="col">Picture</th>
            <th scope="col">Category</th>
            <th scope="col" style="text-align: center;">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $prod)
          <tr>
            <th scope="row">{{$prod->product_id}}</th>
            <td>{{$prod->product_name}}</td>
            <td>Rp {{ number_format($prod->product_price, 0, ',', '.') }}.00</td>
            <td>{{$prod->product_stock}}</td>
            <td><img src="{{ URL::asset('images/product_pictures/'.$prod->product_picture) }}" alt=""  class="card-img-top"></td>
            <td>{{ $prod->product__category->product_category }}</td>
            <td style="text-align: center;">
              <a href="/showproduct/{{$prod->product_id}}" class="btn btn-success">Edit</a>
              <a href="#" class="btn btn-danger delete" id-data="{{$prod->product_id}}">Delete</a>
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
    var stdid = $(this).attr('id-data');
    swal({
        title: "Delete Data?",
        text: "Delete " + stdid + "?\n" + "Once it's deleted, you won't be able to recover this data anymore",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        closeOnClickOutside: false,
        closeOnEsc: false,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal("Data has been deleted successfully!", {
            icon: "success",
          }).then(() => {
            window.location = "/deleteproduct/" + stdid;
          });
        } else {
          swal("Data deletion cancelled!");
        }
      });
  });
</script>

</html>