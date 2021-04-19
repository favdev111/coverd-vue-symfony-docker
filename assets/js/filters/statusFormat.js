module.exports = function (status) {
    if (status == null) return null;

    return status
        .toLowerCase()
        .split('_')
        .map(upperStatus => upperStatus.charAt(0).toUpperCase() + upperStatus.slice(1))
        .join(' ');
};
