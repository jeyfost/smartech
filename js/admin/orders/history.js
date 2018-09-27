function pageBlock(action, block, text) {
    if(action === 1) {
        document.getElementById(block).style.backgroundColor = "#fb5c25";
        document.getElementById(text).style.color = "#fff";
    } else {
        document.getElementById(block).style.backgroundColor = "transparent";
        document.getElementById(text).style.color = "#fb5c25";
    }
}