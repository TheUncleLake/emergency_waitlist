(function() {
    const getpatients = document.getElementById("getpatients");
    const patients = document.getElementById("patients");
    getpatients.onclick = async function() {
        $.ajax({type: "GET", url: "api/getpatients"}).then(function(data) {
            if (typeof data === "string") {
                alert(data);
                return;
            }
            patients.innerHTML = "";
            for (const elem of data) {
                let tr = patients.insertRow();
                tr.insertCell().innerHTML = elem.patient_name;
                tr.insertCell().innerHTML = elem.severity;
                tr.insertCell().innerHTML = elem.staff_name;
                tr.insertCell().innerHTML = elem.date_triage;
            }
        });
    };
})();