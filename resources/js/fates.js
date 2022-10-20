var fates = []
var id = 0

function updateFates() {
    _fates.forEach(fate => {
        if (fate.type) {
            fate['ambition'] = fate.type & 1 && 'on'
            fate['flaw'] = fate.type & 2 && 'on'
            fate['continuous'] = fate.type & 4 && 'on'
        }

        addFateCard(fate)
    });

    updateMaxFates()
    updateAddButton()
}

function updateMaxFates() {
    if (fates.length < maxFates && !document.getElementById('button_add_fate')) {
        displayAddFateButton()
    }

    var maxFatesLabel = document.getElementById('fates_max')
    maxFatesLabel.innerHTML = maxFates - fates.length
}

function displayAddFateButton() {
    var list = document.getElementById('fates')
    var button = document.createElement('button')
    button.className = 'bg-blue-400 rounded-md px-2 py-1 text-white font-bold text-2xl leading-none text-center align-middle'
    button.innerHTML = '+'
    button.type = 'button'
    button.id = 'button_add_fate'
    button.onclick = function () {
        addFateCard()
        list.append(button)
        updateMaxFates()
        updateAddButton()
    }

    list.append(button)
}

function addFateCard(fate) {
    var list = document.getElementById('fates')
    var card = document.createElement('div')
    card.className = 'bg-gray-100 p-2 space-y-2 rounded'
    card.id = id

    var textField = document.createElement('textarea')
    textField.className = 'border border-gray-200 p-2 w-full rounded'
    textField.value = fate && fate['text'] || ''
    textField.placeholder = fateText
    textField.required
    textField.name = 'fates[' + id + '][text]'
    textField.setAttribute('onfocus', 'preview(this)')

    var flagsDiv = document.createElement('div')
    flagsDiv.className = 'flex space-x-2 items-center'

    var checkboxAmbition = document.createElement('input')
    checkboxAmbition.type = 'checkbox'
    checkboxAmbition.checked = fate && fate['ambition'] == 'on' || null
    checkboxAmbition.name = 'fates[' + id + '][ambition]'

    flagsDiv.append(checkboxAmbition)

    var ambitionLabel = document.createElement('label')
    ambitionLabel.htmlFor = 'fates[' + id + '][ambition]'
    ambitionLabel.innerHTML = ambitionLabelText

    flagsDiv.append(ambitionLabel)

    var checkboxFlaw = document.createElement('input')
    checkboxFlaw.type = 'checkbox'
    checkboxFlaw.checked = fate && fate['flaw'] == 'on' || null
    checkboxFlaw.name = 'fates[' + id + '][flaw]'

    flagsDiv.append(checkboxFlaw)

    var flawLabel = document.createElement('label')
    flawLabel.htmlFor = 'fates[' + id + '][flaw]'
    flawLabel.innerHTML = flawLabelText

    flagsDiv.append(flawLabel)

    var checkboxContinuous = document.createElement('input')
    checkboxContinuous.type = 'checkbox'
    checkboxContinuous.checked = fate && fate['continuous'] == 'on' || null
    checkboxContinuous.name = 'fates[' + id + '][continuous]'

    flagsDiv.append(checkboxContinuous)

    var continuousLabel = document.createElement('label')
    continuousLabel.htmlFor = 'fates[' + id + '][flaw]'
    continuousLabel.innerHTML = continuousLabelText

    flagsDiv.append(continuousLabel)

    var deleteButton = document.createElement('button')
    deleteButton.type = 'button'
    deleteButton.className = 'fas fa-trash text-red-400 text-lg'
    deleteButton.onclick = function () {
        fates = fates.filter(_card => _card.id != card.id)
        card.remove()

        updateMaxFates()
        updateAddButton()
    }

    flagsDiv.append(deleteButton)

    card.append(textField)
    card.append(flagsDiv)
    list.append(card)

    fates.push(card)

    id++
}

function updateAddButton() {
    var button = document.getElementById('button_add_fate')

    if (button) {
        if (fates.length >= maxFates) {
            button.classList.add('hidden')
        } else {
            button.classList.remove('hidden')
        }
    }
}

if (typeof (maxFates) != 'undefined') {
    updateFates()
}
