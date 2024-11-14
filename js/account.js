// JavaScript để mở và đóng modal
document.getElementById("addAccountBtn").onclick = function() {
    document.getElementById("addAccountModal").style.display = "block";
}

document.getElementById("closeModalBtn").onclick = function() {
    document.getElementById("addAccountModal").style.display = "none";
}

document.getElementById("cancelBtn").onclick = function() {
    document.getElementById("addAccountModal").style.display = "none";
}

// Khi người dùng bấm bất kỳ chỗ nào ngoài modal, đóng modal
window.onclick = function(event) {
    if (event.target == document.getElementById("addAccountModal")) {
        document.getElementById("addAccountModal").style.display = "none";
    }
}
