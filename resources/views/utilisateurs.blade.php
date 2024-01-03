<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un utilisateur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      width: 350px;
    }
  </style>
</head>
<body>

<div class="card">
  <div class="card-body">
    <h5 class="card-title text-center mb-4">Ajouter un utilisateur</h5>
    <form>
      <div class="mb-3">
        <label for="username" class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control" id="username" placeholder="Entrez le nom d'utilisateur">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Adresse email</label>
        <input type="email" class="form-control" id="email" placeholder="Entrez l'adresse email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" placeholder="Entrez le mot de passe">
      </div>
      <div class="mb-3">
        <label for="role" class="form-label">Rôle</label>
        <select class="form-select" id="role">
          <option value="user">Utilisateur</option>
          <option value="admin">Administrateur</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary d-block w-100">Ajouter l'utilisateur</button>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
