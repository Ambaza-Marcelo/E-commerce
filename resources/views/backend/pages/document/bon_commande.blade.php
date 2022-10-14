<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        tr,th,td{
             border: 1px solid black;
             text-align: center;
             width: 114px;
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
                           &nbsp;&nbsp; Bon de commande
                        </small><br>
                        <small>
                           &nbsp;&nbsp; No: {{ $code }}
                        </small><br>

                        <small>
                           &nbsp;&nbsp; Date : Le {{ date('d') }}/{{date('m')}} / {{ date('Y')}}
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
                                    <th>Specification</th>
                                    <th>Unité</th>
                                    <th>Quantite</th>
                                    <th>Date Fin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->article->name }}</td>
                                    <td>{{ $data->article->specification }}</td>
                                    <td>{{ $data->article->unit }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->end_date)->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br><br>
                <div>
                    &nbsp;&nbsp;{{ $description }}
                </div>
                <br>
                    <div style="display: flex;">
                        <div style="float: left center; margin-right: 0;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;chef S. Généreaux et signature
                            <div>
                                &nbsp;&nbsp;
                            </div>
                        </div>

                        <div style="float: right center; margin-left: 250px;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;DAF et signature
                            <div>
                                
                            </div>
                        </div>
                        <div style="float: right;width: 242px;padding-bottom: 40px;">
                            &nbsp;&nbsp;DG et signature
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

