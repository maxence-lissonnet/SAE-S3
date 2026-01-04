const inputNom = document.getElementById('nomObjet');
const inputQuantite = document.getElementById('quantite')
const inputDescription = document.getElementById('description')
const affichageCompteurNom = document.getElementById('compteurNom');
const affichageCompteurDesc = document.getElementById('compteurDesc');
const limiteCarac = 150;

inputNom.addEventListener('input', () => {
    const longueur = inputNom.value.length;

    // Optionnel : changer la couleur si on approche de la limite
    if (longueur >= limiteCarac) {
        affichageCompteurNom.textContent = 'Limite atteinte'
        affichageCompteurNom.style.color = 'red';
    } else {
        affichageCompteurNom.style.color = '#44474E';
        affichageCompteurNom.textContent = `${longueur} / ${limiteCarac}`;
    }
});

inputQuantite.addEventListener('input', () => {
    const valeur = inputQuantite.value;
    if (parseInt(valeur) >= 99) {
        inputQuantite.value = 99;
    }

    else if (parseInt(valeur) <= 1) {
        inputQuantite.value = 1;
    }
});

inputDescription.addEventListener('input', () => {
    const longueur = inputDescription.value.length;
    if (longueur >= 1000) {
        affichageCompteurDesc.textContent = 'Limite atteinte'
        affichageCompteurDesc.style.color = 'red';
    }

    else {
        affichageCompteurDesc.textContent = `${longueur} / 1000`;
        affichageCompteurDesc.style.color = '#44474E';
    }
});

var input = document.querySelector("#fileInput");
var preview = document.querySelector(".preview");
var fileTypes = ["image/jpeg", "image/jpg", "image/png"];
preview.style.borderRadius = '30px';

input.addEventListener('change', updateImageDisplay);

function updateImageDisplay() {
    while (preview.firstChild) {
        preview.removeChild(preview.firstChild);
    }

    var curFiles = input.files;

    if (curFiles.length == 0) {
        var para = document.createElement("p");
        para.textContent = "Pas de fichier sélectionné";
        preview.appendChild(para);
        preview.style.borderRadius = '30px';
    } else {
        var list = document.createElement("p");
        preview.appendChild(list);
        for (var i = 0; i < curFiles.length; i++) {
            var listItem = document.createElement("p");
            var para = document.createElement("p");
            if (validType(curFiles[i])) {
                var name = curFiles[i].name;
                if (name.length >= 30) {
                    para.textContent = name.substring(0, 30) + '...';
                }
                else {
                    para.textContent = name;
                }
                var nameSpan = document.createElement("em");
                nameSpan.textContent = " - Taille : " + returnFileSize(curFiles[i].size);
                para.appendChild(nameSpan);
                listItem.appendChild(para);
            } else {
                para.textContent = curFiles[i].name;
                var error = document.createElement("span");
                error.textContent = " - ERREUR FORMAT : Changez la sélection";
                error.classList.add("text-error");

                para.appendChild(error);
                listItem.appendChild(para);

                curFiles = [];
                input.value = "";
            }
            list.appendChild(listItem);
        }
        preview.style.borderRadius = '30px 0 0 30px';
    }
}

function validType(file) {
    for (var i = 0; i < fileTypes.length; i++) {
        if (file.type === fileTypes[i]) {
            return true;
        }
    }
    return false;
}

function returnFileSize(number) {
    if (number < 1024) {
        return number + " o";
    }
    else if (number >= 1024 && number < 10485676) {
        return (number / 1024).toFixed(1) + " Ko";
    } else if (number >= 1048576) {
        return (number / 1048576).toFixed(1) + " Mo";
    }
};

const popup = document.getElementById("popup");
popup.showModal();