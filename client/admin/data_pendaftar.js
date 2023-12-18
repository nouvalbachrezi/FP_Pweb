function ubah_status(user_id, status_pendaftaran) {
    fetch("../../server/ubah_status_pendaftaran.php", {
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        credentials: "include",
        body: JSON.stringify({
            user_id: user_id,
            status_pendaftaran: status_pendaftaran
        })
    }).then((response) => {
        return response.json();
    }).then((query_result) => {
        window.location.reload();
    });
}