
//     let btnEnregistrer= document.getElementById('btnEnregistrer');
//     // btnEnregistrer.addEventListener('click',function(event){

//     //     let nom=document.getElementById("nom").value;
//     //     let prenom=document.getElementById("prenom").value;
//     //     let adresse=document.getElementById("adresse").value;
//     //     let contact=document.getElementById("contact").value;
//     //     let date=document.getElementById("date").value;
//     //     let tontine=document.getElementById("tontine").value;
//     // });
    

//    function enregistrer(){
//     let tableBody = document.querySelector("tableau tbody");
//     let newRow = document.createElement('tr');

//     let nomCell= document.createElement('td')
//     nomCell.innerHTML =nom;
//     newRow.appendChild(nomCell);


//     let prenomCell= document.createElement('td')
//     prenomCell.innerHTML =prenom;
//     newRow.appendChild(prenomCell);

//     let adresseCell= document.createElement('td')
//     adresseCell.textContent =adresse;
//     newRow.appendChild(adresseCell);

//     let contactCell= document.createElement('td')
//     contactCell.textContent =contact;
//     newRow.appendChild(contactCell);

//     let dateCell= document.createElement('td')
//     dateCell.textContent =date;
//     newRow.appendChild(dateCell);

//     let tontineCell= document.createElement('td')
//     tontineCell.textContent =tontine;
//     newRow.appendChild(tontineCell);

//     const actionCell = document.createElement("button");
//     const btnSupprimer = document.createElement("tr");
//     btnSupprimer.className = "btn btn-danger offset-3";
//     btnSupprimer.innerHTML = '<i class="fa fa-trash"></i>';
//     btnSupprimer.addEventListener("click", function(event) {
//         event.preventDefault();
//         newRow.remove();
//     });
//     actionCell.appendChild(btnSupprimer);
//     newRow.appendChild(actionCell);

//     tableBody.appendChild(newRow);
    
//    }

//    //======================= BTN-Imprimer ========================

// // Obtenir une référence vers le bouton "Imprimer"
// const btnImprimer = document.getElementById("btnImprimer");

// // Ajouter un écouteur d'événement au clic sur le bouton "Imprimer"
// btnImprimer.addEventListener("click", function(event) {
//     event.preventDefault();

//     const table = document.getElementById("tableau");
//     // Appeler la fonction d'impression
//     window.print();
   
// });
// //======================= BTN-Supprimer ========================

// // Obtenir une référence vers tous les boutons de suppression avec l'ID "btnSupprimer"
// const btnsSupprimer = document.querySelectorAll("#btnSupprimer");

// // Parcourir chaque bouton de suppression et ajouter un écouteur d'événement
// btnsSupprimer.forEach(function(btnSupprimer) {
//     btnSupprimer.addEventListener("click", function(event) {
//         event.preventDefault();

//         // Obtenir la ligne parente du bouton supprimer
//         const ligneASupprimer = btnSupprimer.closest("tr");

//         // Supprimer la ligne du tableau
//         ligneASupprimer.remove();
//     });
// }); 

// //==================== BTN-Recherhcer ========================

// // Obtenir une référence vers le bouton "Rechercher"
// const btnRechercher = document.getElementById("btnRechercher");

// // Ajouter un écouteur d'événement au clic sur le bouton "Rechercher"
// btnRechercher.addEventListener("click", function(event) {
//     event.preventDefault();

//     // Obtenir le contact saisi dans le champ de recherche
//     const contactRecherche = document.getElementById("contact").value;

//     // Obtenir une référence vers le tableau
//     const table = document.getElementById("tableau");

//     // Parcourir chaque ligne dans le tableau
//     for (let ligne of table.rows) {
//         // Obtenir le contact de la première colonne de la ligne
//         const cellulecontact = ligne.cells[3];
//         const contactLigne = cellulecontact.textContent;

//         // Afficher ou masquer la ligne en fonction de la correspondance du contact
//         if (contactLigne === contactRecherche || contactRecherche === "") {
//             ligne.style.display = "table-row"; // Afficher la ligne
//         } else {
//             ligne.style.display = "none"; // Masquer la ligne
//         }
        
//     }

//     const adresseRecherche = document.getElementById("contact").value;

//     // Obtenir une référence vers le tableau
//     const tab = document.getElementById("tableau");

//     // Parcourir chaque ligne dans le tableau
//     for (let ligne of tab.rows) {
//         // Obtenir le contact de la première colonne de la ligne
//         const celluleadresse = ligne.cells[2];
//         const adresseLigne = celluleadresse.textContent;

//         // Afficher ou masquer la ligne en fonction de la correspondance du contact
//         if (adresseLigne === adresseRecherche || adresseRecherche === "") {
//             ligne.style.display = "table-row"; // Afficher la ligne
//         } else {
//             ligne.style.display = "none"; // Masquer la ligne
//         }
        
//     }
// });

// //======================= BTN-Actualiser ========================

// // Obtenir une référence vers le bouton "Actualiser"
// const btnActualiser = document.getElementById("btnActualiser");

// // Ajouter un écouteur d'événement au clic sur le bouton "Actualiser"
// btnActualiser.addEventListener("click", function(event) {
//     event.preventDefault();

//     // Obtenir une référence vers le tableau
//     const table = document.getElementById("tableau");

//     // Parcourir chaque ligne dans le tableau
//     for (let ligne of table.rows) {
//         ligne.style.display = "table-row"; // Ré-afficher la ligne
//     }
// });
