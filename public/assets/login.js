(function() {
    const patient = document.getElementById("patient");
    const admin = document.getElementById("admin");
    const patientlogin = document.getElementById("patientlogin");
    const adminlogin = document.getElementById("adminlogin");
    patient.onclick = function() {
        adminlogin.classList.add("hidden");
        patientlogin.classList.remove("hidden");
    }
    admin.onclick = function() {
        patientlogin.classList.add("hidden");
        adminlogin.classList.remove("hidden");
    }
})();