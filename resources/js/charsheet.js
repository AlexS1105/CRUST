var maxMagic = 0
var maxTech = 0
var maxGeneral = 0

var magicPoints = 0
var techPoints = 0
var generalPoints = 0

var maxNarrativeCrafts = 0
var narrativeCrafts = []
var id = 0

window.updateSkillSum = function(slider) {
    var skill = slider.id.replace(/(^.*\[|\].*$)/g, '')
    var skillLabel = document.getElementById(skill)
    skillLabel.innerHTML = slider.value

    updateSkills()
}

window.updateCraftsSum = function(slider) {
    slider.nextElementSibling.value = slider.value

    updateCrafts()
}

function updateNarrativeCrafts() {
    _narrativeCrafts.forEach(craft => {
        addNarrativeCraftCard(craft['name'], craft['description'])
    });

    updateMaxNarrativeCrafts()
    updateAddButton()
}

function updateMaxNarrativeCrafts() {
    maxNarrativeCrafts = Math.floor((maxMagic + maxTech) / 2) + generalPoints

    if (maxNarrativeCrafts > 0 && !document.getElementById('button_add')) {
        displayAddNarrativeCraftButton()
    }

    var maxNarrativeCraftsLabel = document.getElementById('narrative_crafts_max')
    maxNarrativeCraftsLabel.innerHTML = maxNarrativeCrafts - narrativeCrafts.length
}

function displayAddNarrativeCraftButton() {
    var list = document.getElementById('narrative_crafts')
    var button = document.createElement('button')
    button.className = 'bg-blue-400 rounded-md px-2 py-1 text-white font-bold text-2xl leading-none text-center align-middle'
    button.innerHTML = '+'
    button.type = 'button'
    button.id = 'button_add'
    button.onclick = function() {
        addNarrativeCraftCard()
        list.append(button)
        updateMaxNarrativeCrafts()
        updateAddButton()
    }

    list.append(button)
}

function addNarrativeCraftCard(name, description) {
    var list = document.getElementById('narrative_crafts')
    var card = document.createElement('div')
    card.className = 'bg-gray-100 p-2 space-y-2 rounded'
    card.id = id

    var nameField = document.createElement('input')
    nameField.className = 'border border-gray-200 p-2 w-full rounded'
    nameField.type = 'text'
    nameField.value = name || ''
    nameField.placeholder = craftNameText
    nameField.required
    nameField.name = 'narrative_crafts[' + id + '][name]'

    var descriptionDiv = document.createElement('div')
    descriptionDiv.className = 'flex space-x-2'
    
    var descriptionField = document.createElement('input')
    descriptionField.className = 'border border-gray-200 p-2 w-full rounded'
    descriptionField.type = 'text'
    descriptionField.value = description || ''
    descriptionField.placeholder = craftDescriptionText
    descriptionField.required
    descriptionField.name = 'narrative_crafts[' + id + '][description]'

    descriptionDiv.append(descriptionField)

    var deleteButton = document.createElement('button')
    deleteButton.type = 'button'
    deleteButton.className = 'fas fa-trash text-red-400 text-lg'
    deleteButton.onclick = function() {
        narrativeCrafts = narrativeCrafts.filter(_card => _card.id != card.id)
        card.remove()

        updateMaxNarrativeCrafts()
        updateAddButton()
    }

    descriptionDiv.append(deleteButton)
    
    card.append(nameField)
    card.append(descriptionDiv)
    list.append(card)

    narrativeCrafts.push(card)

    id++
}

function updateAddButton() {
    var button = document.getElementById('button_add')

    if (narrativeCrafts.length >= maxNarrativeCrafts) {
        button.classList.add('hidden')
    } else {
        button.classList.remove('hidden')
    }
}

function updateSkills() {
    var skillSliders = document.querySelectorAll("*[id^='skills']");
    var sum = 0

    for(var i = 0; i < skillSliders.length; i++) {
        var slider = skillSliders[i]
        var skill = slider.id.replace(/(^.*\[|\].*$)/g, '')
        var value = parseInt(slider.value)

        sum += value

        if(skill == 'magic') {
            maxMagic = value
        } else if(skill == 'tech') {
            maxTech = value
        }
    }

    var sumLabel = document.getElementById('skill_points')
    sumLabel.innerHTML = maxSkills - sum

    var parent = sumLabel.parentElement

    if(sum > maxSkills) {
        parent.classList.add('text-red-600')
    } else {
        parent.classList.remove('text-red-600')
    }

    var costs = calculateGeneralCost(magicPoints, techPoints, generalPoints)
    magicPoints = costs[0]
    techPoints = costs[1]

    updateCrafts()
}

function updateCrafts() {
    var craftSliders = document.querySelectorAll("*[id^='crafts']");
    var magicSum = 0
    var techSum = 0
    var generalSum = 0

    var maxTiers = []
    maxTiers['magic'] = 0
    maxTiers['tech'] = 0
    maxTiers['general'] = 0

    var freeTiers = 0

    for(var i = 0; i < craftSliders.length; i++) {
        var slider = craftSliders[i]
        var value = parseInt(slider.value)
        var craft = slider.id.replace(/(^.*\[|\].*$)/g, '')
        var type = magicCrafts.includes(craft) ? 'magic' : techCrafts.includes(craft) ? 'tech' : 'general'

        if(value == 3) {
            maxTiers[type]++
        }
    }

    for(var i = 0; i < craftSliders.length; i++) {
        var slider = craftSliders[i]
        var craft = slider.id.replace(/(^.*\[|\].*$)/g, '')
        var value = parseInt(slider.value)
        var type = magicCrafts.includes(craft) ? 'magic' : techCrafts.includes(craft) ? 'tech' : 'general'
        var cost = 0

        if((maxTiers[type] > 0 || type == 'general' && (maxTiers['magic'] > 0 || maxTiers['tech'] > 0)) && freeTiers == 0 && value == 1) {
            freeTiers++
        } else {
            for(var k = 1; k <= value; k++) {
                cost += k
            }
        }

        if(type == 'magic') {
            magicSum += cost
        } else if(type == 'tech') {
            techSum += cost
        } else {
            generalSum += cost
        }
    }

    var costs = calculateGeneralCost(magicSum, techSum, generalSum)
    magicSum = costs[0]
    techSum = costs[1]

    updateMagicPoints(magicSum)
    updateTechPoints(techSum)
    updateGeneralPoints()
}

function calculateGeneralCost(magicSum, techSum, generalSum) {
    var toSpent = generalSum

    while(toSpent > 0) {
        var magicPoints = maxMagic - magicSum
        var techPoints = maxTech - techSum

        if(magicPoints > 0 && (magicPoints < techPoints || techPoints <= 0)) {
            var cost = magicPoints > 0 ? Math.min(magicPoints, toSpent) : toSpent
            magicSum += cost
            toSpent -= cost
        } else {
            var cost = techPoints > 0 ? Math.min(techPoints, toSpent) : toSpent
            techSum += cost
            toSpent -= cost
        }
    }

    return [magicSum, techSum]
}

function updateMagicPoints(value) {
    var magicMaxLabel = document.getElementById('magic_points_max')
    magicMaxLabel.innerHTML = maxMagic

    if (value != null) {
        magicPoints = value
    }

    var magicSumLabel = document.getElementById('magic_points_spent')
    magicSumLabel.innerHTML = maxMagic - magicPoints

    var parent = magicSumLabel.parentElement

    if(magicPoints > maxMagic) {
        parent.classList.add('text-red-600')
    } else {
        parent.classList.remove('text-red-600')
    }
}

function updateTechPoints(value) {
    var techMaxLabel = document.getElementById('tech_points_max')
    techMaxLabel.innerHTML = maxTech

    if (value != null) {
        techPoints = value
    }

    var techSumLabel = document.getElementById('tech_points_spent')
    techSumLabel.innerHTML = maxTech - techPoints

    var parent = techSumLabel.parentElement.parentElement

    if(techPoints > maxTech) {
        parent.classList.add('text-red-600')
    } else {
        parent.classList.remove('text-red-600')
    }
}

function updateGeneralPoints() {
    maxGeneral = maxMagic - magicPoints + maxTech - techPoints

    var generalMaxLabel = document.getElementById('general_points_max')
    generalMaxLabel.innerHTML = maxGeneral

    var parent = generalMaxLabel.parentElement.parentElement

    if(maxGeneral < 0) {
        parent.classList.add('text-red-600')
    } else {
        parent.classList.remove('text-red-600')
    }
}

if (typeof(maxSkills) != 'undefined') {
    updateSkills()
    updateCrafts()
    updateNarrativeCrafts()
}
