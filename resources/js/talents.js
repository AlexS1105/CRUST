let talents = 0
let talentsCostSum = 0

window.updateTalents = function () {
    let talentCheckboxes = document.querySelectorAll("*[id^='talents'][id$='[selected]']");

    talents = 0
    talentsCostSum = 0

    for (let i = 0; i < talentCheckboxes.length; i++) {
        let checkbox = talentCheckboxes[i]
        let checked = checkbox.checked
        let talentId = checkbox.getAttribute('data-talent-id')
        let cost = parseInt(checkbox.getAttribute('data-talent-cost'))
        let card = document.getElementById('talent-' + talentId)

        if (checked) {
            talents++
            talentsCostSum += cost

            card.classList.remove('opacity-50')
        } else {
            card.classList.add('opacity-50')
        }

        updateLabels()
    }
}

function updateLabels() {
    let talentsLabel = document.getElementById('talent-count')
    talentsLabel.innerHTML = talents
    let talentsCostLabel = document.getElementById('talent-cost')
    talentsCostLabel.innerHTML = talentPoints - talentsCostSum
}

window.updateTalentPoints = function() {
    let input = document.getElementById('talent_points')
    let talentPointsLabel = document.getElementById('talent-points')
    talentPointsLabel.innerHTML = input.value
    maxTalents = input.value
    updateTalents()
}

window.updateMaxTalentsAmount = function() {
    let input = document.getElementById('talents_amount')
    let talentAmountLabel = document.getElementById('max-talent-amount')
    talentAmountLabel.innerHTML = input.value
}

if (typeof (maxTalents) != 'undefined') {
    updateTalents()
}
