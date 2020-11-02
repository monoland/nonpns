<table>
    <thead>
        <tr>
            <th>NIK</th>
            <th>Nama</th>
            <th>L/P</th>
            <th>Tempat Lahir</th>
            <th>Tgl Lahir</th>
            <th>Sekolah</th>
            <th>Status</th>
            <th>Mapel</th>
        </tr>
    </thead>

    <tbody>
        @foreach($teachers as $teacher)
        <tr>
            <td>{{ "'" . $teacher->nik }}</td>
            <td>{{ ($teacher->front_title ? $teacher->front_title . ' ' : '') . $teacher->name . ($teacher->back_title ? ', ' . $teacher->back_title . ' ' : '') }}</td>
            <td>{{ $teacher->gender }}</td>
            <td>{{ $teacher->born_place }}</td>
            <td>{{ $teacher->born_date }}</td>
            <td>{{ optional($teacher->school)->name }}</td>
            <td>{{ $teacher->status }}</td>
            <td>{{ $teacher->subjects->pluck('name')->first() ?: '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>