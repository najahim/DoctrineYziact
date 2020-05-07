function updateHoraires() {
    let horaires = "";
    let champ;
    let on;
    let off;
    try {
        for (var i = 0; i < $('.horaires .champ').length; i++) {
            champ = $($('.horaires .champ')[i]);

            off =    champ.children('.debut').val().split(':')[1] + " " +
                    champ.children('.debut').val().split(':')[0] + " " +
                    "* *" + " " +
                    champ.children('.jour').val();

            on =   champ.children('.fin').val().split(':')[1] + " " +
                    champ.children('.fin').val().split(':')[0] + " " +
                    "* *" + " " +
                    champ.children('.jour').val();
            horaires += off + " off ; " + on + " on ; ";
        }

        // On réécrit le champ
        $('.prog_wifi').val(horaires.trim());
    } catch (e) {
        alert('Erreur dans la saisie de la programmation horaire');
        console.log(e);
    }
}

function ajouterRegle(jour, debut, fin) {
    let jour_val = jour || "1";
    let debut_val = debut || "18:00";
    let fin_val = fin || "23:59";
    let selected = [];
    selected[jour] = "selected";

    $(".horaires").append($(`
        <div class="champ">
            <span>La borne est éteinte</span>
            <select name="jour" class="jour">
                <option value="1-7" ${selected["1-7"] || ""}>toute la semaine</option>
                <option value="1" ${selected["1"] || ""}>le lundi</option>
                <option value="2" ${selected["2"] || ""}>le mardi</option>
                <option value="3" ${selected["3"] || ""}>le mercredi</option>
                <option value="4" ${selected["4"] || ""}>le jeudi</option>
                <option value="5" ${selected["5"] || ""}>le vendredi</option>
                <option value="6" ${selected["6"] || ""}>le samedi</option>
                <option value="7" ${selected["7"] || ""}>le dimanche</option>
            </select>
            <span>entre</span>
            <input type="time" name="start" value="${debut_val}" class="debut">
            <span>et</span>
            <input type="time" name="end" value="${fin_val}"  class="fin">
            <span class="enlever-regle button button-no">Supprimer <i class="fas fa-trash-alt"></i></span>
        </div>
    `));
}


// Calcul de la longitude et de la latitude
// On utilise l'api du gouvernement

function calculerEmplacement() {
    var address =   $(".numero_rue").val() + " " +
                    $(".rue").val() + " " +
                    $(".ville").val() + " " +
                    "&postcode=" + $(".code_postal").val();
    $.getJSON(encodeURI("https://api-adresse.data.gouv.fr/search/?q=" + address + "&limit=1"), function(results) {
        if (results.features[0]) {
            $('.longitude').val(results.features[0].geometry.coordinates[0]);
            $('.latitude').val(results.features[0].geometry.coordinates[1]);
        } else {
            alert("Les coordonnées n'ont pas pus être calculés");
        }

    });
}
