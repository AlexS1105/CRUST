var combatPerks = 0
var noncombatPerks = 0
var attackPerks = 0
var defencePerks = 0

window.updatePerks = function () {
    var perkSelectors = document.querySelectorAll("*[id^='perks'][id$='[id]']");

    combatPerks = 0
    attackPerks = 0
    defencePerks = 0
    noncombatPerks = 0

    for (var i = 0; i < perkSelectors.length; i++) {
        var selector = perkSelectors[i]
        var index = parseInt(selector.value)
        var perkId = selector.getAttribute('data-perk-id')
        var card = document.getElementById('perk-' + perkId)
        var dataFields = document.getElementById('perk-data-' + perkId)

        if (index != -1) {
            var isCombat = selector.getAttribute('data-combat')
            var isAttack = selector.getAttribute('data-attack')
            var isDefence = selector.getAttribute('data-defence')
            var active = false

            if (dataFields != null && dataFields.hasChildNodes()) {
                active = dataFields.children[0].children[0].checked
            }

            if (active) {
                if (isCombat) {
                    combatPerks++

                    if (isAttack) {
                        attackPerks++
                    } else if (isDefence) {
                        defencePerks++
                    }
                } else {
                    noncombatPerks++
                }
            }

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
    var combatPerksLabel = document.getElementById('combat_perk_count')
    combatPerksLabel.innerHTML = combatPerks

    if (combatPerks > maxActivePerks) {
        combatPerksLabel.parentElement.classList.add('text-red-500')
    } else {
        combatPerksLabel.parentElement.classList.remove('text-red-500')
    }

    var attackPerkLabel = document.getElementById('combat_perk_attack')
    attackPerkLabel.innerHTML = attackPerks

    if (attackPerks > 1) {
        attackPerkLabel.parentElement.classList.add('text-red-500')
    } else {
        attackPerkLabel.parentElement.classList.remove('text-red-500')
    }

    var defencePerkLabel = document.getElementById('combat_perk_defence')
    defencePerkLabel.innerHTML = defencePerks

    if (defencePerks > 1) {
        defencePerkLabel.parentElement.classList.add('text-red-500')
    } else {
        defencePerkLabel.parentElement.classList.remove('text-red-500')
    }

    var noncombatPerksLabel = document.getElementById('noncombat_perk_count')
    noncombatPerksLabel.innerHTML = noncombatPerks

    if (noncombatPerks > maxActivePerks) {
        noncombatPerksLabel.parentElement.classList.add('text-red-500')
    } else {
        noncombatPerksLabel.parentElement.classList.remove('text-red-500')
    }
}

if (typeof (maxActivePerks) != 'undefined') {
    updatePerks()
}
