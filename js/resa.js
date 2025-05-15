// fetch-options.js

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const voyageId = urlParams.get('get'); // numéro du voyage

    const xhr = new XMLHttpRequest();
    xhr.open('GET', `http://localhost:8080/api/options.php?id=${voyageId}`, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                const data = JSON.parse(xhr.responseText);
                generateOptionsForm(data);
            } catch (e) {
                console.error('Erreur de parsing JSON', e);
            }
        } else {
            console.error('Erreur GET api/options.php. Status:', xhr.status);
        }
    };

    xhr.onerror = function() {
        console.error('Erreur de requête:', xhr.responseText);
    };

    xhr.send();
});

function generateOptionsForm(etapesData) {
    const container = document.querySelector('.container-res ul');
    if (!container) {
        console.error('Pas de conteneur ici!');
        return;
    }

    // Vider le conteneur
    container.innerHTML = '';

    for (const etapeId in etapesData) {
        if (etapesData.hasOwnProperty(etapeId)) {
            const etape = etapesData[etapeId];
            const etapeLi = document.createElement('li');

            const etapeTitle = document.createElement('h4');
            etapeTitle.textContent = `Etape ${etapeId} : ${etape.titre}`;
            etapeLi.appendChild(etapeTitle);

            const optionsUl = document.createElement('ul');

            const noneLi = document.createElement('li');
            const noneInput = document.createElement('input');
            noneInput.type = 'radio';
            noneInput.name = `etape_${etapeId}`;
            noneInput.id = `none_${etapeId}`;
            noneInput.value = '0';
            noneInput.checked = true;

            const noneLabel = document.createElement('label');
            noneLabel.htmlFor = `none_${etapeId}`;
            noneLabel.textContent = 'Sans option';

            noneLi.appendChild(noneInput);
            noneLi.appendChild(noneLabel);
            optionsUl.appendChild(noneLi);

            const options = etape.options;
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                const optionLi = document.createElement('li');
                
                const optionInput = document.createElement('input');
                optionInput.type = 'radio';
                optionInput.name = `etape_${etapeId}`;
                optionInput.id = `option_${etapeId}_${option.id}`;
                optionInput.value = option.id;
                optionInput.dataset.prix = option.prix;

                const optionLabel = document.createElement('label');
                optionLabel.htmlFor = `option_${etapeId}_${option.id}`;
                optionLabel.textContent = `${option.titre} - ${option.prix}€ (Max ${option.personnesMax} personnes)`;

                optionLi.appendChild(optionInput);
                optionLi.appendChild(optionLabel);
                optionsUl.appendChild(optionLi);
            }

            etapeLi.appendChild(optionsUl);
            container.appendChild(etapeLi);
        }
    }
}