@extends('master.layout')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col"></div>
        <div class="col-4">
            <div class=" d-flex flex-column align-items-center">

                <img src="{{ asset('agent.png') }}" alt="Profile" class="rounded-circle" height="250em" width="250em">

            </div>

        </div>
        <div class="col"></div>

      </div>

      <div class="row mt-3">
            <div class="col-2"></div>
            <div class="col">

                <div class="card">
                    <div class="card-body pt-3">
                        {{-- Les entetes --}}
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Informations</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier le profile</button>
                            </li>


                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Changer le mot de passe</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                        {{-- Les details du profil --}}
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">

                            @auth
                                @if (Auth::user()->role === 'admin')
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col" style="border: 1px solid black">
                                            <h5 class="fw-bold fs-5 text-center">Detail du profile</h5>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 fw-bold fs-5 ">Role: </div>
                                                <div class="col-lg-9 col-md-8 fs-5">Administrateur</div>

                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 fw-bold fs-5">Identifiant</div>
                                                <div class="col-lg-9 col-md-8"></div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 fw-bold" style="font-size: 18px">Nom et Prenom</div>
                                                <div class="col-lg-9 col-md-8"></div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 fw-bold fs-5">Adresse</div>
                                                <div class="col-lg-9 col-md-8"></div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 fw-bold fs-5">Date Adhesion</div>
                                                <div class="col-lg-9 col-md-8"></div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 fw-bold fs-5">Phone</div>
                                                <div class="col-lg-9 col-md-8"></div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 fw-bold fs-5">Email</div>
                                                <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                                            </div>
                                        </div>
                                        <div class="col-1"></div>
                                    </div>
                                @endif
                            @endauth

                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                           <div class="row">
                            <div class="col-2"></div>
                            <div class="col">
                                  <!-- Profile Edit Form -->
                                 <form>
                                     <div class="row mb-3">
                                         <label for="profileImage" class="col-md-4 text-center mt-5 col-lg-3">Profile Image</label>
                                         <div class="col-md-8 col-lg-9">
                                             <img src="{{ asset('agent.png') }}" alt="Profile">
                                         <div class="pt-2">
                                             <input type="file" name="photo" id="" class="form-control border-secondary">
                                         </div>
                                         </div>
                                     </div>

                                     <div class="row mb-3">
                                         <label for="fullName" class="col-md-4 col-lg-3 text-center">Nom</label>
                                         <div class="col-md-8 col-lg-9">
                                             <input name="nom" type="text" class="form-control border-secondary" id="nom">
                                         </div>
                                     </div>

                                     <div class="row mb-3">
                                         <label for="fullName" class="col-md-4 col-lg-3 text-center">Prenom</label>
                                         <div class="col-md-8 col-lg-9">
                                             <input name="prenom" type="text" class="form-control border-secondary" id="prenom">
                                         </div>
                                     </div>


                                     <div class="row mb-3">
                                         <label for="Address" class="col-md-4 col-lg-3 text-center">Address</label>
                                         <div class="col-md-8 col-lg-9">
                                         <input name="address" type="text" class="form-control border-secondary" id="Address" value="">
                                         </div>
                                     </div>

                                     <div class="row mb-3">
                                         <label for="Phone" class="col-md-4 col-lg-3 text-center">Phone</label>
                                         <div class="col-md-8 col-lg-9">
                                         <input name="phone" type="text" class="form-control border-secondary" id="Phone" value="">
                                         </div>
                                     </div>

                                     <div class="row mb-3">
                                         <label for="Email" class="col-md-4 col-lg-3 text-center">Email</label>
                                         <div class="col-md-8 col-lg-9">
                                         <input name="email" type="email" class="form-control border-secondary" id="Email" value="">
                                         </div>
                                     </div>

                                     <div class="text-center">
                                         <button type="submit" class="btn btn-success">Sauvegarder</button>
                                     </div>
                                 </form><!-- End Profile Edit Form -->
                            </div>
                            <div class="col-2"></div>
                           </div>

                        </div>


                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col">
                                    <form>

                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mot de pass courant</label>
                                            <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control border-secondary" id="currentPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de pass</label>
                                            <div class="col-md-8 col-lg-9">
                                            <input name="newpassword" type="password" class="form-control border-secondary" id="newPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirmer</label>
                                            <div class="col-md-8 col-lg-9">
                                            <input name="renewpassword" type="password" class="form-control border-secondary" id="renewPassword">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success">Changer</button>
                                        </div>
                                    </form><!-- End Change Password Form -->
                                </div>
                                <div class="col-2"></div>
                            </div>

                        </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
            <div class="col-2"></div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection
