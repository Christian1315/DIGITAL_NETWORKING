<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Facture Client</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row" style="background-color: #2f80ec;">
            <div class="col-md-12">
                <p class="text-light text-center mt-2"> <strong>FACTURE DE COMMANDE SUR DIGITAL NETWORK</strong></p>
            </div>
        </div>
        <br>
        <div class="row mt-3">
            <div class="col-md-12">
                <h1 class="text-center">Reference : <strong style="background-color: #000;padding:10px;color:#fff"> {{$reference}} </strong> </h1>
                <br>
                <table class="table table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Client</th>
                            <th scope="col">Entreprise</th>
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
                                    <strong>Company :</strong>{{env("APP_NAME")}}<br>
                                    <strong>N° IFU :</strong>{{env("DIGITAL_IFU")}} <br>
                                    <strong>Téléphone:</strong>{{env("DIGITAL_PHONE")}}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br><br><br>
        <div class="row">
            <div class="col-12">
                <h1 class="" style="font-style: italic;text-align:center">Détail de la Facture</h1>
                <table class="table table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Commande</th>
                            <th scope="col">Produit</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Quantité </th>
                            <th scope="col">Prix total</th>
                            <th scope="col">Date de la commande</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commands as $command)
                        <tr>
                            <th scope="row">{{$loop->index + 1}}</th>
                            <td class="text-center">{{$command->id}}</td>
                            <td class="text-center">
                                <table class="table table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Prix</th>
                                            <th scope="col">Date de la commande</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td>
                                                {{$product->name}}
                                            </td>
                                            <td>
                                                {{$product->price}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td class="text-center">{{$command->product_datas->price}}</td>
                            <td class="text-center">{{$command->qty}}</td>
                            <td class="text-danger text-center">{{$command->amount}}</td>
                            <td class="text-center">{{$command->created_at}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th scope="row"></th>
                            <td class="text-center" colspan="3" style="font-style: italic;">Total à payer :</td>
                            <td class="text-center text-danger"> <strong style="background-color: #000;color:#fff;padding:5px;">{{$total}}</strong></td>
                            <td class="text-danger text-center"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

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
        </div>
    </div>

    <!-- Saut de page -->
    <!-- <div style="page-break-after: always;"></div> -->
</body>

</html>