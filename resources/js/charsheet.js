window.updateSkillSum = function(slider) {
    slider.nextElementSibling.value = slider.value

    var skillSliders = document.querySelectorAll('*[id^="skills"]');
    var sum = 0

    for(i = 0; i< skillSliders.length; i++) {
        slider = skillSliders[i]

        sum += parseInt(slider.value)
    }

    var sumLabel = document.getElementById('skill_points')
    sumLabel.innerHTML = sum

    var parent = sumLabel.parentElement

    if(sum > maxSkills) {
        parent.classList.add('text-red-600')
    } else {
        parent.classList.remove('text-red-600')
    }
}
