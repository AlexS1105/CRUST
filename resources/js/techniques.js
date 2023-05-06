let techniques = 0
let techniquesCostSum = 0

window.updateTechniques = function () {
    let techniqueCheckboxes = document.querySelectorAll("*[id^='techniques'][id$='[selected]']");

    techniques = 0
    techniquesCostSum = 0

    for (let i = 0; i < techniqueCheckboxes.length; i++) {
        let checkbox = techniqueCheckboxes[i]
        let checked = checkbox.checked
        let techniqueId = checkbox.getAttribute('data-technique-id')
        let cost = parseInt(checkbox.getAttribute('data-technique-cost'))
        let card = document.getElementById('technique-' + techniqueId)

        if (checked) {
            techniques++
            techniquesCostSum += cost

            card.classList.remove('opacity-50')
        } else {
            card.classList.add('opacity-50')
        }

        updateLabels()
    }
}

function updateLabels() {
    let techniquesLabel = document.getElementById('technique-count')
    techniquesLabel.innerHTML = techniques
    let techniquesCostLabel = document.getElementById('technique-cost')
    techniquesCostLabel.innerHTML = techniquePoints - techniquesCostSum
}

window.updateTechniquePoints = function() {
    let input = document.getElementById('technique_points')
    let techniquePointsLabel = document.getElementById('technique-points')
    techniquePointsLabel.innerHTML = input.value
    maxTechniques = input.value
    updateTechniques()
}

if (typeof (maxTechniques) != 'undefined') {
    updateTechniques()
}
