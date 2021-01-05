<table>
    <thead>
        <tr>
            <th>NAMA</th>
            <th>L/P</th>
            <th>TEMPAT/TGL. LAHIR</th>
            <th>NIK</th>
            <th>STATUS PEGAWAI</th>
            <th>JENJANG PENDIDIKAN</th>
            <th>MAPEL/JABATAN</th>
            <th>UNIT KERJA</th>
        </tr>
    </thead>

    <tbody>
        @foreach($nominatives as $nominative)
        <tr>
            <td>{{ $nominative->name }}</td>
            <td>{{ $nominative->gender }}</td>
            <td>{{ $nominative->born_place . ',' . $nominative->born_date }}</td>
            <td>{{ $nominative->nik }}</td>
            <td>{{ $nominative->status }}</td>
            <td>{{ $nominative->education->name }}</td>
            <td>{{ optional($nominative->subject->first())->name }}</td>
            <td>{{ $nominative->school->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>