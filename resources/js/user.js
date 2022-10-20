window.updatePermissions = function (initial) {
    permissions.forEach(permission => {
        if (!initial || !userPermissions.includes(permission)) {
            var permissionCheckbox = document.getElementsByName(`permissions[${permission}]`)[0];
            var has = hasPermission(permission);

            permissionCheckbox.disabled = has;
            permissionCheckbox.checked = has;
        }
    });
}

window.updateRole = function (roleId, checked) {
    if (checked != userRoles.includes(roleId)) {
        if (checked) {
            userRoles.push(roleId);
        } else {
            userRoles = userRoles.filter(e => e !== roleId);
        }
    }

    updatePermissions();
}

window.hasPermission = function (permission) {
    var has = false;
    userRoles.forEach(roleId => {
        var role = roles.find(e => e.id === roleId);

        if (role.permissions.find(e => e.name === permission)) {
            has = true;
            return;
        }
    })

    return has;
}

try {
    updatePermissions(true);
} catch (e) {

}
