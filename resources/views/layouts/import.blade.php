<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <form action="/data-import" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv_file" accept=".csv" required>
            <button type="submit">Upload CSV</button>
        </form>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Program</th>
                    <th>Kegiatan</th>
                    <th>Output</th>
                    <th>Sub Output</th>
                    <th>Komponen</th>
                    <th>Sub Komponen</th>
                    <th>Uraian Sub Komponen</th>
                    <th>Akun</th>
                    <th>Cons Item</th>
                    <th>uraian_item</th>
                    <th>Volume</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>      
                </tr>
            </thead>
            <tbody>
                @foreach ($item_pagu as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->programs['kode_program']}}</td>
                    <td>{{$item->kegiatans['kode_kegiatan']}}</td>
                    <td>{{$item->outputs['kode_output']}}</td>
                    <td>{{$item->sub_outputs['kode_suboutput']}}</td>
                    <td>{{$item->komponens['kode_komponen']}}</td>
                    <td>{{$item->sub_komponens['kode_subkomponen']}}</td>
                    <td>{{$item->uraian_subkomponens['uraian_subkomponen']}}</td>
                    <td>{{$item->akuns['kode_akun']}}</td>
                    <td>{{$item->cons_item}}</td>
                    <td>{{$item->uraian_item}}</td>
                    <td>{{$item->volume}}</td>
                    <td>{{$item->harga_satuan}}</td>
                    <td>{{$item->total}}</td>    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>