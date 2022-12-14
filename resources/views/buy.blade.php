<!DOCTYPE html>
<html>
<head>
    <title>Examen d'E-commerec</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/bootstrap.min.css')}}">
    <script type="text/javascript" src="{{asset('backend/assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="js/app.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <div style="text-align: center;">
                <h1 class="alert alert-info">EXAMEN E-COMMERCE</h1>
            </div>
            <ul class="" style="display: flex;list-style: none;text-decoration: none;">
                <li style="margin-left: 30%;"><a href="{{ route('welcome')}}">Accueil</a></li>
                <li style="margin-left: 50px;"><a href="">Produits</a></li>
                <li style="margin-left: 50px;"><a href="{{ route('register') }}">S'inscrire</a></li>
                <li style="margin-left: 50px;"><a href="{{ route('admin.login')}}">Se connecter</a></li>
            </ul>

            <br>
    <div>
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body bg-warning">
                    <h4 class="header-title"></h4>
                    <form action="{{ route('admin.orders.store') }}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-sm-6" id="dynamicDiv">
                            <input type="hidden" class="form-control" name="bon_no">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                        <div class="form-group">
                            <label for="name">Client</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Entrer le nom du client">
                        </div>
                        </div>
                        <div class="col-sm-6" id="dynamicDiv2">
                        <div class="form-group">
                            <label for="email">Client-Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Entrer email du client">
                        </div>
                        <!-- select payment mode lumicash or visa card -->
                        <div class="form-group">
                            <label for="paiement">mode de paiement</label>
                            <select class="form-control" name="paiement" id="paiement">
                                <option disabled="disabled" selected="selected">merci de choisir</option>
                                <option value="lumicash">LUMICASH</option>
                                <option value="carte_visa">CARTE VISA</option>
                            </select>
                        </div>
                    </div>

                         <table class="table table-bordered" id="dynamicTable">  
                            <tr class="bg-secondary">
                                <th>Article</th>
                                <th>Quantite Stock</th>
                                <th>Quantite</th>
                                <th>Action</th>
                            </tr>
                            <tr class="bg-warning">  
                                <td><input type="text" name="article_id" value="{{$article->name}}" class="form-control" readonly="readonly" /></td> 
                                <td><input type="text" name="article_id" value="{{$article->quantity}}" class="form-control" readonly="readonly" /></td> 
                                <td><input type="number" name="quantity[]" value="1" class="form-control" min="1" /></td>      
                                <td><button type="button" name="add" id="add" class="btn btn-success">Ajouter plus</button></td>  
                            </tr>  
                        </table> 
                        <div style="margin-top: 15px;margin-left: 15px;">
                            <button type="submit" class="btn btn-primary">Commander</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <br>
    <!-- footer -->
        <div class="jumbotron">
            <div>
                <h1 id="footer">&copy;2022 | DESIGNED BY AMBAZA MARCELLIN</h1>
            </div>
        </div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
        //dynamic add more
    var i = 0;
       
    $("#add").click(function(){
   
        ++i;

         var markup = "<tr class='bg-warning'>"+
                      "<td>"+
                            "<input type='text' name='' placeholder='Entrer produit' class='form-control' />"+
                        "</td>"+
                        "<td>"+
                          "<input type='number' name='quantity[]' placeholder='Entrer Quantity' class='form-control' />"+
                        "</td>"+
                        "<td>"+
                          "<button type='button' class='btn btn-danger remove-tr'>Supprimer</button>"+
                        "</td>"+
                    "</tr>";
   
        $("#dynamicTable").append(markup);
    });
   
    $(document).on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();
    }); 

    //dynamic select
    $('#paiement').change(function () { 
    if ($(this).val() === 'lumicash'){
      var telephone = "<div class='form-group'>"+
                            "<label for='telephone'>telephone No.</label>"+
                            "<input type='text' readonly='readonly' class='form-control' id='telephone' name='telephone' value='+257 69164310'>"+
                        "</div>";
        var code_transaction = "<div class='form-group'>"+
                            "<label for='code_transaction'>Code de Transaction</label>"+
                            "<input type='text' class='form-control' id='code_transaction' name='code_transaction' placeholder='Enter code de Transaction'>"+
                        "</div>";
        var prix =   "<div class='form-group'>"+
                            "<label for='prix'>Prix</label>"+
                            "<input type='text' class='form-control' id='prix' name='prix' readonly='readonly' value='{{$article->unit_price}} fbu'>"+
                        "</div>";

        $("#dynamicDiv").append(code_transaction,prix);
        $("#dynamicDiv2").append(telephone);
    }
    //dynamic select
    if ($(this).val() === 'carte_visa'){

        var date = "<div class='form-group'>"+
                            "<label for='date_expiration'>Date d'expiration</label>"+
                            "<input type='date' class='form-control' id='date_expiration' name='date_expiration'>"+
                        "</div>";
        var numero =   "<div class='form-group'>"+
                            "<label for='numero'>Numero de compte</label>"+
                            "<input type='text' class='form-control' id='numero' name='numero' placeholder='Enter Numero de compte'>"+
                        "</div>";
        var pin =   "<div class='form-group'>"+
                            "<label for='pin'>Code PIN</label>"+
                            "<input type='number' class='form-control' id='pin' name='pin' placeholder='Enter Code PIN'>"+
                        "</div>";
        var prix =   "<div class='form-group'>"+
                            "<label for='prix'>Prix</label>"+
                            "<input type='text' class='form-control' id='prix' name='prix' readonly='readonly' value='{{$article->unit_price / 3400}} $'>"+
                        "</div>";

        $("#dynamicDiv").append(date,prix);
        $("#dynamicDiv2").append(pin,numero);
    }
    })
    .trigger( "change" );

</script>
</body>
</html>