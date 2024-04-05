<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berkas;
use App\Models\Item_pagu;
use App\Models\Bidang;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Perjalanan_dinas;
use App\Models\Total;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function showForm()
    {
        $userId = Auth::user()->id;
        $berkas = Berkas::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
                        
        return view('buat-berkas', compact('berkas'));
    }

    public function storeData(Request $request)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'kode_berkas' => 'required|string|max:255',
            // Sesuaikan dengan kebutuhan validasi Anda
        ]);

        // Simpan data ke dalam tabel berkas
        $kodeBerkas = $request->input('kode_berkas');
        $userId = Auth::user()->id;
        $berkas = Berkas::create([
            'kode_berkas' => $kodeBerkas,
            'user_id' => $userId,
            // Tambahkan kolom-kolom lain yang perlu disimpan
        ]);
        $berkasId = $berkas->id;

        // Respon jika diperlukan
        return response()->json(['message' => 'Data berhasil disimpan', 'berkasId' => $berkasId]);
    }

    public function removeData($id)
    {
        try {
            // Hapus berkas berdasarkan ID
            $berkas = Berkas::findOrFail($id);
            $berkas->delete();

            return response()->json(['message' => 'Berkas berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function buatPengajuan($id, Request $request)
    {
        if($request->isJson()){
            $berkas = Berkas::findOrFail($id);
            $berkasId = $berkas->id;
            return response()->json(['berkasId' => $berkasId]);
        }

        return view('buat-pengajuan');
    }

    public function getIdBerkas()
    {
        $berkasId = "test";

        return response()->json(['berkasId' => $berkasId]);
    }

    public function getProvinsis()
    {
        $provinsis = Provinsi::all();
                        
        return response()->json($provinsis);
    }

    public function getKotas(Request $request)
    {
        $provinsiId = $request->input('provinsi_id');
        $kotas = Kota::where('provinsi_id', $provinsiId)->get();
        return response()->json($kotas);
    }

    public function validateData(Request $request)
    {
        // Validasi NIK di sini, misalnya cek ke tabel users
        $nik = $request->input('nik');
        $npwp = $request->input('npwp');
        $kode_mak = $request->input('kode_mak');

        // Lakukan validasi ke database (tabel users)
        if ($nik){
            $user = User::where('nik', $nik)->first();

            if ($user) {
                $bidang = $user->bidang;
                $data = [
                    'validate' => 'NIK', 
                    'nama' => $user->nama, 
                    'nama_bidang' => $bidang->nama_bidang
                ];

                return response()->json(['status' => 'success', 'data' => $data]);

            } else {

                return response()->json(['status' => 'nik_not_found']);
            }

        } elseif ($npwp && !$nik){
            $user = User::where('npwp', $npwp)->first();

            if ($user) {
                $data = [
                    'validate' => 'NPWP', 
                    'nama' => $user->nama, 
                    'jabatan' => $user->jabatan
                ];

                return response()->json(['status' => 'success', 'data' => $data]);

            } else {

                return response()->json(['status' => 'npwp_not_found']);
            }
        } elseif ($kode_mak) {
            // Ambil semua data dengan kode_mak yang sesuai
            $item_pagu = Item_pagu::where('kode_mak', $kode_mak)->get();

            if ($item_pagu->isNotEmpty()) {
                // Format data untuk response JSON
                $cons_item = $item_pagu->map(function ($item) {
                    return [
                        'cons_item' => $item->cons_item, 
                        'uraian_item' => $item->uraian_item,
                        'nilai_pagu' => $item->total,
                    ];
                });

                $data = [
                    'validate' => 'kode_mak',
                    'cons_item' => $cons_item,
                ];

                return response()->json(['status' => 'success', 'data' => $data]);

            } else {
                return response()->json(['status' => 'kode_mak_not_found']);
            }
        }
    }

    public function formNpwpRegistration(Request $request)
    {
        // Validasi request jika diperlukan
        $rules = [
            'nama' => 'required',
        ];
        
        if ($request->has('nik')) {
            // Validation rules for 'nik'
            $rules['nik'] = 'required|unique:users';
            $rules['bidang'] = 'required';
        } elseif ($request->has('npwp')) {
            // Validation rules for 'npwp'
            $rules['npwp'] = 'required|unique:users';
            $rules['jabatan'] = 'required';
        }

        $request->validate($rules);

        // Check if 'npwp' or 'nik' already exists
        $existingUser = null;

        if ($request->has('npwp')) {
            $existingUser = User::where('npwp', $request->input('npwp'))->first();
        } elseif ($request->has('nik')) {
            $existingUser = User::where('nik', $request->input('nik'))->first();
        }

        if ($existingUser) {
            // 'npwp' already exists, return an error response
            return response()->json(['message' => 'Data sudah ada'], 422);
        } else {
            $nama = $request->input('nama');

            if ($request->has('npwp')) {
                // NPWP registration
                $npwp = $request->input('npwp');
                $jabatan = $request->input('jabatan');
    
                User::create([
                    'nama' => $nama,
                    'npwp' => $npwp,
                    'jabatan' => $jabatan,
                    // Tambahkan kolom-kolom lain yang perlu disimpan
                ]);
            } elseif ($request->has('nik')) {
                // NIK registration
                $nik = $request->input('nik');
                $bidangId = $request->input('bidang');

                $user = User::create([
                    'nama' => $nama,
                    'nik' => $nik,
                ]);

                $bidang = Bidang::firstOrCreate(['kode_bidang' => $bidangId]);
                $bidang->user()->save($user);
                
            }
            
            return response()->json(['message' => 'Data berhasil disimpan']);
        }
        }

        public function submitFormPengajuan(Request $request){

            $rules = [
                'nama_pengirim_berkas' => 'required|string|max:255',
                'bidang_pengirim_berkas' => 'required',
                'jenis_penyedia' => 'required',
                'nama' => 'required',
                'provinsi'=> 'required',
                'kota'=> 'required',
                'jenis_kegiatan' => 'required',
                'kode_mak' => 'required',
                'realisasi' => 'required|array',
            ];

            if ($request->has('jenis_penyedia') && $request->jenis_penyedia === 'penyedia') {
                $rules['nik'] = 'required';
            } elseif ($request->has('npwp') && $request->jenis_penyedia === 'swakelola') {
                $rules['npwp'] = 'required';
            }
    
            $request->validate($rules);

            // Simpan data ke dalam tabel berkas
            $nama_pengirim_berkas = $request->input('nama_pengirim_berkas');
            $bidang_pengirim_berkas = $request->input('bidang_pengirim_berkas');
            $jenis_penyedia = $request->input('jenis_penyedia');
            $npwp = $request->input('npwp');
            $nik = $request->input('nik');
            $nama = $request->input('nama');
            $provinsi = $request->input('provinsi');
            $kota = $request->input('kota');
            $jenis_kegiatan = $request->input('jenis_kegiatan');
            $kode_mak = $request->input('kode_mak');
            $realisasi = $request->input('realisasi');
            $perjalanan_dinas = Perjalanan_dinas::create([
                 'nama_pengirim_berkas' => $nama_pengirim_berkas,
                 'bidang_pengirim_berkas' => $bidang_pengirim_berkas,
                 'jenis_penyedia' => $jenis_penyedia,
                 'npwp' => $npwp,
                 'nik' => $nik,
                 'nama' => $nama,
                 'provinsi' => $provinsi,
                 'kota' => $kota,
                 'jenis_kegiatan' => $jenis_kegiatan,
                 'kode_mak' => $kode_mak,
            ]);
            $perjalanan_dinas_id = $perjalanan_dinas->id;

            foreach ($realisasi as $value) {
                Total::create([
                    'perjalanan_dinas_id' => $perjalanan_dinas_id,
                    'rincian_item' => $value[0],
                    'total' => $value[1],
                ]);
            }

            
            
            
            return response()->json(['message' => 'Data berhasil disimpan']);
        }
}
