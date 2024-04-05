
        <div class="table-responsive" >
            <table class="table align-items-center ">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Program</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kegiatan</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Output</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sub Output</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Komponen</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sub Komponen</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Uraian Sub Komponen</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Akun</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cons Item</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">uraian_item</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Volume</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga Satuan</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>   
                </tr>
              </thead>
              <tbody>
              @foreach ($item_pagu as $key => $item)
                <tr>
                  <td><span class="text-xs font-weight-bold">{{$loop->iteration + ($item_pagu->currentPage() - 1) * $perPage }}.</span></td>
                  <td><span class="text-xs font-weight-bold">{{$item->programs['kode_program']}}</span></td>
                  <td><span class="text-xs font-weight-bold">{{$item->kegiatans['kode_kegiatan']}}</span></td>
                  <td><span class="text-xs font-weight-bold">{{$item->outputs['kode_output']}}</span></td>
                  <td><span class="text-xs font-weight-bold">{{$item->sub_outputs['kode_suboutput']}}</span></td>
                  <td><span class="text-xs font-weight-bold">{{$item->komponens['kode_komponen']}}</span></td>
                  <td><span class="text-xs font-weight-bold">{{$item->sub_komponens['kode_subkomponen']}}</span></td>
                  <td class="td"><span class="text-xs font-weight-bold">{{$item->uraian_subkomponens['uraian_subkomponen']}}</span></td>
                  <td><span class="text-xs font-weight-bold">{{$item->akuns['kode_akun']}}</span></td>
                  <td><span class="text-xs font-weight-bold">{{$item->cons_item}}</span></td>
                  <td class="td2"><span class="text-xs font-weight-bold">{{$item->uraian_item}}</span></td>
                  <td><span class="text-xs font-weight-bold">{{$item->volume}}</span></td>
                  <td><span class="text-xs font-weight-bold">{{$item->harga_satuan}}</span></td>
                  <td><span class="text-xs font-weight-bold">{{$item->total}}</span></td>    
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          {{ $item_pagu->links('pagination::bootstrap-5') }} 