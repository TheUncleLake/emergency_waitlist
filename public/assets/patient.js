(function() {
    const name = document.getElementById("name");
    const severity = document.getElementById("severity");
    const datetriage = document.getElementById("datetriage");
    const info = document.getElementById("info");
    const notriage = document.getElementById("notriage");
    $.ajax({type: "GET", url: "api/getinfo"}).then(function(data) {
        if (typeof data === "string") {
            alert(data);
            return;
        }
        data = data[0];
        name.textContent = data.patient_name;
        if (data.date_triage != null) {
            info.classList.remove("hidden");
            severity.textContent = data.severity;
            datetriage.dateTime = data.date_triage;
            datetriage.textContent = new Date(data.date_triage).toDateString();
        }
        else notriage.classList.remove("hidden");
    });
})();