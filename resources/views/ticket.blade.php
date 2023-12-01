<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Ticket</title>

    <style>
        #content {
            background-color: #F6F6F6;
        }

        ul {
            list-style-type: none;
        }

        ul li {
            margin-block: 15px;
        }

        ul.first li {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-6 shadow-lg" id="content">
                <div class="text-center">
                    <small>*********************</small>
                </div>
                <h5 class="" style="font-style: italic;text-align:center">{{$agency_of_this_agent->name}}</h5>
                <p class="text-center">{{$agency_of_this_agent->country}} / {{$agency_of_this_agent->commune}}</p>
                <p class="text-center">
                    <span> IFU: {{$agency_of_this_agent->ifu}}</span><br>
                    <span> Tel: {{$agency_of_this_agent->phone}}</span>
                </p>

                <div class="text-center">
                    <small>*********************</small>
                </div>

                <br>

                <hr>
                <p class="">Le <strong> <?php echo date("Y/m/d") ?></p>
                <p class="">{{$agency_of_this_agent->name}}</p>
                <p class="">Ticket N° {{$reference}}</p>
                <hr>

                <br>

                <!-- LES PRODUITS -->
                <table class="table table table-striped">
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="text-center">{{$product->name}}</td>
                            <td class="text-center">{{ PRODUCT_QTY($command->id,$product->id)}} x {{$product->price}} :</td>
                            <td class="text-center"> <strong>{{ PRODUCT_PRICE_X_QTY($product->price,PRODUCT_QTY($command->id,$product->id))}} fcfa</strong> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- LES TOTAUX -->
                <hr>
                <table class="table table table-striped px-0 mx-0">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-md-6">
                                <ul class="first">
                                    <li>TOTAL</li>
                                    <li>TVA 18%</li>
                                    <li>Rendu</li>
                                </ul>
                            </td>
                            <td class="col-md-6">
                                <ul>
                                    <li> <strong> <em>{{$total}}</em> </strong></li>
                                    <li>{{TVA($total)}}</li>
                                    <li><?php echo ($total + TVA($total)) ?></li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>

                <br>
                <!--  -->

                <p class="text-center">
                    Les articles achetés ne seront ni échanger ni retourner. <br> Merci de votre visite.
                </p>

                <br>

                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-center">Ce ticket n'est pas normalisé</h6>
                        <p class="text-center">
                            Ce ticket n'est pas encore normalisé! Pensez à sa normalisation.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

    <!-- Saut de page -->
    <!-- <div style="page-break-after: always;"></div> -->
</body>

</html>