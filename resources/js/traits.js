var selectedTrait = null
var selectedSubtrait = null

var traitInput = document.getElementById('trait')
var subtraitInput = document.getElementById('subtrait')

window.selectTrait = function(element) {
  var traitId = parseInt(element.getAttribute('data-id'))
  var subtrait = Boolean(parseInt(element.getAttribute('data-subtrait')))

  if (subtrait) {
    if (selectedSubtrait != null) {
      setSelected(selectedSubtrait, false)
    }

    setSelected(element, true)
    selectedSubtrait = element

    subtraitInput.value = traitId
  } else {
    if (selectedTrait != null) {
      setSelected(selectedTrait, false)
    }

    setSelected(element, true)
    selectedTrait = element

    traitInput.value = traitId
  }
}

function setSelected(element, selected) {
  if (element == null) {
    return
  }

  if (selected) {
    element.classList.remove('opacity-50')
  } else {
    element.classList.add('opacity-50')
  }
}

if (traitInput && traitInput.value) {
  var traitId = traitInput.value
  var card = document.getElementById('trait-' + traitId)

  if (card) {
    window.selectTrait(card)
  }
}

if (subtraitInput && subtraitInput.value) {
  var traitId = subtraitInput.value
  var card = document.getElementById('trait-' + traitId)

  if (card) {
    window.selectTrait(card)
  }
}
