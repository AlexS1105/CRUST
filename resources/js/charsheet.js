
var maxMagic = 0
var maxTech = 0
var maxGeneral = 0

var magicPoints = 0
var techPoints = 0
var generalPoints = 0

window.updateSkillSum = function(slider) {
    slider.nextElementSibling.value = slider.value

    updateSkills()
}

window.updateCraftsSum = function(slider) {
    slider.nextElementSibling.value = slider.value

    updateCrafts()
}

function updateSkills() {
    var skillSliders = document.querySelectorAll('*[id^="skills"]');
    var sum = 0

    for(i = 0; i < skillSliders.length; i++) {
        slider = skillSliders[i]
        var skill = slider.id.replace( /(^.*\[|\].*$)/g, '' )
        var value = parseInt(slider.value)

        sum += value

        if(skill == "magic") {
            maxMagic = value
        } else if(skill == "tech") {
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

    updateMagicPoints()
    updateTechPoints()
    updateGeneralPoints()
}

function updateCrafts() {
    var craftSliders = document.querySelectorAll('*[id^="crafts"]');
    var magicSum = 0
    var techSum = 0
    var generalSum = 0

    var maxTiers = []
    maxTiers['magic'] = 0
    maxTiers['tech'] = 0
    maxTiers['general'] = 0

    var firstTiers = []
    firstTiers['magic'] = 0
    firstTiers['tech'] = 0
    firstTiers['general'] = 0
    
    var freeTiers = 0

    for(i = 0; i < craftSliders.length; i++) {
        slider = craftSliders[i]
        var value = parseInt(slider.value)
        var craft = slider.id.replace( /(^.*\[|\].*$)/g, '' )

        if(value == 3) {
            if(magicCrafts.includes(craft)) {
                maxTiers['magic']++
            } else if(techCrafts.includes(craft)) {
                maxTiers['tech']++
            } else {
                maxTiers['general']++
            }
        }

        if(value == 1) {
            if(magicCrafts.includes(craft)) {
                firstTiers['magic']++
            } else if(techCrafts.includes(craft)) {
                firstTiers['tech']++
            } else {
                firstTiers['general']++
            }
        }
    }

    for(i = 0; i < craftSliders.length; i++) {
        slider = craftSliders[i]
        var craft = slider.id.replace( /(^.*\[|\].*$)/g, '' )
        var value = parseInt(slider.value)
        var type = magicCrafts.includes(craft) ? 'magic' : techCrafts.includes(craft) ? 'tech' : 'general'
        var cost = 0

        if((maxTiers[type] > 0 || type == 'general' && (maxTiers['magic'] > 0 || maxTiers['tech'] > 0)) && freeTiers == 0 && value == 1) {
            freeTiers++
        } else {
            for(k = 1; k <= value; k++) {
                cost += k
            }
        }

        if(type == "magic") {
            magicSum += cost
        } else if(type == "tech") {
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

updateSkills()
updateCrafts()
