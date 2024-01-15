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

        .content {
            background-color: #f6f6f6;
            padding: 10px;
        }

        .reference strong {
            border: solid 2px #000;
            color: #000;
            padding: 5px;
        }

        .block {
            border: solid 1px #000;
            padding: 10px;
        }

        .block .title {
            text-transform: uppercase;
        }

        .totaux>.block {
            margin-right: 20px !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid content">
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table table table-striped px-0 mx-0">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left">
                                <img src="{{$agency_of_this_agent_img}}" width="40%" height="100px" alt="" srcset="">
                            </td>
                            <td>
                                <p class="text-right">Cotonou le, <strong> <?php echo date("Y/m/d") ?> </strong> </p>
                                <br>
                                <h5 class="text-right reference">Reference N°: <strong> {{$reference}} </strong> </h5>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table table-striped px-0 mx-0">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="text-center block one">
                                    <h4 class="title">{{$agency_of_this_agent->name}}</h4>
                                    <!-- <br> -->
                                    <p class="info-master">
                                        <strong>Téléphone</strong>: <small>{{$agency_of_this_agent->phone}}</small> <br>
                                        <strong>Pays</strong> : <small>{{$agency_of_this_agent->country}}</small> <br>
                                        <strong>Commune</strong>: <small>{{$agency_of_this_agent->commune}}</small> <br>
                                    </p>
                                    
                                    <p class="">
                                        <strong>IFU</strong> : <small>{{$agency_of_this_agent->ifu}}</small> <br>
                                        <span> <strong>FACTURE DU :</strong> <?php echo date("Y/m/d") ?> </span> <br>
                                        <span> <strong>Réference : </strong> {{$reference}}</span> <br>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LES ITEMS -->
        <table class="table table table-striped px-0 mx-0">
            <thead>
                <tr>
                    <th scope="col">Items</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Prix (en FCFA)</th>
                    <th scope="col">Qté</th>
                    <th scope="col">% Rem</th>
                    <th scope="col">% TVA</th>
                    <th scope="col">T.S</th>
                    <th scope="col">Montant TTC (en FCFA)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                @php
                $qty = $product->pivot->qty ? $product->pivot->qty : 1;
                @endphp
                <tr>
                    <td class="block">{{$product->name}}</td>
                    <td class="block">{{$product->description}}</td>
                    <td class="block">{{$product->price}}</td>
                    <td class="block"> <?php echo $product->pivot->qty ? $product->pivot->qty : 1 ?></td>
                    <td class="block">{{REMISE($product->price)}}</td>
                    <td class="block">{{TVA($product->price, $qty)}}</td>
                    <td class="block">{{TS($product->price)}}</td>
                    <td class="block">{{TTC($product->price)}}</td>
                </tr>
                @endforeach

                <!--  -->
                <tr>
                    <td class="text-right" colspan="7">Total à payer :</td>
                    <td class="text-center" style="font-style: italic;"> <strong style="background-color: #000;color:#fff;padding:5px;">{{$total}}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- GROUPES & TAX -->
        <table class="table table table-striped px-0 mx-0">
            <thead>
                <tr>
                    <th scope="col">Groupe Tax</th>
                    <th scope="col">Montant HT</th>
                    <th scope="col">Montant TVA</th>
                    <th scope="col">Nb.lignes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="block text-end">{{env("OUR_FACTURE_TAX_GROUP")}}-TAX</td>
                    <td class="block text-end">{{HT($total)}}</td>
                    <td class="block text-end">{{TVA($total,1)}}</td>
                    <td class="block text-end"></td>
                </tr>
            </tbody>
        </table>

        <!-- LES TOTAUX -->
        <table class="table table table-striped px-0 mx-0">
            <thead>
                <tr>
                    <th scope="col">Total HT</th>
                    <th scope="col">Total TVA</th>
                    <th scope="col">Total Remise</th>
                    <th scope="col">Total TS</th>
                    <th scope="col">Total AIB</th>
                    <th scope="col">Total TTC</th>
                    <th scope="col">Net à Payer</th>
                </tr>
            </thead>
            <tbody>
                <tr class="totaux">
                    <td class="block text-end">{{HT($total)}}</td>
                    <td class="block text-end">{{TVA($total,1)}}</td>
                    <td class="block text-end">{{REMISE($total)}}</td>
                    <td class="block text-end">{{TS($total)}}</td>
                    <td class="block text-end">{{AIB($total)}}</td>
                    <td class="block text-end">{{TTC($total)}}</td>
                    <td class="block text-end">{{TTC($total)}}</td>
                </tr>
            </tbody>
        </table>

        <p class="">
            Arrêtée, la présente facture à la somme de <span class="bg-dark p-2 text-white">{{TTC($total)}}</span> FCFA .
        </p>

        <p class="text-right">
            <a href="" style="color:#000;text-decoration:underline">Signature du Responsable</a>
            <br>
            <br>
            Responsable Administratif et Financier
        </p>

        <!-- FACTURE FOOTER -->
        <table class="table table table-striped px-0 mx-0">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="totaux">
                    <td class="">
                        <span> <strong>SOCIETE: </strong>{{$agency_of_this_agent->name}}</span><br>
                        <span> <strong>RCCM: </strong> {{$agency_of_this_agent->rccm}}</span><br>
                    </td>
                    <td>
                        <p class="text-right">Fait à Cotonou le, <strong> <?php echo date("Y/m/d") ?> </strong> </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>