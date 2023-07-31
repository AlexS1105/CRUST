let skillCostSum = 0

window.updateSkills = function () {
    let skillSelectors = document.querySelectorAll("*[name^='skills'][name$='[level]']");
    skillCostSum = 0

    for (let i = 0; i < skillSelectors.length; i++) {
        let selector = skillSelectors[i]
        let value = parseInt(selector.value)
        let skillId = selector.getAttribute('data-skill-id')
        let cost = 0

        switch (value) {
            case 1:
                cost = 1
                break
            case 2:
                cost = 3
                break
            case 3:
                cost = 5
                break
        }

        skillCostSum += cost

        updateSkillLabel(skillId, cost)
    }

    updateSkillsCost()
}

function updateSkillLabel(skillId, cost) {
    let skillLabel = document.getElementById('skill-' + skillId)
    skillLabel.innerHTML = cost
}

function updateSkillsCost() {
    let skillsCostLabel = document.getElementById('skills-cost')
    skillsCostLabel.innerHTML = maxSkills - skillCostSum
}

window.updateSkillPoints = function () {
    let input = document.getElementById('skill_points')
    let skillsPointsLabel = document.getElementById('skill-points')
    skillsPointsLabel.innerHTML = input.value
    maxSkills = input.value
    updateSkills()
}

if (typeof (maxSkills) != 'undefined') {
    updateSkills()
}
