window.updateStatsSum = function () {
    let statInputs = document.querySelectorAll("*[id^='stats']");
    let sum = 0
    let bodySum = 0
    let essenceSum = 0

    for (let i = 0; i < statInputs.length; i++) {
        let input = statInputs[i]
        let value = parseInt(input.value)
        let stat = input.id.replace(/(^.*\[|\].*$)/g, '')
        let cost = getStatCost(value);

        sum += cost

        if (isBodyStat(stat)) {
            bodySum += cost
        } else {
            essenceSum += cost
        }
    }

    updateSumLabel(sum)
    updateBodySumLabel(bodySum)
    updateEssenceSumLabel(essenceSum)
}

function isBodyStat(stat) {
    return ['strength', 'perception', 'agility', 'endurance'].includes(stat)
}

function updateSumLabel(sum) {
    let sumLabel = document.getElementById('stat-points')
    sumLabel.innerHTML = maxStats - sum

    let parent = sumLabel.parentElement

    if (sum > maxStats) {
        parent.classList.add('text-red-600')
    } else {
        parent.classList.remove('text-red-600')
    }
}

function updateBodySumLabel(sum) {
    let sumLabel = document.getElementById('body-sum')
    sumLabel.innerHTML = sum
}

function updateEssenceSumLabel(sum) {
    let sumLabel = document.getElementById('essence-sum')
    sumLabel.innerHTML = sum
}

function getStatCost(value) {
    let cost = 0

    for (let i = 1; i <= value; i++) {
        if (i <= 10) {
            cost++
        } else if (i <= 15) {
            cost += 2
        } else if (i <= 20) {
            cost += 3
        } else {
            cost += 4
        }
    }

    return cost
}

if (typeof (maxStats) != 'undefined') {
    window.updateStatsSum()
}
