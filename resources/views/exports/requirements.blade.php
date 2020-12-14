<table>
    <thead>
        <tr>
            <th colspan="2">NAMA SEKOLAH</th>
            <th>Kebutuhan</th>
            <th>Tersedia ASN</th>
            <th>Non ASN</th>
            <th>Formasi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($schools as $school)
            @if($school->balance > 0)
            <tr>
                <td colspan="2">{{ $school->name }}</td>
                <td>{{ $school->require }}</td>
                <td>{{ $school->available }}</td>
                <td>{{ $school->honorer }}</td>
                <td>{{ $school->balance }}</td>
            </tr>

                @foreach($school->requirements()->with('subject')->where('balance', '>', 0)->get() as $requirement)
                <tr>
                    <td></td>
                    <td>{{ $requirement->subject->name . " (" . $requirement->status . ")" }}</td>
                    <td>{{ $requirement->require }}</td>
                    <td>{{ $requirement->available }}</td>
                    <td>{{ $requirement->honorer }}</td>
                    <td>{{ $requirement->balance }}</td>
                </tr>
                @endforeach
            @endif
        @endforeach
    </tbody>
</table>