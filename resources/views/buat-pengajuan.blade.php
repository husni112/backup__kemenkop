@extends('layouts.user_type.auth')

@section('content')
<style>
    .step-form {
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      width: 400px;
    }

    .step {
      display: none;
    }

    .step.active {
      display: block;
    }

    .step-header {
      background-color: #007bff;
      color: #ffffff;
      padding: 10px;
      text-align: center;
    }

    .step-content {
      padding: 20px;
    }
</style>
<div class="container mt-5">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Buka Modal</button>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">    
            <form id="jenisPelayananForm">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pengajuan Realisasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <!-- Formulir pilihan penyedia atau swakelola -->
                    <div class="mb-3">
                        <label for="nama_user" class="form-label">Nama Pengirim Berkas</label>
                        <input type="text" class="form-control" id="nama_user" name="nama_user" value="{{$user->nama}}" readonly>
                        <label for="bidang_user" class="form-label">Bidang</label>
                        <input type="text" class="form-control" id="bidang_user" name="bidang_user" value="{{$user->bidang->kode_bidang}}" readonly>
                        <label for="jenis_pelayanan" class="form-label">Pilih Jenis Pelayanan</label>
                        <select class="form-select" id="jenis_penyedia" name="jenis_pelayanan" required>
                            <option value="">Pilih Jenis Penyedia</option>
                            <option value="penyedia">Penyedia</option>
                            <option value="swakelola">Swakelola</option>
                        </select>
                    </div>

                    <!-- Formulir input NPWP -->
                    <div class="mb-3" id="formNpwp" style="display:none;">
                        <label for="npwp" class="form-label">NPWP</label>
                        <input type="text" class="form-control" id="npwp" name="npwp">

                        <!-- Display error message container -->
                        <div id="npwpErrorMessage" class="alert alert-danger" style="display:none;">
                            NPWP not found. Please <a href="#" id="registerNpwpLink">register</a>.
                        </div>

                        <div id="infoJabatan" style="display:none;">
                            <label for="nama_penyedia" class="form-label col-sm-3">Nama Penyedia</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama_penyedia" readonly>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mt-2" onclick="registration('npwp')">Buat NPWP</button>
                        <button type="button" class="btn btn-secondary mt-2" onclick="validate('npwp')">Validate</button>
                    </div>

                    <!-- Formulir input NIK -->
                    <div class="mb-3" id="formNik" style="display:none;">
                        <label for="nik" class="form-label">NIK Pelaksana Dinas</label>
                        <input type="text" class="form-control" id="nik" name="nik">

                        <!-- Display error message container -->
                        <div id="nikErrorMessage" class="alert alert-danger" style="display:none;">
                            NPWP not found. Please <a href="#" id="registerNikLink">register</a>.
                        </div>

                        <div id="infoBidang" style="display:none;">
                            <label for="nama_swakelola" class="form-label col-sm-3">Penerima Uang</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama_swakelola" readonly>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mt-2" onclick="registration('nik')">Buat NIK</button>
                        <button type="button" class="btn btn-secondary mt-2" onclick="validate('nik')">Validate</button>
                    </div>

                    <div class="mb-3" id="formNpwpRegistration" style="display:none;">
                        <label for="npwp_pendaftar" class="form-label">NPWP</label>
                        <input type="text" class="form-control" id="npwp_pendaftar" name="npwp_pendaftar">
                        <label for="nama_pendaftar_swakelola" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_pendaftar_swakelola" name="nama_pendaftar_swakelola">
                        <label for="jabatan_pendaftar" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan_pendaftar" name="jabatan_pendaftar">
                        
                        <button type="button" class="btn btn-secondary mt-2" onclick="backToValidationForm('npwp')">Back</button>
                        <button type="button" class="btn btn-secondary mt-2" onclick="submitRegistration('npwp')">Simpan</button>
                    </div>

                    <div class="mb-3" id="formNikRegistration" style="display:none;">
                        <label for="nik_pendaftar" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik_pendaftar" name="nik_pendaftar">
                        <label for="nama_pendaftar_penyedia" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_pendaftar_penyedia" name="nama_pendaftar_penyedia">
                        <label for="bidang_pendaftar" class="form-label">Bidang</label>
                        <input type="text" class="form-control" id="bidang_pendaftar" name="bidang_pendaftar">
                        
                        <button type="button" class="btn btn-secondary mt-2" onclick="backToValidationForm('nik')">Back</button>
                        <button type="button" class="btn btn-secondary mt-2" onclick="submitRegistration('nik')">Simpan</button>
                    </div>
                    <div class="mb-3">
                        <label for="provinsi">Provinsi:</label>
                        <select class="form-select" name="provinsi" id="provinsi">
                            <option value="" disabled selected>Pilih Provinsi</option>
                        </select>

                        <label for="kota">Kota:</label>
                        <select class="form-select" name="kota" id="kota" disabled>
                            <option value="" disabled selected>Pilih Kota</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-check" action="javascript:void(0)">
                            <label class="form-check-label" for="perjalanan_dinas">Perjalanan Dinas</label>
                            <input class="form-check-input" type="radio" name="jenis_kegiatan" id="perjalanan_dinas" value="Perjalanan Dinas">
                        </div>
                
                        <div class="form-check">
                            <label class="form-check-label" for="pengadaan">Pengadaan</label>
                            <input class="form-check-input" type="radio" name="jenis_kegiatan" id="pengadaan" value="Pengadaan">
                        </div>
                
                        <div class="form-check">
                            <label class="form-check-label" for="rapat_biasa">Rapat Biasa</label>
                            <input class="form-check-input" type="radio" name="jenis_kegiatan" id="rapat_biasa" value="Rapat Biasa">
                        </div>
                    </div>
                    <div class="mb-3" id="perjalanan_dinas_detail" style="display:none;">
                        <!-- <label for="awal_pelaksanaan" class="form-label">Awal Pelaksanaan</label>
                        <input type="date" class="form-control" id="awal_pelaksanaan" name="awal_pelaksanaan">
                        <label for="akhir_pelaksanaan" class="form-label">Akhir Pelaksanaan</label>
                        <input type="date" class="form-control" id="akhir_pelaksanaan" name="akhir_pelaksanaan">
                        <label for="no_spt" class="form-label">No SPT</label>
                        <input type="text" class="form-control" id="no_spt" name="no_spt">
                        <label for="tgl_spt" class="form-label">Tanggal SPT</label>
                        <input type="date" class="form-control" id="tgl_spt" name="tgl_spt">
                        <label for="no_spd" class="form-label">No SPD</label>
                        <input type="text" class="form-control" id="no_spd" name="no_spd">
                        <label for="tgl_spd" class="form-label">Tanggal SPD</label>
                        <input type="date" class="form-control" id="tgl_spd" name="tgl_spd">
                        <label for="no_kkp" class="form-label">Nomor Kartu Kredit Pemerintah</label>
                        <input type="text" class="form-control" id="no_kkp" name="no_kkp">
                        <label for="nama_hotel" class="form-label">Nama Hotel</label>
                        <input type="text" class="form-control" id="nama_hotel" name="nama_hotel">
                        <label for="no_kamar" class="form-label">Nomor Kamar</label>
                        <input type="text" class="form-control" id="no_kamar" name="no_kamar">
                        <label for="tgl_kwintansi_pembayaran" class="form-label">Tanggal Kwintansi Pembayaran</label>
                        <input type="date" class="form-control" id="tgl_kwintansi_pembayaran" name="tgl_kwintansi_pembayaran">
                        <label for="no_invoice_hotel" class="form-label">No Invoice</label>
                        <input type="text" class="form-control" id="no_invoice_hotel" name="no_invoice_hotel">
                        <label for="tgl_invoice_hotel" class="form-label">Tanggal Invoice</label>
                        <input type="date" class="form-control" id="tgl_invoice_hotel" name="tgl_invoice_hotel"> -->
                    </div>
                    <div class="mb3" id="rapat_biasa_detail" style="display:none;">
                        <div>
                            <label for="no_spt_asdep" class="form-label">No. SPT Asdep / Sesdep</label>
                            <input type="text" class="form-control" id="no_spt_asdep" name="no_spt_asdep">
                            <label for="tgl_spt_asdep" class="form-label">Tanggal SPT Asdep / Sesdep</label>
                            <input type="date" class="form-control" id="tgl_spt_asdep" name="tgl_spt_asdep">
                            <label for="kkp" class="form-label">KKP</label>
                            <input type="text" class="form-control" id="kkp" name="kkp">
                            <label for="no_kuintansi_rapat" class="form-label">No. Kuintansi</label>
                            <input type="text" class="form-control" id="no_kuintansi_rapat" name="no_kuintansi_rapat">
                            <label for="tgl_kuintansi_rapat" class="form-label">Tanggal Kuintansi</label>
                            <input type="date" class="form-control" id="tgl_kuintansi_rapat" name="tgl_kuintansi_rapat">
                            <label for="no_spk" class="form-label">No. SPK</label>
                            <input type="text" class="form-control" id="no_spk" name="no_spk">
                            <label for="tgl_spk" class="form-label">Tanggal SPK</label>
                            <input type="date" class="form-control" id="tgl_spk" name="tgl_spk">
                            <label for="jumlah_peserta_rapat" class="form-label">Jumlah Peserta</label>
                            <input type="number" class="form-control" id="jumlah_peserta_rapat" name="jumlah_peserta_rapat">
                            <label for="no_efaktur_pajak_rapat" class="form-label">No. Efaktur Pajak</label>
                            <input type="text" class="form-control" id="no_efaktur_pajak_rapat" name="no_efaktur_pajak_rapat">
                            <label for="tgl_efaktur_pajak_rapat" class="form-label">Tanggal Efaktur Pajak</label>
                            <input type="date" class="form-control" id="tgl_efaktur_pajak_rapat" name="tgl_efaktur_pajak_rapat">
                        </div> 
                        <div>
                            <label for="total_realisasi_rapat" class="form-label">Jumlah</label>
                            <input type="text" class="form-control" id="total_realisasi_rapat" name="total_realisasi_rapat">
                            <label for="ppn_rapat" class="form-label">PPN</label>
                            <input type="text" class="form-control" id="ppn_rapat" name="ppn_rapat">
                            <label for="ppn_22_rapat" class="form-label">PPh 22</label>
                            <input type="text" class="form-control" id="ppn_22_rapat" name="ppn_22_rapat">
                            <label for="pph_21_pns_rapat" class="form-label">PPh 21 PNS</label>
                            <input type="text" class="form-control" id="pph_21_pns_rapat" name="pph_21_pns_rapat">
                            <label for="pph_21_non_pns_rapat" class="form-label">PPh 21 Non PNS</label>
                            <input type="text" class="form-control" id="pph_21_non_pns_rapat" name="pph_21_non_pns_rapat">
                            <label for="pph_pasal_23_rapat" class="form-label">PPh Pasal 23</label>
                            <input type="text" class="form-control" id="pph_pasal_23_rapat" name="pph_pasal_23_rapat">
                          </div>
                    </div>          
                    <div class="mb3" id="pengadaan_detail" style="display:none;">
                        <div >
                            <label for="no_sppbj" class="form-label">No. SPPBJ</label>
                            <input type="text" class="form-control" id="no_sppbj" name="no_sppbj">
                            <label for="tgl_sppbj" class="form-label">Tanggal SPPBJ</label>
                            <input type="text" class="form-control" id="tgl_sppbj" name="tgl_sppbj">
                            <label for="no_spk_perjanjian" class="form-label">No. SPK / Perjanjian</label>
                            <input type="text" class="form-control" id="no_spk_perjanjian" name="no_spk_perjanjian">
                            <label for="tgl_spk_perjanjian" class="form-label">Tanggal SPK / Perjanjian</label>
                            <input type="date" class="form-control" id="tgl_spk_perjanjian" name="tgl_spk_perjanjian">
                            <label for="no_spmk" class="form-label">Nomor SPMK</label>
                            <input type="text" class="form-control" id="no_spmk" name="no_spmk">
                            <label for="tgl_spmk" class="form-label">Tanggal SPMK</label>
                            <input type="date" class="form-control" id="tgl_spmk" name="tgl_spmk">
                            <label for="no_kuintansi_pengadaan" class="form-label">Nomor Kuintansi</label>
                            <input type="text" class="form-control" id="no_kuintansi_pengadaan" name="no_kuintansi_pengadaan">
                            <label for="tgl_kuintansi_pengadaan" class="form-label">Tanggal Kuintansi</label>
                            <input type="date" class="form-control" id="tgl_kuintansi_pengadaan" name="tgl_kuintansi_pengadaan">
                            <label for="bast_penyedia" class="form-label">BAST Penyedia > PPK</label>
                            <input type="text" class="form-control" id="bast_penyedia" name="bast_penyedia">
                            <label for="tgl_bast" class="form-label">Tanggal BAST</label>
                            <input type="date" class="form-control" id="tgl_bast" name="tgl_bast">
                            <label for="jumlah_peserta_pengadaan" class="form-label">Jumlah Peserta</label>
                            <input type="number" class="form-control" id="jumlah_peserta_pengadaan" name="jumlah_peserta_pengadaan">
                            <label for="no_efaktur_pajak_pengadaan" class="form-label">No. Efaktur Pajak</label>
                            <input type="text" class="form-control" id="no_efaktur_pajak_pengadaan" name="no_efaktur_pajak_pengadaan">
                            <label for="tgl_efaktur_pajak_pengadaan" class="form-label">Tanggal Efaktur Pajak</label>
                            <input type="date" class="form-control" id="tgl_efaktur_pajak_pengadaan" name="tgl_efaktur_pajak_pengadaan">
                        </div>
                        <div>
                            <label for="total_realisasi_pengadaan" class="form-label">Jumlah</label>
                            <input type="text" class="form-control" id="total_realisasi_pengadaan" name="total_realisasi_pengadaan">
                            <label for="ppn_pengadaan" class="form-label">PPN</label>
                            <input type="text" class="form-control" id="ppn_pengadaan" name="ppn_pengadaan">
                            <label for="ppn_22_pengadaan" class="form-label">PPh 22</label>
                            <input type="text" class="form-control" id="ppn_22_pengadaan" name="ppn_22_pengadaan">
                            <label for="pph_21_pns_pengadaan" class="form-label">PPh 21 PNS</label>
                            <input type="text" class="form-control" id="pph_21_pns_pengadaan" name="pph_21_pns_pengadaan">
                            <label for="pph_21_non_pns_pengadaan" class="form-label">PPh 21 Non PNS</label>
                            <input type="text" class="form-control" id="pph_21_non_pns_pengadaan" name="pph_21_non_pns_pengadaan">
                            <label for="pph_pasal_23_pengadaan" class="form-label">PPh Pasal 23</label>
                            <input type="text" class="form-control" id="pph_pasal_23_pengadaan" name="pph_pasal_23_pengadaan">
                          </div>
                    </div>
                    <div>
                        <label for="kode_mak" class="form-label">Kode MAK</label>
                        <input type="text" class="form-control" id="kode_mak" name="kode_mak" >
                
                        <!-- Display error message container -->
                        <div id="kodeMakErrorMessage" class="alert alert-danger" style="display:none;">
                        Kode MAK not found.
                        </div>
                
                        <div id="infoKodeMak" style="display:none;">
                        </div>
                
                        <button type="button" class="btn btn-secondary mt-2" onclick="backToValidationForm('kode_mak')">Back</button>
                        <button type="button" class="btn btn-secondary mt-2" onclick="validate('kode_mak')">Validate</button>
                    </div>
                    <!-- Tambahkan elemen formulir lainnya sesuai kebutuhan -->
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/script.js') }}">
//     let currentStep = 1;

//     function nextStep(step) {
//         document.querySelector(`.step-${currentStep}`).classList.remove('active');
//         currentStep = step;
//         document.querySelector(`.step-${currentStep}`).classList.add('active');
//     }

//     function prevStep() {
//         if (currentStep > 1) {
//             document.querySelector(`.step-${currentStep}`).classList.remove('active');
//             currentStep--;
//             document.querySelector(`.step-${currentStep}`).classList.add('active');
//         }
// }

    // Fungsi untuk menangani perubahan pilihan jenis pelayanan
    
</script>

@endsection