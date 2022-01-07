var combatPoints = 0
var noncombatPoints = 0

window.updatePerks = function() {
  var perkSelectors = document.querySelectorAll("*[id^='perks'][id$='[id]']");

  combatPoints = 0
  noncombatPoints = 0

  for(var i = 0; i < perkSelectors.length; i++) {
    var selector = perkSelectors[i]
    var index = parseInt(selector.value)
    var perkId = selector.getAttribute('data-perk-id')
    var card = document.getElementById('perk-' + perkId)
    var dataFields = document.getElementById('perk-data-' + perkId)

    if (index != -1) {
      var cost = parseInt(selector.getAttribute('data-cost'))
      var isCombat = selector.getAttribute('data-combat')

      if (dataFields != null && dataFields.hasChildNodes()) {
        var costOffset = parseInt(dataFields.children[0].value) || 0
  
        cost += costOffset
      }

      if (isCombat) {
        combatPoints += cost
      } else {
        noncombatPoints += cost
      }

      card.classList.remove('opacity-50')
      dataFields.classList.remove('hidden')
    } else {
      card.classList.add('opacity-50')
      dataFields.classList.add('hidden')
    }
    
    if (!edit) {
      updateLabels()
    }
  }
}

function updateLabels() {
  var combatPointsLabel = document.getElementById('combat_perk_points')
  combatPointsLabel.innerHTML = maxPerks - combatPoints

  if (combatPoints > maxPerks) {
    combatPointsLabel.parentElement.classList.add('text-red-500')
  } else {
    combatPointsLabel.parentElement.classList.remove('text-red-500')
  }

  var noncombatPointsLabel = document.getElementById('noncombat_perk_points')
  noncombatPointsLabel.innerHTML = maxPerks - noncombatPoints

  if (noncombatPoints > maxPerks) {
    noncombatPointsLabel.parentElement.classList.add('text-red-500')
  } else {
    noncombatPointsLabel.parentElement.classList.remove('text-red-500')
  }
}

if (typeof(maxPerks) != 'undefined') {
  updatePerks()
}
