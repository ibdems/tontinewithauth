@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Membres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Membres</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <div class="container">
  <div class="row mb-4 mt-2">

      <div class="col-12">
          <div class="card">
              <div class="row mb-4 mt-2 p-2">
                <div class="col"></div>
                <label for="">Rechercher par:</label>
                  <div class="col-2">
                    <input id="contact" type="text" name="champRecherche"  class="form-control border-secondary bi bi-chevron-compact-down">
                  </div>
                  <div class="col-2 ">
                    <button class="btn  btn-secondary" type="submit" name="rechercher">
                        <i class="bi bi-search"></i>
                        <span id="btnRechercher">Rechercher</span>
                    </button>
                </div>
                 <!-- <div class="col-2">
                      <button class="form-control border-secondary btn btn-success">
                        <i class="ri ri-filter-line"></i>
                        <span id="btnFiltrer">Filtrer</span>
                      </button>
                  </div>-->
                  <div class="col-2">
                      <button class="form-control border-secondary btn btn-success" type="submit" name="actualiser">
                        <i class="bi bi-refresh"></i>
                        <span id="btnActualiser">Actualiser</span>
                      </button>
                  </div>
                  <div class="col-2">
                    <button class="form-control border-secondary btn btn-success" type="submit" name="nouveau"  data-bs-toggle="modal" data-bs-target="#modalNouveau" >
                      <i class="bi bi-plus"></i>
                      <span id="btnNouveau">Nouveau</span>
                    </button>
                  </div>
                  <div class="col-2">
                    <button class="btn btn-primary" type="submit" name="imprimer">
                        <i class="bi bi-print"></i>
                        <span id="btnImprimer">Imprimer</span>
                    </button>
                </div>
              </div>
              <div class="row mb-4" >
                <div class="col-12">
                  <table id="tableMembre" class=" table table-bordered table-responsive table-hover table-striped" >
                    <thead>
                        <th  class="text-center bg-success text-white" >N°</th>
                        <th  class="text-center bg-success text-white" >Code</th>
                        <th  class="text-center bg-success text-white" >Photo</th>
                        <th  class="text-center bg-success text-white" >Nom</th>
                        <th  class="text-center bg-success text-white" >Prenom</th>
                        <th  class="text-center bg-success text-white" >Adresse</th>
                        <th  class="text-center bg-success text-white" >Contact</th>
                        <th  class="text-center bg-success text-white" >Date d'adhesion</th>
                        <th  class="text-center bg-success text-white" >e-mail</th>
                        <th  class="text-center bg-success text-white" colspan="2">Action</th>
                    </thead>
                    <tbody>
                         {{-- <?php $i=0; ?>
                        @foreach ($agents as $agent)
                            <tr>
                                <td class='btnCoti'><a  class='btn btn-transparent editAgent'  data-bs-toggle='modal' data-bs-target='#modalmodif' data-bs-placement='bottom' title='Modifier'><i class='bi bi-pen'></i></a></td>
                                <td class='btnCoti'><a  class='btn btn-transparent editAgent'  data-bs-toggle='modal' data-bs-target='#modalInfoMembre' data-bs-placement='bottom' title='Modifier'><i class='bi bi-eye'></i></a></td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                  </table>
                </div>

              </div>

          </div>
      </div>
  </div><!-- End Pills Tabs -->
  <div class="modal fade" id="modalNouveau" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Nouveau Membre</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex justify-content-center py-4">
            <a href="#" class="logo d-flex align-items-center w-auto">
              <img src="assets/img/yetemali.jpg" alt="">
              <span class="d-none d-lg-block text-success">Yete</span>
              <span class="d-none d-lg-block text-warning">mali</span>
            </a>
          </div>
            <form action="" method="POST">

                 <div class="row mb-4">
                    <div class="col">
                       <label for="">Nom</label>
                       <input type="text" id="nom" name="nomMembre" class="form-control border-secondary">
                    </div>
                    <div class="col">
                        <label for="">Prenom</label>
                        <input type="text" id="prenom" name="prenomMembre" class="form-control border-secondary">
                    </div>
                 </div>

                 <div class="row mb-4">
                    <div class="col">
                      <label for="">Adresse</label>
                      <input type="text" id="adresse" name="adresseMembre" class="form-control border-secondary">
                    </div>
                    <div class="col">
                      <label for="">Contact</label>
                      <input type="text" id="contact" name="telMembre" class="form-control border-secondary">
                    </div>
                 </div>

                 <div class="row mb-4">
                    <div class="col">
                        <label for="">date_Adhesion</label>
                        <input type="date" id="date" name="dateAdhesion" class="form-control border-secondary">
                    </div>
                    <div class="col">
                        <label for="">E-mail</label>
                      <input type="mail" id="mailMembre" name="mailMembre" class="form-control border-secondary">
                    </div>
                 </div>

                 <div class="row mb-4">
                    <div class="col">
                        <label for="">Agent</label>
                        <select name="agent" id="" class="form-control border-secondary"></select>
                    </div>
                    <div class="col">
                        <label for="">Photo</label>
                      <input type="file" id="photo" name="photo" class="form-control border-secondary">
                    </div>
                 </div>
                <div class="row mb-4 mt-4">
                  <div class="col-6"></div>
                <div class="col-3">
                  <button id="btnEnregistrer" name="enregistrer" type="submit" class="btn btn-success" data-bs-dismiss="modal" onclick="enregistrer()">Enregistrer</button>
                </div>
                <div class="col-3">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                </div>

                </div>
            </form>
        </div>

      </div>
    </div>
  </div><!-- End Vertically centered Modal-->
  <div class="modal fade" id="modalmodif" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex justify-content-center py-4">
            <a href="#" class="logo d-flex align-items-center w-auto">
              <img src="assets/img/yetemali.jpg" alt="">
              <span class="d-none d-lg-block text-success">Yete</span>
              <span class="d-none d-lg-block text-warning">mali</span>
            </a>
          </div>
            <form action="" method="POST">
            <div class="row mb-4">
                    <div class="col">
                       <label for="">Nom</label>
                       <input type="text" id="nom" name="nomMembre" class="form-control border-secondary">
                    </div>
                    <div class="col">
                        <label for="">Prenom</label>
                        <input type="text" id="prenom" name="prenomMembre" class="form-control border-secondary">
                    </div>
                 </div>

                 <div class="row mb-4">
                    <div class="col">
                      <label for="">Adresse</label>
                      <input type="text" id="adresse" name="adresseMembre" class="form-control border-secondary">
                    </div>
                    <div class="col">
                      <label for="">Contact</label>
                      <input type="text" id="contact" name="telMembre" class="form-control border-secondary">
                    </div>
                 </div>

                 <div class="row mb-4">
                    <div class="col">
                        <label for="">date_Adhesion</label>
                        <input type="date" id="date" name="dateAdhesion" class="form-control border-secondary">
                    </div>
                    <div class="col">
                        <label for="">E-mail</label>
                      <input type="mail" id="mailMembre" name="mailMembre" class="form-control border-secondary">
                    </div>
                 </div>

                 <div class="row mb-4">
                    <div class="col">
                        <label for="">Agent</label>
                        <select name="agent" id="" class="form-control border-secondary"></select>
                    </div>
                    <div class="col">
                        <label for="">Photo</label>
                      <input type="file" id="photo" name="photo" class="form-control border-secondary">
                    </div>
                 </div>
                <div class="row mb-4 mt-4">
                  <div class="col-6"></div>
                  <div class="col-3">
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal" name="btnEnregistrer">Enregistrer</button>
                  </div>
                  <div class="col-3">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                  </div>
                  <div class="col-sm-3"></div>
                </div>
            </form>
        </div>

      </div>
    </div>
  </div>

  <!-- Debut Modal pour Voir le suivi -->
  <div class="modal fade" id="modalInfoMembre" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <h2 class="text-center fw-blod">Informations Personnelles</h2>
        <div class="row mb-4 mt-3 p-2">
          <div class="col-6">
            <p><span class="fw-bold ms-3">Identifiant: </span> <span > A1 </span></p>
            <p><span class="fw-bold ms-3">Nom: </span> <span>Diallo</span></p>
            <p><span class="fw-bold ms-3">Adresse: </span> <span id=>Cimenterie</span></p>
          </div>²
          <div class="col-6">
            <p><span class="fw-bold ms-3">Date_Adhesion: </span> <span >11/01/23</span></p>
            <p><span class="fw-bold ms-3">Prenom: </span> <span>Madinatou</span></p>
            <p><span class="fw-bold ms-3">Contact: </span> <span id=>625444313</span></p>
          </div>
        </div>
        <div class="row mb-4">
          <p><span class="fw-bold ms-3">Nombre de tontine participé: </span> <span >2</span></p>
          <p><span class="fw-bold ms-3">Montant total recuperé: </span> <span>5000000</span></p>
          <p><span class="fw-bold ms-3">Nombre de tontine en cours: </span> <span>1</span></p>
        </div>
        <div class="row mb-4">
          <div class="col-6">
            <h4 class="text-center fw-blod ">Tontine1:</h4>
            <p><span class="fw-bold ms-3">Payement Effectué: </span> <span>200000</span></p>
            <p><span class="fw-bold ms-3">Payement Restant: </span> <span>0</span></p>
            <p><span class="fw-bold ms-3">Retard de payement: </span> <span>0</span></p>
            <p><span class="fw-bold ms-3">Date de prise: </span> <span></span>11/07/23</p>

          </div>
          <div class="col-6">
            <h4 class="text-center fw-blod ">Tontine2</h4>
            <p><span class="fw-bold ms-3">Payement Effectué: </span> <span>500000</span></p>
            <p><span class="fw-bold ms-3">Payement Restant: </span> <span>500000</span></p>
            <p><span class="fw-bold ms-3">Retard de payement: </span> <span>1</span></p>
            <p><span class="fw-bold ms-3">Date de prise: </span> <span>11/09/23</span></p>
          </div>


        </div>




        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>
</main>
<!-- Fin du main -->
@endsection



