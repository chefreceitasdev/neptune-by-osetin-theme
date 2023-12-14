function byID(id) {
    return document.getElementById(id);
}

if (byID("toggle-1")) {
    byID("toggle-1").onclick = function() {
        if (byID("container-1").classList.contains("closed")) {
            byID("container-1").classList.remove("closed");

            byID("container-2").classList.add("closed");
            byID("container-3").classList.add("closed");
            byID("container-4").classList.add("closed");
            byID("container-5").classList.add("closed");

        } else {
            byID("container-1").classList.add("closed");
        }
    }
}
if (byID("toggle-2")) {
    byID("toggle-2").onclick = function() {
        if (byID("container-2").classList.contains("closed")) {
            byID("container-2").classList.remove("closed");

            byID("container-1").classList.add("closed");
            byID("container-3").classList.add("closed");
            byID("container-4").classList.add("closed");
            byID("container-5").classList.add("closed");

        } else {
            byID("container-2").classList.add("closed");
        }
    }
}

if (byID("toggle-3")) {
    byID("toggle-3").onclick = function() {
        if (byID("container-3").classList.contains("closed")) {
            byID("container-3").classList.remove("closed");

            byID("container-2").classList.add("closed");
            byID("container-1").classList.add("closed");
            byID("container-4").classList.add("closed");
            byID("container-5").classList.add("closed");

        } else {
            byID("container-3").classList.add("closed");
        }
    }
}

if (byID("toggle-4")) {
    byID("toggle-4").onclick = function() {
        if (byID("container-4").classList.contains("closed")) {
            byID("container-4").classList.remove("closed");

            byID("container-2").classList.add("closed");
            byID("container-3").classList.add("closed");
            byID("container-1").classList.add("closed");
            byID("container-5").classList.add("closed");

        } else {
            byID("container-4").classList.add("closed");
        }
    }
}

if (byID("toggle-5")) {
    byID("toggle-5").onclick = function() {
        if (byID("container-5").classList.contains("closed")) {
            byID("container-5").classList.remove("closed");

            byID("container-2").classList.add("closed");
            byID("container-3").classList.add("closed");
            byID("container-4").classList.add("closed");
            byID("container-1").classList.add("closed");

        } else {
            byID("container-5").classList.add("closed");
        }
    }
}