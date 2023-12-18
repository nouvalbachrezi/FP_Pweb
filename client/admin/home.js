$(document).ready(function() {
    let button_color = {
        "Menunggu Verifikasi": "primary",
        "Belum Isi Data": "warning",
        "Revisi Data": "danger",
        "Lolos": "success"
    }

    function tambahDataPendaftar(daftar_akun, id, nama, status) {
        let dataBaru = document.createElement("div");
        dataBaru.classList.add("w-50");
        dataBaru.classList.add("p-1");
        dataBaru.innerHTML = `
            <div id="data-${id}" class="border border-1 border-primary bg-white px-3 py-1 card-corner clickable">
                <p class="primary-font fs-5 text-black mb-2">${nama}</p>
                <div class="d-flex flex-row p-0">
                    <p class="bg-${button_color[status]} rounded-pill m-0 py-2 px-3 primary-font text-white fs-6">${status}</p>
                </div>
            </div>
        `;
        
        daftar_akun.appendChild(dataBaru);

        $(`#data-${id}`).click(function() {
            window.location.href = `./data_pendaftar.php?user_id=${id}`;
        });
    }

    function ambilDataPendaftarBerdasarkanKategori(kategori) {
        fetch("../../server/daftar_pendaftar.php", {
            method: "POST",
            headers: {'Content-Type': 'application/json'},
            credentials: "include",
            body: JSON.stringify({
                kategori: kategori
            })
        }).then((response) => {
            return response.json();
        }).then((query_result) => {
            let daftar_akun = document.getElementById("list-pendaftar");
            while (daftar_akun.firstChild) {
                daftar_akun.removeChild(daftar_akun.lastChild);
            }
            
            for (let data of query_result) {
                tambahDataPendaftar(daftar_akun, data["u_id"], data["u_nama_lengkap"], data["u_status_pendaftaran"]);
            }
        });
    }
    
    $("#button-filter-menunggu-verifikasi").click(function() {
        ambilDataPendaftarBerdasarkanKategori("Menunggu Verifikasi");
    });

    $("#button-filter-belum-isi").click(function() {
        ambilDataPendaftarBerdasarkanKategori("Belum Isi Data");
    });

    $("#button-filter-revisi").click(function() {
        ambilDataPendaftarBerdasarkanKategori("Revisi Data");
    });

    $("#button-filter-lolos").click(function() {
        ambilDataPendaftarBerdasarkanKategori("Lolos");
    });
});