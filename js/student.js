

// JavaScript để mở và đóng modal
document.getElementById("addStudentBtn").onclick = function() {
    document.getElementById("addStudentModal").style.display = "block";
}

document.getElementById("closeModalBtn").onclick = function() {
    document.getElementById("addStudentModal").style.display = "none";
}

document.getElementById("cancelBtn").onclick = function() {
    document.getElementById("addStudentModal").style.display = "none";
}

// Khi người dùng bấm bất kỳ chỗ nào ngoài modal, đóng modal
window.onclick = function(event) {
    if (event.target == document.getElementById("addStudentModal")) {
        document.getElementById("addStudentModal").style.display = "none";
    }
}