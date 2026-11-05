import jsQR from "jsqr";

window.jsQR = jsQR;

if ("serviceWorker" in navigator) {
    window.addEventListener("load", () => {
        navigator.serviceWorker
            .register("/sw.js")
            .then((registration) => {
                console.log(
                    "JagaKlik Service Worker aktif:",
                    registration.scope,
                );
            })
            .catch((error) => {
                console.error("Gagal mendaftarkan Service Worker:", error);
            });
    });
}
