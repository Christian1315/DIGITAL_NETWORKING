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
                <p class="text-center">Cotonou le, <strong> <?php echo date("Y/m/d") ?> </strong> </p>
                <br>
                <h3 class="text-center reference">Reference N°: <strong> {{$facture->reference}} </strong> </h3>
                <br>

                <table class="table table table-striped px-0 mx-0">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="text-center block one">
                                    <h4 class="title">{{$master_of_this_agent->raison_sociale}}</h4>
                                    <!-- <br> -->
                                    <p class="info-master">
                                        <strong>Téléphone</strong>: <small>{{$master_of_this_agent->raison_sociale}}</small> <br>
                                        <strong>Pays</strong> : <small>{{$master_of_this_agent->country}}</small> <br>
                                        <strong>Commune</strong>: <small>{{$master_of_this_agent->commune}}</small> <br>
                                    </p>
                                    <!-- <br></br><br> -->
                                    <p class="">
                                        <strong>IFU</strong> : <small>{{$master_of_this_agent->ifu}}</small> <br>
                                        <span> <strong>FACTURE DU :</strong> <?php echo date("Y/m/d") ?> </span> <br>
                                        <span> <strong>Réference : </strong> {{$facture->reference}}</span> <br>
                                    </p>
                                </div>
                            </td>

                            <td>
                                <div class="text-center block two">
                                    <div class="" style="align-items:center;padding-right:50px">
                                        <span>
                                            <h4 class="text-center">Code MECEF/DGI</h4>
                                            <p class="text-center"> <strong> {{$dgi_details["codeMECeFDGI"]}}</strong></p>
                                            <ul style="list-style-type: none;">
                                                <li> <strong>MECeF NIM :</strong> {{$dgi_details["nim"]}}</li>
                                                <li> <strong>MECeF :</strong> {{$dgi_details["counters"]}}</li>
                                                <li> <strong>MECeF Heure :</strong> {{$dgi_details["dateTime"]}}</li>
                                            </ul>
                                        </span>
                                        <span>
                                            <div class="text-center code_qr">
                                                <img src="{{$code_qr_img}}" width="80px" alt="" srcset="">
                                            </div>
                                        </span>
                                    </div>
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
                    <th scope="col">P.U.TTC (en FCFA)</th>
                    <th scope="col">Qté</th>
                    <th scope="col">% Rem</th>
                    <th scope="col">% TVA</th>
                    <th scope="col">T.S</th>
                    <th scope="col">Montant TTC (en FCFA)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td class="block">{{$product->name}}</td>
                    <td class="block">{{$product->description}}</td>
                    <td class="block">{{$product->price}}</td>
                    <td class="block"> <?php echo $product->qty ? $product->qty : 1 ?></td>
                    <td class="block"></td>
                    <td class="block">{{TVA($product->price)}}</td>
                    <td class="block"></td>
                    <td class="block">{{$product->price}}</td>
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
                    <td class="block text-end">B-TAX</td>
                    <td class="block text-end">504 288</td>
                    <td class="block text-end">90 772</td>
                    <td class="block text-end">2</td>
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
                    <td class="block text-end">504 288</td>
                    <td class="block text-end">90 772</td>
                    <td class="block text-end">0</td>
                    <td class="block text-end"></td>
                    <td class="block text-end"></td>
                    <td class="block text-end">595060</td>
                    <td class="block text-end">595 060</td>
                </tr>
            </tbody>
        </table>

        <p class="">
            Arrêtée, la présente facture à la somme de $total FCFA TTC.
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
                        <span> <strong>SOCIETE: </strong>{{$master_of_this_agent->raison_sociale}}</span><br>
                        <span> <strong>RCCM: </strong> {{$master_of_this_agent->rccm}}</span><br>
                    </td>
                    <td>
                        <p class="text-right">Fait à Cotonou le, <strong> <?php echo date("Y/m/d") ?> </strong> </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Saut de page -->
    <!-- <div style="page-break-after: always;"></div> -->
</body>

</html>