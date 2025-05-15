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
                options(data);
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

function options(etapesData) {
    const container = document.querySelector('.container-res ul');
    if (!container) {
        console.error('Pas de conteneur ici!');
        return;
    }

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
            noneInput.type = 'checkbox';
            noneInput.name = `etape_${etapeId}_none`;
            noneInput.id = `none_${etapeId}`;
            noneInput.value = '0';
            noneInput.checked = true;
            noneInput.classList.add('none-option');

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
                optionInput.type = 'checkbox';
                optionInput.name = `etape_${etapeId}_options_${option.id}`;
                optionInput.id = `option_${etapeId}_${option.id}`;
                optionInput.value = option.id;
                optionInput.dataset.prix = option.prix;
                optionInput.dataset.etape = etapeId;
                optionInput.classList.add('price-option');

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
    setupPriceCalculation();
}

function calculateTotalPrice() {
    let total = parseInt(document.getElementById('prixbase').dataset.prix) || 0;

    const selectedOptions = document.querySelectorAll('.price-option:checked');

    for (let i = 0; i < selectedOptions.length; i++) {
        total += parseInt(selectedOptions[i].dataset.prix) || 0;
    }
    return total;
}

function setupPriceCalculation() {
    document.querySelectorAll('.none-option').forEach(noneOption => {
        noneOption.addEventListener('change', function() {
            const etapeId = this.name.split('_')[1];
            const options = document.querySelectorAll(`.price-option[data-etape="${etapeId}"]`);

            if (this.checked) {
                // Décoche tous les autres choix
                for (let i = 0; i < options.length; i++) {
                    options[i].checked = false;
                }
            }
            updateTotal();
        });
    });

    document.querySelectorAll('.price-option').forEach(option => {
        option.addEventListener('change', function() {
            const etapeId = this.dataset.etape;
            const noneOption = document.querySelector(`.none-option[name="etape_${etapeId}_none"]`);

            if (this.checked) {
                noneOption.checked = false;
            } else if (!anyOptionChecked(etapeId)) {
                noneOption.checked = true;
            }
            updateTotal();
        });
    });

    function anyOptionChecked(etapeId) {
        const options = document.querySelectorAll(`.price-option[data-etape="${etapeId}"]`);
        for (let i = 0; i < options.length; i++) {
            if (options[i].checked) return true;
        }
        return false;
    }

    function updateTotal() {
        const totalElement = document.getElementById('prixtotal');
        if (totalElement) {
            totalElement.textContent = `Total: ${calculateTotalPrice()} €`;
        }
    }

    updateTotal();
}