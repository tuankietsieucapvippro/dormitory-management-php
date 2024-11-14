// JavaScript để mở và đóng modal
document.getElementById("addRoomBtn").onclick = function() {
    document.getElementById("addRoomModal").style.display = "block";
}

document.getElementById("closeModalBtn").onclick = function() {
    document.getElementById("addRoomModal").style.display = "none";
}

document.getElementById("cancelBtn").onclick = function() {
    document.getElementById("addRoomModal").style.display = "none";
}

// Khi người dùng bấm bất kỳ chỗ nào ngoài modal, đóng modal
window.onclick = function(event) {
    if (event.target == document.getElementById("addRoomModal")) {
        document.getElementById("addRoomModal").style.display = "none";
    }
}
