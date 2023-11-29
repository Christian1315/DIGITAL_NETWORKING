<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Facture Client</title>

    <style>
        small {
            font-size: 10px !important;
        }

        th {
            font-size: 10px !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-12">
                <p class="text-left">Cotonou le, <strong> <?php echo date("Y/m/d") ?> </strong> </p>
                <p class="text-right">Reference : <strong style="background-color: #000;padding:5px;color:#fff"> {{$reference}} </strong> </p>
                <table class="table table table-striped px-0 mx-0">
                    <thead>
                        <tr>
                            <th scope="col">Client</th>
                            <th scope="col">Entreprise</th>
                            <th scope="col">Info de la DGI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="">
                                    <strong>Nom :</strong>{{$client->firstname}} <br>
                                    <strong>Prénom :</strong>{{$client->lastname}} <br>
                                </div>
                            </td>
                            <td>
                                <div class="">
                                    <strong>Company :</strong>{{$master_of_this_agent->raison_sociale}}<br>
                                    <strong>N° IFU :</strong>{{$master_of_this_agent->ifu}} <br>
                                    <!-- <strong>Téléphone:</strong>{{$master_of_this_agent->phone}} -->
                                </div>
                            </td>
                            <td>
                                <h6 class="text-center">Code MECEF/DGI</h6>
                                <div class="">
                                    <span class="">
                                        <small>MECeF NIM:</small> <small>ED04001172</small>;
                                        <small>MECeF Compteur:</small> <small>88584/69346 FV</small>;
                                        <small>MECeF Heure S:</small> <small><?php echo date("Y/m/d") ?></small>
                                    </span><br>
                                    <div class="text-center">
                                        <img src="QR_Code_example.png" style="width: 50px;height:50px" alt="" srcset="">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="" style="font-style: italic;text-align:center">Détail de la Facture</p>
                <table class="table table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">N° Commande</th>
                            <th scope="col" class="text-center">Produit</th>
                            <th scope="col" class="text-center">Prix total</th>
                            <th scope="col" class="text-center">Date de la commande</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">{{$command->id}}</td>
                            <td class="text-center">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Prix</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <strong style="font-style: italic;font-size:10px!important">{{$product->name}}</strong>
                                            </td>
                                            <td class="text-danger">
                                                <strong style="font-style: italic;">{{$product->price}}</strong>
                                            </td>
                                            <td>
                                                {{ PRODUCT_QTY($command->id,$product->id)}}
                                            </td>
                                            <td>
                                               <strong> {{ PRODUCT_PRICE_X_QTY($product->price,PRODUCT_QTY($command->id,$product->id))}}</strong>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td class="text-danger text-center">{{$command->amount}}</td>
                            <td class="text-center">{{$command->created_at}}</td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td class="text-center" colspan="3" style="font-style: italic;">Total à payer : <strong style="background-color: #000;color:#fff;padding:5px;">{{$total}}</strong></td>
                            <td class="text-center text-danger"> </td>
                            <td class="text-danger text-center"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="https://res.cloudinary.com/duk6hzmju/image/upload/v1696441954/digital-logo_micxsx.jpg" width="50px" alt="" srcset="">
            </div>
        </div>
        <br><br>
        <div class="row bottom-fixed" style="background-color: #2f80ec;">
            <div class="col-md-12">
                <p class="text-light text-center mt-2">© Copyright - <?php echo date("Y"); ?> - DIGITAL NETWORK</p>
            </div>
        </div> -->
    </div>

    <!-- Saut de page -->
    <!-- <div style="page-break-after: always;"></div> -->
</body>

</html>