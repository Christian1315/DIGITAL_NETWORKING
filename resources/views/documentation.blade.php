<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DIGITAL NETWORK</title>
    <link rel="shortcut icon" href="digital-logo.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

</head>

<body class="antialiased">
    <div class="container-fluid">
        <div class="row  shadow-lg bg-light fixed-top header">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <a class="navbar-brand text-white bg--red rounded shadow px-3" href="/"> <strong>DIGITAL NETWORK</strong></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a href="#" class="nav-link" aria-current="page" href="#">Site Officiel</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="/documentation">Documentation</a>
                                </li>
                            </ul>
                            <form class="d-flex" role="search">
                                <img src="digital-logo.jpeg" class="logo shadow-lg p-3 bg-body rounded" alt="" srcset="">
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="container content">
                    <div class="row">
                        <div class="col-md-12 text-center sur l'accueil">
                            <a href="/" class="return text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                                </svg>
                                <strong>Retour</strong>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1 class="title">bienvenu sur la documentation de l'API</h1>
                            <img src="digital-logo.jpeg" class="rounded shadow-lg" width="500" alt="" srcset=""><br><br>

                            <p class="text-dark">JNP STORE est un module de networking qui vise à gérer les stocks dans les stations JNP</p>
                        </div>
                    </div>

                    <!-- ################ TOUTES LES ROUTES RELATIVES AUX USERS ############### -->
                    <div class="bg-dark text-center mb-5">
                        <h1 class="text-white">TOUTES LES ROUTES RELATIVES AUX USERS</h1>
                    </div>
                    <div class="row" id="documenation">
                        <div class="col-md-12">

                            <!-- REGISTRATION -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ CREATION DE COMPTE ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/register </h5>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">DATA ::</strong></h5>
                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "username": "gogo", <br>
                                                "gender": "M", <br>
                                                "country": "Bénin", <br>
                                                "phone": "61765590",<br>
                                                "password": "gogo",<br>
                                                "lastname": "gogo",<br>
                                                "firstname": "Christian",<br>
                                                "email": "gogo@gmail.com",<br>
                                                "parent_id": 1,##L'ID du user parent qui effectue l'ajout<br>
                                                "phone": 23445757785,##Facultatif ## C'est Pour les transporteurs <br>
                                                "phone": 23445757785,##Facultatif ## C'est Pour les transporteurs
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    </p>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- LOGIN -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ LOGIN D'UN USER ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/login </h5>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">DATA ::</strong></h5>
                                    <p class="">
                                    <ul>

                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "account": "admin",##Soit le username, le mail ou soit le phone <br>
                                                "password": "mypassword",
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    </p>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data)</h5>
                                </div>
                            </div>

                            <!-- LOGOUT -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ LOGOUT D'UN USER ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/logout </h5>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">DATA ::</strong></h5>
                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    </p>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.GET(url,header)</h5>
                                </div>
                            </div>

                            <!-- GET ALL USERS -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ RECUPERER TOUT LES USERS ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/all </h5>
                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.GET(url,header)</h5>
                                </div>
                            </div>

                            <!-- GET A USER -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ RECUPERER UN USER ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/< user_id>/retrieve
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.GET(url,header)</h5>
                                </div>
                            </div>

                            <!-- UPDATE A USER -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ MODIFIER UN USER ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>

                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "column1": "value1",<br>
                                                "column2": "value2",<br>
                                                "column3": "value3",<br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/< user_id>/update
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- DELETE A USER -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ SUPPRIMER UN USER ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/< user_id>/delete
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.DELETE(url,header)</h5>
                                </div>
                            </div>

                            <!-- ATTACH A USER TO A PROFIL-->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ ATTACHER UN USER A UN PROFIL ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>

                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "user_id": "1"##ID du user,<br>
                                                "profil_id": "2"##ID du profil<br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/< user_id>/attach-profil
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- ATTACH A USER TO A RANG-->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ ATTACHER UN USER A UN RANG ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>

                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "user_id": "1"##ID du user,<br>
                                                "rang_id": "2"##ID du rang<br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/< user_id>/attach-rang
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- ATTACH A USER TO A RIGHT-->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ ATTACHER UN USER A UN RIGHT ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>

                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "user_id": "1"##ID du user,<br>
                                                "right_id": "2"##ID du rang<br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/< user_id>/attach-right
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ################ TOUTES LES ROUTES RELATIVES AUX PROFILS ############### -->
                    <div class="bg-dark text-center my-5">
                        <h1 class="text-white">TOUTES LES ROUTES RELATIVES AUX PROFILS</h1>
                    </div>
                    <div class="row" id="documenation">
                        <div class="col-md-12">

                            <!-- AJOUT D'UN PROFIL -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ AJOUT D'UN PROFILE ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/profil/add </h5>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">DATA ::</strong></h5>
                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "name": "gogo", <br>
                                                "description": "Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer", <br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    </p>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- GET ALL PROFILS -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ RECUPERER TOUT LES PROFILS ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/profil/all </h5>
                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.GET(url,header)</h5>
                                </div>
                            </div>

                            <!-- GET A PROFIL -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ RECUPERER UN PROFIL ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/profil/< profil_id>/retrieve
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.GET(url,header)</h5>
                                </div>
                            </div>

                            <!-- UPDATE A PROFIL -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ MODIFIER UN PROFIL ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>

                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "column1": "value1",<br>
                                                "column2": "value2",<br>
                                                "column3": "value3",<br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/profil/< profil_id>/update
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- DELETE A PROFIL -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ SUPPRIMER UN PROFIL ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/profil/< profil_id>/delete
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.DELETE(url,header)</h5>
                                </div>
                            </div>

                            <!-- ATTACH A USER TO A PROFIL-->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ ATTACHER UN USER A UN PROFIL ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>

                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "user_id": "1"##ID du user,<br>
                                                "profil_id": "2"##ID du profil<br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/< user_id>/attach-profil
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- ATTACH A USER TO A RANG-->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ ATTACHER UN USER A UN RANG ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>

                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "user_id": "1"##ID du user,<br>
                                                "rang_id": "2"##ID du rang<br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/< user_id>/attach-rang
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- ATTACH A USER TO A RIGHT-->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ ATTACHER UN USER A UN RIGHT ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>

                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "user_id": "1"##ID du user,<br>
                                                "right_id": "2"##ID du rang<br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/user/< user_id>/attach-right
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ################ TOUTES LES ROUTES RELATIVES AUX RANGS ############### -->
                    <div class="bg-dark text-center my-5">
                        <h1 class="text-white">TOUTES LES ROUTES RELATIVES AUX RANGS</h1>
                    </div>
                    <div class="row" id="documenation">
                        <div class="col-md-12">

                            <!-- AJOUT D'UN RANG -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ AJOUT D'UN RANG ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/rand/add </h5>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">DATA ::</strong></h5>
                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "name": "gogo", <br>
                                                "description": "Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer", <br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    </p>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- GET ALL RANG -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ RECUPERER TOUT LES RANGS ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/rang/all </h5>
                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.GET(url,header)</h5>
                                </div>
                            </div>

                            <!-- GET A RANG -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ RECUPERER UN RANG ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/rang/< rang_id>/retrieve
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.GET(url,header)</h5>
                                </div>
                            </div>

                            <!-- UPDATE A RANG -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ MODIFIER UN RANG ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>

                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "column1": "value1",<br>
                                                "column2": "value2",<br>
                                                "column3": "value3",<br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/rang/< rang_id>/update
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- DELETE A RANG -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ SUPPRIMER UN RANG ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/rang/< rang_id>/delete
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.DELETE(url,header)</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ################ TOUTES LES ROUTES RELATIVES AUX ACTIONS ############### -->
                    <div class="bg-dark text-center my-5">
                        <h1 class="text-white">TOUTES LES ROUTES RELATIVES AUX ACTIONS</h1>
                    </div>
                    <div class="row" id="documenation">
                        <div class="col-md-12">

                            <!-- AJOUT D'UNE ACTION -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ AJOUT D'UNE ACTION ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/action/add </h5>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">DATA ::</strong></h5>
                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "name": "gogo", <br>
                                                "description": "Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer", <br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    </p>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- GET ALL ACTIONS -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ RECUPERER TOUTES LES ACTIONS ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/action/all </h5>
                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.GET(url,header)</h5>
                                </div>
                            </div>

                            <!-- GET AN ACTION -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ RECUPERER UNE ACTION ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/action/< action_id>/retrieve
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.GET(url,header)</h5>
                                </div>
                            </div>

                            <!-- UPDATE AN ACTION -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ MODIFIER UNE ACTION ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>

                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "column1": "value1",<br>
                                                "column2": "value2",<br>
                                                "column3": "value3",<br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/action/< action_id>/update
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- DELETE AN ACTION -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ SUPPRIMER UNE ACTION ==========##</button>
                                    </div>

                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/action/< action_id>/delete
                                    </h5>

                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.DELETE(url,header)</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ################ TOUTES LES ROUTES RELATIVES AUX RIGHTS ############### -->
                    <div class="bg-dark text-center my-5">
                        <h1 class="text-white">TOUTES LES ROUTES RELATIVES AUX RIGHTS</h1>
                    </div>
                    <div class="row" id="documenation">
                        <div class="col-md-12">

                            <!-- AJOUT D'UN RIGHTS -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ AJOUT D'UN RIGHT ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/right/add </h5>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">DATA ::</strong></h5>
                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                        <li>data =
                                            <ul>
                                                <li>{</li>
                                                "label": "gogo", <br>
                                                "action_id": 1, <br>
                                                "profil_id": 1, <br>
                                                "rang_id": 1, <br>
                                                "rang_id": 1, <br>
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    </p>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.POST(url,data,header)</h5>
                                </div>
                            </div>

                            <!-- GET ALL RIGHTS -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button disabled class="btn documentation ">##============ RECUPERER TOUT LES RIGHTS ==========##</button>
                                    </div>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">URL ::</strong> BASE_URL/api/v1/right/all </h5>
                                    <p class="">
                                    <ul>
                                        <li>header =
                                            <ul>
                                                <li>{</li>
                                                "key": "Authorization",<br>
                                                "value": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjQyODkzZWIwY",<br>
                                                "type": "text"
                                                <li>}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h5 class="mt-5"> <strong class="bg-dark p-1 text-white ">EXEMPLE DE REQUEST::</strong> fetch.GET(url,header)</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-light shadow-lg py-3 footer fixed-bottom d-none d-md-block d-md-lg">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-dark text-center">© Copyright 2023 - Développé par HSMC</p>
                </div>
            </div>
        </div>

        <div class="container-fluid bg-light shadow-lg py-3 footer d-none d-sm-block">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-dark text-center">© Copyright 2023 - Développé par HSMC</p>
                </div>
            </div>
        </div>

    </div>
</body>

</html>