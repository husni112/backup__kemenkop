  
  function addData() {
    function formatDateWithoutSeparator(date) {
      const year = date.getFullYear().toString().slice(-2);
      const month = ('0' + (date.getMonth() + 1)).slice(-2);
      const day = ('0' + date.getDate()).slice(-2);
      const hours = ('0' + date.getHours()).slice(-2);
      const minutes = ('0' + date.getMinutes()).slice(-2);
      const seconds = ('0' + date.getSeconds()).slice(-2);

      return `${month}${day}${year}${hours}${minutes}${seconds}`;
    }

    const currentDate = new Date();
    const formattedDate = formatDateWithoutSeparator(currentDate);
 
    // Menggabungkan nama pengguna dengan tanggal
    const kodeBerkas = `${formattedDate}`;

    // Mengirim data ke server menggunakan AJAX
    fetch('/buat-berkas', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({kode_berkas: kodeBerkas,})
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(result => {
      // Mendapatkan berkasID dari respons
      var berkasID = result.berkasId;
      console.log(berkasID);
      // Lakukan tindakan lain dengan berkasID
      refreshListContainer(berkasID);
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }

  function refreshListContainer() {
    // Fetch the updated list from the server using AJAX
    fetch('', {
        method: 'GET', // Use the appropriate method for your server route
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    })
    .then(response => response.text())
    .then(html => {
      const parsedHtml = new DOMParser().parseFromString(html, 'text/html');
      const listContainer = parsedHtml.getElementById('listContainer');

      if (listContainer) {
        // Menampilkan listContainer di dokumen saat ini
        const currentListContainer = document.getElementById('listContainer');
        
        // Pilihan 1: Mengganti seluruh isi listContainer di dokumen saat ini
         currentListContainer.innerHTML = listContainer.innerHTML;

        // Pilihan 2: Menambahkan isi listContainer di dokumen saat ini
        //currentListContainer.appendChild(listContainer.cloneNode(true));
    } else {
        console.error('Elemen dengan ID "listContainer" tidak ditemukan dalam HTML yang diparse.');
    }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }


  function removeData(event, id) {
    const confirmation = confirm('Apakah Anda yakin ingin menghapus data ini?');

    if (confirmation) {
        // Mengirim permintaan penghapusan ke server menggunakan AJAX
        fetch(`/delete-berkas/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(result => {
            console.log(result.message);
            // Setelah penghapusan berhasil, hapus elemen dari tampilan
            refreshListContainer();
        })
        
        .catch(error => {
            console.error('Error:', error);
        });
    }

    event.stopPropagation();
  }

  function redirectToPage(route) {
    window.location.href = route;
  }

  $('#jenis_penyedia').on('change', function() {
    var selectedValue = $(this).val();

    // Sembunyikan semua formulir
    $('#formNpwp').hide();
    $('#formNik').hide();

    // Tampilkan formulir yang sesuai dengan pilihan
    if (selectedValue === 'penyedia') {
        $('#formNpwp').show();
        $('#formNikRegistration').hide();
        $('#nikErrorMessage').hide();

        $('#nik').val('');
        $('#nama_swakelola').val('');
        $('#infoBidang').hide();
        nikValidated = false;

        $('#nik_pendaftar').val('');
        $('#nama_pendaftar_penyedia').val('');
        $('#bidang_pendaftar').val('');

    } else if (selectedValue === 'swakelola') {
        $('#formNik').show();
        $('#formNpwpRegistration').hide();
        $('#npwpErrorMessage').hide();

        $('#npwp').val('');
        $('#nama_penyedia').val('');
        $('#infoJabatan').hide();
        npwpValidated = false;

        $('#npwp_pendaftar').val('');
        $('#nama_pendaftar_swakelola').val('');
        $('#jabatan_pendaftar').val('');
    }
});

function backToValidationForm(type) {
    if (type === 'nik') {
        $('#formNik').show();
        $('#formNikRegistration').hide();
        $('#nik').val('');
        $('#nama_swakelola').val('');
        $('#infoBidang').hide();
        nikValidated = false;            

    } else if (type === 'npwp') {
        $('#formNpwp').show();
        $('#formNpwpRegistration').hide();
        $('#npwp').val('');
        $('#nama_penyedia').val('');
        $('#infoJabatan').hide();
        npwpValidated = false;

    } else if (type === 'kode_mak'){
        $('#infoKodeMak').empty();
        $('#infoKodeMak').hide();
        $('#kodeMakErrorMessage').hide();
        kodeMakValidated = false;
    }
}

function registration(type) {
    if (type === 'npwp') {
        $('#formNpwp').hide();
        $('#formNpwpRegistration').show();
        npwpValidated = false;

    } else if (type === 'nik') {
        $('#formNik').hide();
        $('#formNikRegistration').show();
        npwpValidated = false;
    }
}

$('#registerNpwpLink').click(function(e) {
    // Prevent the default behavior (e.g., following the link)
    e.preventDefault();

    // Your custom action here, for example, show another form or perform some action
    $('#formNpwpRegistration').show();
    $('#npwpErrorMessage').hide(); // Hide the error message if it's visible
});

let counter = 1;
function createConsItemSelector(data) {
    var outerDiv = document.createElement('div');
    outerDiv.setAttribute('id', counter);

    var label = document.createElement('label');
    label.setAttribute('for', `add_cons_item_${counter}`);
    label.classList.add('form-label');
    label.textContent = 'Cons_Item';
    outerDiv.appendChild(label);

    var newSelect = document.createElement('select');
    newSelect.classList.add('form-select');
    newSelect.id = `select_cons_item_${counter}`;

    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = 'Pilih Cons Item';
    defaultOption.selected = true;
    defaultOption.disabled = true;
    newSelect.add(defaultOption);

    data.forEach(function (item) {
        var option = document.createElement('option');
        option.value = item.uraian_item;
        option.text = item.cons_item;
        option.classList.add('custom-option');
        option.setAttribute('data-cons-item', item.cons_item);
        option.setAttribute('label', item.cons_item + ' - ' + item.uraian_item);
        newSelect.add(option);
    });

    var existingInput;
    var existingLabel;

    newSelect.addEventListener('change', function () {
        var selectedValue = this.value;
        var selectedOption = this.options[this.selectedIndex];
        var consItem = selectedOption.getAttribute('data-cons-item');

        if (existingLabel) {
            existingLabel.remove();
        }

        if (existingInput) {
            existingInput.remove();
            existingInput = null;
        }

        if (selectedValue !== '') {
            existingLabel = document.createElement('label');
            existingLabel.for = 'Nilai' + selectedValue;
            existingLabel.textContent = 'Total Realisasi ' + selectedValue;
            existingLabel.id = 'labelFor' + selectedValue;
            outerDiv.appendChild(existingLabel);

            existingInput = document.createElement('input');
            existingInput.type = 'number';
            existingInput.name = 'Nilai  ' + selectedValue;
            existingInput.id = 'inputFor' + consItem;
            existingInput.classList.add('form-control');
            existingInput.placeholder = 'Enter Total Realisasi';
            outerDiv.appendChild(existingInput);
        }
    });

    outerDiv.appendChild(newSelect);
    counter ++;
    return outerDiv;
}

function submitForm(){
    if (isValidated && (nikValidated || npwpValidated) && kodeMakValidated) {
        var jenis_kegiatan_radios = document.getElementsByName('jenis_kegiatan');

        // Mencari radio button yang dipilih
        var selected_radio;
        for (var i = 0; i < jenis_kegiatan_radios.length; i++) {
            if (jenis_kegiatan_radios[i].checked) {
                selected_radio = jenis_kegiatan_radios[i];
                break;
            }
        }

        // Memeriksa jika radio button "Perjalanan Dinas" yang dipilih
        if (selected_radio && selected_radio.id === 'perjalanan_dinas') {
            const allConsItem = [];
            const selects = document.querySelectorAll('select[id^="select_cons_item_"]');
            const inputs = document.querySelectorAll('input[id^="inputFor"]');

            const combinedArray = Array.from(selects).map((select, index) => {
                const selectValue = select.value;
                const inputValue = inputs[index] ? inputs[index].value : null;
    
                return [selectValue, inputValue];
            });

            allConsItem.push(...combinedArray);

            function isArrayValid(arr) {
                return arr !== null && arr.length === 2 && arr.every(item => item !== null && item !== "");
            }

            // Periksa setiap array dalam allConsItem
            const consItemValid = allConsItem.every(isArrayValid);

            if (consItemValid) {
                console.log("Semua array dalam allConsItem valid.");
                var pengirimBerkas = document.getElementById('nama_user').value;
                var bidang = document.getElementById('bidang_user').value;
                var jenisPenyedia = document.getElementById('jenis_penyedia').value;
                var npwp = document.getElementById('npwp').value;
                var nik = document.getElementById('nik').value;
                var provinsi = document.getElementById('provinsi').value;
                var kota = document.getElementById('kota').value;
                var nama1 = document.getElementById('nama_swakelola').value;
                var nama2 = document.getElementById('nama_penyedia').value;
                var kodeMak = document.getElementById('kode_mak').value;
                var jenisKegiatan = selected_radio.value;
                var id = this.id;

                console.log(pengirimBerkas);
                console.log(bidang);
                console.log(jenisPenyedia);
                console.log(npwp);
                console.log(nik);
                console.log(nama1);
                console.log(nama2);
                console.log(provinsi);
                console.log(kota);
                console.log(selected_radio.value);
                console.log(allConsItem);
                console.log(kodeMak);
                console.log(id);

                $.ajax({
                    type: 'POST',
                    url: '/submitFormPengajuan',  // Ganti dengan URL yang sesuai di server Anda
                    data: { 
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        nama_pengirim_berkas: pengirimBerkas,
                        bidang_pengirim_berkas: bidang,
                        jenis_penyedia: jenisPenyedia,
                        nik: nik,
                        nama: nama1,
                        provinsi: provinsi,
                        kota: kota,
                        jenis_kegiatan: jenisKegiatan,
                        kode_mak: kodeMak,
                        realisasi: allConsItem,
                    },
                    success: function(response) {
                        console.log('Data berhasil terkirim:', response);
                        alert('Data Berhasil Ditambahkan');
                    },
                    error: function(xhr) {
                        console.error('Terjadi kesalahan saat mengirim formulir:', xhr.responseText);
                    }
                });


            // Lakukan tindakan atau kirim data jika semuanya valid
            } else {
                console.error("Terdapat array dalam allConsItem yang kosong atau null.");
            // Lakukan tindakan atau tangani kesalahan jika ada array yang tidak valid
            }

        } else if (selected_radio && selected_radio.id === 'pengadaan') {
            var jenisKegiatan = selected_radio.value;
            console.log(jenisKegiatan);
        } else if (selected_radio && selected_radio.id === 'rapat_biasa') {
            var jenisKegiatan = selected_radio.value;
            console.log(jenisKegiatan);
        } else {
            return alert('Data Belum Diisi');
        }

    } else {
        alert('Silakan validasi data terlebih dahulu sebelum mengirimkan form.');
    }
}

function validate(type) {
    if (type === 'npwp') {
        var npwpValue = $('#npwp').val();

        // Pastikan NPWP tidak kosong sebelum melakukan validasi
        if (npwpValue.trim() === '') { 
            return alert('NPWP harus diisi sebelum validasi.');
        }

        // Lakukan validasi NPWP menggunakan AJAX
        $.ajax({
            url: '/validate',
            type: 'POST',
            data: { _token: $('meta[name="csrf-token"]').attr('content'), npwp: npwpValue },
            success: function (response) {
                handleValidationResponse(response);
            },
            error: function (error) {
                console.error('Terjadi kesalahan: ' + error.responseText);
            }
        });
    } else if (type === 'nik') {
        var nikValue = $('#nik').val();

        // Pastikan NPWP tidak kosong sebelum melakukan validasi
        if (nikValue.trim() === '') {
            return alert('NIK harus diisi sebelum validasi.');;
        }

        // Lakukan validasi NIK menggunakan AJAX
        $.ajax({
            url: '/validate',
            type: 'POST',
            data: { _token: $('meta[name="csrf-token"]').attr('content'), nik: nikValue },
            success: function (response) {
                handleValidationResponse(response);
            },
            error: function (error) {
                console.error('Terjadi kesalahan: ' + error.responseText);
            }
        });
    } else if (type === 'kode_mak') {
        var kode_mak_value = $('#kode_mak').val();

        if (kode_mak_value.trim() === '') {
            return alert('Kode MAK Harus Diisi');
        }

        $.ajax({
            url: '/validate',
            type: 'POST',
            data: { _token: $('meta[name="csrf-token"]').attr('content'), kode_mak: kode_mak_value , },
            success: function (response) {
                handleValidationResponse(response);
            },
            error: function (error) {
                console.error('Terjadi kesalahan: ' + error.responseText);
            }
        });

    }
}

let isValidated = false;
let nikValidated = false;
let npwpValidated = false;
let kodeMakValidated = false;
// Fungsi untuk menangani respons validasi
function handleValidationResponse(response) {
    if (response.status === 'success') {
        $('#npwpErrorMessage').hide();
        $('#nikErrorMessage').hide();
        $('#kodeMakErrorMessage').hide();  

        // Tampilkan informasi tambahan berdasarkan jenis identitas
        if (response.data.validate === 'NIK') {
            $('#nama_swakelola').val(response.data.nama);
            $('#infoBidang').show();
            $('#infoJabatan').hide();
            nikValidated = true;
        } else if (response.data.validate === 'NPWP') {
            $('#infoBidang').hide();
            $('#nama_penyedia').val(response.data.nama);
            $('#infoJabatan').show();
            npwpValidated = true;
        } else if (response.data.validate === 'kode_mak'){
            var containerId = 'infoKodeMak';
            var consItemContainer = createConsItemSelector(response.data.cons_item);
            var containerElement = document.getElementById(containerId);
            containerElement.appendChild(consItemContainer);
            $('#infoKodeMak').show();
            kodeMakValidated = true;
        }
        isValidated = true;
    } else if (response.status === 'npwp_not_found') 
    {
        // Tampilkan formulir pendaftaran NPWP di sini
        $('#npwpErrorMessage').html('NPWP not found.');
        $('#npwpErrorMessage').show();
        $('#infoJabatan').hide();
        isValidated = false;

    } else if (response.status === 'nik_not_found') 
    {
        // Tampilkan formulir pendaftaran NPWP di sini
        $('#nikErrorMessage').html('NIK not found.');
        $('#nikErrorMessage').show();
        $('#infoBidang').hide();
        isValidated = false;

    } else if (response.status === 'kode_mak_not_found') 
    {
        // Tampilkan formulir pendaftaran NPWP di sini
        $('#kodeMakErrorMessage').html('kode MAK not found.');
        $('#kodeMakErrorMessage').show();
        $('#infoKodeMak').hide();
        isValidated = false;

    } else 
    {
        // Tampilkan pesan kesalahan
        alert('Terjadi kesalahan: ' + response.message);
    }
}

function submitRegistration(type) { 
    if (type === 'npwp'){
        var npwpValue = document.getElementById('npwp_pendaftar').value;
        var namaValue = document.getElementById('nama_pendaftar_swakelola').value;
        var jabatanValue = document.getElementById('jabatan_pendaftar').value;
        // Kirim permintaan AJAX ke server
        $.ajax({
            type: 'POST',
            url: '/daftar-npwp-swakelola',  // Ganti dengan URL yang sesuai di server Anda
            data: { 
                _token: $('meta[name="csrf-token"]').attr('content'),
                nama: namaValue,
                npwp: npwpValue,
                jabatan: jabatanValue 
            },
            success: function(response) {
                console.log('Formulir NPWP Registration berhasil terkirim:', response);
                // Lakukan tindakan atau manipulasi DOM lainnya setelah formulir terkirim
                $('#formNpwpRegistration').hide();
                $('#formNpwp').show();
                $('#npwp_pendaftar').val('');
                $('#nama_pendaftar_swakelola').val('');
                $('#jabatan_pendaftar').val('');
                alert('Data Berhasil Ditambahkan');
            },
            error: function(xhr) {
                console.error('Terjadi kesalahan saat mengirim formulir:', xhr.responseText);

            if (xhr.status === 422) {
                // Data sudah ada, tampilkan pop-up message
                alert('Data sudah ada');
            } else {
                // Tampilkan pesan kesalahan atau lakukan tindakan lain sesuai kebutuhan
            }
            }
        });
    } else if (type === 'nik') {
        var nikValue = document.getElementById('nik_pendaftar').value;   
        var namaValue = document.getElementById('nama_pendaftar_penyedia').value; 
        var bidangValue = document.getElementById('bidang_pendaftar').value;
        // Kirim permintaan AJAX ke server
        $.ajax({
            type: 'POST',
            url: '/daftar-npwp-swakelola',  // Ganti dengan URL yang sesuai di server Anda
            data: { 
                _token: $('meta[name="csrf-token"]').attr('content'),
                nama: namaValue,
                nik: nikValue,
                bidang: bidangValue 
            },
            success: function(response) {
                console.log('Formulir NIK Registration berhasil terkirim:', response);
                // Lakukan tindakan atau manipulasi DOM lainnya setelah formulir terkirim
                $('#formNikRegistration').hide();
                $('#formNik').show();
                $('#nik_pendaftar').val('');
                $('#nama_pendaftar_penyedia').val('');
                $('#bidang_pendaftar').val('');
                alert('Data Berhasil Ditambahkan');
            },
            error: function(xhr) {
                console.error('Terjadi kesalahan saat mengirim formulir:', xhr.responseText);

            if (xhr.status === 422) {
                // Data sudah ada, tampilkan pop-up message
                alert('Data sudah ada');
            } else {
                // Tampilkan pesan kesalahan atau lakukan tindakan lain sesuai kebutuhan
            }
            }
        });
    }
    
}

//fungsi untuk memilih radio button
document.addEventListener('DOMContentLoaded', function () {
  var radioButtons = document.getElementsByName('jenis_kegiatan');

  radioButtons.forEach(function (radioButton) {
    radioButton.addEventListener('change', function () {
      displayKegiatan(this.id);
    });
  });
});

function displayKegiatan(jenis_kegiatan) {
  hideAllKegiatan(); // Menyembunyikan semua pertanyaan terlebih dahulu

  var kegiatanId = jenis_kegiatan + '_detail';
  document.getElementById(kegiatanId).style.display = 'block';
}

function hideAllKegiatan() {
  var kegiatanIds = ['perjalanan_dinas_detail', 'pengadaan_detail', 'rapat_biasa_detail'];

  kegiatanIds.forEach(function (id) {
    document.getElementById(id).style.display = 'none';
  });
}


//fungsi untuk memilih kota
$('#myModal').on('shown.bs.modal', function () {
    getIdBerkas();
    var provinsiSelect = $('#provinsi');
    // Ketika modal ditampilkan, ambil data provinsi
    fetch('/get-provinsis', {
        method: 'GET',
        header: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
          }
        return response.json();
    })
    .then(result=> {
        $.each(result, function (index, provinsi) {
            provinsiSelect.append('<option value="' + provinsi.id + '">' + provinsi.nama_provinsi + '</option>');
        });
    })

});

$('#provinsi').change(function () {
    var selectedProvinsi = $(this).val();
    // Mengambil data kota dari server menggunakan AJAX
    fetch('/get-kotas', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({provinsi_id: selectedProvinsi})
    })
    .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
    .then(result => {
        var kotaSelect = $('#kota');
        kotaSelect.empty(); // Mengosongkan opsi provinsi sebelum diisi ulang
        kotaSelect.append('<option value="" disabled selected>Pilih Kota</option>');
        $.each(result, function (index, kota) {
            kotaSelect.append('<option value="' + kota.id + '">' + kota.nama_kota + '</option>');
        });
        // Mengaktifkan opsi kota setelah data diisi
        kotaSelect.prop('disabled', false);
    })
});

fetch('/pengajuan/get', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
    },
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(result => {
      if (result.berkasId) {
        let $berkasId = result.berkasId;
        console.log($berkasId); // Output: 'test'
      } else {
        console.log('Tidak ada data berkasId');
      }
    })
    .catch(error => {
      console.error('There was a problem with the fetch operation:', error);
    });
