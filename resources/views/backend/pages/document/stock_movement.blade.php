<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        tr,th,td{
             border: 1px solid black;
             text-align: center;
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
                    <div style="float: right; border-top-right-radius: 10px solid black;border-top-left-radius: 10px solid black;border-bottom-right-radius: 10px solid black;border-bottom-left-radius: 10px solid black; background-color: rgb(150,150,150);width: 242px;padding: 20px;">
                        <small>
                           &nbsp;&nbsp; Mouvement du stock
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
                                    <th>Date</th>
                                    <th>Article</th>
                                    <th>Specification</th>
                                    <th>C.U.M.P</th>
                                    <th>Stock Initial</th>
                                    <th>Entrée</th>
                                    <th>Stock Total</th>
                                    <th>Sortie</th>
                                    <th>Destination</th>
                                    <th>Auteur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $data->article->name }}</td>
                                    <td>{{ $data->article->specification }}</td>
                                    <td>{{ number_format($data->article->unit_price,0,',','.') }}fbu</td>
                                    <td>{{ $data->quantity_stock_initial }}</td>
                                    <td>{{ $data->quantity_stockin }}</td>
                                    <td>{{ $data->stock_total }}</td>
                                    <td>{{ $data->quantity_stockout }}</td>
                                    <td>@if($data->service_id){{ $data->service->name }}@endif</td>
                                    <td>{{ $data->created_by }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br><br>
                    <div style="display: flex;">
                        <div style="float: left center; margin-right: 0;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;Gestionnaire et signature
                            <div>
                                &nbsp;&nbsp;
                            </div>
                        </div>

                        <div style="float: right center; margin-left: 200px;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;Chef S. Généraux et signature
                            <div>
                                
                            </div>
                        </div>
                        <div style="float: right;margin-right: 15px;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;DAF et signature
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

