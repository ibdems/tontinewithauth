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
                @auth
                    @if(auth()->user()->isAdmin())
                        <img src="{{ asset('app/public/'. Auth()->user()->admins->photoAdmin) }}" alt="Profile" class="fa-photo rounded-circle" height="250em" width="250em">
                    @elseif (auth()->user()->isDelegue())
                        <img src="{{ asset('app/public/'. Auth()->user()->delegues->photoDelegue) }}" alt="Profile" class="rounded-circle" height="250em" width="250em">
                    @elseif (auth()->user()->isAgent())
                        <img src="{{ asset('app/public/'. Auth()->user()->agents->photoAgent) }}" alt="Profile" class="rounded-circle" height="250em" width="250em">
                    @endif
                @endauth

            </div>

        </div>
        <div class="col"></div>

      </div>

      <div class="row mt-3">
            <div class="col-2"></div>
            <div class="col">
                @auth
                    @if(auth()->user()->isAdmin())
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

                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col ms-5" style="border: 1px solid black">
                                            <h5 class="fw-bold fs-5 text-center">Detail du profile</h5>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5 ">Role : </div>
                                                <div class="col-lg-7 col-md-6 fs-5">Administrateur</div>

                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Identifiant :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ auth()->user()->admins->codeAdmin }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5" style="font-size: 18px">Nom et Prenom :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">
                                                    {{ Auth::user()->admins->nomAdmin . ' '. Auth::user()->admins->prenomAdmin }}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Adresse :</div>
                                                <div class="col-lg-7 col-md-66 fs-5"> {{ auth()->user()->admins->adresseAdmin }}</div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Date Adhesion :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ auth()->user()->admins->dateAdhesion }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Phone :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ auth()->user()->admins->telAdmin }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Email :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ Auth::user()->email }}</div>
                                            </div>
                                        </div>
                                        <div class="col-1"></div>
                                    </div>

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col">
                                        <!-- Profile Edit Form -->
                                        <form method="POST" action="{{ route('updateProfil') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    @if (Session::has('success'))
                                                        <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="hidden" name="code" value="{{ auth()->user()->admins->codeAdmin }}">
                                            <div class="row mb-3">
                                                <label for="profileImage" class="col-md-6 text-black fs-5 text-center mt-5 col-lg-5">Profile Image</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <img src="{{ asset('app/public/'. auth()->user()->admins->photoAdmin) }}" alt="Profile">
                                                <div class="pt-2">
                                                    <input type="file" name="photo" id=""  class="form-control border-secondary">
                                                </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="fullName" class="col-md-6 text-black col-lg-5 fs-5 text-center">Nom</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="nom" type="text" value="{{ auth()->user()->admins->nomAdmin }}" class="form-control border-secondary" id="nom">
                                                </div>
                                                @error('nom')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="fullName" class="col-md-6 text-black col-lg-5 fs-5 text-center">Prenom</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="prenom" type="text" value="{{ auth()->user()->admins->prenomAdmin }}" class="form-control border-secondary" id="prenom">
                                                </div>
                                                @error('prenom')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="row mb-3">
                                                <label for="Address" class="col-md-6 text-black col-lg-5 fs-5 text-center">Address</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="address" type="text" class="form-control border-secondary" id="Address" value="{{ auth()->user()->admins->adresseAdmin }}">
                                                </div>
                                                @error('address')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="tel" class="col-md-6 text-black col-lg-5 fs-5 text-center">Telephone</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="tel" type="tel" class="form-control border-secondary" id="tel" value="{{ auth()->user()->admins->telAdmin }}">
                                                </div>
                                                @error('tel')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="date" class="col-md-6 text-black col-lg-5 fs-5 text-center">Date Adhesion</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="date" type="date" class="form-control border-secondary" id="date" value="{{ auth()->user()->admins->dateAdhesion }}">
                                                </div>
                                                @error('date')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Email" class="col-md-6 text-black  fs-5 col-lg-5 text-center">Email</label>
                                                <div class="col-md-6 col-lg-7">
                                                <input name="email" type="email" class="form-control border-secondary" id="Email" value="{{ auth()->user()->admins->mailAdmin }}">
                                                </div>
                                                @error('email')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
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
                                            <form method="POST" action="{{ route('updatePassword') }}">
                                                @csrf
                                                @method('put')
                                                <div class="row">
                                                    <div class="col">
                                                        @if (Session::has('success'))
                                                            <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="currentPassword" class="col-md-6 col-lg-5 col-form-label">Mot de pass courant</label>
                                                    <div class="col-md-6 col-lg-7">
                                                    <input name="current_password" type="password" class="form-control border-secondary" id="currentPassword">
                                                    </div>
                                                    @error('current_password')
                                                        <span class="text-center text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="newPassword" class="col-md-6 col-lg-5 col-form-label">Nouveau mot de pass</label>
                                                    <div class="col-md-6 col-lg-7">
                                                    <input name="password" type="password" class="form-control border-secondary" id="newPassword">
                                                    </div>
                                                    @error('password')
                                                        <span class="text-center text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="renewPassword" class="col-md-6 col-lg-5 col-form-label">Confirmer</label>
                                                    <div class="col-md-6 col-lg-7">
                                                    <input name="password_confirmation" type="password" class="form-control border-secondary" id="renewPassword">
                                                    </div>
                                                    @error('password_confirmation')
                                                        <span class="text-center text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-success">Changer</button>
                                                    @if (session('status') === 'password-updated')
                                                        <p
                                                            x-data="{ show: true }"
                                                            x-show="show"
                                                            x-transition
                                                            x-init="setTimeout(() => show = false, 2000)"
                                                            class="text-sm text-gray-600"
                                                        >{{ __('Saved.') }}</p>
                                                    @endif
                                                </div>
                                            </form><!-- End Change Password Form -->
                                        </div>
                                        <div class="col-2"></div>
                                    </div>

                                </div>

                                </div><!-- End Bordered Tabs -->

                            </div>
                        </div>
                    @elseif (auth()->user()->isDelegue())
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

                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col ms-5" style="border: 1px solid black">
                                            <h5 class="fw-bold fs-5 text-center">Detail du profile</h5>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5 ">Role : </div>
                                                <div class="col-lg-7 col-md-6 fs-5">Delegue</div>

                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Identifiant :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ auth()->user()->delegues->codeDelegue }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5" style="font-size: 18px">Nom et Prenom :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">
                                                    {{ Auth::user()->delegues->nomDelegue . ' '. Auth::user()->delegues->prenomDelegue }}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Adresse :</div>
                                                <div class="col-lg-7 col-md-66 fs-5"> {{ auth()->user()->delegues->adresseDelegue }}</div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Date Adhesion :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ auth()->user()->delegues->dateAdhesion }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Phone :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ auth()->user()->delegues->telDelegue }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Email :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ Auth::user()->email }}</div>
                                            </div>
                                        </div>
                                        <div class="col-1"></div>
                                    </div>

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col">
                                        <!-- Profile Edit Form -->
                                        <form method="POST" action="{{ route('updateProfil') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    @if (Session::has('success'))
                                                        <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="hidden" name="code" value="{{ auth()->user()->delegues->codeDelegue }}">
                                            <div class="row mb-3">
                                                <label for="profileImage" class="col-md-6 text-black fs-5 text-center mt-5 col-lg-5">Profile Image</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <img src="{{ asset('app/public/'. auth()->user()->delegues->photoDelegue) }}" alt="Profile">
                                                <div class="pt-2">
                                                    <input type="file" name="photo" id=""  class="form-control border-secondary">
                                                </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="fullName" class="col-md-6 text-black col-lg-5 fs-5 text-center">Nom</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="nom" type="text" value="{{ auth()->user()->delegues->nomDelegue }}" class="form-control border-secondary" id="nom">
                                                </div>
                                                @error('nom')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="fullName" class="col-md-6 text-black col-lg-5 fs-5 text-center">Prenom</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="prenom" type="text" value="{{ auth()->user()->delegues->prenomDelegue }}" class="form-control border-secondary" id="prenom">
                                                </div>
                                                @error('prenom')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="row mb-3">
                                                <label for="Address" class="col-md-6 text-black col-lg-5 fs-5 text-center">Address</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="address" type="text" class="form-control border-secondary" id="Address" value="{{ auth()->user()->delegues->adresseDelegue }}">
                                                </div>
                                                @error('address')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="tel" class="col-md-6 text-black col-lg-5 fs-5 text-center">Telephone</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="tel" type="tel" class="form-control border-secondary" id="tel" value="{{ auth()->user()->delegues->telDelegue }}">
                                                </div>
                                                @error('tel')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="date" class="col-md-6 text-black col-lg-5 fs-5 text-center">Date Adhesion</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="date" type="date" class="form-control border-secondary" id="date" value="{{ auth()->user()->delegues->dateAdhesion }}">
                                                </div>
                                                @error('date')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Email" class="col-md-6 text-black  fs-5 col-lg-5 text-center">Email</label>
                                                <div class="col-md-6 col-lg-7">
                                                <input name="email" type="email" class="form-control border-secondary" id="Email" value="{{ auth()->user()->delegues->mailDelegue }}">
                                                </div>
                                                @error('email')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
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
                                            <form method="POST" action="{{ route('updatePassword') }}">
                                                @csrf
                                                @method('put')
                                                <div class="row">
                                                    <div class="col">
                                                        @if (Session::has('success'))
                                                            <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="currentPassword" class="col-md-6 col-lg-5 col-form-label">Mot de pass courant</label>
                                                    <div class="col-md-6 col-lg-7">
                                                    <input name="current_password" type="password" class="form-control border-secondary" id="currentPassword">
                                                    </div>
                                                    @error('current_password')
                                                        <span class="text-center text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="newPassword" class="col-md-6 col-lg-5 col-form-label">Nouveau mot de pass</label>
                                                    <div class="col-md-6 col-lg-7">
                                                    <input name="password" type="password" class="form-control border-secondary" id="newPassword">
                                                    </div>
                                                    @error('password')
                                                        <span class="text-center text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="renewPassword" class="col-md-6 col-lg-5 col-form-label">Confirmer</label>
                                                    <div class="col-md-6 col-lg-7">
                                                    <input name="password_confirmation" type="password" class="form-control border-secondary" id="renewPassword">
                                                    </div>
                                                    @error('password_confirmation')
                                                        <span class="text-center text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-success">Changer</button>
                                                    @if (session('status') === 'password-updated')
                                                        <p
                                                            x-data="{ show: true }"
                                                            x-show="show"
                                                            x-transition
                                                            x-init="setTimeout(() => show = false, 2000)"
                                                            class="text-sm text-gray-600"
                                                        >{{ __('Saved.') }}</p>
                                                    @endif
                                                </div>
                                            </form><!-- End Change Password Form -->
                                        </div>
                                        <div class="col-2"></div>
                                    </div>

                                </div>

                                </div><!-- End Bordered Tabs -->

                            </div>
                        </div>
                    @elseif (auth()->user()->isAgent())
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

                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col ms-5" style="border: 1px solid black">
                                            <h5 class="fw-bold fs-5 text-center">Detail du profile</h5>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5 ">Role : </div>
                                                <div class="col-lg-7 col-md-6 fs-5">Agent</div>

                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Identifiant :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ auth()->user()->agents->codeAgent }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5" style="font-size: 18px">Nom et Prenom :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">
                                                    {{ Auth::user()->agents->nomAgent . ' '. Auth::user()->agents->prenomAgent }}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Adresse :</div>
                                                <div class="col-lg-7 col-md-66 fs-5"> {{ auth()->user()->agents->adresseAgent }}</div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Date Adhesion :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ auth()->user()->agents->dateAdhesion }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Phone :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ auth()->user()->agents->telAgent }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-6 fw-bold fs-5">Email :</div>
                                                <div class="col-lg-7 col-md-6 fs-5">{{ Auth::user()->email }}</div>
                                            </div>
                                        </div>
                                        <div class="col-1"></div>
                                    </div>

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col">
                                        <!-- Profile Edit Form -->
                                        <form method="POST" action="{{ route('updateProfil') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    @if (Session::has('success'))
                                                        <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="hidden" name="code" value="{{ auth()->user()->agents->codeAgent }}">
                                            <div class="row mb-3">
                                                <label for="profileImage" class="col-md-6 text-black fs-5 text-center mt-5 col-lg-5">Profile Image</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <img src="{{ asset('app/public/'. auth()->user()->agents->photoAgent) }}" alt="Profile">
                                                <div class="pt-2">
                                                    <input type="file" name="photo" id=""  class="form-control border-secondary">
                                                </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="fullName" class="col-md-6 text-black col-lg-5 fs-5 text-center">Nom</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="nom" type="text" value="{{ auth()->user()->agents->nomAgent }}" class="form-control border-secondary" id="nom">
                                                </div>
                                                @error('nom')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="fullName" class="col-md-6 text-black col-lg-5 fs-5 text-center">Prenom</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="prenom" type="text" value="{{ auth()->user()->agents->prenomAgent }}" class="form-control border-secondary" id="prenom">
                                                </div>
                                                @error('prenom')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="row mb-3">
                                                <label for="Address" class="col-md-6 text-black col-lg-5 fs-5 text-center">Address</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="address" type="text" class="form-control border-secondary" id="Address" value="{{ auth()->user()->agents->adresseAgent }}">
                                                </div>
                                                @error('address')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="tel" class="col-md-6 text-black col-lg-5 fs-5 text-center">Telephone</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="tel" type="tel" class="form-control border-secondary" id="tel" value="{{ auth()->user()->agents->telAgent }}">
                                                </div>
                                                @error('tel')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="date" class="col-md-6 text-black col-lg-5 fs-5 text-center">Date Adhesion</label>
                                                <div class="col-md-6 col-lg-7">
                                                    <input name="date" type="date" class="form-control border-secondary" id="date" value="{{ auth()->user()->agents->dateAdhesion }}">
                                                </div>
                                                @error('date')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Email" class="col-md-6 text-black  fs-5 col-lg-5 text-center">Email</label>
                                                <div class="col-md-6 col-lg-7">
                                                <input name="email" type="email" class="form-control border-secondary" id="Email" value="{{ auth()->user()->agents->mailAgent }}">
                                                </div>
                                                @error('email')
                                                    <span class="text-center text-danger">{{ $message }}</span>
                                                @enderror
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
                                            <form method="POST" action="{{ route('updatePassword') }}">
                                                @csrf
                                                @method('put')
                                                <div class="row">
                                                    <div class="col">
                                                        @if (Session::has('success'))
                                                            <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="currentPassword" class="col-md-6 col-lg-5 col-form-label">Mot de pass courant</label>
                                                    <div class="col-md-6 col-lg-7">
                                                    <input name="current_password" type="password" class="form-control border-secondary" id="currentPassword">
                                                    </div>
                                                    @error('current_password')
                                                        <span class="text-center text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="newPassword" class="col-md-6 col-lg-5 col-form-label">Nouveau mot de pass</label>
                                                    <div class="col-md-6 col-lg-7">
                                                    <input name="password" type="password" class="form-control border-secondary" id="newPassword">
                                                    </div>
                                                    @error('password')
                                                        <span class="text-center text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="renewPassword" class="col-md-6 col-lg-5 col-form-label">Confirmer</label>
                                                    <div class="col-md-6 col-lg-7">
                                                    <input name="password_confirmation" type="password" class="form-control border-secondary" id="renewPassword">
                                                    </div>
                                                    @error('password_confirmation')
                                                        <span class="text-center text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-success">Changer</button>
                                                    @if (session('status') === 'password-updated')
                                                        <p
                                                            x-data="{ show: true }"
                                                            x-show="show"
                                                            x-transition
                                                            x-init="setTimeout(() => show = false, 2000)"
                                                            class="text-sm text-gray-600"
                                                        >{{ __('Saved.') }}</p>
                                                    @endif
                                                </div>
                                            </form><!-- End Change Password Form -->
                                        </div>
                                        <div class="col-2"></div>
                                    </div>

                                </div>

                                </div><!-- End Bordered Tabs -->

                            </div>
                        </div>
                    @endif
                @endauth


            </div>
            <div class="col-2"></div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection

