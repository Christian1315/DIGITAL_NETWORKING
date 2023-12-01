<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Rapport </title>

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
                                <img src="{{$agency_of_this_agent_img}}" width="100px" height="100px" alt="" srcset="">
                            </td>
                            <td>
                                <p class="text-right">Cotonou le, <strong> <?php echo date("Y/m/d") ?> </strong> </p>
                                <br>
                                <p class="text-right reference">IP SESSION: <strong> {{$session->ip}} (ID: {{$session->id}} ) </strong> </p>
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
                                    <p class="info-master">
                                        <strong>Téléphone</strong>: <small>{{$agency_of_this_agent->phone}}</small> <br>
                                        <strong>Pays</strong> : <small>{{$agency_of_this_agent->country}}</small> <br>
                                        <strong>Commune</strong>: <small>{{$agency_of_this_agent->commune}}</small> <br>
                                        <strong>IFU</strong> : <small>{{$agency_of_this_agent->ifu}}</small> <br>
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
                    <th scope="col">ID Command</th>
                    <th scope="col">Produit</th>
                    <th scope="col">Qté</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commands as $command)
                <tr>
                    <td class="block">{{$command->id}}</td>
                    <td class="block">
                        <table class="table table table-striped px-0 mx-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Prix</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($command->products as $product)
                                <tr>
                                    <td class="block">{{$product->id}}</td>
                                    <td class="block">{{$product->name}}</td>
                                    <td class="block">{{$product->price}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td class="block">{{$command->qty}}</td>
                    <td class="block">{{$command->amount}}</td>
                    <td class="block">{{$command->created_at}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>

        <p class="">
            Arrêtée, le présent rapport à la session d'IP <span class="bg-dark p-2 text-white">{{$session->ip}}</span> .
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
                        <span> <strong>SOCIETE: </strong>$agency_of_this_agent->name</span><br>
                        <span> <strong>RCCM: </strong> $agency_of_this_agent->rccm</span><br>
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