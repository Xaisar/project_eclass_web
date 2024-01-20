<div class="modal fade" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form action="{{ route('classroom.knowledge-assessments.create-or-update-assessment', ['course' => $course->hashid, 'assignment' => $assignment->hashid]) }}" method="post" data-request="ajax" data-modal-close="false">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="exampleModalFullscreenLabel">{{$title}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mb-4">
                        @php
                            $scheme = [
                                'writing_test' => 'Tes Tulis',
                                'oral_test' => 'Test Lisan',
                                'assignment' => 'Tugas',
                            ];
                        @endphp
                        <strong>
                            <i class="fa fa-info-circle"></i>
                            INFO
                        </strong>
                        <hr>
                        <ol>
                            <li>Halaman ini menampilkan Penilaian Tugas <strong><u>Skema {{ $scheme[$assignment->scheme] }}</u></strong></li>
                            <li>KKM pada penilaian ini adalah {{ $course->subject->grade }}, jika nilai kurang dari KKM, maka siswa harus mengikuti remedial</li>
                            <li>Feedback digunakan untuk mengirim masukan ke siswa yang bersangkatun untuk bahan evaluasi mandiri</li>
                        </ol>
                    </div>
                    <button class="btn btn-danger btn-sm float-start" data-bs-dismiss="modal" type="button">Tutup</button>
                    <button class="btn btn-primary btn-sm float-start mx-1" type="submit"><i class="fa fa-save"></i> Simpan</button>
                    <a href="{{ route('classroom.knowledge-assessments.export', ['course' => $course->hashid, 'assignment' => $assignment->hashid]) }}" target="_blank" class="btn btn-success btn-sm float-start" type="button"><i class="fa fa-download"></i> Export Excel</a>
                    <table id="ratingTable" class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>Remedial</th>
                            <th>Tugas</th>
                            <th>Feedback</th>
                        </thead>
                        <tbody>
                            @foreach($students as $item)
                                <tr id="ID{{ $item->hashid }}">
                                    <td width="5%" style="vertical-align: top!important">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: top!important">
                                        <span>{{ $item->identity_number }}</span>
                                    </td>
                                    <td style="vertical-align: top!important">
                                        <strong>{{ $item->name }}</strong>
                                        <input type="hidden" name="student_id[]" value="{{ $item->hashid }}">
                                    </td>
                                    <td style="vertical-align: top!important">
                                        <span>{{ $item->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </td>
                                    <td style="vertical-align: top !important">
                                        <input type="number" class="form-control score" id="score-{{ $item->hashid }}" data-grade="{{ $course->subject->grade }}" data-score="{{ $item->hashid }}" name="score[]" placeholder="Nilai" autocomplete="off" value="{{ $item->knowledgeAssessment->count() > 0 ? $item->knowledgeAssessment[0]->score : '' }}" max="100" min="0">
                                        @if ($item->knowledgeAssessment->count() > 0 && !is_null($item->knowledgeAssessment[0]->score))
                                            <button type="button" class="btn btn-danger btn-sm delete-score mt-2" data-id="{{ $item->knowledgeAssessment[0]->hashid }}" data-delete-id="{{ $item->hashid }}"><i class="fa fa-trash"></i> Hapus Nilai</button>
                                        @endif
                                    </td>
                                    <td style="vertical-align: top !important" class="status" id="status-{{ $item->hashid }}">
                                        @if ($item->knowledgeAssessment->count() > 0)
                                            @if ($item->knowledgeAssessment[0]->score >= $course->subject->grade && $item->knowledgeAssessment[0]->is_finished == true && !is_null($item->knowledgeAssessment[0]->score))
                                                <h5><span class="badge bg-success">Tuntas</span></h5>
                                                <input type="hidden" class="form-control" name="is_finished[]" value="1">
                                            @elseif($item->knowledgeAssessment[0]->score < $course->subject->grade && $item->knowledgeAssessment[0]->is_finished == false && !is_null($item->knowledgeAssessment[0]->score))
                                                <h5><span class="badge bg-danger">Belum Tuntas</span></h5>
                                                <input type="hidden" class="form-control" name="is_finished[]" value="0">
                                            @else
                                                <input type="hidden" class="form-control" name="is_finished[]" value="0">
                                            @endif
                                        @else
                                            <input type="hidden" class="form-control" name="is_finished[]" value="0">
                                        @endif
                                    </td>
                                    <td style="vertical-align: top !important" id="remedial-{{ $item->hashid }}">
                                        @if ($item->knowledgeAssessment->count() > 0)
                                            @if (!is_null($item->knowledgeAssessment[0]->score) && $item->knowledgeAssessment[0]->score < $course->subject->grade && $item->knowledgeAssessment[0]->is_finished == false && !is_null($item->knowledgeAssessment[0]->remedial))
                                                <input type="number" class="form-control remedial" id="remedial" name="remedial[]" placeholder="Nilai remidi" autocomplete="off" value="{{ $item->knowledgeAssessment[0]->remedial }}" max="100" min="0">
                                            @elseif (!is_null($item->knowledgeAssessment[0]->score) && $item->knowledgeAssessment[0]->score < $course->subject->grade && $item->knowledgeAssessment[0]->is_finished == false && is_null($item->knowledgeAssessment[0]->remedial))
                                                <input type="number" class="form-control remedial" id="remedial" name="remedial[]" placeholder="Nilai remidi" autocomplete="off" max="100" min="0">
                                            @elseif($item->knowledgeAssessment[0]->is_finished == true)
                                                <input type="hidden" class="form-control remedial" id="remedial" name="remedial[]" placeholder="Nilai remidi" autocomplete="off" max="100" min="0">
                                            @else
                                                <input type="hidden" class="form-control remedial" id="remedial" name="remedial[]" placeholder="Nilai remidi" autocomplete="off" max="100" min="0">
                                            @endif
                                        @else
                                            <input type="hidden" class="form-control remedial" id="remedial" name="remedial[]" placeholder="Nilai remidi" autocomplete="off" max="100" min="0">
                                        @endif
                                    </td>
                                    <td style="vertical-align: top !important">
                                        @if ($assignment->is_uploaded)
                                            @if($item->knowledgeAssessment->count() > 0 && !is_null($item->knowledgeAssessment[0]->attachment))
                                                <a href="{{ $item->knowledgeAssessment[0]->attachment_type ? route('classroom.knowledge-assessments.download-assessment', ['course' => $course->hashid, 'knowledgeAssessment' => $item->knowledgeAssessment[0]->hashid]) : $item->knowledgeAssessment[0]->attachment }}" target="_blank" class="btn btn-soft-success btn-sm btn-rounded px-3"><i class="fa fa-download"></i> Download Tugas</a>
                                            @else
                                                <span class="badge badge-soft-danger p-2">Belum dikerjakan</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="col-2">
                                        <textarea name="feedback[]" rows="2" id="feedback-{{ $item->hashid }}" class="form-control">{{ $item->knowledgeAssessment->count() > 0 ? $item->knowledgeAssessment[0]->feedback : '' }}</textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div> 
    </div>
</div>