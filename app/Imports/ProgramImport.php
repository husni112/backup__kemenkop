<?php

namespace App\Imports;

use App\Models\{Akun, Item_pagu, Kegiatan, Komponen, Output, Program, Sub_komponen, Sub_output, Uraian_subkomponen};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;


class ProgramImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    use Importable;
    
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            $item_pagu = Item_pagu::where('cons_item', $row['cons_item'])->first();
            $kode_mak = $row['kode_program'].$row['kode_kegiatan'].$row['kode_output'].$row['kode_suboutput'].$row['kode_komponen'].$row['kode_subkomponen'].$row['kode_akun'];
            
            if(!$item_pagu){
                $item_pagu = new Item_pagu([
                    'cons_item' => $row['cons_item'],
                    'uraian_item' => $row['uraian_item'],
                    'volume' => $row['volkeg'],
                    'harga_satuan' => $row['hargasat'],
                    'total' => $row['total'],
                    'kode_mak' => $kode_mak,
                ]);
            } elseif($item_pagu){
                // Update attributes if the item already exists
                $item_pagu->uraian_item = $row['uraian_item'];
                $item_pagu->volume = $row['volkeg'];
                $item_pagu->harga_satuan = $row['hargasat'];
                $item_pagu->total = $row['total'];
                $item_pagu->kode_mak = $kode_mak;                
                //$item_pagu->kode_pkosks = $kode_pkosks;
            }
            
            $akun = Akun::firstOrCreate(['kode_akun' => $row['kode_akun']]);
            $akun->item_pagus()->save($item_pagu);
            $uraian_subkomponen = Uraian_subkomponen::firstOrCreate(['uraian_subkomponen' => $row['uraian_subkomponen']]);
            $uraian_subkomponen->item_pagus()->save($item_pagu);
            $sub_komponen = Sub_komponen::firstOrCreate(['kode_subkomponen' => $row['kode_subkomponen']]);
            $sub_komponen->item_pagus()->save($item_pagu);
            $komponen = Komponen::firstOrCreate(['kode_komponen' => $row['kode_komponen']]);
            $komponen->item_pagus()->save($item_pagu);
            $sub_output = Sub_output::firstOrCreate(['kode_suboutput' => $row['kode_suboutput']]);
            $sub_output->item_pagus()->save($item_pagu);
            $output = Output::firstOrCreate(['kode_output' => $row['kode_output']]);
            $output->item_pagus()->save($item_pagu);
            $kegiatan = Kegiatan::firstOrCreate(['kode_kegiatan' => $row['kode_kegiatan']]);
            $kegiatan->item_pagus()->save($item_pagu);
            $program = Program::firstOrCreate(['kode_program' => $row['kode_program']]);
            $program->item_pagus()->save($item_pagu);
            
            
            //$nama_subkomponens = Uraian_subkomponen::firstOrCreate(['uraian_subkomponen' => $row['uraian_subkomponen']]);
            //$nama_subkomponens->akuns()->syncWithoutDetaching([$akun->id]);

            /*if(!$item_pagu){
                Item_pagu::create([
                    'cons_item' => $row['cons_item'],
                    'uraian_item' => $row['uraian_item'],
                    'volume' => $row['volkeg'],
                    'harga_satuan' => $row['hargasat'],
                    'total' => $row['total'],
                ]);
                if(!$akun){
                    Akun::create([
                        'kode_akun' => $row['kode_akun'],
                    ]);
                    if($akun['id']){
                        dd($akun);
                    }
                   
                    //Item_pagu::create([
                    //    'akun_id' => $akun['id']

                    //]);
                    if(!$nama_subkomponen){
                        Sub_komponen::create([
                            'kode_program' => $row['kode_program'],
                            'kode_kegiatan' => $row['kode_kegiatan'],
                            'kode_output' => $row['kode_output'],
                            'kode_suboutput' => $row['kode_suboutput'],
                            'kode_komponen' => $row['kode_komponen'],
                            'kode_subkomponen' => $row['kode_subkomponen'],
                            'nama_subkomponen' => $row['uraian_subkomponen'],
                        ]);    
                    }           
                } /*elseif($akun){
                    if(!$nama_subkomponen){
                        Sub_komponen::create([
                            'kode_program' => $row['kode_program'],
                            'kode_kegiatan' => $row['kode_kegiatan'],
                            'kode_output' => $row['kode_output'],
                            'kode_suboutput' => $row['kode_suboutput'],
                            'kode_komponen' => $row['kode_komponen'],
                            'kode_subkomponen' => $row['kode_subkomponen'],
                            'nama_subkomponen' => $row['uraian_subkomponen'],
                        ]);
                    }
                }
            } else {
                return null;
            };*/

            
            /*if($item_pagu){
                $test = Item_pagu::find($item_pagu['id']);
                $test->update([
                    'akun_id' => $akun['id'],
                ]);
            }*/



            /*if(!$item_pagu && !$nama_subkomponen && !$akun){
                Item_pagu::create([
                    'cons_item' => $row['cons_item'],
                    'uraian_item' => $row['uraian_item'],
                    'volume' => $row['volkeg'],
                    'harga_satuan' => $row['hargasat'],
                    'total' => $row['total'],
                ]);
                Sub_komponen::create([
                    'kode_program' => $row['kode_program'],
                    'kode_kegiatan' => $row['kode_kegiatan'],
                    'kode_output' => $row['kode_output'],
                    'kode_suboutput' => $row['kode_suboutput'],
                    'kode_komponen' => $row['kode_komponen'],
                    'kode_subkomponen' => $row['kode_subkomponen'],
                    'nama_subkomponen' => $row['uraian_subkomponen'],
                ]);
                Akun::create([
                    'kode_akun' => $row['kode_akun'],
                ]);
            } elseif(!$item_pagu && !$akun){
                Item_pagu::create([
                    'cons_item' => $row['cons_item'],
                    'uraian_item' => $row['uraian_item'],
                    'volume' => $row['volkeg'],
                    'harga_satuan' => $row['hargasat'],
                    'total' => $row['total'],
                ]);
                Sub_komponen::create([
                    'kode_program' => $row['kode_program'],
                    'kode_kegiatan' => $row['kode_kegiatan'],
                    'kode_output' => $row['kode_output'],
                    'kode_suboutput' => $row['kode_suboutput'],
                    'kode_komponen' => $row['kode_komponen'],
                    'kode_subkomponen' => $row['kode_subkomponen'],
                    'nama_subkomponen' => $row['uraian_subkomponen'],
                ]);
            }elseif(!$item_pagu && !$nama_subkomponen){
                Item_pagu::create([
                    'cons_item' => $row['cons_item'],
                    'uraian_item' => $row['uraian_item'],
                    'volume' => $row['volkeg'],
                    'harga_satuan' => $row['hargasat'],
                    'total' => $row['total'],
                ]);
                Sub_komponen::create([
                    'kode_program' => $row['kode_program'],
                    'kode_kegiatan' => $row['kode_kegiatan'],
                    'kode_output' => $row['kode_output'],
                    'kode_suboutput' => $row['kode_suboutput'],
                    'kode_komponen' => $row['kode_komponen'],
                    'kode_subkomponen' => $row['kode_subkomponen'],
                    'nama_subkomponen' => $row['uraian_subkomponen'],
                ]);
            } elseif(!$nama_subkomponen && !$akun){
                Sub_komponen::create([
                    'kode_program' => $row['kode_program'],
                    'kode_kegiatan' => $row['kode_kegiatan'],
                    'kode_output' => $row['kode_output'],
                    'kode_suboutput' => $row['kode_suboutput'],
                    'kode_komponen' => $row['kode_komponen'],
                    'kode_subkomponen' => $row['kode_subkomponen'],
                    'nama_subkomponen' => $row['uraian_subkomponen'],
                ]);
                Akun::create([
                    'kode_akun' => $row['kode_akun'],
                    ]);
            } elseif(!$nama_subkomponen){
                Sub_komponen::create([
                    'kode_program' => $row['kode_program'],
                    'kode_kegiatan' => $row['kode_kegiatan'],
                    'kode_output' => $row['kode_output'],
                    'kode_suboutput' => $row['kode_suboutput'],
                    'kode_komponen' => $row['kode_komponen'],
                    'kode_subkomponen' => $row['kode_subkomponen'],
                    'nama_subkomponen' => $row['uraian_subkomponen'],
                ]);      
            } elseif(!$akun){
                Akun::create([
                    'kode_akun' => $row['kode_akun'],
                ]);
            } elseif(!$item_pagu){
                Item_pagu::create([
                    'cons_item' => $row['cons_item'],
                    'uraian_item' => $row['uraian_item'],
                    'volume' => $row['volkeg'],
                    'harga_satuan' => $row['hargasat'],
                    'total' => $row['total'],
            ]);
            } */
 
        }
    }
}

            /* Untuk many to many
            $akun = Akun::where('kode_akun', $row['kode_akun'])->first();
            $sub_komponen = Sub_komponen::where('kode_subkomponen', $row['kode_subkomponen'])->first();
                $test = Akun::find($sub_komponen['id']);
                $test->sub_komponens()->sync($akun['id']);
            */


            //if ($akun) {
            //    $test->akuns()->attach($akun['id']);
            //} else {
            //    // Handle the case where $akun is not found
            //}

            /*$nama_subkomponen = Sub_komponen::where('nama_subkomponen', $row['uraian_subkomponen'])->first();
            if(!$nama_subkomponen){
                Sub_komponen::create([
                    'kode_program' => $row['kode_program'],
                    'kode_kegiatan' => $row['kode_kegiatan'],
                    'kode_output' => $row['kode_output'],
                    'kode_suboutput' => $row['kode_suboutput'],
                    'kode_komponen' => $row['kode_komponen'],
                    'kode_subkomponen' => $row['kode_subkomponen'],
                    'nama_subkomponen' => $row['uraian_subkomponen'],
                ]);
            }*/
            /*$program = Program::where('kode_program', $row['kode_program'])->first();
            $kegiatan = Kegiatan::where('kode_kegiatan', $row['kode_kegiatan'])->first();
            $output = Output::where('kode_output', $row['kode_output'])->first();
            $sub_output = Sub_output::where('kode_suboutput', $row['kode_suboutput'])->first();
            $komponen = Komponen::where('kode_komponen', $row['kode_komponen'])->first();
            $sub_komponen = Sub_komponen::where('kode_subkomponen', $row['kode_subkomponen'])->first();
            $akun = Akun::where('kode_akun', $row['kode_akun'])->first();
            $item_pagu = Item_pagu::where('cons_item', $row['cons_item'])->first();

            if(!$item_pagu){
                Item_pagu::create([
                    'cons_item' => $row['cons_item'],
                    'uraian_item' => $row['uraian_item'],
                    'volume' => $row['volkeg'],
                    'harga_satuan' => $row['hargasat'],
                    'total' => $row['total'],
                ]);

                if(!$akun){
                    Akun::create([
                        'kode_akun' => $row['kode_akun'],
                    ]);
                } elseif(!$sub_komponen){
                    Sub_komponen::create([
                        'kode_subkomponen' => $row['kode_subkomponen'],
                        'nama_subkomponen' => $row['uraian_subkomponen'],
                    ]);
    
                } elseif(!$komponen){
                    Komponen::create([
                        'kode_komponen' => $row['kode_komponen'],
                    ]);
    
                } elseif(!$sub_output){
                    Sub_output::create([
                        'kode_suboutput' => $row['kode_suboutput'],
                    ]);
    
                } elseif(!$output) {
                    Output::create([
                        'kode_output' => $row['kode_output']
                    ]);
                } elseif(!$kegiatan)  {
                    Kegiatan::create([
                        'program_id' => $program['id'],
                        'kode_kegiatan' => $row['kode_kegiatan'],        
                    ]);
                    
                } if (!$program){
                    Program::create([
                        'kode_program' => $row['kode_program'],
                    ]);
                }
            }

            
                /*if (!$program){
                    Program::create([
                        'kode_program' => $row['kode_program'],
                    ]);
                } elseif(!$kegiatan)  {
                    Kegiatan::create([
                        'program_id' => $program['id'],
                        'kode_kegiatan' => $row['kode_kegiatan'],        
                    ]);
                    
                } elseif(!$output) {
                    Output::create([
                        'kode_output' => $row['kode_output']
                    ]);
                } elseif(!$komponen){
                    Komponen::create([
                        'kode_komponen' => $row['kode_komponen'],
                    ]);
    
                } elseif(!$komponen){
                    Komponen::create([
                        'kode_komponen' => $row['kode_komponen'],
                    ]);
    
                } elseif(!$sub_komponen){
                    Sub_komponen::create([
                        'kode_subkomponen' => $row['kode_subkomponen'],
                        'nama_subkomponen' => $row['uraian_subkomponen'],
                    ]);
    
                } elseif(!$akun){
                    Akun::create([
                        'kode_akun' => $row['kode_akun'],
                    ]);
                }*/

        
        /*foreach($rows as $row){
            $akun = Akun::where('kode_akun', $row['kode_akun'])->first();
            $item_pagu = Item_pagu::where('cons_item', $row['cons_item'])->first();
            if($item_pagu!=null){
                $test = Item_pagu::find($item_pagu['id']);
                $test->update([
                    'akun_id' => $akun['id'],
                ]);
            }

            $akun = Akun::where('kode_akun', $row['kode_akun'])->first();
            $sub_komponen = Sub_komponen::where('kode_subkomponen', $row['kode_subkomponen'])->first();
                $test = Akun::find($sub_komponen['id']);
                $test->sub_komponens()->sync($akun['id']);
        }*/



        /*    if(!$akun){
                Akun::create([
                    'kode_akun' => $row['kode_akun'],
                ]);
                Item_pagu::create([
                    'akun_id' => $akun['id'],
                ]);
            }


            if (!$program){
                Program::create([
                    'kode_program' => $row['kode_program'],
                ]);
            } elseif(!$kegiatan)  {
                Kegiatan::create([
                    'program_id' => $program['id'],
                    'kode_kegiatan' => $row['kode_kegiatan'],        
                ]);
                
            } elseif(!$output) {
                Output::create([
                    'kode_output' => $row['kode_output']
                ]);
            } elseif(!$sub_output){
                Sub_output::create([
                    'kode_suboutput' => $row['kode_suboutput'],
                ]);

            } elseif(!$komponen){
                Komponen::create([
                    'kode_komponen' => $row['kode_komponen'],
                ]);

            } elseif(!$sub_komponen){
                Sub_komponen::create([
                    'kode_subkomponen' => $row['kode_subkomponen'],
                    'nama_subkomponen' => $row['uraian_subkomponen'],
                ]);

            } elseif(!$akun){
                Akun::create([
                    'kode_akun' => $row['kode_akun'],
                ]);
                Item_pagu::create([
                    'akun_id' => $akun['id'],
                ]);
            }*/



//function ($row){
    //$kegiatan = Kegiatan::find($row);
    //$kegiatan->kegiatan_output()->sync(1);
    //};
            //if($program){
            //    Kegiatan::create([
            //        'program_id' => $program['id'],
            //        'kode_kegiatan' => $row['kode_kegiatan']
            //    ]);
            //}
            



            //$existingRecord = Kegiatan::where('kode_kegiatan', $row['kode_kegiatan'])->first();
           // if ($existingRecord) {
                // Data sudah ada, tidak perlu mengisi lagi
            //  return null;
           // } else {
                // Data belum ada, buat record baru
              //  Kegiatan::create([
              //  'kode_kegiatan' => $row['kode_kegiatan'],
           // ]);
            // Model yang dikembalikan akan diabaikan oleh Excel::import
           // return null;