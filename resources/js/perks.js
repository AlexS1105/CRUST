let perks = 0
let perksCostSum = 0

window.updatePerks = function () {
    let perkCheckboxes = document.querySelectorAll("*[id^='perks'][id$='[selected]']");

    perks = 0
    perksCostSum = 0

    for (let i = 0; i < perkCheckboxes.length; i++) {
        let checkbox = perkCheckboxes[i]
        let checked = checkbox.checked
        let perkId = checkbox.getAttribute('data-perk-id')
        let cost = parseInt(checkbox.getAttribute('data-perk-cost'))
        let card = document.getElementById('perk-' + perkId)
        let dataFields = document.getElementById('perk-data-' + perkId)

        if (checked) {
            perks++
            perksCostSum += cost

            card.classList.remove('opacity-50')
            dataFields.classList.remove('hidden')
        } else {
            card.classList.add('opacity-50')
            dataFields.classList.add('hidden')
        }

        updateLabels()
    }
}

function updateLabels() {
    let perksLabel = document.getElementById('perk-count')
    perksLabel.innerHTML = perks
    let perksCostLabel = document.getElementById('perk-cost')
    perksCostLabel.innerHTML = perkPoints - perksCostSum
}

window.updatePerkPoints = function() {
    let input = document.getElementById('perk_points')
    let perkPointsLabel = document.getElementById('perk-points')
    perkPointsLabel.innerHTML = input.value
    maxPerks = input.value
    updatePerks()
}

if (typeof (maxPerks) != 'undefined') {
    updatePerks()
}
