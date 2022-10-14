<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        tr,th,td{
             border: 1px solid black;
             text-align: center;
             width: 65px;
        }

    </style>

<body>
<div>
    <div>
        <div>
            <div>
                <div>
                   <!-- <img src="{{ asset('img.logopiece.jpg')}}"> -->
                  <!-- <h1>MUSUMBA STEEL</h1> -->
                   <img src="img/logopiece.jpg" width="695" height="45">
                </div>
                <div>
                    <div style="float: left;">
                          <small> &nbsp;&nbsp;{{$setting->commune}}-{{$setting->zone}}</small><br>
                          <small>&nbsp;&nbsp;{{$setting->rue}}</small><br>
                          <small>&nbsp;&nbsp;{{$setting->telephone1}}-{{$setting->telephone2}}</small><br>
                          <small>&nbsp;&nbsp;{{$setting->email}}</small>
                    </div>
                    <br>
                    <div style="float: right; border-top-right-radius: 10px solid black;border-top-left-radius: 10px solid black;border-bottom-right-radius: 10px solid black;border-bottom-left-radius: 10px solid black; background-color: rgb(150,150,150);width: 242px;">
                        <small>
                           &nbsp;&nbsp; Etat du stock
                        </small><br>
                        <small>
                           &nbsp;&nbsp; Date : {{ $dateTime }}
                        </small>
                    </div>
                    <br><br><br><br><br>
                    <br><br><br>
                    <div>
                        <table style="border: 1px solid black;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Article</th>
                                    <th>code</th>
                                    <th>Quantite</th>
                                    <th>Unité</th>
                                    <th>Categorie</th>
                                    <th>Valeur Unitaire</th>
                                    <th>Valeur Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->article->name }}</td>
                                    <td>{{ $data->article->code }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ $data->unit }}</td>
                                    <td>{{ $data->article->categoryRayon->category->name }}</td>
                                    <td>{{ number_format($data->article->unit_price,0,',','.' )}}fbu</td>
                                    <td>{{ number_format($data->total_value,0,',','.' )}}fbu</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th style="background-color: rgb(150,150,150);" colspan="6"></th>
                                    <th>{{ number_format($totalValue,0,',','.') }}fbu</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <br><br>
                    <div style="display: flex;">
                        <div style="float: left center; margin-right: 0;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;Gestionnaire Stock et signature
                            <div>

                            </div>
                        </div>
                    </div>
 
            </div>
        </div>
    </div>
</div>
</body>
</html>

