function displayBulletPoints(value) {
    var specializationsList = document.getElementById('specializations-list');
    var lines = value.split('\n');
    specializationsList.innerHTML = '';
    
    for (var i = 0; i < lines.length; i++) {
        if (lines[i].trim() !== '') {
            var listItem = document.createElement('li');
            listItem.textContent = lines[i];
            specializationsList.appendChild(listItem);
        }
    }
}
