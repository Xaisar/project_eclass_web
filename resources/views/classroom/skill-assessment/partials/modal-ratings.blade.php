<div class="modal fade" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form action="{{ route('classroom.skill-assessments.create-or-update-assessment', ['course' => $course->hashid, 'assignment' => $assignment->hashid]) }}" method="post" data-request="ajax" data-modal-close="false">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="exampleModalFullscreenLabel">{{$title}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mb-4">
                        @php
                            $scheme = [
                                'project' => 'Proyek',
                                'practice' => 'Unjuk Kerja / Praktik',
                                'product' => 'Produk',
                                'portfolio' => 'Portofolio'
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
                            <li>Penilaian Keterampilan berbeda  di setiap Skema Penilaiannya</li>
                        </ol>
                    </div>
                    <button class="btn btn-danger btn-sm float-start" data-bs-dismiss="modal" type="button">Tutup</button>
                    <button class="btn btn-primary btn-sm float-start mx-1" type="submit"><i class="fa fa-save"></i> Simpan</button>
                    <a href="{{ route('classroom.skill-assessments.export', ['course' => $course->hashid, 'assignment' => $assignment->hashid]) }}" target="_blank" class="btn btn-success btn-sm float-start" type="button"><i class="fa fa-download"></i> Export Excel</a>
                    <input type="hidden" name="scheme" value="{{ $assignment->scheme }}">
                    <table id="ratingTable" class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            {{-- table portfolio --}}
                            @if($assignment->scheme == 'portfolio')
                                <th>Nilai</th>
                                @if($assignment->is_uploaded)
                                    <th>Tugas</th>
                                @endif
                                <th>Keterangan</th>
                            @endif
                            
                            {{-- table produk --}}
                            @if($assignment->scheme == 'product')
                                <th>Perencanaan</th>
                                <th>Proses Pembuatan</th>
                                <th>Hasil Produk</th>
                                <th>Jumlah Skor</th>
                                <th>Nilai</th>
                                @if($assignment->is_uploaded)
                                    <th>Tugas</th>
                                @endif
                                <th>Keterangan</th>
                            @endif
    
                            {{-- table project --}}
                            @if($assignment->scheme == 'project')
                                <th>Persiapan</th>
                                <th>Pelaksanaan</th>
                                <th>Laporan</th>
                                <th>Jumlah Skor</th>
                                <th>Nilai</th>
                                @if($assignment->is_uploaded)
                                    <th>Tugas</th>
                                @endif
                                <th>Keterangan</th>
                            @endif
    
                            {{-- table project --}}
                            @if($assignment->scheme == 'practice')
                                <th>Materi</th>
                                <th>Penguasaan</th>
                                <th>Retorika</th>
                                <th>Komunikasi</th>
                                <th>Jumlah Skor</th>
                                <th>Nilai</th>
                                @if($assignment->is_uploaded)
                                    <th>Tugas</th>
                                @endif
                                <th>Keterangan</th>
                            @endif
                        </thead>
                        <tbody>
                            @foreach($students as $item)
                                <tr id="ID{{ $item->hashid }}">
                                    <td width="5%" style="vertical-align: top!important">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: top!important">
                                        <strong>{{ $item->name }}</strong>
                                        <p class="text-muted small m-0 p-0">{{ $item->identity_number }}</p>
                                        <input type="hidden" name="student_id[]" value="{{ $item->hashid }}">
                                    </td>
                                    {{-- table portfolio --}}
                                    @if($assignment->scheme == 'portfolio')
                                        <td class="col-1" style="vertical-align: top!important">
                                            <input type="number" name="score[]" class="form-control" placeholder="0" autocomplete="off" min="0" max="100" value="{{ $item->skillAssessment->count() > 0 ? $item->skillAssessment[0]->score : '' }}">
                                        </td>
                                        @if($assignment->is_uploaded)
                                            <td style="vertical-align: top!important">
                                                @if($item->skillAssessment->count() > 0 && !is_null($item->skillAssessment[0]->attachment))
                                                    <a href="{{ $item->skillAssessment[0]->attachment_type ? route('classroom.skill-assessments.download-assessment', ['course' => $course->hashid, 'skillAssessment' => $item->skillAssessment[0]->hashid]) : $item->skillAssessment[0]->attachment }}" target="_blank" class="btn btn-soft-success btn-sm btn-rounded px-3"><i class="fa fa-download"></i> Download Tugas</a>
                                                @else
                                                    <span class="badge badge-soft-danger p-2">Belum dikerjakan</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            <textarea name="description[]" rows="2" class="form-control">{{ $item->skillAssessment->count() > 0 ? $item->skillAssessment[0]->description : '' }}</textarea>
                                        </td>
                                    @endif
    
                                    {{-- table product --}}
                                    @if($assignment->scheme == 'product')
                                        <td class="col-1" style="vertical-align: top!important">
                                            <select name="theory_score[]" data-id="ID{{ $item->hashid }}" class="form-control js-choices theory-score">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->theory_score == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->theory_score == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->theory_score == 3 ? 'selected' : '' }}>3</option>
                                                <option value="4" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->theory_score == 4 ? 'selected' : '' }}>4</option>
                                            </select>
                                        </td>
                                        <td class="col-1" style="vertical-align: top!important">
                                            <select name="process_score[]" data-id="ID{{ $item->hashid }}" class="form-control js-choices process-score">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 3 ? 'selected' : '' }}>3</option>
                                                <option value="4" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 4 ? 'selected' : '' }}>4</option>
                                            </select>
                                        </td>
                                        <td class="col-1" style="vertical-align: top!important">
                                            <select name="result_score[]" data-id="ID{{ $item->hashid }}" class="form-control js-choices result-score">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 3 ? 'selected' : '' }}>3</option>
                                                <option value="4" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 4 ? 'selected' : '' }}>4</option>
                                            </select>
                                        </td>
                                        <td style="vertical-align: top!important">
                                            <span class="total-score">{{ $item->skillAssessment->count() > 0 ? ($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->result_score) : '0' }}</span>
                                            <input type="hidden" name="total_score[]" class="form-control total-score" value="{{ $item->skillAssessment->count() > 0 ? ($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->result_score) : '0' }}">
                                        </td>
                                        <td style="vertical-align: top!important">
                                            <span class="score">{{ $item->skillAssessment->count() > 0 ? (int) (($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->result_score)* (100 / 12)) : '0' }}</span>
                                            <input type="hidden" name="score[]" class="form-control score" value="{{ $item->skillAssessment->count() > 0 ? (int) (($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->result_score)* (100 / 12)) : '0' }}">
                                        </td>
                                        @if($assignment->is_uploaded)
                                            <td style="vertical-align: top!important">
                                                @if($item->skillAssessment->count() > 0 && !is_null($item->skillAssessment[0]->attachment))
                                                    <a href="{{ $item->skillAssessment[0]->attachment_type ? route('classroom.skill-assessments.download-assessment', ['course' => $course->hashid, 'skillAssessment' => $item->skillAssessment[0]->hashid]) : $item->skillAssessment[0]->attachment }}" target="_blank" class="btn btn-soft-success btn-sm btn-rounded px-3"><i class="fa fa-download"></i> Download Tugas</a>
                                                @else
                                                    <span class="badge badge-soft-danger p-2">Belum dikerjakan</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td class="col-2">
                                            <textarea name="description[]" rows="2" class="form-control">{{ $item->skillAssessment->count() > 0 ? $item->skillAssessment[0]->description : '' }}</textarea>
                                        </td>
                                    @endif
    
                                    {{-- table project --}}
                                    @if($assignment->scheme == 'project')
                                        <td class="col-1" style="vertical-align: top!important">
                                            <select name="theory_score[]" data-id="ID{{ $item->hashid }}" class="form-control js-choices theory-score">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->theory_score == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->theory_score == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->theory_score == 3 ? 'selected' : '' }}>3</option>
                                            </select>
                                        </td>
                                        <td class="col-1" style="vertical-align: top!important">
                                            <select name="process_score[]" data-id="ID{{ $item->hashid }}" class="form-control js-choices process-score">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 3 ? 'selected' : '' }}>3</option>
                                                <option value="4" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 4 ? 'selected' : '' }}>4</option>
                                                <option value="5" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 5 ? 'selected' : '' }}>5</option>
                                                <option value="6" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 6 ? 'selected' : '' }}>6</option>
                                                <option value="7" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 7 ? 'selected' : '' }}>7</option>
                                                <option value="8" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 8 ? 'selected' : '' }}>8</option>
                                                <option value="9" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 9 ? 'selected' : '' }}>9</option>
                                            </select>
                                        </td>
                                        <td class="col-1" style="vertical-align: top!important">
                                            <select name="result_score[]" data-id="ID{{ $item->hashid }}" class="form-control js-choices result-score">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 3 ? 'selected' : '' }}>3</option>
                                                <option value="4" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 4 ? 'selected' : '' }}>4</option>
                                                <option value="5" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 5 ? 'selected' : '' }}>5</option>
                                                <option value="6" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 6 ? 'selected' : '' }}>6</option>
                                                <option value="7" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 7 ? 'selected' : '' }}>7</option>
                                                <option value="8" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 8 ? 'selected' : '' }}>8</option>
                                                <option value="9" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 9 ? 'selected' : '' }}>9</option>
                                                <option value="10" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 10 ? 'selected' : '' }}>10</option>
                                                <option value="11" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 11 ? 'selected' : '' }}>11</option>
                                                <option value="12" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->result_score == 12 ? 'selected' : '' }}>12</option>
                                            </select>
                                        </td>
                                        <td style="vertical-align: top!important">
                                            <span class="total-score">{{ $item->skillAssessment->count() > 0 ? ($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->result_score) : '0' }}</span>
                                            <input type="hidden" name="total_score[]" class="form-control total-score" value="{{ $item->skillAssessment->count() > 0 ? ($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->result_score) : '0' }}">
                                        </td>
                                        <td style="vertical-align: top!important">
                                            <span class="score">{{ $item->skillAssessment->count() > 0 ? (int) (($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->result_score)* (100 / 24)) : '0' }}</span>
                                            <input type="hidden" name="score[]" class="form-control score" value="{{ $item->skillAssessment->count() > 0 ? (int) (($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->result_score)* (100 / 24)) : '0' }}">
                                        </td>
                                        @if($assignment->is_uploaded)
                                            <td style="vertical-align: top!important">
                                                @if($item->skillAssessment->count() > 0 && !is_null($item->skillAssessment[0]->attachment))
                                                    <a href="{{ $item->skillAssessment[0]->attachment_type ? route('classroom.skill-assessments.download-assessment', ['course' => $course->hashid, 'skillAssessment' => $item->skillAssessment[0]->hashid]) : $item->skillAssessment[0]->attachment }}" target="_blank" class="btn btn-soft-success btn-sm btn-ro  unded px-3"><i class="fa fa-download"></i> Download Tugas</a>
                                                @else
                                                    <span class="badge badge-soft-danger p-2">Belum dikerjakan</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td class="col-2">
                                            <textarea name="description[]" rows="2" class="form-control">{{ $item->skillAssessment->count() > 0 ? $item->skillAssessment[0]->description : '' }}</textarea>
                                        </td>
                                    @endif
    
                                    {{-- table practice --}}
                                    @if($assignment->scheme == 'practice')
                                        <td class="col-1" style="vertical-align: top!important">
                                            <select name="theory_score[]" data-id="ID{{ $item->hashid }}" class="form-control js-choices theory-score">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->theory_score == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->theory_score == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->theory_score == 3 ? 'selected' : '' }}>3</option>
                                            </select>
                                        </td>
                                        <td class="col-1" style="vertical-align: top!important">
                                            <select name="process_score[]" data-id="ID{{ $item->hashid }}" class="form-control js-choices process-score">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->process_score == 3 ? 'selected' : '' }}>3</option>
                                            </select>
                                        </td>
                                        <td class="col-1" style="vertical-align: top!important">
                                            <select name="rhetoric_score[]" data-id="ID{{ $item->hashid }}" class="form-control js-choices rhetoric-score">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->rhetoric_score == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->rhetoric_score == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->rhetoric_score == 3 ? 'selected' : '' }}>3</option>
                                            </select>
                                        </td>
                                        <td class="col-1" style="vertical-align: top!important">
                                            <select name="feedback_score[]" data-id="ID{{ $item->hashid }}" class="form-control js-choices feedback-score">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->feedback_score == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->feedback_score == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $item->skillAssessment->count() > 0 && $item->skillAssessment[0]->feedback_score == 3 ? 'selected' : '' }}>3</option>
                                            </select>
                                        </td>
                                        <td style="vertical-align: top!important">
                                            <span class="total-score">{{ $item->skillAssessment->count() > 0 ? (int) ($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->rhetoric_score + $item->skillAssessment[0]->feedback_score) : '0' }}</span>
                                            <input type="hidden" name="total_score[]" class="form-control total-score" value="{{ $item->skillAssessment->count() > 0 ? (int) ($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->rhetoric_score + $item->skillAssessment[0]->feedback_score) : '0' }}">
                                        </td>
                                        <td style="vertical-align: top!important">
                                            <span class="score">{{ $item->skillAssessment->count() > 0 ? (int) (($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->rhetoric_score + $item->skillAssessment[0]->feedback_score) * (100 / 12)) : '0' }}</span>
                                            <input type="hidden" name="score[]" class="form-control score" value="{{ $item->skillAssessment->count() > 0 ? (int) (($item->skillAssessment[0]->theory_score + $item->skillAssessment[0]->process_score + $item->skillAssessment[0]->rhetoric_score + $item->skillAssessment[0]->feedback_score) * (100 / 12)) : '0' }}">
                                        </td>
                                        @if($assignment->is_uploaded)
                                            <td style="vertical-align: top!important">
                                                @if($item->skillAssessment->count() > 0 && !is_null($item->skillAssessment[0]->attachment))
                                                    <a href="{{ $item->skillAssessment[0]->attachment_type ? route('classroom.skill-assessments.download-assessment', ['course' => $course->hashid, 'skillAssessment' => $item->skillAssessment[0]->hashid]) : $item->skillAssessment[0]->attachment }}" target="_blank" class="btn btn-soft-success btn-sm btn-rounded px-3"><i class="fa fa-download"></i> Download Tugas</a>
                                                @else
                                                    <span class="badge badge-soft-danger p-2">Belum dikerjakan</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td class="col-2">
                                            <textarea name="description[]" rows="2" class="form-control">{{ $item->skillAssessment->count() ? $item->skillAssessment[0]->description : '' }}</textarea>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div> 
    </div>
</div>