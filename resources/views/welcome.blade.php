<!DOCTYPE html>
<html>
<head>
    <title>Examen d'E-commerce</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <link rel="stylesheet" type="text/css" href="backend/assets/css/bootstrap.min.css">
    <script type="text/javascript" src="backend/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <div style="text-align: center;">
                <h1 class="alert alert-info">EXAMEN E-COMMERCE</h1>
            </div>
            <ul class="" style="display: flex;list-style: none;text-decoration: none;">
                <li style="margin-left: 30%;"><a href="">Accueil</a></li>
                <li style="margin-left: 50px;"><a href="">Produits</a></li>
                <li style="margin-left: 50px;"><a href="{{ route('register') }}">S'inscrire</a></li>
                <li style="margin-left: 50px;"><a href="{{ route('admin.login')}}">Se connecter</a></li>
            </ul>

            <br>
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-4">
                     <div class="single-discount-product mt-30">
                        <div class="product-image">
                            <img src="{{asset('storage/image_produits/'.$product->image)}}" width="300">
                        </div>
                        <div class="product-content">
                            <h4 class="content-title mb-15">{{$product->name}}&nbsp;<span>{{number_format($product->unit_price,0,' ',' ')}} fbu</span><br></h4>
                            <a href="{{ route('buy',$product->id)}}" class="btn btn-danger">Acheter <i class="lni-chevron-right"></i></a>
                        </div>
                    </div>
                    <div>
                        <div>
                            {{$product->specification}}
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
        <br>
        <div class="jumbotron">
            <div>
                <h1 id="footer">&copy;2022 | DESIGNED BY AMBAZA MARCELLIN</h1>
            </div>
        </div>
    </div>
</body>
</html>