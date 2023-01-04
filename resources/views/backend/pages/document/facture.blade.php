<!-- invoice-->
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        tr,th,td{
             border: 1px solid black;
             width: 135px;
             text-align: center;
        }
        .signature{
            display: flex;
        }
    </style>
</head>

<body>
<div>
    <div>
        <div>
            <div>
               <div>
                </div>
                <!-- invoice titel -->
                <h1 style="text-decoration: underline;text-align: center;">FACTURE</h1>
                <div>

                    <br>
                    <div style="float: right; border-top-right-radius: 10px solid black;border-top-left-radius: 10px solid black;border-bottom-right-radius: 10px solid black;border-bottom-left-radius: 10px solid black;background-color: rgb(150,150,150);width: 242px;">
                        <small>
                           &nbsp;&nbsp; Facture
                        </small><br>
                        <small>
                           &nbsp;&nbsp; Ref/ : {{ $bon_no}}
                        </small><br>
                        <small>
                           &nbsp;&nbsp; commande No : {{ $commande_no}}
                        </small><br>
                        <small>
                           &nbsp;&nbsp; Date : Le {{ date('d') }}/{{date('m')}}/{{ date('Y')}}
                        </small>
                    </div>
                    <br><br><br><br><br>
                    <br><br><br>
                    <div>
                        <table style="border: 1px solid black;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix Unitaire</th>
                                    <th>Valeur Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->article->name }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ number_format($data->article->unit_price,0,',','.' )}}fbu</td>
                                    <td>{{ number_format($data->total_value,0,',','.' )}}fbu</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <!-- total value -->
                                <tr>
                                    <th>Total</th>
                                    <th style="background-color: rgb(150,150,150);" colspan="3"></th>
                                    <th>{{ number_format($totalValue,0,',','.') }}fbu</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <br><br>
                <div>
                    &nbsp;&nbsp;{{ $description }}
                </div>
                <br>
                    <div style="display: flex;">
                        <div style="float: left;">
                            &nbsp;&nbsp;Nom Client
                            <div>
                                &nbsp;&nbsp;{{ $customer }}
                            </div>
                        </div>
                        <div style="float: right;">
                            &nbsp;&nbsp;Merci!
                            <div>
                                &nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

