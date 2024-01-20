<table cellpadding="5" width="100%">
    <tr>
        <th style="text-align: center;font-weight: bold" colspan="8">
            Penilaian Tugas {{ $assignment->scheme == 'writing_test' ? 'Tes Tulis' : ($assignment->scheme == 'oral_test' ? 'Tes Lisan' : 'Penugasan') }}
        </th>
    </tr>
    <tr>
        <th style="text-align: center" colspan="8"></th>
    </tr>
    <tr>
        <th style="text-align: center;font-weight: bold">No.</th>
        <th style="text-align: center;font-weight: bold">NISN</th>
        <th style="text-align: center;font-weight: bold">Nama</th>
        <th style="text-align: center;font-weight: bold">Jenis Kelamin</th>
        <th style="text-align: center;font-weight: bold">Nilai</th>
        <th style="text-align: center;font-weight: bold">Status</th>
        <th style="text-align: center;font-weight: bold">Remedial</th>
        <th style="text-align: center;font-weight: bold">Feedback</th>
    </tr>
    @foreach($students as $student)
        <tr style="margin-top: 5px">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $student->identity_number }}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td>{{ $student->knowledgeAssessment->count() > 0 ? $student->knowledgeAssessment[0]->score : '' }}</td>
            @if ($student->knowledgeAssessment->count() > 0)
                @if ($student->knowledgeAssessment[0]->score >= $course->subject->grade && $student->knowledgeAssessment[0]->is_finished == true && !is_null($student->knowledgeAssessment[0]->score))
                    <td>Tuntas</td>
                @elseif($student->knowledgeAssessment[0]->score < $course->subject->grade && $student->knowledgeAssessment[0]->is_finished == false && !is_null($student->knowledgeAssessment[0]->score))
                    <td>Belum Tuntas</td>
                @else
                    <td>Belum Tuntas</td>
                 @endif
            @else
                <td></td>
            @endif
            @if ($student->knowledgeAssessment->count() > 0)
                @if (!is_null($student->knowledgeAssessment[0]->score) && $student->knowledgeAssessment[0]->score < $course->subject->grade && $student->knowledgeAssessment[0]->is_finished == false && !is_null($student->knowledgeAssessment[0]->remedial))
                    <td>{{ $student->knowledgeAssessment[0]->remedial }}</td>
                @elseif (!is_null($student->knowledgeAssessment[0]->score) && $student->knowledgeAssessment[0]->score < $course->subject->grade && $student->knowledgeAssessment[0]->is_finished == false && is_null($student->knowledgeAssessment[0]->remedial))
                    <td>-</td>
                @elseif($student->knowledgeAssessment[0]->is_finished == true)
                    <td>-</td>
                @else
                    <td>-</td>
                @endif
            @else
                <td></td>
            @endif
            @if ($student->knowledgeAssessment->count() > 0 && $student->knowledgeAssessment[0]->feedback)
                <td>{{ $student->knowledgeAssessment[0]->feedback }}</td>
            @else
                <td></td>
            @endif
        </tr>
    @endforeach
</table>